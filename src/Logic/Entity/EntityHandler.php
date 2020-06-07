<?php
namespace YesPHP\Logic\Entity;

use YesPHP\Traits\JsonMapperTrait;

class EntityHandler{

    use JsonMapperTrait;

    public function makeNullInstance($type,$object,$param = []){

        $mapper = $this->getJsonMapper();

        $instance = $mapper->getInstanceByObject($object,[$type,$param]);

        return $instance;

    }

    public function serialize($object,$instance = null,$type = null,$param = null){

        $mapper = $this->getJsonMapper();

        $instance = $instance ?: $this->makeNullInstance($type,$object,$param);

        $instance = $mapper->map($object,$instance);

        return $instance;

    }
    
}