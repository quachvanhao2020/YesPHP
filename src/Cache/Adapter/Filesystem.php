<?php
namespace YesPHP\Cache\Adapter;

use Laminas\Cache\Storage\Adapter\Filesystem as AdapterFilesystem;
use YesPHP\Cache\StorageInterface;
use YesPHP\Model\EntityArrow;

class Filesystem extends AdapterFilesystem implements StorageInterface{

        /**
     * Get an item.
     *
     */
    public function getItemByArrow(EntityArrow $arrow){

        return $this->getItem($arrow->getId());
        
    }

            /**
     * Get an item.
     *
     */
    public function hasItemByArrow(EntityArrow $arrow){


    }


}