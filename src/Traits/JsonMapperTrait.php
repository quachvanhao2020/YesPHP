<?php
namespace YesPHP\Traits;
use YesPHP\JsonMapper;

trait JsonMapperTrait{

        /**
     * @var JsonMapper
     */

    protected $jsonMapper;


    /**
     * Get the value of jsonMapper
     */ 
    public function getJsonMapper()
    {
        if(!$this->jsonMapper){

            $jsonMapper = new JsonMapper;

            $mapper = function ($class, $jvalue) {

                return $jvalue;
            };

            $jsonMapper->setDeclaredClasses(get_declared_classes());

            //$jsonMapper->classMap[EntityFilter::class] = $mapper;

            $jsonMapper->bStrictNullTypes = false;
            $jsonMapper->bEnforceMapType = false;

            $this->setJsonMapper($jsonMapper);

        };

        return $this->jsonMapper;
    }

    /**
     * Set the value of jsonMapper
     *
     * @return  self
     */ 
    public function setJsonMapper($jsonMapper)
    {
        $this->jsonMapper = $jsonMapper;

        return $this;
    }
}