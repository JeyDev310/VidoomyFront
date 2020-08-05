<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 14:13
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeRequestAssetsVideoObject
{
    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $mimes;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $minduration;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $maxduration;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $protocols;

    /**
     * NativeRequestAssetsVideoObject constructor.
     * @param array $mimes
     * @param int $minduration
     * @param int $maxduration
     * @param array $protocols
     */
    public function __construct(
        array $mimes,
        int $minduration,
        int $maxduration,
        array $protocols)
    {
        $this->mimes = $mimes;
        $this->minduration = $minduration;
        $this->maxduration = $maxduration;
        $this->protocols = $protocols;
    }

    /**
     * @return array
     */
    public function getMimes(): array
    {
        return $this->mimes;
    }

    /**
     * @return int
     */
    public function getMinduration(): int
    {
        return $this->minduration;
    }

    /**
     * @return int
     */
    public function getMaxduration(): int
    {
        return $this->maxduration;
    }

    /**
     * @return array
     */
    public function getProtocols(): array
    {
        return $this->protocols;
    }




}