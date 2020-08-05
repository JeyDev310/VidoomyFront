<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 15/04/2020
 * Time: 12:22
 */

namespace App\Model;


class AdRequest
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var int
     */
    protected $ad_type;

    /**
     * @var boolean
     */
    protected $secure;

    /**
     * @var array
     */
    protected $mimes;

    /**
     * @var int
     */
    protected $minduration;

    /**
     * @var int
     */
    protected $maxduration;

    /**
     * @var int
     */
    protected $pos;

    /**
     * @var array
     */
    protected $protocols;

    /**
     * @var int
     */
    protected $w;

    /**
     * @var int
     */
    protected $h;

    /**
     * @var boolean
     */
    protected $skip;

    /**
     * @var array
     */
    protected $btype;

    /**
     * @var int
     */
    protected $native_title_len;

    /**
     * @var int
     */
    protected $native_img_w;

    /**
     * @var int
     */
    protected $native_img_h;

    /**
     * @var array
     */
    protected $native_video_mimes;

    /**
     * @var int
     */
    protected $native_video_minduration;

    /**
     * @var int
     */
    protected $native_video_maxduration;

    /**
     * @var array
     */
    protected $native_video_protocols;

    /**
     * @var int
     */
    protected $native_data_type;

    /**
     * @var string
     */
    protected $ip;

    /**
     * @var string
     */
    protected $ua;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var string
     */
    protected $carrier;

    /**
     * @var int
     */
    protected $devicetype;

    /**
     * @var string
     */
    protected $ifa;

    /**
     * @var string
     */
    protected $os;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var float
     */
    protected $lat;

    /**
     * @var float
     */
    protected $lon;

    /**
     * @var string
     */
    protected $publisher_id;

    /**
     * @var string
     */
    protected $publisher_name;

    /**
     * @var array
     */
    protected $publisher_cat;

    /**
     * @var string
     */
    protected $site_id;

    /**
     * @var string
     */
    protected $site_name;

    /**
     * @var string
     */
    protected $site_domain;

    /**
     * @var string
     */
    protected $site_page;

    /**
     * @var string
     */
    protected $app_id;

    /**
     * @var string
     */
    protected $app_name;

    /**
     * @var string
     */
    protected $app_domain;

    /**
     * @var string
     */
    protected $app_page;

    /**
     * @var boolean
     */
    protected $coppa;

    /**
     * @var boolean
     */
    protected $gdpr;

    /**
     * @var string
     */
    protected $us_privacy;

    /**
     * AdRequest constructor.
     * @param string $id
     * @param int $ad_type
     * @param bool $secure
     * @param array $mimes
     * @param int $minduration
     * @param int $maxduration
     * @param int $pos
     * @param array $protocols
     * @param int $w
     * @param int $h
     * @param bool $skip
     * @param array $btype
     * @param int $native_title_len
     * @param int $native_img_w
     * @param int $native_img_h
     * @param array $native_video_mimes
     * @param int $native_video_minduration
     * @param int $native_video_maxduration
     * @param array $native_video_protocols
     * @param int $native_data_type
     * @param string $ip
     * @param string $ua
     * @param string $language
     * @param string $carrier
     * @param int $devicetype
     * @param string $ifa
     * @param string $os
     * @param string $country
     * @param string $city
     * @param float $lat
     * @param float $lon
     * @param string $publisher_id
     * @param string $publisher_name
     * @param array $publisher_cat
     * @param string $site_id
     * @param string $site_name
     * @param string $site_domain
     * @param string $site_page
     * @param string $app_id
     * @param string $app_name
     * @param string $app_domain
     * @param string $app_page
     * @param bool $coppa
     * @param bool $gdpr
     * @param string $us_privacy
     */
    public function __construct(
        string $id,
        int $ad_type,
        bool $secure = null,
        array $mimes = null,
        int $minduration = null,
        int $maxduration = null,
        int $pos = null,
        array $protocols = null,
        int $w = null,
        int $h = null,
        bool $skip = null,
        array $btype = null,
        int $native_title_len = null,
        int $native_img_w = null,
        int $native_img_h = null,
        array $native_video_mimes = null,
        int $native_video_minduration = null,
        int $native_video_maxduration = null,
        array $native_video_protocols = null,
        int $native_data_type = null,
        string $ip,
        string $ua,
        string $language = null,
        string $carrier = null,
        int $devicetype = null,
        string $ifa = null,
        string $os = null,
        string $country,
        string $city = null,
        float $lat = null,
        float $lon = null,
        string $publisher_id,
        string $publisher_name = null,
        array $publisher_cat = null,
        string $site_id = null,
        string $site_name = null,
        string $site_domain = null,
        string $site_page = null,
        string $app_id = null,
        string $app_name = null,
        string $app_domain = null,
        string $app_page = null,
        bool $coppa = null,
        bool $gdpr = null,
        string $us_privacy = null)
    {
        $this->id = $id;
        $this->ad_type = $ad_type;
        $this->secure = $secure;
        $this->mimes = $mimes;
        $this->minduration = $minduration;
        $this->maxduration = $maxduration;
        $this->pos = $pos;
        $this->protocols = $protocols;
        $this->w = $w;
        $this->h = $h;
        $this->skip = $skip;
        $this->btype = $btype;
        $this->native_title_len = $native_title_len;
        $this->native_img_w = $native_img_w;
        $this->native_img_h = $native_img_h;
        $this->native_video_mimes = $native_video_mimes;
        $this->native_video_minduration = $native_video_minduration;
        $this->native_video_maxduration = $native_video_maxduration;
        $this->native_video_protocols = $native_video_protocols;
        $this->native_data_type = $native_data_type;
        $this->ip = $ip;
        $this->ua = $ua;
        $this->language = $language;
        $this->carrier = $carrier;
        $this->devicetype = $devicetype;
        $this->ifa = $ifa;
        $this->os = $os;
        $this->country = $country;
        $this->city = $city;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->publisher_id = $publisher_id;
        $this->publisher_name = $publisher_name;
        $this->publisher_cat = $publisher_cat;
        $this->site_id = $site_id;
        $this->site_name = $site_name;
        $this->site_domain = $site_domain;
        $this->site_page = $site_page;
        $this->app_id = $app_id;
        $this->app_name = $app_name;
        $this->app_domain = $app_domain;
        $this->app_page = $app_page;
        $this->coppa = $coppa;
        $this->gdpr = $gdpr;
        $this->us_privacy = $us_privacy;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAdType(): int
    {
        return $this->ad_type;
    }

    /**
     * @return bool
     */
    public function isSecure():? bool
    {
        return $this->secure;
    }

    /**
     * @return array
     */
    public function getMimes(): array
    {
        return $this->mimes;
    }

    /**
     * @return int
     */
    public function getMinduration(): int
    {
        return $this->minduration;
    }

    /**
     * @return int
     */
    public function getMaxduration(): int
    {
        return $this->maxduration;
    }

    /**
     * @return int
     */
    public function getPos():? int
    {
        return $this->pos;
    }

    /**
     * @return array
     */
    public function getProtocols(): array
    {
        return $this->protocols;
    }

    /**
     * @return int
     */
    public function getW():? int
    {
        return $this->w;
    }

    /**
     * @return int
     */
    public function getH():? int
    {
        return $this->h;
    }

    /**
     * @return bool
     */
    public function isSkip():? bool
    {
        return $this->skip;
    }

    /**
     * @return array
     */
    public function getBtype():? array
    {
        return $this->btype;
    }

    /**
     * @return int
     */
    public function getNativeTitleLen():? int
    {
        return $this->native_title_len;
    }

    /**
     * @return int
     */
    public function getNativeImgW():? int
    {
        return $this->native_img_w;
    }

    /**
     * @return int
     */
    public function getNativeImgH():? int
    {
        return $this->native_img_h;
    }

    /**
     * @return array
     */
    public function getNativeVideoMimes():? array
    {
        return $this->native_video_mimes;
    }

    /**
     * @return int
     */
    public function getNativeVideoMinduration():? int
    {
        return $this->native_video_minduration;
    }

    /**
     * @return int
     */
    public function getNativeVideoMaxduration():? int
    {
        return $this->native_video_maxduration;
    }

    /**
     * @return array
     */
    public function getNativeVideoProtocols():? array
    {
        return $this->native_video_protocols;
    }

    /**
     * @return int
     */
    public function getNativeDataType():? int
    {
        return $this->native_data_type;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getUa():? string
    {
        return $this->ua;
    }

    /**
     * @return string
     */
    public function getLanguage():? string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getCarrier():? string
    {
        return $this->carrier;
    }

    /**
     * @return int
     */
    public function getDevicetype():? int
    {
        return $this->devicetype;
    }

    /**
     * @return string
     */
    public function getIfa():? string
    {
        return $this->ifa;
    }

    /**
     * @return string
     */
    public function getOs():? string
    {
        return $this->os;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getCity():? string
    {
        return $this->city;
    }

    /**
     * @return float
     */
    public function getLat():? float
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLon():? float
    {
        return $this->lon;
    }

    /**
     * @return string
     */
    public function getPublisherId(): string
    {
        return $this->publisher_id;
    }

    /**
     * @return string
     */
    public function getPublisherName():? string
    {
        return $this->publisher_name;
    }

    /**
     * @return array
     */
    public function getPublisherCat():? array
    {
        return $this->publisher_cat;
    }

    /**
     * @return string
     */
    public function getSiteId():? string
    {
        return $this->site_id;
    }

    /**
     * @return string
     */
    public function getSiteName():? string
    {
        return $this->site_name;
    }

    /**
     * @return string
     */
    public function getSiteDomain():? string
    {
        return $this->site_domain;
    }

    /**
     * @return string
     */
    public function getSitePage():? string
    {
        return $this->site_page;
    }

    /**
     * @return string
     */
    public function getAppId():? string
    {
        return $this->app_id;
    }

    /**
     * @return string
     */
    public function getAppName():? string
    {
        return $this->app_name;
    }

    /**
     * @return string
     */
    public function getAppDomain():? string
    {
        return $this->app_domain;
    }

    /**
     * @return string
     */
    public function getAppPage():? string
    {
        return $this->app_page;
    }

    /**
     * @return bool
     */
    public function isCoppa():? bool
    {
        return $this->coppa;
    }

    /**
     * @return bool
     */
    public function isGdpr():? bool
    {
        return $this->gdpr;
    }

    /**
     * @return string
     */
    public function getUsPrivacy():? string
    {
        return $this->us_privacy;
    }



}