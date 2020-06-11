<?php
namespace YesPHP\Model;
use YesPHP\Model\EntityInfo;
use JsonSerializable;
use YesPHP\ArraySerializable;
use YesPHP\Dynamic;
use YesPHP\DynamicSerializable;

class Entity implements JsonSerializable,ArraySerializable,DynamicSerializable 
{
    
    const ID = "id";
    const INFO = "info";

    public function toArray(){
        return array_merge([
            self::ID => $this->getId(),
            self::INFO => $this->getInfo(),
        ],[]);
    }

    public function arrayTo(array $array){
        $self = new static;
        $self->setId($array["id"]);
        $self->setInfo($array["info"]);
        return $self;
    }

    public function toDynamic(){
        $dynamic = new Dynamic;
        $dynamic->id = $this->getId();
        $dynamic->info = $this->getInfo();
    }

    public function dynamicTo(Dynamic $dynamic){
        $self = new static;
        $self->setId($dynamic->id);
        $self->setInfo($dynamic->info);
        return $self;
    }

    public function jsonSerialize() {
        return $this->toArray();
    }

    public static function propertySpecificity(){

        return self::ID;
    }

        /**
     * 
     *
     * @var \YesPHP\Model\EntityInfo
     */
    protected $info;

    public function __construct($id = null)
    {
        $this->setId($id);
    }

        /**
     * 
     *
     * @var string
     */
    protected $id;

    /**
     * Get the value of id
     *
     * @return  string
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  string  $id
     *
     * @return  self
     */ 
    public function setId(string $id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of info
     *
     * @return  \YesPHP\Model\EntityInfo
     */ 
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set the value of info
     *
     * @param  \YesPHP\Model\EntityInfo  $info
     *
     * @return  self
     */ 
    public function setInfo(\YesPHP\Model\EntityInfo $info = null)
    {
        $this->info = $info;

        return $this;
    }
}