<?php
namespace YesPHP\Model\Storage;

use YesPHP\ArrayObject;
use YesPHP\Model\Storage\Iterator\RefEntityIterator;
use YesPHP\Model\RefEntity;

class RefEntityStorage extends ArrayObject{

        /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return RefEntityIterator
     */
    public function getIterator()
    {
        return new RefEntityIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  RefEntity[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

                    /**
     * Set the value of storage
     *
     * @param  \YesPHP\Filter\RefEntity[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}