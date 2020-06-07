<?php
namespace YesPHP\Model;
use YesPHP\Model\EntityInfo;
use JsonSerializable;

class Entity implements JsonSerializable {
    
    const ID = "id";
    const __INFO = "__info";

    public function jsonSerialize() {
        return [
            self::ID => $this->getId(),
            self::__INFO => $this->get__info(), 
        ];
    }
    /**
     * 
     *
     * @var EntityInfo
     */
    protected $__info;

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
     * Get the value of __info
     *
     * @return  EntityInfo
     */ 
    public function get__info()
    {
        return $this->__info;
    }

    /**
     * Set the value of __info
     *
     * @param  EntityInfo  $__info
     *
     * @return  self
     */ 
    public function set__info(EntityInfo $__info)
    {
        $this->__info = $__info;

        return $this;
    }
}