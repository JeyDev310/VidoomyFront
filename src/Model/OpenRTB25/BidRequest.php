<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 16/04/2020
 * Time: 13:50
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class BidRequest
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
     * @Serializer\Type("array<App\Model\OpenRTB25\ImpressionObject>")
     * @Serializer\Groups({"message"})
     */
    protected $imp;

    /**
     * @var DeviceObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\DeviceObject")
     * @Serializer\Groups({"message"})
     */
    protected $device;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $currency;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $tmax;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $at;

    /**
     * @var SiteObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\SiteObject")
     * @Serializer\Groups({"message"})
     */
    protected $site;

    /**
     * @var AppObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\AppObject")
     * @Serializer\Groups({"message"})
     */
    protected $app;

    /**
     * @var UserObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\UserObject")
     * @Serializer\Groups({"message"})
     */
    protected $user;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $bcat;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $badv;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $wseat;

    /**
     * @var RegulationObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\RegulationObject")
     * @Serializer\Groups({"message"})
     */
    protected $regs;

    /**
     * BidRequest constructor.
     * @param string $id
     * @param array $imp
     * @param DeviceObject $device
     * @param array $currency
     * @param int $tmax
     * @param int $at
     * @param SiteObject $site
     * @param AppObject $app
     * @param UserObject $user
     * @param array $bcat
     * @param array $badv
     * @param array $wseat
     * @param RegulationObject $regs
     */
    public function __construct(
        string $id,
        array $imp,
        DeviceObject $device,
        array $currency,
        int $tmax,
        int $at,
        SiteObject $site = null,
        AppObject $app = null,
        UserObject $user = null,
        array $bcat = null,
        array $badv = null,
        array $wseat = null,
        RegulationObject $regs = null)
    {
        $this->id = $id;
        $this->imp = $imp;
        $this->device = $device;
        $this->currency = $currency;
        $this->tmax = $tmax;
        $this->at = $at;
        $this->site = $site;
        $this->app = $app;
        $this->user = $user;
        $this->bcat = $bcat;
        $this->badv = $badv;
        $this->wseat = $wseat;
        $this->regs = $regs;
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
    public function getImp(): array
    {
        return $this->imp;
    }

    /**
     * @return DeviceObject
     */
    public function getDevice(): DeviceObject
    {
        return $this->device;
    }

    /**
     * @return array
     */
    public function getCurrency(): array
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getTmax(): int
    {
        return $this->tmax;
    }

    /**
     * @return int
     */
    public function getAt(): int
    {
        return $this->at;
    }

    /**
     * @return SiteObject
     */
    public function getSite():? SiteObject
    {
        return $this->site;
    }

    /**
     * @return AppObject
     */
    public function getApp():? AppObject
    {
        return $this->app;
    }

    /**
     * @return UserObject
     */
    public function getUser():? UserObject
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getBcat():? array
    {
        return $this->bcat;
    }

    /**
     * @return array
     */
    public function getBadv():? array
    {
        return $this->badv;
    }

    /**
     * @return array
     */
    public function getWseat():? array
    {
        return $this->wseat;
    }

    /**
     * @return RegulationObject
     */
    public function getRegs():? RegulationObject
    {
        return $this->regs;
    }




}