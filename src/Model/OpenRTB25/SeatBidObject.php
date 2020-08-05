<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 13:11
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class SeatBidObject
{
    /**
     * @var array
     *
     * @Serializer\Type("array<App\Model\OpenRTB25\ResponseBidObject>")
     * @Serializer\Groups({"message"})
     */
    protected $bid;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $seat;

    /**
     * SeatBidObject constructor.
     * @param array $bid
     * @param string $seat
     */
    public function __construct(
        array $bid,
        string $seat = null)
    {
        $this->bid = $bid;
        $this->seat = $seat;
    }

    /**
     * @return array
     */
    public function getBid(): array
    {
        return $this->bid;
    }

    /**
     * @return string
     */
    public function getSeat():? string
    {
        return $this->seat;
    }




}