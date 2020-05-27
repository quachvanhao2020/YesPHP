<?php
namespace YesPHP\Exception;

use JsonSerializable;

class IException extends Exception implements JsonSerializable{

    const TARGET = "target";

        /**
    * 
    *
    * @var mixed
    */
    protected $target;

    public function __construct($target,string $message = "", int $code = 0, \Throwable $previous = NULL){

        $this->setTarget($target);

        parent::__construct($message,$code,$previous);

    }

    public function jsonSerialize() {
        return array_merge([
            self::TARGET => $this->getTarget(),
        ],parent::jsonSerialize());
    }

        /**
     * Get the value of target
     *
     * @return  mixed
     */ 
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set the value of target
     *
     * @param  mixed  $target
     *
     * @return  self
     */ 
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

}