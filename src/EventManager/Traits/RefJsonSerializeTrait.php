<?php
namespace TGDDFace\Traits;
use JsonSerializable;

trait RefJsonSerializeTrait{

    public function jsonSerialize() {

        $array = $this->_jsonSerialize();

        return $this->refJsonSerialize($array);

    }

    public abstract function _jsonSerialize();

    public abstract function refJsonSerialize($array);

}