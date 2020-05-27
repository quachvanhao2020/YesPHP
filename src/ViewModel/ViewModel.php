<?php
namespace YesPHP\ViewModel;

use Laminas\View\Model\ViewModel as ModelViewModel;
use YesPHP\Model\ViewIndex;
use YesPHP\ViewModel\Storage\ViewModelStorage;
use YesPHP\Model\RefEntity;

class ViewModel extends ModelViewModel{

    const CAPTURETO = "captureTo";
    const CHILDREN = "children";
    const TEMPLATE = "template";
    const POSID = "posId";
    const INJECTEVIEWS = "injecteViews";
    const VARIABLES = "variables";
    const OPTIONS = "options";
    
    public function __debugInfo()
    {
        return [
            self::POSID => $this->getPosId(),
            self::INJECTEVIEWS => $this->getInjecteViews(),
            self::VARIABLES => $this->getVariables(),
            self::OPTIONS => $this->getOptions(),
            self::CAPTURETO => $this->captureTo(),
            self::CHILDREN => $this->getChildren(),
            self::TEMPLATE => $this->getTemplate(),
        ];
    }

        /**
     * 
     *
     * @var bool
     */
    protected $canInjecte = true;

        /**
     * Constructor
     *
     * @param  null|array|Traversable $variables
     * @param  array|Traversable $options
     */
    public function __construct($variables = [], $options = [])
    {
        parent::__construct($variables,$options);

        $this->setInjecteViews(new ViewModelStorage());
    }

    public function viewsInjecte(ViewIndex $viewIndex = null){

        if(!$this->getCanInjecte()) return;

        $viewIndex = $viewIndex ?: $this->getOption("views");

        if(!empty($viewIndex)){

            $this->setOption("views",$this->viewsRender($viewIndex));

            $this->setCanInjecte(false);

        }

    }

    public function viewsRender(ViewIndex $viewIndex){

        $this->setPosId($viewIndex->getPosId());

        $childs = $viewIndex->getChilds();

        $parentClass = enClassString(get_class($this))."_to";

        if(!empty($childs)){

            foreach ($childs as $key => $value) {
                
                if(!$value->getActive()) continue;

                $ref = RefEntity::stringTo($key);

                $options = array_merge(["views" => $value],$value->getOptions());

                $view = $ref->getClass()::$parentClass($this,null,[],$options);

                if($view instanceof ViewModel){

                    $view->viewsInjecte();

                    $this->getInjecteViews()->append($view);

                }

            }

        }

        return $viewIndex;

    }

    /**
     * 
     *
     * @var string
     */
    protected $posId;
    
    /**
     * 
     *
     * @var ViewModelStorage
     */
    protected $injecteViews;
    
        /**
     * Get the value of injecteViews
     *
     * @return  ViewModelStorage
     */ 
    public function findInjecteViews($id){

        $views = [];

        foreach ($this->getInjecteViews() as $key => $value) {
            
            if($value->getPosId() == $id){

                $views[] = $value;

            }

        };

        return $views;

    }

    /**
     * Get the value of injecteViews
     *
     * @return  ViewModelStorage
     */ 
    public function getInjecteViews()
    {
        if($this->injecteViews == null) $this->setInjecteViews(new ViewModelStorage());

        return $this->injecteViews;
    }

    /**
     * Set the value of injecteViews
     *
     * @param  ViewModelStorage  $injecteViews
     *
     * @return  self
     */ 
    public function setInjecteViews($injecteViews)
    {
        $this->injecteViews = $injecteViews;

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
     * Get the value of canInjecte
     *
     * @return  bool
     */ 
    public function getCanInjecte()
    {
        return $this->canInjecte;
    }

    /**
     * Set the value of canInjecte
     *
     * @param  bool  $canInjecte
     *
     * @return  self
     */ 
    public function setCanInjecte(bool $canInjecte)
    {
        $this->canInjecte = $canInjecte;

        return $this;
    }
}