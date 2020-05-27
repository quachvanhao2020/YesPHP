<?php
namespace YesPHP\Logic\Entity;

use YesPHP\Model\Entity;
use YesPHP\StorageAvance;
use YesPHP\Model\EntityHelperModel;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\Math\Rand;
use YesPHP\Exception\IException;
use YesPHP\Model\RefEntity;
use YesPHP\Model\StatisticalModel;
use YesPHP\EventManager\Traits\EventManagerTrait;
use YesPHP\EventManager\Traits\ListenerAggregateTrait;
use YesPHP\Traits as YesTraits;
use YesPHP\Aware\CanInterface;
use YesPHP\StorageAvanceInterface;
use YesPHP\Model\EntityArrow;


class EntityManager implements ManagerEntityInterface,ListenerAggregateInterface {

    use EventManagerTrait;
    use ListenerAggregateTrait;
    use YesTraits\Options;
    use YesTraits\Log;

    const EVENT_GET_ITEM = "even_get_item";
    const EVENT_SET_ITEM = "even_set_item";
    const EVENT_ADD_ITEM = "even_add_item";


    const NOT_ACTIVE = "not_active";

    const CONFIG = "config";
    const MANAGER = "manager";
    const STORAGE = "storage";

    public static function makeId(){

        $string = Rand::getString(9, '1234567890');

        return $string;

    }

        /**
     * @var CanInterface
     */
    protected $can;

    /**
     * @var Manager
     */
    protected $manager;

     /**
     * @var StorageAvanceInterface
     */
    protected $storage;

    public function __debugInfo() {
        return [
            self::MANAGER => $this->getManager(),
        ];
    }

    public function __construct(StorageAvanceInterface $storage)
    {
        $this->storage = $storage;
    }

    public function attach(EventManagerInterface $events,$priority = 1)
    {
        $this->listeners[] = $events->attach('*', [$this, 'log']);
    }

    public function log(EventInterface $e)
    {
        $event  = $e->getName();
        $params = $e->getParams();
        //$this->log->info(sprintf('%s: %s', $event, json_encode($params)));
    }

    public function getActiveEntitys(){

        $actives = [];

        foreach ($this->getOptions() as $key => $value) {
           
            if($value){

                $actives[] = $key;

            }

        }

        return $actives;

    }

    public function doingRefObjectSerialize(&$object,$key,&$value){}

        /**
     * Test if an item exists.
     *
     * @param  string $key
     * @return bool
     * @throws \Laminas\Cache\Exception\ExceptionInterface
     */
    public function hasItem($key){

        return $this->getStorage()->getIndexStorage()->hasItem($key);

    }


        /**
     * Set the value of activeProduct
     * @param 
     * @return EntityHelperModel[]
     */
    public function getEntityHelperModels(){

        $items = $this->getActiveEntitys();

        foreach ($items as $key => $value) {

            $items[$key] = $this->getItemHelper($value);

        }

        return $items;

    }

            /**
     * Set the value of activeProduct
     * @param string $id
     * @return StatisticalModel
     */
    public function getItemStatistical($id = "0"){

        $statistical = $this->getStorage()->getStatisticalStorage();

        $type = $this->getTypeProductStatistical();
        
        $object = $statistical->getItem($id);

        if(is_object($object)){

            $object = $this->refObjectSerialize($object);

        };

        $object = $statistical->makeInstance($type,$object);

        $this->getEventManager()->trigger(self::EVENT_GET_ITEM, $this, [$object]);

        return $object;

    }

    public function getItemHelper($id){

        $helperStorage = $this->getStorage()->getHelperStorage();

        $type = $this->getTypeProductHelper();
        
        $object = $helperStorage->getItem($id);

        if(is_object($object)){

            $object = $this->refObjectSerialize($object);

        };

        $object = $helperStorage->makeInstance($type,$object);

        $this->getEventManager()->trigger(self::EVENT_GET_ITEM, $this, [$object]);

        return $object;

    }

    /**
     * Set the value of activeProduct
     * @param string $id
     * @return  Product
     */ 

    public function getItem(EntityArrow $arrow){

        $id = $arrow->getId();

        if(!$this->getCan()->canRead($id)) {

            $this->getEventManager()->trigger(self::EVENT_GET_ITEM, $this, [new IException($id,self::NOT_ACTIVE)]);

            //return;

        };

        $indexStorage = $this->getStorage()->getIndexStorage();

        $type = $this->getTypeProduct();
        
        $object = $indexStorage->getItem($id);

        var_dump($object,$type,$id);

        //if($object == null) return;

        $rootRef = RefEntity::stdClassTo($object,$type);

        $instance = $indexStorage->makeNullInstance($type,$object);
        
        if($instance instanceof Entity){ $instance ->setId($rootRef->getId()); }

        $this->getManager()->getRefs()[(string)$rootRef] = $instance;

        if(is_object($object)){

            $object = $this->refObjectSerialize($object);

        };

        $object = $indexStorage->makeInstance($type,$object,[],$instance);

        return $object;
    }

    public function refObjectSerialize($object){

        $object = $this->getManager()->refObjectSerialize($object,[$this, 'doingRefObjectSerialize']);

        return $object;

    }

    public function optimize($id){

        $entity = null;

        $itemStd = $this->getManager()->refObjectUnSerialize($entity,[
            RefEntity::stdClassTo($entity),
        ]);

        if($itemStd !== null) $entity = $itemStd;

        return $this->setItem($id,json_encode($entity,JSON_PRETTY_PRINT));

    }

    public function setItem($id,$item){

        $itemStd = json_decode(json_encode($item));

        if($this->getStorage()->getIndexStorage()->setItem($id,json_encode($itemStd,JSON_PRETTY_PRINT))){
    
            $this->getEventManager()->trigger(self::EVENT_SET_ITEM, $this, [$item]);

            return true;

        }

        return false;

    }

    public function addItem($id,$item){

        if($this->hasItem($id)){

            return;

        }

        $itemStd = Manager::refObjectUnSerialize(json_decode(json_encode($item)),$this->getManager());

        if($this->getStorage()->getIndexStorage()->addItem($id,json_encode($itemStd,JSON_PRETTY_PRINT))){
    
            $this->getEventManager()->trigger(self::EVENT_ADD_ITEM, $this, [$item]);

            return true;

        }

        return false;

    }

    /**
     * Get the value of storage
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set the value of storage
     *
     * @return  self
     */ 
    public function setStorage(StorageAvanceInterface $storage)
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * Get the value of manager
     */ 
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set the value of manager
     *
     * @return  self
     */ 
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

    public function getTypeProduct(){

        return Entity::class;

    }

    /**
     * Get the value of can
     *
     * @return  CanInterface
     */ 
    public function getCan()
    {
        return $this->can;
    }

    /**
     * Set the value of can
     *
     * @param  CanInterface  $can
     *
     * @return  self
     */ 
    public function setCan(CanInterface $can)
    {
        $this->can = $can;

        return $this;
    }
}