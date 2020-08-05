<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 17/04/2020
 * Time: 18:22
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class AppObject
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
    protected $app_id;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $app_name;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $app_domain;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $app_page;

    /**
     * AppObject constructor.
     * @param PublisherObject $publisher
     * @param string $app_id
     * @param string $app_name
     * @param string $app_domain
     * @param string $app_page
     */
    public function __construct(
        PublisherObject $publisher,
        string $app_id = null,
        string $app_name = null,
        string $app_domain = null,
        string $app_page = null)
    {
        $this->publisher = $publisher;
        $this->app_id = $app_id;
        $this->app_name = $app_name;
        $this->app_domain = $app_domain;
        $this->app_page = $app_page;
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
    public function getAppId():? string
    {
        return $this->app_id;
    }

    /**
     * @return string
     */
    public function getAppName():? string
    {
        return $this->app_name;
    }

    /**
     * @return string
     */
    public function getAppDomain():? string
    {
        return $this->app_domain;
    }

    /**
     * @return string
     */
    public function getAppPage():? string
    {
        return $this->app_page;
    }



}