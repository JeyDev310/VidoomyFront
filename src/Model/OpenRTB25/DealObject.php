<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 16/04/2020
 * Time: 19:31
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class DealObject
{

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $id;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $wseat;

    /**
     * @var float
     *
     * @Serializer\Type("float")
     * @Serializer\Groups({"message"})
     */
    protected $bidfloor;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $at;

    /**
     * DealObject constructor.
     * @param string $id
     * @param array $wseat
     * @param float $bidfloor
     * @param int $at
     */
    public function __construct(
        string $id,
        array $wseat = null,
        float $bidfloor = null,
        int $at = null)
    {
        $this->id = $id;
        $this->wseat = $wseat;
        $this->bidfloor = $bidfloor;
        $this->at = $at;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getWseat():? array
    {
        return $this->wseat;
    }

    /**
     * @return float
     */
    public function getBidfloor():? float
    {
        return $this->bidfloor;
    }

    /**
     * @return int
     */
    public function getAt():? int
    {
        return $this->at;
    }



}