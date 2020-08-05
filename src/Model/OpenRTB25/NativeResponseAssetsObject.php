<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 14:00
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeResponseAssetsObject
{
    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $id;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $required;

    /**
     * @var NativeResponseAssetsTitleObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeResponseAssetsTitleObject")
     * @Serializer\Groups({"message"})
     */
    protected $title;

    /**
     * @var NativeResponseAssetsImageObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeResponseAssetsImageObject")
     * @Serializer\Groups({"message"})
     */
    protected $img;

    /**
     * @var NativeResponseAssetsVideoObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeResponseAssetsVideoObject")
     * @Serializer\Groups({"message"})
     */
    protected $video;

    /**
     * @var NativeResponseAssetsDataObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeResponseAssetsDataObject")
     * @Serializer\Groups({"message"})
     */
    protected $data;


    /**
     * @var NativeResponseLinkObject
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $link;

    /**
     * NativeResponseAssetsObject constructor.
     * @param int $id
     * @param int $required
     * @param NativeResponseAssetsTitleObject $title
     * @param NativeResponseAssetsImageObject $img
     * @param NativeResponseAssetsVideoObject $video
     * @param NativeResponseAssetsDataObject $data
     * @param NativeResponseLinkObject $link
     */
    public function __construct(
        int $id,
        int $required = null,
        NativeResponseAssetsTitleObject $title = null,
        NativeResponseAssetsImageObject $img = null,
        NativeResponseAssetsVideoObject $video = null,
        NativeResponseAssetsDataObject $data = null,
        NativeResponseLinkObject $link = null)
    {
        $this->id = $id;
        $this->required = $required;
        $this->title = $title;
        $this->img = $img;
        $this->video = $video;
        $this->data = $data;
        $this->link = $link;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getRequired():? int
    {
        return $this->required;
    }

    /**
     * @return NativeResponseAssetsTitleObject
     */
    public function getTitle():? NativeResponseAssetsTitleObject
    {
        return $this->title;
    }

    /**
     * @return NativeResponseAssetsImageObject
     */
    public function getImg():? NativeResponseAssetsImageObject
    {
        return $this->img;
    }

    /**
     * @return NativeResponseAssetsVideoObject
     */
    public function getVideo():? NativeResponseAssetsVideoObject
    {
        return $this->video;
    }

    /**
     * @return NativeResponseAssetsDataObject
     */
    public function getData():? NativeResponseAssetsDataObject
    {
        return $this->data;
    }

    /**
     * @return NativeResponseLinkObject
     */
    public function getLink():? NativeResponseLinkObject
    {
        return $this->link;
    }

}