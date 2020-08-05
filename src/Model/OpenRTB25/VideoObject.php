<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 16/04/2020
 * Time: 18:57
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class VideoObject
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
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $pos;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $protocols;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $w;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $h;

    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $skip;

    /**
     * VideoObject constructor.
     * @param array $mimes
     * @param int $minduration
     * @param int $maxduration
     * @param int $pos
     * @param array $protocols
     * @param int $w
     * @param int $h
     * @param int $skip
     */
    public function __construct(
        array $mimes,
        int $minduration,
        int $maxduration,
        int $pos = null,
        array $protocols,
        int $w = null,
        int $h = null,
        int $skip = null)
    {
        $this->mimes = $mimes;
        $this->minduration = $minduration;
        $this->maxduration = $maxduration;
        $this->pos = $pos;
        $this->protocols = $protocols;
        $this->w = $w;
        $this->h = $h;
        $this->skip = $skip;
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
     * @return int
     */
    public function getPos():? int
    {
        return $this->pos;
    }

    /**
     * @return array
     */
    public function getProtocols(): array
    {
        return $this->protocols;
    }

    /**
     * @return int
     */
    public function getW():? int
    {
        return $this->w;
    }

    /**
     * @return int
     */
    public function getH():? int
    {
        return $this->h;
    }

    /**
     * @return int
     */
    public function getSkip():? int
    {
        return $this->skip;
    }




}