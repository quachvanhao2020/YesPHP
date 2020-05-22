<?php
namespace YesPHP\Traits;

use Laminas\Cache\Storage\StorageInterface;
use Laminas\Cache\Storage\Adapter\Filesystem;

function seo_friendly_url($string){
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    return strtolower(trim($string, '-'));
}

trait Cache{

    use Options;

            /**
     * @var StorageInterface
     */
    protected $cache;

    public static function cacheId($unique){

        $id = null;

        if(method_exists($unique,"toUniqueId")){

            /** @var mixed $request */
            $id = @$unique->toUniqueId();

            $id = seo_friendly_url($id);
        }

        return $id;

    }

    public static function cacheMiddleWareStatic($context,StorageInterface $cache,$functions,$param_arr = [],callable $callable = null){

        $canCache = false;

        $unique = $param_arr[0];

        $clearCache = false;

        if($context instanceof AwareOptionsInterface){

            $clearCache = $context->getOption("clearCache",false);

        }

        $id = self::cacheId($unique);

        if(isset($id)){

            if(!$clearCache && $cache->hasItem($id)){

                $object = $cache->getItem($id);

                if(is_callable($callable)){

                    return $callable($object);

                }

                return $object;

            }

            $canCache = true;

        }

        $result = call_user_func_array($functions,$param_arr);

        $canCache && $cache->setItem($id,$result);

        return $result;

    }

    public function cacheMiddleWare($functions,$param_arr = [],callable $callable = null){

        return self::cacheMiddleWareStatic($this,$this->getCache(),$functions,$param_arr,$callable);

    }


    public static function defaultCache(){

        return new Filesystem([
            "cache_dir" => __DIR__."/../cache",
            "dir_level"=>0,
            "suffix"=>"json",
            "namespace_separator"=>"",
            "tag_suffix"=>"",
            "namespace"=>"",
            "ttl"=>1800,
        ]);

    }

    /**
     * Get the value of cache
     *
     * @return  StorageInterface
     */ 
    public function getCache()
    {
        if(!$this->cache) {
            $this->setCache(self::defaultCache());
        }

        return $this->cache;
    }

    /**
     * Set the value of cache
     *
     * @param  StorageInterface  $cache
     *
     * @return  self
     */ 
    public function setCache(StorageInterface $cache = null)
    {
        $this->cache = $cache;

        return $this;
    }

}