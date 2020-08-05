<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 17/04/2020
 * Time: 17:35
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class DeviceObject
{

    /**
     * @var GeoObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\GeoObject")
     * @Serializer\Groups({"message"})
     */
    protected $geo;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $ip;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $ua;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $language;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $carrier;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $devicetype;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $ifa;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $os;

    /**
     * DeviceObject constructor.
     * @param GeoObject $geo
     * @param string $ip
     * @param string $ua
     * @param string $language
     * @param string $carrier
     * @param int $devicetype
     * @param string $ifa
     * @param string $os
     */
    public function __construct(
        GeoObject $geo,
        string $ip,
        string $ua = null,
        string $language = null,
        string $carrier = null,
        int $devicetype = null,
        string $ifa = null,
        string $os = null)
    {
        $this->geo = $geo;
        $this->ip = $ip;
        $this->ua = $ua;
        $this->language = $language;
        $this->carrier = $carrier;
        $this->devicetype = $devicetype;
        $this->ifa = $ifa;
        $this->os = $os;
    }

    /**
     * @return GeoObject
     */
    public function getGeo(): GeoObject
    {
        return $this->geo;
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



}