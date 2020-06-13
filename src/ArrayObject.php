<?php
namespace YesPHP;

use JsonSerializable;
use Laminas\Stdlib\ArrayObject as StdlibArrayObject;
use YesPHP\Model\Entity;

class ArrayObject extends StdlibArrayObject implements JsonSerializable,DynamicSerializable{

    const STORAGE = "storage";

    public function toDynamic(Dynamic $dynamic = null){
        $dynamic = $dynamic ?: new Dynamic;
        $dynamic->{self::STORAGE} = $this->getStorage();
        return $dynamic;
    }

    public function dynamicTo(Dynamic $dynamic){
        $self = new static;
        return $self;
    }

    /**
     * @var array
     */
    protected $storage = [];

    public function jsonSerialize() {
        return $this->getStorage();
    }

            /**
     * Appends the value
     *
     * @param Entity $entity
     * @return bool
     */
    public function existEntity(Entity $entity)
    {
        $bool = isset($this[$entity->getId()]);
        return $bool;
    }

                /**
     * Appends the value
     *
     * @param Entity $entity
     * @return Entity
     */
    public function getEntity($entity)
    {

        if(is_string($entity)){
            $entity = new Entity($entity);
        }
        if($entity instanceof Entity && $this->existEntity($entity)){

            $entity = $this[$entity->getId()];
            return $entity;
        };
    }

    /**
     * Appends the value
     *
     * @param  Entity $entity
     * @return void
     */
    public function appendEntity(Entity $entity)
    {
        $this->storage[$entity->getId()] = $entity;
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