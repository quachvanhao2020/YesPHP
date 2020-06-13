<?php
namespace YesPHP;
use YesPHP\Dynamic;

interface DynamicSerializable{

    /**
     * @return  Dynamic
     */
    public function toDynamic(Dynamic $dynamic = null);

    /**
     * 
     *
     * @param  Dynamic  $dynamic
     *
     * @return self
     */
    public function dynamicTo(Dynamic $dynamic);

}