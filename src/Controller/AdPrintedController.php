<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 21/04/2020
 * Time: 17:55
 */

namespace App\Controller;

use App\Message\StatsMessage;
use App\Message\BidMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\AmqpExt\AmqpStamp;


class AdPrintedController extends AbstractController
{
    protected $bus;

    /**
     * AdPrintedController constructor.
     * @param $bus
     */
    public function __construct(
        MessageBusInterface $bus
    ){
        $this->bus = $bus;
    }

    /**
     * @Route("/show/", name="ad_printed")
     * @param $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request): Response
    {
        $publisherId = $request->query->get('publisher_id');
        $adType = $request->query->get('ad_type');
        $siteId = !empty($request->query->get('site_id')) ?$request->query->get('site_id'): null;
        $zone = !empty($request->query->get('zone')) ?$request->query->get('zone'): null;
        $domain = !empty($request->query->get('domain')) ?$request->query->get('domain'): null;
        $devicetype = $request->query->get('devicetype');
        $country = $request->query->get('country');
        $money = $request->query->get('money');
        //$encryptedMoney = $request->query->get('money');
        $adomain = $request->query->get('adomain');
        $seat = $request->query->get('seat');
        $id = $request->query->get('id');

        /*
        //TODO add keys to secrets
        //TODO verify signature

        //Decrypt money
        $decryptResult = base64_decode(substr($encryptedMoney,0,38));

        $decryptInitVector = substr($decryptResult,0,16);
        $decryptPriceEncoded = substr($decryptResult,16,8);
        //$decryptSignature = substr($decryptResult,24,4);

        $e_Key = base64_decode('MoUlsZf5usRzmyC2NA8bT8zO1FnZEHLchKEnw3YyktM=');  // Prod Encryption key (e_key)
        //$i_Key = base64_decode('1MSlylDgrLKUSxQ6bcZB8I0zMJ7xGlMLa4NhpDpcBh8=');  // Prod Integrity key (i_key)

        $price_pad = substr(hash_hmac('sha1',$decryptInitVector, $e_Key,true), 0,8);
        $moneyString = ($decryptPriceEncoded ^ $price_pad);
        $moneyMicrosCPI = (float) $moneyString;
        $money = $moneyMicrosCPI/1000;
        */

        //Store in DB Ad Printed
        $date = new \DateTime(date('Y-m-d H:0:0'));

        $this->bus->dispatch(new StatsMessage(
           $publisherId,
           $adType,
           $siteId,
           $zone,
           $domain,
           $devicetype,
           $country,
           $date,
           0,
           1,
           0,
           $money,
           $adomain,
           $seat
        ),[
            new AmqpStamp('stats', AMQP_NOPARAM)
        ]);


        //Store in DB Bid Imp
        $impDate = new \DateTime(date('Y-m-d H:i:s'));

        $this->bus->dispatch(new BidMessage(
            $id,
            1,
            null,
            null,
            null,
            $impDate
        ),[
            new AmqpStamp('bids', AMQP_NOPARAM)
        ]);

        $response = new Response(null,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        return $response;
    }

}