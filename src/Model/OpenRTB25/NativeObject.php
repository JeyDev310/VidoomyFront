<?php
/**
 * Created by PhpStorm.
 * User: ando
 * Date: 21/04/2020
 * Time: 12:50
 */

namespace App\Model\OpenRTB25;

use JMS\Serializer\Annotation as Serializer;

class NativeObject
{
    /**
     * @var NativeRequestObject
     *
     * @Serializer\Type("App\Model\OpenRTB25\NativeRequestObject")
     * @Serializer\Groups({"message"})
     */
    protected $request;

    /**
     * NativeObject constructor.
     * @param NativeRequestObject $request
     */
    public function __construct(NativeRequestObject $request)
    {
        $this->request = $request;
    }

    /**
     * @return NativeRequestObject
     */
    public function getRequest(): NativeRequestObject
    {
        return $this->request;
    }




}