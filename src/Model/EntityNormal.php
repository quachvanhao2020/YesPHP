<?php
namespace YesPHP\Model;
use YesPHP\Model\Storage\EntityStorage;
use YesPHP\Model\Entity;

class EntityNormal extends Entity{

    const PARENT = "parent";
    const CHILDS = "childs";
    const REF = "ref";

    public function toArray(){
        return array_merge([
            self::CHILDS => $this->getChilds(),
            self::PARENT => $this->getParent(),
            self::REF => $this->getRef(),
        ],parent::toArray());
    }

    public static function propertySpecificity(){
        return self::PARENT;
    }

        /**
     * 
     *
     * @var string
     */
    protected $ref;
    /**
     * 
     *
     * @var Entity
     */
    protected $parent;

        /**
     * 
     *
     * @var EntityStorage
     */
    protected $childs;
    /**
     * Get the value of parent
     *
     * @return  self
     */ 
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the value of parent
     *
     * @param  \YesPHP\Model\Entity  $parent
     *
     * @return  self
     */ 
    public function setParent(\YesPHP\Model\Entity $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }


    /**
     * Get the value of childs
     *
     * @return  EntityStorage
     */ 
    public function getChilds()
    {
        if(!$this->childs) $this->setChilds(new EntityStorage());

        return $this->childs;
    }

    /**
     * Set the value of childs
     *
     * @param  EntityStorage  $childs
     *
     * @return  self
     */ 
    public function setChilds(EntityStorage $childs)
    {
        $this->childs = $childs;

        return $this;
    }

    /**
     * Get the value of ref
     *
     * @return  string
     */ 
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set the value of ref
     *
     * @param  string  $ref
     *
     * @return  self
     */ 
    public function setRef(string $ref = null)
    {
        $this->ref = $ref;

        return $this;
    }
}