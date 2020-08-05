<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 18/04/2020
 * Time: 13:51
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class EventTrackerRequestObject
{
    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $event;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $method;

    /**
     * EventTrackerRequestObject constructor.
     * @param int $event
     * @param array $method
     */
    public function __construct(int $event, array $method)
    {
        $this->event = $event;
        $this->method = $method;
    }

    /**
     * @return int
     */
    public function getEvent(): int
    {
        return $this->event;
    }

    /**
     * @return array
     */
    public function getMethod(): array
    {
        return $this->method;
    }



}