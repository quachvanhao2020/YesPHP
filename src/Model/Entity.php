<?php
namespace YesPHP\Model;

use JsonSerializable;

class Entity implements JsonSerializable {
    
    const ID = "id";
    const __CLASS = "__class";

    public function jsonSerialize() {
        return [
            self::ID => $this->getId(),
            self::__CLASS => get_class($this), 
        ];
    }
    /**
     * 
     *
     * @var string
     */
    protected $class;

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