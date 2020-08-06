<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 19/05/2020
 * Time: 19:49
 */

namespace App\Message;

use App\Model\AdRequest;

class BidMessage
{
    private $id;
    private $showed;
    private $message;
    private $bidDate;
    private $adRequest;
    private $impDate;


    /**
     * StatsMessage constructor.
     * @param string $id
     * @param int $showed
     * @param string $message
     * @param \DateTime $bidDate
     * @param AdRequest $adRequest
     * @param \DateTime $impDate
     */
    public function __construct(
        string $id,
        int $showed,
        string $message = null,
        \DateTime $bidDate = null,
        AdRequest $adRequest = null,
        \DateTime $impDate = null)
    {
        $this->id = $id;
        $this->showed = $showed;
        $this->message = $message;
        $this->bidDate = $bidDate;
        $this->adRequest = $adRequest;
        $this->impDate = $impDate;
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
    public function getShowed(): int
    {
        return $this->showed;
    }

    /**
     * @return string
     */
    public function getMessage():? string
    {
        return $this->message;
    }

    /**
     * @return \DateTime
     */
    public function getBidDate():? \DateTime
    {
        return $this->bidDate;
    }

    /**
     * @return \DateTime
     */
    public function getImpDate():? \DateTime
    {
        return $this->impDate;
    }

    /**
     * @return AdRequest
     */
    public function getAdRequest():? AdRequest
    {
        return $this->adRequest;
    }


}