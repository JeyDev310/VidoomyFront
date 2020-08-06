<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 26/05/2020
 * Time: 12:31
 */

namespace App\Message;

class CookieMessage
{

    private $bidoomyCookie;
    private $exchangeCookie;
    private $exchangeName;
    private $date;

    /**
     * CookieMessage constructor.
     * @param string $bidoomyCookie
     * @param string $exchangeCookie
     * @param string $exchangeName
     * @param \DateTime $date
     */
    public function __construct(string $bidoomyCookie, string $exchangeCookie, string $exchangeName, \DateTime $date)
    {
        $this->bidoomyCookie = $bidoomyCookie;
        $this->exchangeCookie = $exchangeCookie;
        $this->exchangeName = $exchangeName;
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getBidoomyCookie(): string
    {
        return $this->bidoomyCookie;
    }

    /**
     * @return string
     */
    public function getExchangeCookie(): string
    {
        return $this->exchangeCookie;
    }

    /**
     * @return string
     */
    public function getExchangeName(): string
    {
        return $this->exchangeName;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

}