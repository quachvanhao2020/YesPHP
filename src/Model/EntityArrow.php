<?php
namespace YesPHP\Model;
use YesPHP\Model\Storage\EntityArrowStorage;
use YesPHP\AwareMergeInterface;
use YesPHP\Dynamic;

class EntityArrow extends Entity{

    const PROTOTYPE = "prototype";
    const VALUE = "value";

    public function toDynamic(Dynamic $dynamic = null){

        $value = $this->getValue();

        if($value instanceof Entity){

            $dynamic = $value->toDynamic();

            var_dump($dynamic->dynamicElement());

            var_dump($dynamic);
        }
        
        return $dynamic;
    }

    public function merge(AwareMergeInterface $entity){
        if($entity instanceof self){
            $this->setPrototype($entity->getPrototype());
            $entity->getValue() && $this->setValue($entity->getValue());
        }
        return parent::merge($entity);
    }

    public static function propertySpecificity(){

        return self::PROTOTYPE;
    }

    public function toArray()
    {
        return array_merge([
            self::PROTOTYPE => $this->getPrototype(),
        ],parent::toArray());
    }

    /**
     * @var EntityArrowStorage
     */
    protected $prototype;

        /**
     * @var mixed
     */
    protected $value;

    /**
     * Get the value of prototype
     *
     * @return  EntityArrowStorage
     */ 
    public function getPrototype()
    {
        return $this->prototype;
    }

    /**
     * Set the value of prototype
     *
     * @param  EntityArrowStorage  $prototype
     *
     * @return  self
     */ 
    public function setPrototype(EntityArrowStorage $prototype)
    {
        $this->prototype = $prototype;

        return $this;
    }

    /**
     * Get the value of value
     *
     * @return  mixed
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param  mixed  $value
     *
     * @return  self
     */ 
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}