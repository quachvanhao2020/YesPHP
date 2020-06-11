<?php

use YesPHP\Model\EntityArrow;
use YesPHP\Model\EntityInfo;

require_once "vendor/autoload.php";

$arrow1 = new EntityArrow(1);
$arrow2 = new EntityArrow(2);
$arrow2->setInfo((new EntityInfo)->setClass("222"));

var_dump(objectToArray($arrow1,true),objectToArray($arrow2,true));

$arrowTotal = $arrow1+$arrow2;

var_dump($arrowTotal);

return;