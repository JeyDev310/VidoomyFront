<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 16/04/2020
 * Time: 13:03
 */

namespace App\Model;


class RTBSetup
{
    /**
     * @var float
     */
    protected $bidfloor;

    /**
     * @var string
     */
    protected $at;

    /**
     * @var int
     */
    protected $tmax;

    /**
     * @var array
     */
    protected $bcat;

    /**
     * @var array
     */
    protected $badv;

    /**
     * @var array
     */
    protected $wseat;

    /**
     * @var int
     */
    protected $private_auction;

    /**
     * @var array
     */
    protected $deals;

    /**
     * RTBSetup constructor.
     * @param float $bidfloor
     * @param string $at
     * @param int $tmax
     * @param array $bcat
     * @param array $badv
     * @param array $wseat
     * @param int $private_auction
     * @param array $deals
     */
    public function __construct(
        float $bidfloor,
        string $at,
        int $tmax,
        array $bcat = null,
        array $badv = null,
        array $wseat = null,
        int $private_auction = null,
        array $deals =null)
    {
        $this->bidfloor = $bidfloor;
        $this->at = $at;
        $this->tmax = $tmax;
        $this->bcat = $bcat;
        $this->badv = $badv;
        $this->wseat = $wseat;
        $this->private_auction = $private_auction;
        $this->deals = $deals;
    }

    /**
     * @return float
     */
    public function getBidfloor(): float
    {
        return $this->bidfloor;
    }

    /**
     * @return string
     */
    public function getAt(): string
    {
        return $this->at;
    }

    /**
     * @return int
     */
    public function getTmax(): int
    {
        return $this->tmax;
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
     * @return int
     */
    public function getPrivateAuction():? int
    {
        return $this->private_auction;
    }

    /**
     * @return array
     */
    public function getDeals():? array
    {
        return $this->deals;
    }

}