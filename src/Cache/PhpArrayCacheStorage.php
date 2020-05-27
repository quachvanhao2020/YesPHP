<?php
namespace YesPHP\Cache;

use Laminas\Cache\Storage\Adapter\Filesystem;
use Laminas\Cache\Storage\StorageInterface;
use stdClass;
use YesPHP\Service\Traits\JsonMapperTrait;
use YesPHP\Cache\StorageInterface as BStorageInterface;
use YesPHP\StorageAvanceInterface;

class PhpArrayCacheStorage implements BStorageInterface,StorageAvanceInterface{

            /**
     * Get the value of indexStorage
     *
     * @return  StorageInterface
     */ 
    public function getIndexStorage(){

        return $this;
    }

    /**
     * Get the value of helperStorage
     *
     * @return  StorageInterface
     */ 
    public function getHelperStorage(){

        return $this;
    }

        /**
     * Get the value of normalStorage
     *
     * @return  StorageInterface
     */ 
    public function getNormalStorage(){

        return $this;
    }

    /**
     * Get the value of prototypeStorage
     *
     * @return  StorageInterface
     */ 
    public function getPrototypeStorage(){

        return $this;
    }

    /**
     * Get the value of statisticalStorage
     *
     * @return  StorageInterface
     */ 
    public function getStatisticalStorage(){

        return $this;
    }

        /**
     * @var StorageInterface
     */
    protected $storage;

    public function __construct(StorageInterface $storage = null)
    {
        $this->setStorage($storage);
    }

    public function _clone()
    {

    }

        /**
     * Set options.
     *
     * @param array|Traversable|Adapter\AdapterOptions $options
     * @return StorageInterface Fluent interface
     */
    public function setOptions($options){

        return $this->getStorage()->setOptions($options);

    }

    /**
     * Get options
     *
     * @return Adapter\AdapterOptions
     */
    public function getOptions(){

        return $this->getStorage()->getOptions();

    }

        /* reading */

    /**
     * Get an item.
     *
     * @param  string  $key
     * @param  bool $success
     * @param  mixed   $casToken
     * @return mixed Data on success, null on failure
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function getItem($key, &$success = null, &$casToken = null){

        return $item;

    }

    /* reading */

    /**
     * Get multiple items.
     *
     * @param  array $keys
     * @return array Associative array of keys and values
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function getItems(array $keys){

        if($storage = $this->getStorage()){


        }else{



        }

    }

    /**
     * Test if an item exists.
     *
     * @param  string $key
     * @return bool
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function hasItem($key){

        return $this->getStorage()->hasItem($key);

    }

    /**
     * Test multiple items.
     *
     * @param  array $keys
     * @return array Array of found keys
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function hasItems(array $keys){


    }

    /**
     * Get metadata of an item.
     *
     * @param  string $key
     * @return array|bool Metadata on success, false on failure
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function getMetadata($key){


    }

    /**
     * Get multiple metadata
     *
     * @param  array $keys
     * @return array Associative array of keys and metadata
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function getMetadatas(array $keys){


    }

    /* writing */

    /**
     * Store an item.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return bool
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function setItem($key, $value){


    }

    /**
     * Store multiple items.
     *
     * @param  array $keyValuePairs
     * @return array Array of not stored keys
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function setItems(array $keyValuePairs){


    }

    /**
     * Add an item.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return bool
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function addItem($key, $value){


    }

    /**
     * Add multiple items.
     *
     * @param  array $keyValuePairs
     * @return array Array of not stored keys
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function addItems(array $keyValuePairs){


    }

    /**
     * Replace an existing item.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return bool
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function replaceItem($key, $value){


    }

    /**
     * Replace multiple existing items.
     *
     * @param  array $keyValuePairs
     * @return array Array of not stored keys
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function replaceItems(array $keyValuePairs){


    }

    /**
     * Set an item only if token matches
     *
     * It uses the token received from getItem() to check if the item has
     * changed before overwriting it.
     *
     * @param  mixed  $token
     * @param  string $key
     * @param  mixed  $value
     * @return bool
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     * @see    getItem()
     * @see    setItem()
     */
    public function checkAndSetItem($token, $key, $value){


    }

    /**
     * Reset lifetime of an item
     *
     * @param  string $key
     * @return bool
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function touchItem($key){


    }

    /**
     * Reset lifetime of multiple items.
     *
     * @param  array $keys
     * @return array Array of not updated keys
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function touchItems(array $keys){


    }

    /**
     * Remove an item.
     *
     * @param  string $key
     * @return bool
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function removeItem($key){


    }

    /**
     * Remove multiple items.
     *
     * @param  array $keys
     * @return array Array of not removed keys
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function removeItems(array $keys){


    }

    /**
     * Increment an item.
     *
     * @param  string $key
     * @param  int    $value
     * @return int|bool The new value on success, false on failure
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function incrementItem($key, $value){


    }

    /**
     * Increment multiple items.
     *
     * @param  array $keyValuePairs
     * @return array Associative array of keys and new values
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function incrementItems(array $keyValuePairs){


    }

    /**
     * Decrement an item.
     *
     * @param  string $key
     * @param  int    $value
     * @return int|bool The new value on success, false on failure
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function decrementItem($key, $value){


    }

    /**
     * Decrement multiple items.
     *
     * @param  array $keyValuePairs
     * @return array Associative array of keys and new values
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function decrementItems(array $keyValuePairs){


    }

    /* status */

    /**
     * Capabilities of this storage
     *
     * @return Capabilities
     */
    public function getCapabilities(){


    }


    /**
     * Get the value of storage
     *
     * @return  StorageInterface
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set the value of storage
     *
     * @param  StorageInterface  $storage
     *
     * @return  self
     */ 
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;

        return $this;
    }
}