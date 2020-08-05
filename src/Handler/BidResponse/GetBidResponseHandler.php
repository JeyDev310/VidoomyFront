<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 12:43
 */

namespace App\Handler\BidResponse;

use App\Model\OpenRTB25\BidRequest;
use App\Model\AdResponse;
use App\Model\RTBSetup;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpClient\HttpClient;

class GetBidResponseHandler
{
    protected $serializer;

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    public function execute(BidRequest $bidRequestOpenRTB,RTBSetup $RTBSetup, int $adType)
    {
        //Serialize to JSON
        $bidRequestJson = $this->serializer->serialize($bidRequestOpenRTB, 'json');
        $postData['body'] = gzencode($bidRequestJson);

        //Get All the bids placed
        $client = HttpClient::create(['headers' => [
            'Content-Encoding' => 'gzip',
        ]]);
        $endpoints = $this->getEndpointExchanges();

        $bidResponseJson = null;
        foreach($endpoints as $endpoint) {
            $responseBidswitch = $client->request('POST', $endpoint, $postData);

            $content = $responseBidswitch->getContent();

            if(!$content){
                return null;
            }

            $bidResponseJson = $this->serializer->deserialize($content, 'App\Model\OpenRTB25\BidResponse', 'json');
        }

        //Select Winner
        $arrayBids = array();
        $arrayBidsDeal = array();
        $arraySetupDeal = array();
        $wseat = $RTBSetup->getWseat();
        $badv = $RTBSetup->getBadv();
        $bcat = $RTBSetup->getBcat();
        $at = $RTBSetup->getAt();
        $bidfloor = $RTBSetup->getBidfloor();

        //Deals Logic
        $dealIdArray = $RTBSetup->getDeals();

        foreach($bidResponseJson->getSeatbid() as $bidArray) {
            //Check Whitelist Seat
            if($wseat && !in_array($bidArray->getSeat(), $wseat)){
                continue;
            }

            foreach($bidArray->getBid() as $bid) {
                //Check Bad Advertiser with adomain
                if($badv && $bid->getAdomain() && array_intersect($bid->getAdomain(),$badv)){
                    continue;
                }

                //Check Blocked Categories with Adv Cat
                if($bcat && $bid->getCat() && array_intersect($bid->getCat(),$bcat)){
                    continue;
                }

                //Check Bid is lower than Bidfloor
                if ($bid->getPrice() < $bidfloor){
                    continue;
                }

                //Check if has dealId
                if($bid->getDealid()){
                    foreach($dealIdArray as $deal){
                        if($deal->getId() == $bid->getDealid() &&
                            in_array($bidArray->getSeat(), $deal->getWseat()) &&
                            $bid->getPrice() >= $deal->getBidfloor()
                        ){
                            $arraySetupDeal[$deal->getId()]['at'] = $deal->getAt();
                            $arraySetupDeal[$deal->getId()]['bidfloor'] = $deal->getBidfloor();

                            if($deal->getAt() == 3){
                                $bid->setPrice($deal->getBidfloor());
                            }
                            $arrayBidsDeal[] = $bid;

                        }
                    }
                }

                //Add SeatId to bid
                if ($bidArray->getSeat()) {
                    $bid->setSeat($bidArray->getSeat());
                }

                $arrayBids[] = $bid;

            }
        }

        if($arrayBidsDeal){
            $arrayBids = $arrayBidsDeal;
        }

        if(!$arrayBids){
            return null;
        }


        //Order by higher bid
        usort(
            $arrayBids,
            function ($a, $b) {
                if ($a->getPrice() == $b->getPrice()) {
                    return mt_rand(0,1);
                }
                return ($a->getPrice() > $b->getPrice()) ? -1 : 1;
            }
        );

        if($arraySetupDeal){
            $at = $arraySetupDeal[$arrayBids[0]->getDealid()]['at'];
            $bidfloor = $arraySetupDeal[$arrayBids[0]->getDealid()]['bidfloor'];
        }

        //Set Win Price
        if($at == 1){
            $winPrice =  $arrayBids[0]->getPrice();
        }elseif ($at == 2 && isset($arrayBids[1])){
            $winPrice =  $arrayBids[1]->getPrice() + 0.01;
        }else{
            $winPrice = $bidfloor;
        }

        //TODO Encrypt Price
        /*
         * Encriptar Precio ganado

        $winPrice = 2700;
        $winPrice = pack('L', substr($winPrice,0,8));
        $e_Key = 'skU7Ax_NL5pPAFyKdkfZjZz2-VhIN8bjj1rVFOaJ_5o=';  // Example Encryption key (e_key)
        $i_Key = 'arO23ykdNqUQ5LEoQ0FVmPkBd7xB5CO89PDZlSjpFxo=';  // Example Integrity key (i_key)

        $initVector = substr($bidResponseJson->getId(),0,16);
        $pad = substr(hash_hmac('sha1',$initVector, $e_Key,true), 0,8);
        //$pad = substr(hash_hmac('sha1',substr($bidResponseJson->getId(),0,16), $e_Key,true),0,8);
        $priceEncoded = ($pad ^ substr($winPrice,0,8));
        $configSignature = substr(hash_hmac('sha1', $winPrice . $bidResponseJson->getId(), $i_Key,true),0,4);

        $encryptedPrice = base64_encode($initVector.$priceEncoded.$configSignature);


        var_dump($winPrice);
        var_dump($priceEncoded);
        var_dump($configSignature);

        var_dump($encryptedPrice);
        echo strlen($encryptedPrice);
        die();

        */

        //Create Bidoomy Won notification Pixel
        if($bidRequestOpenRTB->getApp()) {
            $publisher_id = $bidRequestOpenRTB->getApp()->getPublisher()->getId();
            $site_id = $bidRequestOpenRTB->getApp()->getAppId();
            $domain= $bidRequestOpenRTB->getApp()->getAppDomain();
            $zone = $bidRequestOpenRTB->getApp()->getAppPage();

        }else{
            $publisher_id = $bidRequestOpenRTB->getSite()->getPublisher()->getId();
            $site_id = $bidRequestOpenRTB->getSite()->getSiteId();
            $domain= $bidRequestOpenRTB->getSite()->getSiteDomain();
            $zone = $bidRequestOpenRTB->getSite()->getSitePage();
        }

        if($arrayBids[0]->getAdomain()){
            $adomain = '&adomain='.implode('|',$arrayBids[0]->getAdomain());
        }else{
            $adomain = null;
        }

        if($arrayBids[0]->getSeat()) {
            $seat = '&seat=' . $arrayBids[0]->getSeat();
        }else{
            $seat = null;
        }

        $bdmPixel = 'https://rtb.vidoomy.com/show/?publisher_id='.$publisher_id.'&site_id='.$site_id.'&zone='.$zone.'&domain='.$domain.'&devicetype='.$bidRequestOpenRTB->getDevice()->getDevicetype().'&country='.$bidRequestOpenRTB->getDevice()->getGeo()->getCountry().'&money='.$winPrice.$adomain.$seat;

        //addBurl (client won notification pixel) && Bidoomy Won Pixel
        switch ($adType) {
            case 0: // Video
                $responseWithBurl = str_replace('<Wrapper>', '<Wrapper><Impression><![CDATA[' . $arrayBids[0]->getBurl() . ']]></Impression>', $arrayBids[0]->getAdm());
                $responseWithBdmPixel = str_replace('<Wrapper>', '<Wrapper><Impression><![CDATA['.$bdmPixel.']]></Impression>',$responseWithBurl );
                break;
            case 1: // Banner
                $responseWithBdmPixel = '<?xml version="1.0" encoding="UTF-8"?><Ad><AdTag><![CDATA['.$arrayBids[0]->getAdm().']]></AdTag><Impression><![CDATA['.$bdmPixel.']]></Impression><Impression><![CDATA[' . $arrayBids[0]->getBurl() . ']]></Impression></Ad>';
                break;
            case 2: // Native
                $responseWithBdmPixel = $this->serializer->serialize($arrayBids[0]->getAdmNative(), 'json');
                $responseWithBdmPixel = substr($responseWithBdmPixel, 0, -1).',"bidoomyPixel":"'.$bdmPixel.'","burl":"'.$arrayBids[0]->getBurl().'"}';
                break;
        }

        //addWinPrice
        $adResponse = new AdResponse(str_replace('${AUCTION_PRICE}', $winPrice, $responseWithBdmPixel),$bidResponseJson->getSeatbid()[0]->getSeat(),implode('|',$arrayBids[0]->getAdomain()),$winPrice);

        return $adResponse;

    }

    /**
     * @return array
     */
    protected function getEndpointExchanges(): array
    {

        $endpoints[] = 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid';
        //$endpoints[] = 'http://9eb88c5c.ngrok.io/bidResponse';

        return $endpoints;

    }

}