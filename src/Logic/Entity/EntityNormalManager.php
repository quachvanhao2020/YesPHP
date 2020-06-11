<?php
namespace YesPHP\Logic\Entity;
use YesPHP\Model\EntityArrow;
use YesPHP\Model\EntityNormal;

class EntityNormalManager extends EntityManager{

        /**
     * 
     * @param EntityArrow $arrow
     * @return EntityNormal
     */ 
    public function getItem(EntityArrow $arrow){
        return parent::getItem($arrow);
    }

        /**
     * 
     * @param string $arrow
     * @param EntityNormal $item
     * @return bool
     */ 
    public function setItem(EntityArrow $arrow,$item){
        return parent::setItem($arrow,$item);
    }

    public function getTypeProduct(){
        return EntityNormal::class;
    }

}