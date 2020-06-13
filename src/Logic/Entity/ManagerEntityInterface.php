<?php
namespace YesPHP\Logic\Entity;
use YesPHP\Model\EntityArrow;

interface ManagerEntityInterface{

    /**
     * 
     * @param EntityArrow $arrow
     * @return mixed
     */ 
    public function getItem(EntityArrow $arrow);

        /**
     * 
     * @param EntityArrow $arrow
     * 
     * @return mixed
     */
    public function setItem(EntityArrow $arrow);

    /**
     * 
     * 
     * @return string
     */
    public function getTypeProduct();
}