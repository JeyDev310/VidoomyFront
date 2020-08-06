<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 16/04/2020
 * Time: 13:01
 */

namespace App\Handler\AdAdapter;

use App\Model\OpenRTB25\BannerObject;
use App\Model\OpenRTB25\NativeObject;
use App\Model\OpenRTB25\NativeRequestAssetsObject;
use App\Model\OpenRTB25\NativeRequestObject;
use App\Model\OpenRTB25\NativeRequestAssetsTitleObject;
use App\Model\OpenRTB25\NativeRequestAssetsImageObject;
use App\Model\OpenRTB25\NativeRequestAssetsVideoObject;
use App\Model\OpenRTB25\NativeRequestAssetsDataObject;
use App\Model\RTBSetup;
use App\Model\AdRequest;
use App\Model\OpenRTB25\RegulationExtObject;
use App\Model\OpenRTB25\RegulationObject;
use App\Model\OpenRTB25\BidRequest;
use App\Model\OpenRTB25\VideoObject;
use App\Model\OpenRTB25\PmpObject;
use App\Model\OpenRTB25\ImpressionObject;
use App\Model\OpenRTB25\GeoObject;
use App\Model\OpenRTB25\DeviceObject;
use App\Model\OpenRTB25\PublisherObject;
use App\Model\OpenRTB25\SiteObject;
use App\Model\OpenRTB25\AppObject;
use App\Model\OpenRTB25\UserObject;

class FormatVidoomyToRTBHandler
{

    public function execute(AdRequest $adRequest, RTBSetup $RTBSetup): BidRequest
    {
        $pmpObject = null;
        if($deals = $RTBSetup->getDeals())
        {
            $pmpObject = new PmpObject($RTBSetup->getPrivateAuction(), $deals);
        }

        switch ($adRequest->getAdType()) {
            case 0:  //Video
                $creativeObject = new VideoObject($adRequest->getMimes(), $adRequest->getMinduration(), $adRequest->getMaxduration(), $adRequest->getPos(), array_map('\intval', $adRequest->getProtocols()), $adRequest->getW(), $adRequest->getH(), $adRequest->isSkip());
                $arrayImpressions[] = new ImpressionObject('1',$creativeObject, null, null, $RTBSetup->getBidfloor(), 'USD', $adRequest->isSecure(),$pmpObject);
                break;

            case 1:  //Banner
                $creativeObject = new BannerObject(1, $adRequest->getW(), $adRequest->getH(), $adRequest->getBtype());
                $arrayImpressions[] = new ImpressionObject('1',null, $creativeObject,null, $RTBSetup->getBidfloor(), 'USD', $adRequest->isSecure(),$pmpObject);
                break;

            case 2:  //Native

                //Title Object
                if ($adRequest->getNativeTitleLen()) {
                    $nativeAssetArray[] = new NativeRequestAssetsObject(1, 0, new NativeRequestAssetsTitleObject($adRequest->getNativeTitleLen()));
                }

                //Image Object
                if ($adRequest->getNativeImgH() && $adRequest->getNativeImgW()) {
                    $nativeAssetArray[] = new NativeRequestAssetsObject(2, 0, null, new NativeRequestAssetsImageObject($adRequest->getNativeImgH(), $adRequest->getNativeImgW()));
                }

                //Video Object
                if ($adRequest->getNativeVideoMimes() && $adRequest->getNativeVideoMinduration() && $adRequest->getNativeVideoMaxduration() && $adRequest->getNativeVideoProtocols()){
                    $nativeAssetArray[] = new NativeRequestAssetsObject(3, 0, null, null, new NativeRequestAssetsVideoObject($adRequest->getNativeVideoMimes(), $adRequest->getNativeVideoMinduration(), $adRequest->getNativeVideoMaxduration(), $adRequest->getNativeVideoProtocols()));
                }

                //Data Object
                if ($adRequest->getNativeDataType()) {
                    $nativeAssetArray[] = new NativeRequestAssetsObject(4, 0, null, null, null, new NativeRequestAssetsDataObject($adRequest->getNativeDataType()));
                }

                $nativeRequestObject = new NativeRequestObject('1.2',$nativeAssetArray);
                $creativeObject = new NativeObject($nativeRequestObject);
                $arrayImpressions[] = new ImpressionObject('1',null, null, $creativeObject, $RTBSetup->getBidfloor(), 'USD', $adRequest->isSecure(),$pmpObject);
                break;
        }

        $geoObject = new GeoObject($adRequest->getCountry(),$adRequest->getCity(),$adRequest->getLat(),$adRequest->getLon());

        $deviceObject = new DeviceObject($geoObject, $adRequest->getIp(), $adRequest->getUa(),$adRequest->getLanguage(),$adRequest->getCarrier(),$adRequest->getDevicetype(),$adRequest->getIfa(),$adRequest->getOs());


        $explodeCookie = explode('::::',$adRequest->getCookie());
        if(isset($explodeCookie[1])){
            $userObject = new UserObject($explodeCookie[0],$explodeCookie[1]);
        }else{
            $userObject = new UserObject($explodeCookie[0]);
        }

        $publisherObject = new PublisherObject($adRequest->getPublisherId(),$adRequest->getPublisherName(),$adRequest->getPublisherCat());

        $siteObject = null;
        $appObject = null;

        if($adRequest->getAppId()){
            $appObject = new AppObject($publisherObject,$adRequest->getAppId(),$adRequest->getAppName(),$adRequest->getAppDomain(),$adRequest->getAppPage());

        }else{
            $siteObject = new SiteObject($publisherObject,$adRequest->getSiteId(),$adRequest->getSiteName(),$adRequest->getSiteDomain(),$adRequest->getSitePage());

        }

        $extObject = new RegulationExtObject($adRequest->isGdpr(),$adRequest->getUsPrivacy());
        $regsObject = new RegulationObject($adRequest->isCoppa(),$extObject);

        $bidRequest = new BidRequest($adRequest->getId(), $arrayImpressions, $deviceObject,['USD'], $RTBSetup->getTmax(),$RTBSetup->getAt(), $siteObject, $appObject, $userObject, $RTBSetup->getBcat(), $RTBSetup->getBadv(), $RTBSetup->getWseat(), $regsObject);

        return $bidRequest;
    }

}