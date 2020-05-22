<?php
namespace YesPHP;

use JsonSerializable;
use Laminas\Stdlib\ArrayObject as StdlibArrayObject;

class ArrayObject extends StdlibArrayObject implements JsonSerializable {

    /**
     * @var array
     */
    protected $storage = [];

    public function jsonSerialize() {
        return $this->getStorage();
    }

    /**
     * Constructor
     *
     * @param array  $input
     * @param int    $flags
     * @param string $iteratorClass
     */
    public function __construct($input = [], $flags = self::STD_PROP_LIST, $iteratorClass = 'ArrayIterator')
    {

        $this->setFlags($flags);
        $this->setStorage($input);
        $this->setIteratorClass($iteratorClass);
        $this->protectedProperties = array_keys(get_object_vars($this));
    }

        /**
     * Sort the entries by keys using a user-defined comparison function
     *
     * @param  callable $function
     * @return void
     */
    public function tryKeep($function,$unset = false)
    {
        $storage = new self();

        if (is_callable($function)) {

            foreach ($this->getStorage() as $key => $value) {
                
                if(!$function($value)){

                    if($unset) unset($this->storage[$key]);

                }else{
                    
                    $storage->append($value);

                }

            }

        }

        return $storage;
    }

    public function merge(self $storage){

       return $this->setStorage(array_merge($storage->getStorage(),$this->getStorage()));

    }

    public function clear(){
        
        return $this->setStorage([]);
    }

    /**
     * Get the value of storage
     *
     * @return  array
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set the value of storage
     *
     * @param  array  $storage
     *
     * @return  self
     */ 
    public function setStorage($storage = [])
    {
        if(!empty($storage)) {

            $this->storage = $storage;

        }

        return $this;
    }

}