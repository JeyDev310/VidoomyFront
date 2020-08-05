<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 28/04/2020
 * Time: 14:33
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeResponseAssetsImageObject
{

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $url;

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
     * NativeResponseAssetsImageObject constructor.
     * @param string $url
     * @param int $h
     * @param int $w
     */
    public function __construct(string $url, int $h, int $w)
    {
        $this->url = $url;
        $this->h = $h;
        $this->w = $w;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getH(): int
    {
        return $this->h;
    }

    /**
     * @return int
     */
    public function getW(): int
    {
        return $this->w;
    }




}