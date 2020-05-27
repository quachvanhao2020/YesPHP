<?php
namespace YesPHP\Exception;

use JsonSerializable;

class Exception extends \Exception implements JsonSerializable{

    const MESSAGE = "message";
    const CODE = "code";
    const FILE = "file";
    const LINE = "line";

    public function jsonSerialize() {
        return array_merge([
            self::MESSAGE => $this->getMessage(),
            self::CODE => $this->getCode(),
            self::FILE => $this->getFile(),
            self::LINE => $this->getLine(),
        ],[]);
    }

    public static function _Exception_to(\Exception $ex){

        return new self($ex->getMessage(),$ex->getCode(),$ex->getPrevious());

    }

}