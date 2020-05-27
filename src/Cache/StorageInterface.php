<?php
namespace YesPHP\Cache;

use Laminas\Cache\Storage\StorageInterface as StorageStorageInterface;
use YesPHP\Service\Manager;
use YesPHP\Model\EntityArrow;

interface StorageInterface 
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
     * Set options.
     *
     * @param array|Traversable|Adapter\AdapterOptions $options
     * @return StorageInterface Fluent interface
     */
    public function setOptions($options);

    /**
     * Get options
     *
     * @return Adapter\AdapterOptions
     */
    public function getOptions();

}