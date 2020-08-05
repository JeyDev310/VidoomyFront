<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 20/04/2020
 * Time: 13:22
 */

namespace App\Model;


class AdResponse
{
    /**
     * @var string
     */
    protected $html_code;

    /**
     * @var string
     */
    protected $seat;

    /**
     * @var string
     */
    protected $adomain;

    /**
     * @var float
     */
    protected $money;

    /**
     * AdResponse constructor.
     * @param string $html_code
     * @param string $seat
     * @param string $adomain
     * @param float $money
     */
    public function __construct(
        string $html_code,
        string $seat = null,
        string $adomain = null,
        float $money = null)
    {
        $this->html_code = $html_code;
        $this->seat = $seat;
        $this->adomain = $adomain;
        $this->money = $money;
    }

    /**
     * @return string
     */
    public function getHtmlCode(): string
    {
        return $this->html_code;
    }

    /**
     * @return string
     */
    public function getSeat():? string
    {
        return $this->seat;
    }

    /**
     * @return string
     */
    public function getAdomain():? string
    {
        return $this->adomain;
    }

    /**
     * @return float
     */
    public function getMoney():? float
    {
        return $this->money;
    }



}