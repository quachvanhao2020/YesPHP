<?php
namespace YesPHP\Response;

use Laminas\Http\Response;
use stdClass;

class JsonResponse extends Response{

    const JSONCONTENT = "jsonContent";

    /**
     * @var object
     */
    protected $jsonContent;

    public static function Laminas_Http_Response_to(Response $response,self $me = null){

        $me = $me ?: new self();

        $me->setContent($response->getContent());

        return $me;

    }

        /**
     * Set message content
     *
     * @param  mixed $value
     * @return Message
     */
    public function setContent($value)
    {
        $value = $value ?: "{}";

        $jsonValue = json_decode($value);

        $this->setJsonContent($jsonValue ?: new stdClass);

        return parent::setContent($value);
    }


    /**
     * Get the value of jsonContent
     *
     * @return  object
     */ 
    public function getJsonContent()
    {
        return $this->jsonContent;
    }

    /**
     * Set the value of jsonContent
     *
     * @param  object  $jsonContent
     *
     * @return  self
     */ 
    public function setJsonContent(object $jsonContent)
    {
        $this->jsonContent = $jsonContent;

        return $this;
    }
}