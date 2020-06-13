<?php

use YesPHP\Model\EntityArrow;
use YesPHP\Model\EntityInfo;
use YesPHP\Model\Storage\EntityArrowStorage;

require_once "vendor/autoload.php";

$arrow1 = new EntityArrow(1);

$arrow2 = new EntityArrow(2);
$arrow2->setInfo((new EntityInfo)->setClass("222"));
$arrow2->setPrototype(new EntityArrowStorage([
    new EntityArrow(44),
]));

$rs =  $arrow1->merge($arrow2);

var_dump($rs);

return;