<?php
namespace YesPHP\Cache;

use Laminas\Cache\Storage\StorageInterface as StorageStorageInterface;
use YesPHP\Model\EntityArrow;

interface StorageInterface 
//extends StorageStorageInterface
{
        /**
     * Get an item.
     *
     */
    public function hasItemByArrow(EntityArrow $arrow);
    /**
     * Get an item.
     *
     */
    public function getItemByArrow(EntityArrow $arrow);

        /**
     * Get an item.
     *
     */
    public function setItemByArrow(EntityArrow $arrow);

}