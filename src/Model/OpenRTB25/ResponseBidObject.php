<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 13:14
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class ResponseBidObject
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $impid;

    /**
     * @var float
     *
     * @Serializer\Type("float")
     * @Serializer\Groups({"message"})
     */
    protected $price;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $protocol;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $adm;

    /**
     * @var NativeResponseObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeResponseObject")
     * @Serializer\Groups({"message"})
     */
    protected $adm_native;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $burl;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $iurl;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $language;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $adomain;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $cat;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $cid;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $crid;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $attr;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $dealid;

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
     * @var BidExtObject
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $ext;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $seat;

    /**
     * ResponseBidObject constructor.
     * @param string $id
     * @param string $impid
     * @param float $price
     * @param int $protocol
     * @param string $adm
     * @param NativeResponseObject $adm_native
     * @param string $burl
     * @param string $iurl
     * @param string $language
     * @param array $adomain
     * @param array $cat
     * @param string $cid
     * @param string $crid
     * @param array $attr
     * @param string $dealid
     * @param int $h
     * @param int $w
     * @param BidExtObject $ext
     * @param string $seat
     */
    public function __construct(
        string $id,
        string $impid,
        float $price,
        int $protocol = null,
        string $adm = null,
        NativeResponseObject $adm_native = null,
        string $burl,
        string $iurl = null,
        string $language = null,
        array $adomain,
        array $cat = null,
        string $cid = null,
        string $crid,
        array $attr = null,
        string $dealid = null,
        int $h = null,
        int $w = null,
        BidExtObject $ext = null,
        string $seat = null)
    {
        $this->id = $id;
        $this->impid = $impid;
        $this->price = $price;
        $this->protocol = $protocol;
        $this->adm = $adm;
        $this->adm_native = $adm_native;
        $this->burl = $burl;
        $this->iurl = $iurl;
        $this->language = $language;
        $this->adomain = $adomain;
        $this->cat = $cat;
        $this->cid = $cid;
        $this->crid = $crid;
        $this->attr = $attr;
        $this->dealid = $dealid;
        $this->h = $h;
        $this->w = $w;
        $this->ext = $ext;
        $this->seat = $seat;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getImpid(): string
    {
        return $this->impid;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getProtocol():? int
    {
        return $this->protocol;
    }

    /**
     * @return string
     */
    public function getAdm():? string
    {
        return $this->adm;
    }

    /**
     * @return NativeResponseObject
     */
    public function getAdmNative():? NativeResponseObject
    {
        return $this->adm_native;
    }

    /**
     * @return string
     */
    public function getBurl(): string
    {
        return $this->burl;
    }

    /**
     * @return string
     */
    public function getIurl():? string
    {
        return $this->iurl;
    }

    /**
     * @return string
     */
    public function getLanguage():? string
    {
        return $this->language;
    }

    /**
     * @return array
     */
    public function getAdomain(): array
    {
        return $this->adomain;
    }

    /**
     * @return array
     */
    public function getCat():? array
    {
        return $this->cat;
    }

    /**
     * @return string
     */
    public function getCid():? string
    {
        return $this->cid;
    }

    /**
     * @return string
     */
    public function getCrid(): string
    {
        return $this->crid;
    }

    /**
     * @return array
     */
    public function getAttr():? array
    {
        return $this->attr;
    }

    /**
     * @return string
     */
    public function getDealid():? string
    {
        return $this->dealid;
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

    /**
     * @return BidExtObject
     */
    public function getExt():? BidExtObject
    {
        return $this->ext;
    }

    /**
     * @return string
     */
    public function getSeat():? string
    {
        return $this->seat;
    }

    /**
     * @param string $seat
     */
    public function setSeat(string $seat): void
    {
        $this->seat = $seat;
    }


}