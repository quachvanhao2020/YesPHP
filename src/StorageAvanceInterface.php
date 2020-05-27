<?php
namespace YesPHP;
use YesPHP\Cache\StorageInterface;
//use Laminas\Cache\Storage\StorageInterface;

interface StorageAvanceInterface{

        /**
     * Get the value of indexStorage
     *
     * @return  StorageInterface
     */ 
    public function getIndexStorage();

}