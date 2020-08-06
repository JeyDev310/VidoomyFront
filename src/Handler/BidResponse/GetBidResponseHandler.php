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
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\HttpClient\NativeHttpClient;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;


class GetBidResponseHandler
{
    protected $serializer;
    protected $redis;

    public function __construct(
        SerializerInterface $serializer,
        ClientInterface $redis
    )
    {
        $this->serializer = $serializer;
        $this->redis = $redis;
    }

    public function execute(BidRequest $bidRequestOpenRTB,RTBSetup $RTBSetup, int $adType)

    {
        //Serialize to JSON
        $bidRequestJson = $this->serializer->serialize($bidRequestOpenRTB, 'json',SerializationContext::create()->setSerializeNull(false));
        $postData['body'] = gzencode($bidRequestJson);
        $postData['timeout'] = 0.5;

        //Get All the bids placed
        /*$client = HttpClient::create(['headers' => [
            'Content-Encoding' => 'gzip',
        ]]);
        */
        $client = new NativeHttpClient(['headers' => [
            'Content-Encoding' => 'gzip',
        ]]);

        $endpoints = $this->getEndpointExchanges($bidRequestOpenRTB->getDevice()->getGeo()->getCountry());

        $bidResponseJson = null;

        foreach($endpoints as $endpoint) {
            try {
                $responseBidswitch = $client->request('POST', $endpoint, $postData);

                //file_put_contents('/usr/src/app/var/log/logsStatusCode.txt', $responseBidswitch->getStatusCode().PHP_EOL , FILE_APPEND | LOCK_EX);

                $statusCode = $responseBidswitch->getStatusCode();
                if ($statusCode !== 200) {
                    $responseBidswitch->cancel();
                    return null;
                }

                $content = $responseBidswitch->getContent();

                if (!$content) {
                    $responseBidswitch->cancel();

                    return null;
                }

                file_put_contents('/usr/src/app/var/log/logsContent.txt', $responseBidswitch->getContent().PHP_EOL , FILE_APPEND | LOCK_EX);

                $bidResponseJson = $this->serializer->deserialize($content, 'App\Model\OpenRTB25\BidResponse', 'json');
            } catch (TransportExceptionInterface $e) {
                return null;
            }
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
        /*
        //Encrypting the Win Price
        $winPriceMicrosCPI = $winPrice*1000;
        $winPriceTrimmed = substr($winPriceMicrosCPI,0,8);
        $winPricePad = str_pad($winPriceTrimmed, 8, '0', STR_PAD_LEFT);

        $e_Key = base64_decode('MoUlsZf5usRzmyC2NA8bT8zO1FnZEHLchKEnw3YyktM=');  // Prod Encryption key (e_key)
        $i_Key = base64_decode('1MSlylDgrLKUSxQ6bcZB8I0zMJ7xGlMLa4NhpDpcBh8=');  // Prod Integrity key (i_key)

        $initVector = substr($bidResponseJson->getId(),0,16);
        $pad = substr(hash_hmac('sha1',$initVector, $e_Key,true), 0,8);
        $priceEncoded = ($pad ^ $winPricePad);
        $configSignature = substr(hash_hmac('sha1', $winPricePad . $initVector, $i_Key,true),0,4);

        $encryptedPrice = substr(base64_encode($initVector.$priceEncoded.$configSignature),0,38);
        */

        //Create Bidoomy Won notification Pixel
        if($bidRequestOpenRTB->getApp()) {
            $publisher_id = $bidRequestOpenRTB->getApp()->getPublisher()->getId();
            $site_id = $bidRequestOpenRTB->getApp()->getId();
            $domain= $bidRequestOpenRTB->getApp()->getDomain();
            $zone = $bidRequestOpenRTB->getApp()->getPage();

        }else{
            $publisher_id = $bidRequestOpenRTB->getSite()->getPublisher()->getId();
            $site_id = $bidRequestOpenRTB->getSite()->getId();
            $domain= $bidRequestOpenRTB->getSite()->getDomain();
            $zone = $bidRequestOpenRTB->getSite()->getPage();
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

        $bdmPixel = 'https://rtb.vidoomy.com/show/?id='.$bidResponseJson->getId().'&ad_type='.$adType.'&publisher_id='.$publisher_id.'&site_id='.$site_id.'&zone='.$zone.'&domain='.$domain.'&devicetype='.$bidRequestOpenRTB->getDevice()->getDevicetype().'&country='.$bidRequestOpenRTB->getDevice()->getGeo()->getCountry().'&money='.$winPrice.$adomain.$seat;

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
        $adResponse = new AdResponse(str_replace('${AUCTION_PRICE}', $winPrice, $responseWithBdmPixel),$bidResponseJson->getSeatbid()[0]->getSeat(),implode('|',$arrayBids[0]->getAdomain()),$winPrice,$bidResponseJson->getId());

        return $adResponse;

    }

    /**
     * @param string $country
     * @return array
     */
    protected function getEndpointExchanges(string $country): array
    {

        /*$bsCountryEndpoint = $this->redis->get('endpoint:bidswitch:'.$country);
        if(!$bsCountryEndpoint){
            $bsCountryEndpoint = 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid';

        }*/

        $countryBSArray = array(
            'AF' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'AX' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'AL' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'DZ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'AS' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'AD' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'AO' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'AI' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'AQ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'AG' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'AR' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'AM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'AW' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'AU' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'AT' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'AZ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BS' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'BH' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BD' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BB' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'BY' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BZ' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'BJ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BM' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'BT' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BO' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'BQ' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'BA' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BW' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BV' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'BR' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'IO' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BN' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BG' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BF' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BI' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CV' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'KH' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CA' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'KY' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'CF' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TD' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CL' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'CN' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CX' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CC' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CO' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'KM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CG' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CD' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CK' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CR' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'CI' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'HR' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CU' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'CW' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'CY' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CZ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'DK' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'DJ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'DM' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'DO' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'EC' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'EG' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SV' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'GQ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'ER' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'EE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SZ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'ET' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'FK' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'FO' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'FJ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'FI' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'FR' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GF' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'PF' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TF' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GA' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'DE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GH' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GI' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GR' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GL' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'GD' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'GP' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'GU' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GT' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'GG' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GN' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GW' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GY' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'HT' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'HM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'VA' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'HN' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'HK' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'HU' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'IS' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'IN' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'ID' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'IR' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'IQ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'IE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'IM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'IL' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'IT' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'JM' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'JP' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'JE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'JO' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'KZ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'KE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'KI' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'KP' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'KR' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'KW' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'KG' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'LA' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'LV' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'LB' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'LS' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'LR' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'LY' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'LI' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'LT' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'LU' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MO' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MG' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MW' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MY' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MV' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'ML' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MT' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MH' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MQ' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'MR' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MU' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'YT' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MX' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'FM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MD' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MC' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MN' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'ME' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MS' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'MA' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MZ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'NA' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'NR' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'NP' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'NL' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'NC' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'NZ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'NI' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'NE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'NG' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'NU' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'NF' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MK' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'MP' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'NO' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'OM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'PK' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'PW' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'PS' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'PA' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'PG' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'PY' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'PE' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'PH' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'PN' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'PL' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'PT' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'PR' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'QA' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'RE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'RO' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'RU' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'RW' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'BL' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'SH' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'KN' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'LC' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'MF' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'PM' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'VC' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'WS' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'ST' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SA' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SN' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'RS' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SC' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SL' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SG' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SX' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'SK' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SI' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SB' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SO' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'ZA' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GS' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'SS' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'ES' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'LK' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SD' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SR' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'SJ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'CH' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'SY' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TW' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TJ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TZ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TH' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TL' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TG' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TK' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TO' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TT' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'TN' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TR' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'TC' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'TV' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'UG' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'UA' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'AE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'GB' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'US' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'UM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'UY' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'UZ' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'VU' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'VE' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'VN' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'VG' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'VI' => 'http://vidoomy.bc-us-east.bidswitch.net/vidoomy_bid',
            'WF' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'EH' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'YE' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'ZM' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid',
            'ZW' => 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid');

        if(isset($countryBSArray[$country])){
            $bsCountryEndpoint = $countryBSArray[$country];
        }else{
            $bsCountryEndpoint = 'http://vidoomy.bc-eu.bidswitch.net/vidoomy_bid';
        }


        $endpoints[] = $bsCountryEndpoint;

        return $endpoints;

    }

}
