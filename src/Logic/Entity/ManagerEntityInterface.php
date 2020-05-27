<?php
namespace YesPHP\Logic\Entity;
use YesPHP\Model\EntityArrow;

interface ManagerEntityInterface{

    public function getItem(EntityArrow $arrow);

    public function setItem(EntityArrow $arrow,$data);

    public function addItem(EntityArrow $arrow,$data);

    public function getTypeProduct();

}