<?php
namespace YesPHP\Model;

use Laminas\View\Model\ViewModel;

class ViewIndex{

    public static function arrayTo($array){

        $view = new self;

        $options = isset($array["options"]) ? $array["options"] : ["pos"=>""];

        $childs = isset($array["childs"]) ? $array["childs"] : [];

        $active = isset($options["active"]) ? $options["active"] : false;

        $view->setPosId($options["pos"]);

        $options = isset($options["options"]) ? $options["options"] : [];

        foreach ($childs as $key => $value) {
            
            $childs[$key] = self::arrayTo($value);

        }

        $view->setChilds($childs);
        $view->setActive($active);
        $view->setOptions($options);

        //unset($active,$options,$childs);

        return $view;

    }

    /**
     * 
     *
     * @var ViewModel
     */
    protected $view;

        /**
     * 
     *
     * @var self[]
     */
    protected $childs;


        /**
     * 
     *
     * @var string
     */
    protected $posId;


        /**
     * 
     *
     * @var bool
     */
    protected $active;

            /**
     * 
     *
     * @var array
     */
    protected $options;

    /**
     * Get the value of view
     *
     * @return  ViewModel
     */ 
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set the value of view
     *
     * @param  ViewModel  $view
     *
     * @return  self
     */ 
    public function setView(ViewModel $view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the value of posId
     *
     * @return  string
     */ 
    public function getPosId()
    {
        return $this->posId;
    }

    /**
     * Set the value of posId
     *
     * @param  string  $posId
     *
     * @return  self
     */ 
    public function setPosId(string $posId)
    {
        $this->posId = $posId;

        return $this;
    }

    /**
     * Get the value of childs
     *
     * @return  self[]
     */ 
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * Set the value of childs
     *
     * @param  self[]  $childs
     *
     * @return  self
     */ 
    public function setChilds($childs)
    {
        $this->childs = $childs;

        return $this;
    }

    /**
     * Get the value of active
     *
     * @return  bool
     */ 
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @param  bool  $active
     *
     * @return  self
     */ 
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the value of options
     *
     * @return  array
     */ 
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the value of options
     *
     * @param  array  $options
     *
     * @return  self
     */ 
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }
}