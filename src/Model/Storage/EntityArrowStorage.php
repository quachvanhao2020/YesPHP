<?php
namespace YesPHP\Model\Storage;

use YesPHP\ArrayObject;
use YesPHP\Model\Storage\Iterator\EntityArrowIterator;
use YesPHP\Model\EntityArrow;

class EntityArrowStorage extends ArrayObject{

    /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return EntityArrowIterator
     */
    public function getIterator()
    {
        return new EntityArrowIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  EntityArrow[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  \YesPHP\Model\EntityArrow[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}