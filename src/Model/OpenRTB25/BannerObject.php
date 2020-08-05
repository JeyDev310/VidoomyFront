<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 21/04/2020
 * Time: 12:44
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class BannerObject
{

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $id;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $w;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $h;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $btype;

    /**
     * BannerObject constructor.
     * @param string $id
     * @param int $w
     * @param int $h
     * @param array $btype
     */
    public function __construct(
        string $id,
        int $w,
        int $h,
        array $btype = null)
    {
        $this->id = $id;
        $this->w = $w;
        $this->h = $h;
        $this->btype = $btype;
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
    public function getW(): int
    {
        return $this->w;
    }

    /**
     * @return int
     */
    public function getH(): int
    {
        return $this->h;
    }

    /**
     * @return array
     */
    public function getBtype():? array
    {
        return $this->btype;
    }

}