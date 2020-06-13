<?php
namespace YesPHP\Model;
use YesPHP\Dynamic;

class EntityInfo extends Entity{

    const _CLASS = "class";
        /**
     * 
     *
     * @var string
     */
    protected $class;

    public function toDynamic(Dynamic $dynamic = null){
        $dynamic = $dynamic ?: new Dynamic;
        $dynamic->{self::_CLASS} = $this->getClass();
        return parent::toDynamic($dynamic);
    }

    public function toArray() {
        return array_merge([
            self::_CLASS => $this->getClass(),
        ],parent::toArray());
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
    public function setClass(string $class = null)
    {
        $this->class = $class;

        return $this;
    }
}