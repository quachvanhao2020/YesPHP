<?php
namespace YesPHP;
use stdClass;
use YesPHP\Model\Entity;

class Dynamic extends stdClass
{

    public static function dynamicElementS(Dynamic $dynamic,$recursive = false){

        $a = function($value,$recursive){

            if($value instanceof DynamicSerializable){
                $value = $value->toDynamic();
                if($recursive) $value = $value->dynamicElement($recursive);
            }

            return $value;
        };

        foreach ($dynamic as $key => $value) {

            if(is_array($value)){
                foreach ($value as $key1 => $value1) {
                    $value[$key1] = $a($value1,$recursive);
                }
            }else{
                $value = $a($value,$recursive);
            };

            $dynamic->$key = $value;

        }

        return $dynamic;

    }

    public function dynamicElement($recursive = false){
        return self::dynamicElementS($this,$recursive);
    }

    public function __call($key, $params)
    {
        if ( ! isset($this->{$key})) {
            throw new \Exception("Call to undefined method " . __CLASS__ . "::" . $key . "()");
        }

        return $this->{$key}->__invoke(... $params);
    }

    public function toArray(){
        return self::toArrayStatic($this);
    }

    public static function toArrayStatic($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = self::toArrayStatic($value);
                }
                if ($value instanceof stdClass) {
                    $array[$key] = self::toArrayStatic((array)$value);
                }
            }
        }
        if ($array instanceof stdClass) {
            return self::toArrayStatic((array)$array);
        }
        return $array;
    }

    public static function fromEntity(Entity $entity) {

        $array = object2array($entity);

        return self::fromArray($array);

    }

    public static function fromArray($array) {
        $object = new self();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = self::fromArray($value);
            }
            $object->$key = $value;
        }
        return $object;
    }
}