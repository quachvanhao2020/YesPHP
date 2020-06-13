<?php
namespace YesPHP;

interface AwareMergeInterface{


    /**
     * Set the value of info
     *
     * @param self $merge
     *
     * @return  self
     */
    public function merge(AwareMergeInterface $merge);

}