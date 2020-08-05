<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 28/04/2020
 * Time: 14:32
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeResponseAssetsTitleObject
{

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $text;

    /**
     * NativeResponseAssetsTitleObject constructor.
     * @param string $text
     */
    public function __construct(string $text = null)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText():? string
    {
        return $this->text;
    }

}