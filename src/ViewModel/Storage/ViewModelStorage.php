<?php
namespace YesPHP\ViewModel\Storage;

use YesPHP\ArrayObject;
use YesPHP\ViewModel\Storage\Iterator\ViewModelIterator;
use YesPHP\ViewModel;

class ViewModelStorage extends ArrayObject{

    /**
     * Create a new iterator from an ArrayObject instance
     *
     * @return ViewModelIterator
     */
    public function getIterator()
    {
        return new ViewModelIterator($this->storage);
    }

    /**
     * Get the value of storage
     *
     * @return  ViewModel[]
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

            /**
     * Set the value of storage
     *
     * @param  \YesPHP\Model\ViewModel[]  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        return parent::setStorage($storage);
    }

}