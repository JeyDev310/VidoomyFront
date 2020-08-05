<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 17/04/2020
 * Time: 18:39
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class RegulationExtObject
{
    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $gdpr;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $us_privacy;

    /**
     * RegulationExtObject constructor.
     * @param int $gdpr
     * @param string $us_privacy
     */
    public function __construct(
        int $gdpr = null,
        string $us_privacy = null)
    {
        $this->gdpr = $gdpr;
        $this->us_privacy = $us_privacy;
    }

    /**
     * @return int
     */
    public function getGdpr():? int
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