<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 17/04/2020
 * Time: 18:16
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class PublisherObject
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
    protected $name;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"message"})
     */
    protected $cat;

    /**
     * PublisherObject constructor.
     * @param string $id
     * @param string $name
     * @param array $cat
     */
    public function __construct(
        string $id,
        string $name = null,
        array $cat = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cat = $cat;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName():? string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getCat():? array
    {
        return $this->cat;
    }




}