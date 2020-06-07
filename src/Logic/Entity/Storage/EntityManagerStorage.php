<?php
namespace YesPHP\Logic\Entity\Storage;

use YesPHP\ArrayObject;
use YesPHP\Logic\Entity\EntityManager;
use YesPHP\Logic\Entity\Storage\Iterator\EntityManagerIterator;

class EntityManagerStorage extends ArrayObject{

    /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return EntityManagerIterator
     */
    public function getIterator()
    {
        return new EntityManagerIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  EntityManager[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  EntityManager  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}