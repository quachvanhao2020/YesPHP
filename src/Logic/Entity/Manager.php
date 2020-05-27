<?php
namespace YesPHP\Logic\Entity;
use Interop\Container\ContainerInterface;
use YesPHP\Cache\JsonCacheStorage;
use YesPHP\Cache\StorageInterface;
use YesPHP\Model\RefEntity;
use YesPHP\EventManager\Traits\EventManagerTrait;
use function YesPHP\runPhpString;
use YesPHP\Model\Storage\RefEntityStorage;
use YesPHP\Traits;

class Manager{

    use EventManagerTrait;
    use Traits\Log;

    /**
     * @var EntityManager[]
     */
    protected $maps;


    /**
     * @var RefEntityStorage
     */
    protected $refs;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public static function getDir(){

        return __DIR__;

    }

    public function __construct($maps = [],ContainerInterface $container = null)
    {
        $this->setMaps($maps);
        $this->setContainer($container);
        $this->setRefs(new RefEntityStorage());
    }

    public function __debugInfo() {
        return [
            'maps' => $this->maps,
            "events" => $this->getEventManager(),
        ];
    }

    public static function avalidRefEntity(RefEntity $refEntity){

        if(class_exists($refEntity->getClass()) && !empty($refEntity->getId())){

            return true;

        }
        return false;
    }

    public function refObjectUnSerialize($object,$refs = []){

        $ref = RefEntity::stdClassTo($object);

        if($ref && !in_array($ref,$refs)){

            return (string)$ref;

        }

        if(is_array($object) || is_object($object)){

            foreach ($object as $key => $value) {

                $value = self::refObjectUnSerialize($value);

                if(is_object($object)){

                    $object->$key = $value;
    
                }else if(is_array($object)){
    
                    $object[$key] = $value;
    
                }
    
            }

        }

        return $object;

    }

    public function refObjectSerialize($object,callable $callable = null){

        if($object == null) return;

        foreach ($object as $key => $value) {

            if($callable) {

                $callable($object,$key,$value);
            }
            
            if(is_string($value)){

                $value = runPhpString($value);

                $ref = RefEntity::stringTo($value);

                if($ref && self::avalidRefEntity($ref)){

                    $value = $this->get($ref);

                    $this->getRefs()[(string)$ref] = $value;
                }

            }
            
            if(is_array($value)){

                $value = self::refObjectSerialize($value,$callable);

            }else if(is_object($value) && get_class($value) == \stdClass::class){

                $value = self::refObjectSerialize($value,$callable);

            };

            if(is_object($object)){

                $object->$key = $value;

            }else if(is_array($object)){

                $object[$key] = $value;

            }

        }

        return $object;

    }

    public function get(RefEntity $ref){

        $refs = $this->getRefs();

        if($refs->offsetExists((string)$ref)) {

            $object = $refs->offsetGet((string)$ref);

            $this->getLog()->info(sprintf('%s:%s:%s', __METHOD__,"cache",tryToString($object)));

            return $object;

        }

        $manager = $this->findManager($ref->getClass());

        if($manager){

            $manager->getStorage()->storageCallable(function(StorageInterface $storage) use ($refs){

                if($storage instanceof JsonCacheStorage){

                    $storage->getJsonMapper()->getRefs()->merge($refs);
                }

            });

            if($ref->getType() == "helper"){

                $object = $manager->getItemHelper($ref->getId());

                $this->getLog()->info(sprintf('%s:%s:%s',__METHOD__,"helper",tryToString($object)));

            }

            $object = $manager->getItem($ref->getId());

            $this->getLog()->info(sprintf('%s:%s:%s',__METHOD__,"manager",tryToString($object)));

            return $object;
        
        }

    }

    public function findManager($class){

        $maps = $this->getMaps();

        if(isset($maps[$class])) return $maps[$class];

        foreach ($maps as $key => $manager) {

            if(is_string($manager)){

                $manager = $this->getContainer()->get($manager);

            }

            if($manager instanceof EntityManager){

                if($class == $manager->getTypeProduct()){

                    $this->maps[$class] = $manager;

                    return $manager;

                }
            }
            
        }

    }

    /**
     * Get the value of maps
     */ 
    public function getMaps()
    {
        return $this->maps;
    }

    /**
     * Set the value of maps
     *
     * @return  self
     */ 
    public function setMaps($maps)
    {
        $this->maps = $maps;

        return $this;
    }

    /**
     * Get the value of container
     */ 
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set the value of container
     *
     * @return  self
     */ 
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get the value of refs
     *
     * @return  RefEntityStorage
     */ 
    public function getRefs()
    {
        return $this->refs;
    }

    /**
     * Set the value of refs
     *
     * @param  RefEntityStorage  $refs
     *
     * @return  self
     */ 
    public function setRefs(RefEntityStorage $refs)
    {
        $this->refs = $refs;

        return $this;
    }
}