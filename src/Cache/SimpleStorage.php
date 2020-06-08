<?php
namespace YesPHP\Cache;

use YesPHP\ArrayObject;
use YesPHP\Model\EntityArrow;
use YesPHP\Cache\Iterator\SimpleStorageIterator;
use YesPHP\Dynamic;

class SimpleStorage extends ArrayObject implements StorageInterface{

            /**
     * @var mixed
     */
    protected $value;
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

    public function dynamicCollect(EntityArrow $arrow){

        $root = $this->getValue();

        $arrow->getId();

    }

    /**
     * Get an item.
     *
     */
    public function getItemByArrow(EntityArrow $arrow){

        $storage = $this->getStorageByEntityArrow($arrow);

        return $storage->toDynamic();

    }

    public function toDynamic(){

        $root = $this->getValue();

        foreach ($this->getIterator() as $key => $value) {
            
            $root->{$key} = $value->toDynamic();

        }

        return $root;

    }

    public function getStorageByEntityArrow(EntityArrow $arrow,$auto = false){

        if(isset($this[$arrow->getId()])){

            $storage = $this[$arrow->getId()];

        }else if($auto){
            $storage = new SimpleStorage();
            $this[$arrow->getId()] = $storage;
        }else{
            throw new \Exception("Error Processing Request", 1);
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

    public function setItemByArrow(EntityArrow $arrow,$data = null){

        $storage = $this->getStorageByEntityArrow($arrow,true);

        $storage->setValue(Dynamic::fromArray($data));

        //var_dump($arrow,$data);

    }



    /**
     * Get the value of value
     *
     * @return  mixed
     */ 
    public function getValue()
    {
        if(!$this->value) $this->setValue(new Dynamic);

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