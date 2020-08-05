<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 16/04/2020
 * Time: 19:39
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class ImpressionObject
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $id;

    /**
     * @var VideoObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\VideoObject")
     * @Serializer\Groups({"message"})
     */
    protected $video;

    /**
     * @var BannerObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\BannerObject")
     * @Serializer\Groups({"message"})
     */
    protected $banner;

    /**
     * @var NativeRequestObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeRequestObject")
     * @Serializer\Groups({"message"})
     */
    protected $native;

    /**
     * @var float
     *
     * @Serializer\Type("float")
     * @Serializer\Groups({"message"})
     */
    protected $bidfloor;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $bidfloorcur;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $secure;

    /**
     * @var PmpObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\PmpObject")
     * @Serializer\Groups({"message"})
     */
    protected $pmp;

    /**
     * ImpressionObject constructor.
     * @param string $id
     * @param $video
     * @param $banner
     * @param $native
     * @param float $bidfloor
     * @param string $bidfloorcur
     * @param int $secure
     * @param PmpObject $pmp
     */
    public function __construct(
        string $id,
        $video = null,
        $banner = null,
        $native = null,
        float $bidfloor = null,
        string $bidfloorcur = null,
        int $secure = null,
        PmpObject $pmp = null)
    {
        $this->id = $id;
        $this->video = $video;
        $this->banner = $banner;
        $this->native = $native;
        $this->bidfloor = $bidfloor;
        $this->bidfloorcur = $bidfloorcur;
        $this->secure = $secure;
        $this->pmp = $pmp;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return VideoObject
     */
    public function getVideo():? VideoObject
    {
        return $this->video;
    }

    /**
     * @return BannerObject
     */
    public function getBanner():? BannerObject
    {
        return $this->banner;
    }

    /**
     * @return NativeRequestObject
     */
    public function getNative():? NativeRequestObject
    {
        return $this->native;
    }

    /**
     * @return float
     */
    public function getBidfloor():? float
    {
        return $this->bidfloor;
    }

    /**
     * @return string
     */
    public function getBidfloorcur():? string
    {
        return $this->bidfloorcur;
    }

    /**
     * @return int
     */
    public function getSecure():? int
    {
        return $this->secure;
    }

    /**
     * @return PmpObject
     */
    public function getPmp():? PmpObject
    {
        return $this->pmp;
    }



}