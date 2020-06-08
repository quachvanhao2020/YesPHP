<?php
namespace YesPHP\Model;

use JsonSerializable;

class EntityInfo implements JsonSerializable{

    const _CLASS = "class";
        /**
     * 
     *
     * @var string
     */
    protected $class;

    public function jsonSerialize() {
        return [
            self::_CLASS => $this->getClass(),
        ];
    }

        /**
     * Get the value of class
     *
     * @return  self
     */ 
    public static function fromArray($array) {

        $class = isset($array["class"]) ? $array["class"] : null;

        if($class){

            $object = new self();
            $object->setClass($class);
            return $object;

        }
    }

    /**
     * Get the value of class
     *
     * @return  string
     */ 
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the value of class
     *
     * @param  string  $class
     *
     * @return  self
     */ 
    public function setClass(string $class)
    {
        $this->class = $class;

        return $this;
    }
}