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
    public function execute(Request $request): AdRequest
    {

        //Ad Type
        $ad_type = $request->query->get('ad_type');

        //Bid Request Object
        $id = $request->query->get('id');

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
        $publisher_cat = $request->query->get('publisher_cat');

        //Site Object
        $site_id = $request->query->get('site_id');
        $site_name = $request->query->get('site_name');
        $site_domain = $request->query->get('site_domain');
        $site_page = $request->query->get('site_page');

        //App Object
        $app_id = $request->query->get('app_id');
        $app_name = $request->query->get('app_name');
        $app_domain = $request->query->get('app_domain');
        $app_page = $request->query->get('app_page');

        //Regulation Object
        $coppa = $request->query->get('coppa');

        //Regs Ext Object¶
        $gdpr = $request->query->get('gdpr');
        $us_privacy = $request->query->get('us_privacy');

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
            $us_privacy);

        return $adRequest;
    }

}