<?php
namespace YesPHP;

use YesPHP\Cache\JsonCacheStorage;
use YesPHP\Cache\StorageInterface;

class StorageAvance implements StorageAvanceInterface{

    /**
     * @var StorageInterface
     */
    protected $indexStorage;

    public function __construct(StorageInterface $indexStorage)
    {
        $this->setIndexStorage($indexStorage);
    }

    public function getStub($id){

        if($this->getIndexStorage() instanceof JsonCacheStorage){

            $object = $this->getIndexStorage()->getItem($id);

            return $object;
                
        }

    }

    public function storageCallable(callable $call){

        $array = [$this->getIndexStorage()];

        foreach ($array as $key => $value) {
            $call($value);
        }

    }

    /**
     * Get the value of indexStorage
     *
     * @return  StorageInterface
     */ 
    public function getIndexStorage()
    {
        return $this->indexStorage;
    }

    /**
     * Set the value of indexStorage
     *
     * @param  StorageInterface  $indexStorage
     *
     * @return  self
     */ 
    public function setIndexStorage(StorageInterface $indexStorage)
    {
        $this->indexStorage = $indexStorage;

        return $this;
    }

}