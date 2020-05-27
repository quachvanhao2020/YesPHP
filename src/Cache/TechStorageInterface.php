<?php
namespace YesPHP\Cache;

use YesPHP\Model\EntityArrow;

interface TechStorageInterface extends StorageInterface
{

    public function makeNullInstance($type,$object,$param = []);

    public function makeInstance($type,$object,$param = [],$instance = null);

}