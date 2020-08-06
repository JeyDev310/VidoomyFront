<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 15/04/2020
 * Time: 12:12
 */

namespace App\Handler\AdRequest;

use Symfony\Component\HttpFoundation\Request;
use App\Model\AdRequest;

class ParseRequestHandler
{

    /**
     * @param Request $request
     *
     * @return AdRequest
     *
     * @throws \Exception
     */
    public function execute(Request $request): ?AdRequest
    {

        //Ad Type
        $ad_type = $request->query->get('ad_type');

        //Bid Request Object
        $id = $request->query->get('id');

        if(!$id){
            return null;
        }

        //Impression Object
        $secure = $request->query->get('secure');

        //Video Object
        $mimes = $request->query->get('mimes');
        $minduration = $request->query->get('minduration');
        $maxduration = $request->query->get('maxduration');
        $pos = $request->query->get('pos');
        $protocols = $request->query->get('protocols');
        $w = $request->query->get('w');
        $h = $request->query->get('h');
        $skip = $request->query->get('skip');

        //Banner Object
        $btype = $request->query->get('btype');

        //Native Object
        $native_title_len = $request->query->get('native_title_len');
        $native_img_w = $request->query->get('native_img_w');
        $native_img_h = $request->query->get('native_img_h');
        $native_video_mimes = $request->query->get('native_video_mimes');
        $native_video_minduration = $request->query->get('native_video_minduration');
        $native_video_maxduration = $request->query->get('native_video_maxduration');
        $native_video_protocols = $request->query->get('native_video_protocols');
        $native_data_type = $request->query->get('native_data_type');

        //Device Object
        $ip = $request->query->get('ip');
        $ua = $request->query->get('ua');
        $language = $request->query->get('language');
        $carrier = $request->query->get('carrier');
        $devicetype = $request->query->get('devicetype');
        $ifa = $request->query->get('ifa');
        $os = $request->query->get('os');

        //Geo Object
        $country = $request->query->get('country');
        $city = $request->query->get('city');
        $lat = $request->query->get('lat');
        $lon = $request->query->get('lon');

        //Publisher Object
        $publisher_id = $request->query->get('publisher_id');

        $publisher_name = $request->query->get('publisher_name');
        if (empty ($publisher_name)){
            $publisher_name = null;
        }

        $publisher_cat = $request->query->get('publisher_cat');
        if (empty ($publisher_cat)){
            $publisher_cat = null;
        }

        //Site Object
        $site_id = $request->query->get('site_id');
        if (empty ($site_id)){
            $site_id = null;
        }

        $site_name = $request->query->get('site_name');
        if (empty ($site_name)){
            $site_name = null;
        }

        $site_domain = $request->query->get('site_domain');
        if (empty ($site_domain)){
            $site_domain = null;
        }

        $site_page = $request->query->get('site_page');
        if (empty ($site_page)){
            $site_page = null;
        }

        //App Object
        $app_id = $request->query->get('app_id');
        if (empty ($app_id)){
            $app_id = null;
        }

        $app_name = $request->query->get('app_name');
        if (empty ($app_name)){
            $app_name = null;
        }

        $app_domain = $request->query->get('app_domain');
        if (empty ($app_domain)){
            $app_domain = null;
        }

        $app_page = $request->query->get('app_page');
        if (empty ($app_page)){
            $app_page = null;
        }

        //Regulation Object
        $coppa = $request->query->get('coppa');
        if (empty ($coppa)){
            $coppa = null;
        }
        //Regs Ext Object¶
        $gdpr = $request->query->get('gdpr');
        if (empty ($gdpr)){
            $gdpr = null;
        }

        $us_privacy = $request->query->get('us_privacy');
        if (empty ($us_privacy)){
            $us_privacy = null;
        }

        //User Sync Cookie
        if($request->cookies->has('Bidoomy-Cookie')){
            $cookie = $request->cookies->get('Bidoomy-Cookie');
        }else{
            $cookie = $id;
        }


        $adRequest = new AdRequest(
            $id,
            $ad_type,
            $secure,
            $mimes,
            $minduration,
            $maxduration,
            $pos,
            $protocols,
            $w,
            $h,
            $skip,
            $btype,
            $native_title_len,
            $native_img_w,
            $native_img_h,
            $native_video_mimes,
            $native_video_minduration,
            $native_video_maxduration,
            $native_video_protocols,
            $native_data_type,
            $ip,
            $ua,
            $language,
            $carrier,
            $devicetype,
            $ifa,
            $os,
            $country,
            $city,
            $lat,
            $lon,
            $publisher_id,
            $publisher_name,
            $publisher_cat,
            $site_id,
            $site_name,
            $site_domain,
            $site_page,
            $app_id,
            $app_name,
            $app_domain,
            $app_page,
            $coppa,
            $gdpr,
            $us_privacy,
            $cookie);

        return $adRequest;
    }

}