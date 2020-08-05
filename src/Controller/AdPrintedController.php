<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 21/04/2020
 * Time: 17:55
 */

namespace App\Controller;

use App\Message\StatsMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

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
     */
    public function index(Request $request)
    {
        $publisherId = $request->query->get('publisher_id');
        $siteId = !empty($request->query->get('site_id')) ?$request->query->get('site_id'): null;
        $zone = !empty($request->query->get('zone')) ?$request->query->get('zone'): null;
        $domain = !empty($request->query->get('domain')) ?$request->query->get('domain'): null;
        $devicetype = $request->query->get('devicetype');
        $country = $request->query->get('country');
        $money = $request->query->get('money');
        $adomain = $request->query->get('adomain');
        $seat = $request->query->get('seat');

        //Store in DB Ad Printed
        $date = new \DateTime(date('Y-m-d H:0:0'));

        $this->bus->dispatch(new StatsMessage(
           $publisherId,
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
        ));

        $response = new Response(null,
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        return $response;
    }

}