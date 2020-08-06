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
    protected $request_native;

    /**
     * NativeObject constructor.
     * @param NativeRequestObject $request_native
     */
    public function __construct(NativeRequestObject $request_native)
    {
        $this->request_native = $request_native;
    }

    /**
     * @return NativeRequestObject
     */
    public function getRequest(): NativeRequestObject
    {
        return $this->request_native;
    }




}