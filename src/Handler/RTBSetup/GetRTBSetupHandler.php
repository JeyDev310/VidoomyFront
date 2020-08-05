<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 16/04/2020
 * Time: 11:59
 */

namespace App\Handler\RTBSetup;

use App\Model\AdRequest;
use App\Model\OpenRTB25\DealObject;
use App\Model\RTBSetup;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

class GetRTBSetupHandler
{
    protected $redis;

    public function __construct(
        ClientInterface $redis
    ) {
        $this->redis = $redis;
    }

    /**
     * @param AdRequest $adRequest
     *
     * @return array|mixed|string
     *
     */
    public function execute(AdRequest $adRequest): RTBSetup
    {

        if ($dataResponse = $this->redis->get('bidfloor:'.$adRequest->getPublisherId().':'.$adRequest->getCountry())) {
            $bidfloor = json_decode($dataResponse, true);
        }else if ($dataResponse = $this->redis->get('bidfloor:'.$adRequest->getPublisherId().':WW')) {
            $bidfloor = json_decode($dataResponse, true);
        }else if ($dataResponse = $this->redis->get('bidfloor:global:'.$adRequest->getCountry())) {
            $bidfloor = json_decode($dataResponse, true);
        }else {
            $dataResponse = $this->redis->get('bidfloor:global:WW');
            $bidfloor = json_decode($dataResponse, true);
        }

        $dataResponse = $this->redis->get('at:global');
        $at = json_decode($dataResponse, true);

        $dataResponse = $this->redis->get('tmax:global');
        $tmax = json_decode($dataResponse, true);

        $bcat = $this->redis->smembers('bcat:global');

        $badv = $this->redis->smembers('badv:global');

        $wseat = $this->redis->smembers('wseat:global');

        $private_auction = $this->redis->get('private_auction:global');

        $deals = $this->redis->smembers('deals:global');

        $dealsArray = array();
        foreach($deals as $deal) {
            $dealExploded = explode(':', $deal);
            $wseatExploded = explode(',',$dealExploded[1]);
            $dealsArray[] = new DealObject($dealExploded[0],$wseatExploded,$dealExploded[2],$dealExploded[3]);
        }

        return new RTBSetup($bidfloor, $at, $tmax, $bcat, $badv, $wseat, $private_auction, $dealsArray);
    }

}