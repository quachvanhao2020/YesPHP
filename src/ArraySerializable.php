<?php
namespace YesPHP;

interface ArraySerializable{

    /**
     * @return  array
     */
    public function toArray();

        /**
     * 
     *
     * @param  array  $array
     *
     * @return  self
     */
    public function arrayTo(array $array);

}