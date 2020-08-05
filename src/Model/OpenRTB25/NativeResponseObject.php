<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 13:34
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeResponseObject
{
    /**
     * @var array
     *
     * @Serializer\Type("array<App\Model\OpenRTB25\NativeResponseAssetsObject>")
     * @Serializer\Groups({"message"})
     */
    protected $assets;

    /**
     * @var NativeResponseLinkObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeResponseLinkObject")
     * @Serializer\Groups({"message"})
     */
    protected $link;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $imptrackers;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $ver;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $jstracker;

    /**
     * @var array
     *
     * @Serializer\Type("array<App\Model\OpenRTB25\EventTrackerRequestObject>")
     * @Serializer\Groups({"message"})
     */
    protected $eventtrackers;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $privacy;

    /**
     * NativeResponseObject constructor.
     * @param array $assets
     * @param NativeResponseLinkObject $link
     * @param array $imptrackers
     * @param string $ver
     * @param string $jstracker
     * @param array $eventtrackers
     * @param string $privacy
     */
    public function __construct(
        array $assets,
        NativeResponseLinkObject $link,
        array $imptrackers = null,
        string $ver = null,
        string $jstracker = null,
        array $eventtrackers = null,
        string $privacy = null)
    {
        $this->assets = $assets;
        $this->link = $link;
        $this->imptrackers = $imptrackers;
        $this->ver = $ver;
        $this->jstracker = $jstracker;
        $this->eventtrackers = $eventtrackers;
        $this->privacy = $privacy;
    }

    /**
     * @return array
     */
    public function getAssets(): array
    {
        return $this->assets;
    }

    /**
     * @return NativeResponseLinkObject
     */
    public function getLink(): NativeResponseLinkObject
    {
        return $this->link;
    }

    /**
     * @return array
     */
    public function getImptrackers():? array
    {
        return $this->imptrackers;
    }

    /**
     * @return string
     */
    public function getVer():? string
    {
        return $this->ver;
    }

    /**
     * @return string
     */
    public function getJstracker():? string
    {
        return $this->jstracker;
    }

    /**
     * @return array
     */
    public function getEventtrackers():? array
    {
        return $this->eventtrackers;
    }

    /**
     * @return string
     */
    public function getPrivacy():? string
    {
        return $this->privacy;
    }




}