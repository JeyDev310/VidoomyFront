<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 21/04/2020
 * Time: 12:51
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeRequestObject
{

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $ver;

    /**
     * @var array
     *
     * @Serializer\Type("array<App\Model\OpenRTB25\NativeRequestAssetsObject>")
     * @Serializer\Groups({"message"})
     */
    protected $assets;

    /**
     * NativeRequestObject constructor.
     * @param string $ver
     * @param array $assets
     */
    public function __construct(string $ver, array $assets)
    {
        $this->ver = $ver;
        $this->assets = $assets;
    }

    /**
     * @return string
     */
    public function getVer(): string
    {
        return $this->ver;
    }

    /**
     * @return array
     */
    public function getAssets(): array
    {
        return $this->assets;
    }

}