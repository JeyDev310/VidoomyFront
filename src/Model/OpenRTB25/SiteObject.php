<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 17/04/2020
 * Time: 18:18
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class SiteObject
{

    /**
     * @var PublisherObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\PublisherObject")
     * @Serializer\Groups({"message"})
     */
    protected $publisher;

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
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $domain;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $page;

    /**
     * SiteObject constructor.
     * @param PublisherObject $publisher
     * @param string $id
     * @param string $name
     * @param string $domain
     * @param string $page
     */
    public function __construct(
        PublisherObject $publisher,
        string $id = null,
        string $name = null,
        string $domain = null,
        string $page = null)
    {
        $this->publisher = $publisher;
        $this->id = $id;
        $this->name = $name;
        $this->domain = $domain;
        $this->page = $page;
    }

    /**
     * @return PublisherObject
     */
    public function getPublisher(): PublisherObject
    {
        return $this->publisher;
    }

    /**
     * @return string
     */
    public function getId():? string
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
     * @return string
     */
    public function getDomain():? string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getPage():? string
    {
        return $this->page;
    }



}