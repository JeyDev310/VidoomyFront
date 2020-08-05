<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 28/04/2020
 * Time: 14:33
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeResponseAssetsVideoObject
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $vasttag;

    /**
     * NativeResponseAssetsVideoObject constructor.
     * @param string $vasttag
     */
    public function __construct(string $vasttag)
    {
        $this->vasttag = $vasttag;
    }

    /**
     * @return string
     */
    public function getVasttag(): string
    {
        return $this->vasttag;
    }



}