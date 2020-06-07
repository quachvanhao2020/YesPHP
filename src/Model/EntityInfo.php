<?php
namespace YesPHP\Model;

use JsonSerializable;

class EntityInfo implements JsonSerializable{

        /**
     * 
     *
     * @var string
     */
    protected $class;


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