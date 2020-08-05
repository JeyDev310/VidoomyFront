<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 14:10
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeRequestAssetsImageObject
{

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $h;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $w;

    /**
     * NativeRequestAssetsImageObject constructor.
     * @param int $h
     * @param int $w
     */
    public function __construct(
        int $h = null,
        int $w = null)
    {
        $this->h = $h;
        $this->w = $w;
    }

    /**
     * @return int
     */
    public function getH():? int
    {
        return $this->h;
    }

    /**
     * @return int
     */
    public function getW():? int
    {
        return $this->w;
    }

}