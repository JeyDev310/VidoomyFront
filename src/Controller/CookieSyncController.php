<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 22/05/2020
 * Time: 16:14
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\AmqpExt\AmqpStamp;
use App\Message\CookieMessage;



class CookieSyncController extends AbstractController
{

    protected $redis;
    protected $bus;

    public function __construct(
        ClientInterface $redis,
        MessageBusInterface $bus

    ) {
        $this->redis = $redis;
        $this->bus = $bus;
    }

    /**
     * @Route("/cookie/", name="cookie_sync")
     * @param $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request): Response
    {

        $response = new Response(null,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );

        $exchangeCookie = $request->query->get('exchange_cookie');
        $exchangeName = $request->query->get('exchange_name');

        //Check Exchange Cookie value
        if($exchangeCookie && $exchangeName) {

            //Get & Update Bidoomy Cookie
            if ($request->cookies->has('Bidoomy-Cookie')) {

                $explodeCookie = explode('::::',$request->cookies->get('Bidoomy-Cookie'));

                if(isset($explodeCookie[1])){
                    $updatedCookie = $explodeCookie[0].'::::'.$exchangeCookie;
                }else{
                    $updatedCookie = $request->cookies->get('Bidoomy-Cookie').'::::'.$exchangeCookie;
                }

                $this->updateCookieToCookieMessage(
                    $explodeCookie[0],
                    $exchangeCookie,
                    $exchangeName);

                $response->headers->setCookie(new Cookie('Bidoomy-Cookie', $updatedCookie, strtotime('+1 year')));

            }
        }

        return $response;

    }

    /**
     * @param string $bidoomyCookie
     * @param string $exchangeCookie
     * @param string $exchangeName
     * @return void
     */
    protected function updateCookieToCookieMessage(string $bidoomyCookie, string $exchangeCookie, string $exchangeName): void
    {
        $date = new \DateTime(date('Y-m-d H:i:s'));

        $this->bus->dispatch(new CookieMessage(
            $bidoomyCookie,
            $exchangeCookie,
            $exchangeName,
            $date
        ),[
            new AmqpStamp('cookie', AMQP_NOPARAM)
        ]);

    }

}