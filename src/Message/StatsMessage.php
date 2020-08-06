<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 21/04/2020
 * Time: 10:27
 */

namespace App\Message;

class StatsMessage
{
    private $publisher;
    private $adType;
    private $site;
    private $zone;
    private $domain;
    private $platform;
    private $country;
    private $date;
    private $bidResponse;
    private $impression;
    private $bidResponseMoney;
    private $impressionMoney;
    private $adomain;
    private $seat;

    /**
     * StatsMessage constructor.
     * @param string $publisher
     * @param int $adType
     * @param string $site
     * @param string $zone
     * @param string $domain
     * @param int $platform
     * @param string $country
     * @param \DateTime $date
     * @param int $bidResponse
     * @param int $impression
     * @param float $bidResponseMoney
     * @param float $impressionMoney
     * @param string $adomain
     * @param string $seat
     */
    public function __construct(
        string $publisher,
        int $adType,
        string $site = null,
        string $zone = null,
        string $domain = null,
        int $platform,
        string $country,
        \DateTime $date,
        int $bidResponse = null,
        int $impression = null,
        float $bidResponseMoney = null,
        float $impressionMoney = null,
        string $adomain = null,
        string $seat = null)
    {
        $this->publisher = $publisher;
        $this->adType = $adType;
        $this->site = $site;
        $this->zone = $zone;
        $this->domain = $domain;
        $this->platform = $platform;
        $this->country = $country;
        $this->date = $date;
        $this->bidResponse = $bidResponse;
        $this->impression = $impression;
        $this->bidResponseMoney = $bidResponseMoney;
        $this->impressionMoney = $impressionMoney;
        $this->adomain = $adomain;
        $this->seat = $seat;
    }

    /**
     * @return string
     */
    public function getPublisher(): string
    {
        return $this->publisher;
    }

    /**
     * @return int
     */
    public function getAdType(): int
    {
        return $this->adType;
    }

    /**
     * @return string
     */
    public function getSite():? string
    {
        return $this->site;
    }

    /**
     * @return string
     */
    public function getZone():? string
    {
        return $this->zone;
    }

    /**
     * @return string
     */
    public function getDomain():? string
    {
        return $this->domain;
    }

    /**
     * @return int
     */
    public function getPlatform(): int
    {
        return $this->platform;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getBidResponse():? int
    {
        return $this->bidResponse;
    }

    /**
     * @return int
     */
    public function getImpression():? int
    {
        return $this->impression;
    }

    /**
     * @return float
     */
    public function getBidResponseMoney():? float
    {
        return $this->bidResponseMoney;
    }

    /**
     * @return float
     */
    public function getImpressionMoney():? float
    {
        return $this->impressionMoney;
    }

    /**
     * @return string
     */
    public function getAdomain():? string
    {
        return $this->adomain;
    }

    /**
     * @return string
     */
    public function getSeat():? string
    {
        return $this->seat;
    }

}