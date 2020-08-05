<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 13:21
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class BidExtObject
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $advertiser_name;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $agency_name;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $agency_id;

    /**
     * BidExtObject constructor.
     * @param string $advertiser_name
     * @param string $agency_name
     * @param string $agency_id
     */
    public function __construct(
        string $advertiser_name = null,
        string $agency_name = null,
        string $agency_id = null)
    {
        $this->advertiser_name = $advertiser_name;
        $this->agency_name = $agency_name;
        $this->agency_id = $agency_id;
    }

    /**
     * @return string
     */
    public function getAdvertiserName():? string
    {
        return $this->advertiser_name;
    }

    /**
     * @return string
     */
    public function getAgencyName():? string
    {
        return $this->agency_name;
    }

    /**
     * @return string
     */
    public function getAgencyId():? string
    {
        return $this->agency_id;
    }




}