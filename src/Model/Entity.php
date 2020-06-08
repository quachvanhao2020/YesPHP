<?php
namespace YesPHP\Model;
use YesPHP\Model\EntityInfo;
use JsonSerializable;

class Entity implements JsonSerializable {
    
    const ID = "id";
    const INFO = "info";

    public function jsonSerialize() {
        return [
            self::ID => $this->getId(),
            self::INFO=> $this->getInfo(), 
        ];
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
    public function setInfo(\YesPHP\Model\EntityInfo $info)
    {
        $this->info = $info;

        return $this;
    }
}