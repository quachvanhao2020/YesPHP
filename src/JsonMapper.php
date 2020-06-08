<?php
namespace YesPHP;
use JsonMapper as BJsonMapper;
use stdClass;
use YesPHP\Model\Entity;
use YesPHP\Model\EntityInfo;
use YesPHP\Model\EntityNormal;
use YesPHP\Model\Storage\RefEntityStorage;
use YesPHP\Model\RefEntity;

class JsonMapper extends BJsonMapper{

    /**
     * Full name
     * @var RefEntityStorage
     */
    protected $refs;

    /**
     * Map data all data in $json into the given $object instance.
     *
     * @param object $json   JSON object structure from json_decode()
     * @param object $object Object to map $json data into
     *
     * @return mixed Mapped object is returned.
     * @see    mapArray()
     */
    public function map($json,$object)
    {

        if(is_object($json) && !$json instanceof stdClass){

            $object = $json;

        }

        if(is_array($json)){

            $json = Dynamic::fromArray($json);
            //var_dump($json,$object);
        }

        if($object instanceof Entity){

            if(isset($json->id)){

                $object->setId($json->id);

            }

            $this->writeRef($object);
        }

        $result = parent::map($json,$object);

        $this->writeRef($result);

        return $result;
    }

    public function writeRef($entity = null){

        if($entity instanceof Entity){

            $this->getRefs()[(string)(RefEntity::entityTo($entity))] = $entity;

        }

    }

    public function handleJvalue($jvalue){

        if(is_string($jvalue)){

            if(isset($this->getRefs()[$jvalue])){

                return $this->getRefs()[$jvalue];
            }

        }

        if($jvalue instanceof Entity){

            //$ref = RefEntity::entityIdTo($jvalue);

        }

        return $jvalue;

    }

        /**
     * Create a new object of the given type.
     *
     * This method exists to be overwritten in child classes,
     * so you can do dependency injection or so.
     *
     * @param string  $class        Class name to instantiate
     * @param boolean $useParameter Pass $parameter to the constructor or not
     * @param mixed   $jvalue       Constructor parameter (the json value)
     *
     * @return object Freshly created object
     */
    protected function createInstance(
        $class, $useParameter = false, $jvalue = null
    ) {

        $jvalue = $this->handleJvalue($jvalue);

        if(!($jvalue instanceof stdClass)){

            return $jvalue;

        }

        return parent::createInstance($class,$useParameter,$jvalue);

    }

        /**
     * Set a property on a given object to a given value.
     *
     * Checks if the setter or the property are public are made before
     * calling this method.
     *
     * @param object $object   Object to set property on
     * @param object $accessor ReflectionMethod or ReflectionProperty
     * @param mixed  $value    Value of property
     *
     * @return void
     */
    protected function setProperty(
        $object, $accessor, $value
    ) {

        $value = $this->handleJvalue($value);

        parent::setProperty($object,$accessor,$value);
    }

    public function getInstanceByObject($json,$arrayObject = []){

        $type = $arrayObject[0];

        $param = $arrayObject[1];

        $type = $this->getMappedType($type,$json);

        $class = new \ReflectionClass($type);

        $instance = $class->newInstanceArgs($param);

        return $instance;

    }

        /**
     * Get the mapped class/type name for this class.
     * Returns the incoming classname if not mapped.
     *
     * @param string $type   Type name to map
     * @param mixed  $jvalue Constructor parameter (the json value)
     *
     * @return string The mapped type/class name
     */
    protected function getMappedType($type, $jvalue = null)
    {

        $type = parent::getMappedType($type,$jvalue);

        if(isset($jvalue->info)){

            $info = EntityInfo::fromArray(Dynamic::toArrayStatic($jvalue->info));

            if($info) $type = $info->getClass();

        }

        $child = $this->getSubClass($type);

        if(count($child) > 0){

            foreach ($child as $value) {
                
                $sp = $value::propertySpecificity();

                if(isset($jvalue->{$sp})){

                    $type = $value;

                }
            }

        }

        return $type;

    }

    protected $declaredClasses = [];

    public function getSubClass($className){

        $children = array();
        foreach($this->getDeclaredClasses() as $class ){
            if( is_subclass_of( $class, $className ) )
                $children[] = $class;
        }

        return $children;

    }

    /**
     * Get the value of declaredClasses
     */ 
    public function getDeclaredClasses()
    {
        return $this->declaredClasses;
    }

    /**
     * Set the value of declaredClasses
     *
     * @return  self
     */ 
    public function setDeclaredClasses($declaredClasses)
    {
        $this->declaredClasses = $declaredClasses;

        return $this;
    }


    /**
     * Get full name
     *
     * @return  RefEntityStorage
     */ 
    public function getRefs()
    {
        if($this->refs == null) $this->setRefs(new RefEntityStorage());

        return $this->refs;
    }

    /**
     * Set full name
     *
     * @param  RefEntityStorage  $refs  Full name
     *
     * @return  self
     */ 
    public function setRefs(RefEntityStorage $refs)
    {
        $this->refs = $refs;

        return $this;
    }
}