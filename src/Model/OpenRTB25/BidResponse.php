<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 13:08
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class BidResponse
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
     * @Serializer\Type("array<App\Model\OpenRTB25\SeatBidObject>")
     * @Serializer\Groups({"message"})
     */
    protected $seatbid;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $cur;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $nbr;

    /**
     * BidResponse constructor.
     * @param string $id
     * @param array $seatbid
     * @param string $cur
     * @param int $nbr
     */
    public function __construct(
        string $id,
        array $seatbid,
        string $cur = null,
        int $nbr = null)
    {
        $this->id = $id;
        $this->seatbid = $seatbid;
        $this->cur = $cur;
        $this->nbr = $nbr;
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
    public function getSeatbid(): array
    {
        return $this->seatbid;
    }

    /**
     * @return string
     */
    public function getCur():? string
    {
        return $this->cur;
    }

    /**
     * @return int
     */
    public function getNbr():? int
    {
        return $this->nbr;
    }



}