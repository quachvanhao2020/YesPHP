<?php
namespace YesPHP\Model;

use JsonSerializable;

class RefEntity extends Entity implements JsonSerializable{

    public function jsonSerialize() {
        return $this->getClass()."-".$this->getId();
    }

    public function __toString()
    {
        return $this->getClass()."-".$this->getId().(!empty($this->getType()) ? "-".$this->getType() : "");
    }

    /**
     * @var string
     */

    protected $class;

    /**
     * @var string
     */
    protected $type;

    public function __construct($id,$class,$type = "")
    {
        $this->setId($id);
        $this->setClass($class);
        $this->setType($type);
        
    }

    public static function stdClassTo($object,$class = null){

        if(isset($object->id)){

            $class = $class ?: (isset($object->__class) ? $object->__class : "");

            return new self($object->id,$class);

        }

    }

    public static function entityTo(Entity $entity){

        return new self($entity->getId(),get_class($entity));

    }

    public static function entityIdTo(Entity $entity){

        return self::stringTo($entity->getId());

    }

    public static function stringTo(string $value){

        $value = explode("-",$value);
 
        $id = "";

        $count = count($value);

        $class = $value[0];

        $type = "";

        if($count > 0) {

            $class = $value[0];

            if($count >= 2){

                $id = $value[1];

                if($count >= 3){

                    $type = $value[2];

                }
    
            } 

        }
        
        $ref = new self($id,$class,$type);
 
        return $ref;
 
     }

    /**
     * Get the value of class
     */ 
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the value of class
     *
     * @return  self
     */ 
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get the value of type
     *
     * @return  string
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param  string  $type
     *
     * @return  self
     */ 
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }
}