<?php
namespace YesPHP;
use stdClass;
use YesPHP\Model\Entity;

class Dynamic extends stdClass
{
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