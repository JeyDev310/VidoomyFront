<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 22/05/2020
 * Time: 12:38
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class UserObject
{

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $buyeruid;

    /**
     * UserObject constructor.
     * @param string $id
     * @param string $buyeruid
     */
    public function __construct(string $id = null, string $buyeruid = null)
    {
        $this->id = $id;
        $this->buyeruid = $buyeruid;
    }


}