<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 13:39
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeResponseLinkObject
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $url;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $clicktrackers;

    /**
     * NativeResponseLinkObject constructor.
     * @param string $url
     * @param array $clicktrackers
     */
    public function __construct(
        string $url,
        array $clicktrackers = null)
    {
        $this->url = $url;
        $this->clicktrackers = $clicktrackers;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getClicktrackers():? array
    {
        return $this->clicktrackers;
    }




}