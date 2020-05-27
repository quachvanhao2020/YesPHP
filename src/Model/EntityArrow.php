<?php
namespace YesPHP\Model;
use YesPHP\Model\Storage\EntityArrowStorage;

class EntityArrow extends Entity{

    /**
     * @var EntityArrowStorage
     */
    protected $prototype;

    public function __construct($id = null)
    {
        parent::__construct($id);
    }
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
}