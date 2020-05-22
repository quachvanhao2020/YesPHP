<?php
namespace YesPHP\Request;

use JsonSerializable;
use Laminas\Http\PhpEnvironment\Request as BRequest;

class Request extends BRequest implements JsonSerializable
{
    public function jsonSerialize() {
        return $this->toArray();
    }

    public function toArray() {

        return [];
    }

            /**
     * @return string
     */
    public function toString()
    {
        $str = json_encode($this->serverParams);

        $str .= json_encode($this->postParams);

        $str = $str ?: "";

        return parent::toString().$str;
    }

    public function init(){

        foreach ($this->toArray() as $key => $value) {
            $this->getPost()->set(ucfirst($key),$value);
        }

    }

}