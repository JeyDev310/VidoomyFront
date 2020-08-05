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
    protected $site_id;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $site_name;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $site_domain;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"message"})
     */
    protected $site_page;

    /**
     * SiteObject constructor.
     * @param PublisherObject $publisher
     * @param string $site_id
     * @param string $site_name
     * @param string $site_domain
     * @param string $site_page
     */
    public function __construct(
        PublisherObject $publisher,
        string $site_id = null,
        string $site_name = null,
        string $site_domain = null,
        string $site_page = null)
    {
        $this->publisher = $publisher;
        $this->site_id = $site_id;
        $this->site_name = $site_name;
        $this->site_domain = $site_domain;
        $this->site_page = $site_page;
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
    public function getSiteId():? string
    {
        return $this->site_id;
    }

    /**
     * @return string
     */
    public function getSiteName():? string
    {
        return $this->site_name;
    }

    /**
     * @return string
     */
    public function getSiteDomain():? string
    {
        return $this->site_domain;
    }

    /**
     * @return string
     */
    public function getSitePage():? string
    {
        return $this->site_page;
    }

}