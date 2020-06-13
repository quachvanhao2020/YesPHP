<?php
namespace YesPHP\Cache;

use YesPHP\ArrayObject;
use YesPHP\Model\EntityArrow;
use YesPHP\Cache\Iterator\SimpleStorageIterator;
use YesPHP\Dynamic;
use YesPHP\Model\Entity;
use YesPHP\Model\Storage\EntityArrowStorage;

class SimpleStorage extends ArrayObject implements StorageInterface{

    /**
     * @var EntityArrowStorage
     */
    protected $entityArrows;

    public function __construct($input = [], $flags = self::STD_PROP_LIST, $iteratorClass = 'ArrayIterator')
    {

        $this->setEntityArrows(new EntityArrowStorage());
        return parent::__construct($input,$flags,$iteratorClass);   
    }

            /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return SimpleStorageIterator
     */
    public function getIterator()
    {
        return new SimpleStorageIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  self[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  self[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

            /**
     * Get an item.
     *
     */
    public function hasItemByArrow(EntityArrow $arrow){


    }

    /**
     * Get an item.
     *
     */
    public function getItemByArrow(EntityArrow $arrow){

        $entityArrows = $this->getEntityArrows();

        if($arrow2 = $entityArrows->getEntity($arrow)){

            return $arrow2;
        }

    }

    public function fillEntityArrow(EntityArrow $arrow){

        $prototypes = $arrow->getPrototype();

        if($prototypes){

            foreach ($prototypes->getIterator() as $key => $value) {
                
                if($storage instanceof self){

                    return $storage->getStorageByEntityArrow($value,$auto);

                }

            }

        }

    }

    public function getStorageByEntityArrow(EntityArrow $arrow,$auto = false){

        if(isset($this[$arrow->getId()])){

            $storage = $this[$arrow->getId()];

        }else if($auto){

            $storage = new SimpleStorage();
            $this[$arrow->getId()] = $storage;

        }else{
            throw new \Exception("Error".$arrow->getId(), 1);
        }

        $prototypes = $arrow->getPrototype();

        if($prototypes){

            foreach ($prototypes->getIterator() as $key => $value) {
                
                if($storage instanceof self){

                    return $storage->getStorageByEntityArrow($value,$auto);

                }

            }

        }

        return $storage;
        
    }

    public function setItemByArrow(EntityArrow $arrow){

        $entityArrows = $this->getEntityArrows();

        if($arrow2 = $entityArrows->getEntity($arrow)){

            if($arrow2 instanceof Entity){

                return $arrow2->merge($arrow);
            }

        }else return $entityArrows->appendEntity($arrow);
    }

    /**
     * Get the value of entityArrows
     *
     * @return  EntityArrowStorage
     */ 
    public function getEntityArrows()
    {
        return $this->entityArrows;
    }

    /**
     * Set the value of entityArrows
     *
     * @param  EntityArrowStorage  $entityArrows
     *
     * @return  self
     */ 
    public function setEntityArrows(EntityArrowStorage $entityArrows)
    {
        $this->entityArrows = $entityArrows;

        return $this;
    }
}