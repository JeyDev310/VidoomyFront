<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 16/04/2020
 * Time: 19:37
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class PmpObject
{

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $private_auction;

    /**
     * @var array
     *
     * @Serializer\Type("array<App\Model\OpenRTB25\DealObject>")
     * @Serializer\Groups({"message"})
     */
    protected $deals;

    /**
     * PmpObject constructor.
     * @param int $private_auction
     * @param array $deals
     */
    public function __construct(
        int $private_auction = null,
        array $deals)
    {
        $this->private_auction = $private_auction;
        $this->deals = $deals;
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
    public function getDeals(): array
    {
        return $this->deals;
    }




}