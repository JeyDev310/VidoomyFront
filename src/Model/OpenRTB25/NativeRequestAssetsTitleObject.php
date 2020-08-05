<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 14:08
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeRequestAssetsTitleObject
{
    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $len;

    /**
     * NativeRequestAssetsTitleObject constructor.
     * @param int $len
     */
    public function __construct(int $len)
    {
        $this->len = $len;
    }

    /**
     * @return int
     */
    public function getLen(): int
    {
        return $this->len;
    }




}