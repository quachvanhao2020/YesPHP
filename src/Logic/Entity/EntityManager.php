<?php
namespace YesPHP\Logic\Entity;

use YesPHP\Model\Entity;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\Math\Rand;
use YesPHP\Exception\IException;
use YesPHP\Model\RefEntity;
use YesPHP\EventManager\Traits\EventManagerTrait;
use YesPHP\EventManager\Traits\ListenerAggregateTrait;
use YesPHP\Traits as YesTraits;
use YesPHP\Aware\CanInterface;
use YesPHP\Cache\StorageInterface;
use YesPHP\Dynamic;
use YesPHP\Model\EntityArrow;
use YesPHP\Model\EntityNormal;

class EntityManager implements //ManagerEntityInterface,
ListenerAggregateInterface {

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
    const ENTITYHANDLER = "entity_handler";

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
     * @var StorageInterface
     */
    protected $storage;

         /**
     * @var EntityHandler
     */
    protected $entityHandler;

    public function __debugInfo() {
        return [
            //self::MANAGER => $this->getManager(),
            self::STORAGE => $this->getStorage(),
            //self::ENTITYHANDLER => $this->getEntityHandler(),
        ];
    }

    public function __construct(StorageInterface $storage,EntityHandler $entityHandler)
    {
        $this->setStorage($storage);
        $this->setEntityHandler($entityHandler);
    }

    /**
     * 
     * @param EntityArrow $arrow
     * @return Entity
     */ 
    public function getItem(EntityArrow $arrow){

        $id = $arrow->getId();

        if(!$this->getCan()->canRead($id)) {

            $this->getEventManager()->trigger(self::EVENT_GET_ITEM, $this, [new IException($id,self::NOT_ACTIVE)]);
        };

        $data = $this->getStorage()->getItemByArrow($arrow);

        $type = $this->getTypeProduct();

        $instance = new $type();

        $entity = $this->getEntityHandler()->serialize($data,$instance,$type);

        return $entity;
    }
    /**
     * Set the value of activeProduct
     * @param string $id
     * @return Entity
     */ 
    public function getItemm(EntityArrow $arrow){

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

    /**
     * 
     * @param string $arrow
     * @param Entity $item
     * @return bool
     */ 
    public function setItem(EntityArrow $arrow,$item){

        $item = Dynamic::fromEntity($item);

        if($this->getStorage()->setItemByArrow($arrow,$item)){
    
            return true;

        }

        return false;

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

    /**
     * Get the value of entityHandler
     *
     * @return  EntityHandler
     */ 
    public function getEntityHandler()
    {
        return $this->entityHandler;
    }

    /**
     * Set the value of entityHandler
     *
     * @param  EntityHandler  $entityHandler
     *
     * @return  self
     */ 
    public function setEntityHandler(EntityHandler $entityHandler)
    {
        $this->entityHandler = $entityHandler;

        return $this;
    }

    /**
     * Get the value of storage
     *
     * @return  StorageInterface
     */ 
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Set the value of storage
     *
     * @param  StorageInterface  $storage
     *
     * @return  self
     */ 
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;

        return $this;
    }
}