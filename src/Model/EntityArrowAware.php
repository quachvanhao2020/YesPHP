<?php
namespace YesPHP\Model;
use YesPHP\Model\EntityArrow;

class EntityArrowAware{

    /**
     * @var EntityArrow
     */
    protected $entityArrow;

    /**
     * Get the value of entityArrow
     *
     * @return  EntityArrow
     */ 
    public function getEntityArrow()
    {
        return $this->entityArrow;
    }

    /**
     * Set the value of entityArrow
     *
     * @param  EntityArrow  $entityArrow
     *
     * @return  self
     */ 
    public function setEntityArrow(EntityArrow $entityArrow)
    {
        $this->entityArrow = $entityArrow;

        return $this;
    }
}