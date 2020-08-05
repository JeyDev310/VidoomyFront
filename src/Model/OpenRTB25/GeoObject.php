<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 17/04/2020
 * Time: 17:42
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class GeoObject
{

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $country;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $city;

    /**
     * @var float
     *
     * @Serializer\Type("float")
     * @Serializer\Groups({"message"})
     */
    protected $lat;

    /**
     * @var float
     *
     * @Serializer\Type("float")
     * @Serializer\Groups({"message"})
     */
    protected $lon;

    /**
     * GeoObject constructor.
     * @param string $country
     * @param string $city
     * @param float $lat
     * @param float $lon
     */
    public function __construct(
        string $country,
        string $city = null,
        float $lat = null,
        float $lon = null)
    {
        $this->country = $country;
        $this->city = $city;
        $this->lat = $lat;
        $this->lon = $lon;
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



}