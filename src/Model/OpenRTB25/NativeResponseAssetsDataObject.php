<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 28/04/2020
 * Time: 14:34
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeResponseAssetsDataObject
{

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $value;

    /**
     * NativeResponseAssetsDataObject constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

}