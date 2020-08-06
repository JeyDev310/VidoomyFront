<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\AmqpExt\AmqpStamp;
use App\Handler\AdRequest\ParseRequestHandler;
use App\Handler\RTBSetup\GetRTBSetupHandler;
use App\Handler\AdAdapter\FormatVidoomyToRTBHandler;
use App\Handler\BidResponse\GetBidResponseHandler;
use App\Model\AdRequest;
use App\Model\AdResponse;
use App\Message\StatsMessage;
use App\Message\BidMessage;
use JMS\Serializer\SerializerInterface;


class AdRequestController extends AbstractController
{
    protected $parseRequestHandler;
    protected $getRTBSetupHandler;
    protected $formatVidoomyToRTBHandler;
    protected $getBidResponseHandler;
    protected $serializer;
    protected $bus;

    public function __construct(
        ParseRequestHandler $parseRequestHandler,
        GetRTBSetupHandler $getRTBSetupHandler,
        FormatVidoomyToRTBHandler $formatVidoomyToRTBHandler,
        GetBidResponseHandler $getBidResponseHandler,
        SerializerInterface $serializer,
        MessageBusInterface $bus
    ) {
        $this->parseRequestHandler = $parseRequestHandler;
        $this->getRTBSetupHandler = $getRTBSetupHandler;
        $this->formatVidoomyToRTBHandler = $formatVidoomyToRTBHandler;
        $this->getBidResponseHandler = $getBidResponseHandler;
        $this->serializer = $serializer;
        $this->bus = $bus;
    }


    /**
     * @Route("/", name="ad_request")
     * @param $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request): Response
    {
        try {

            //Get data from an Ad Request from Vidoomy publishers
            $adRequest = $this->parseRequestHandler->execute($request);

            $httpOrigin = 'Empty';

            if (isset($_SERVER['HTTP_ORIGIN'])) {
                $httpOrigin = $_SERVER['HTTP_ORIGIN'];
            }

            //Return 400 Bad request
            if (!$adRequest) {
                $response = new Response(null,
                    400,
                    ['Content-Type' => 'text/xml',
                        'Access-Control-Allow-Origin' => $httpOrigin,
                        'Access-Control-Allow-Credentials' => 'true']);
                return $response;
            }

            //Get data from RTB setup
            $rtbSetup = $this->getRTBSetupHandler->execute($adRequest);

            //Create a Bid Request in OpenRTB 2.5 to send to exchanges
            $bidRequestOpenRTB = $this->formatVidoomyToRTBHandler->execute($adRequest, $rtbSetup);

            //Send Bid Request and get Bid Response from exchanges
            $bidResponseOpenRTB = $this->getBidResponseHandler->execute($bidRequestOpenRTB, $rtbSetup, $adRequest->getAdType());

            //Return 204 No winning bid - No response
            if (!$bidResponseOpenRTB) {
                $response = new Response(null,
                    204,
                    ['Content-Type' => 'text/xml',
                        'Access-Control-Allow-Origin' => $httpOrigin,
                        'Access-Control-Allow-Credentials' => 'true']);
                $response->headers->setCookie(new Cookie('Bidoomy-Cookie', $adRequest->getCookie(), strtotime('+1 year')));
                return $response;
            }

            //Store in DB Bid placed
            $this->addBidToStats($adRequest, $bidResponseOpenRTB);

            //Temp track bids
            $this->addBidToBidMessage($bidResponseOpenRTB->getHtmlCode(), $bidResponseOpenRTB->getBidId(), $adRequest);

            //Select Output to print:  XML for video/banner  JSON for native
            if ($adRequest->getAdType() == 2) {
                $contentType = 'text/json';
            } else {
                $contentType = 'text/xml';
            }

            //Return to Vidoomy the AdMarkup
            $response = new Response($bidResponseOpenRTB->getHtmlCode(),
                Response::HTTP_OK,
                ['Content-Type' => $contentType,
                    'Access-Control-Allow-Origin' => $httpOrigin,
                    'Access-Control-Allow-Credentials' => 'true']);
            $response->headers->setCookie(new Cookie('Bidoomy-Cookie', $adRequest->getCookie(), strtotime('+1 year')));

            return $response;

        // Bad request
        } catch (\Throwable $t) {
            $response = new Response($t->getMessage());
            return $response;
        }
    }

    /**
     * @param AdRequest $adRequest
     * @param AdResponse $adResponse
     * @return void
     */
    protected function addBidToStats(AdRequest $adRequest, AdResponse $adResponse): void
    {
        $date = new \DateTime(date('Y-m-d H:0:0'));

        $this->bus->dispatch(new StatsMessage(
            $adRequest->getPublisherId(),
            $adRequest->getAdType(),
            $adRequest->getSiteId()??$adRequest->getAppId(),
            urldecode($adRequest->getSitePage()??$adRequest->getAppPage()),
            $adRequest->getSiteDomain()??$adRequest->getAppDomain(),
            $adRequest->getDevicetype(),
            $adRequest->getCountry(),
            $date,
            1,
            0,
            $adResponse->getMoney(),
            0,
            $adResponse->getAdomain(),
            $adResponse->getSeat()
        ),[
            new AmqpStamp('stats', AMQP_NOPARAM)
        ]);

    }

    /**
     * @param string $adm
     * @param string $id
     * @param AdRequest $adRequest
     * @return void
     */
    protected function addBidToBidMessage(string $adm, string $id, AdRequest $adRequest): void
    {
        $date = new \DateTime(date('Y-m-d H:i:s'));

        $this->bus->dispatch(new BidMessage(
            $id,
            0,
            $adm,
            $date,
            $adRequest
        ),[
            new AmqpStamp('bids', AMQP_NOPARAM)
        ]);

    }
}
