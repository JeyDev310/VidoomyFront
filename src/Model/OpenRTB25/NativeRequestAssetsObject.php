<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 14:00
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeRequestAssetsObject
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
     * @var NativeRequestAssetsTitleObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeRequestAssetsTitleObject")
     * @Serializer\Groups({"message"})
     */
    protected $title;

    /**
     * @var NativeRequestAssetsImageObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeRequestAssetsImageObject")
     * @Serializer\Groups({"message"})
     */
    protected $img;

    /**
     * @var NativeRequestAssetsVideoObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeRequestAssetsVideoObject")
     * @Serializer\Groups({"message"})
     */
    protected $video;

    /**
     * @var NativeRequestAssetsDataObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeRequestAssetsDataObject")
     * @Serializer\Groups({"message"})
     */
    protected $data;

    /**
     * NativeRequestAssetsObject constructor.
     * @param int $id
     * @param int $required
     * @param NativeRequestAssetsTitleObject $title
     * @param NativeRequestAssetsImageObject $img
     * @param NativeRequestAssetsVideoObject $video
     * @param NativeRequestAssetsDataObject $data
     */
    public function __construct(
        int $id,
        int $required = null,
        NativeRequestAssetsTitleObject $title = null,
        NativeRequestAssetsImageObject $img = null,
        NativeRequestAssetsVideoObject $video = null,
        NativeRequestAssetsDataObject $data = null)
    {
        $this->id = $id;
        $this->required = $required;
        $this->title = $title;
        $this->img = $img;
        $this->video = $video;
        $this->data = $data;
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
     * @return NativeRequestAssetsTitleObject
     */
    public function getTitle():? NativeRequestAssetsTitleObject
    {
        return $this->title;
    }

    /**
     * @return NativeRequestAssetsImageObject
     */
    public function getImg():? NativeRequestAssetsImageObject
    {
        return $this->img;
    }

    /**
     * @return NativeRequestAssetsVideoObject
     */
    public function getVideo():? NativeRequestAssetsVideoObject
    {
        return $this->video;
    }

    /**
     * @return NativeRequestAssetsDataObject
     */
    public function getData():? NativeRequestAssetsDataObject
    {
        return $this->data;
    }



}