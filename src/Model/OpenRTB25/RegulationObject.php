<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 17/04/2020
 * Time: 18:37
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class RegulationObject
{
    /**
     * @var int
     *
     * @Serializer\Type("int")
     * @Serializer\Groups({"message"})
     */
    protected $coppa;

    /**
     * @var RegulationExtObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\RegulationExtObject")
     * @Serializer\Groups({"message"})
     */
    protected $ext;

    /**
     * RegulationObject constructor.
     * @param int $coppa
     * @param RegulationExtObject $ext
     */
    public function __construct(
        int $coppa = null,
        RegulationExtObject $ext = null)
    {
        $this->coppa = $coppa;
        $this->ext = $ext;
    }

    /**
     * @return int
     */
    public function getCoppa():? int
    {
        return $this->coppa;
    }

    /**
     * @return RegulationExtObject
     */
    public function getExt():? RegulationExtObject
    {
        return $this->ext;
    }



}