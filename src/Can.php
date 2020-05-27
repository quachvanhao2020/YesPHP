<?php
namespace YesPHP;

use YesPHP\Aware\CanInterface;
use YesPHP\Traits;

class Can implements CanInterface{

    use Traits\Options;

    public function __construct($fileConfig = "")
    {

        $fileConfig.="config.php";

        if(file_exists($fileConfig)){

            $this->setOptions(require $fileConfig);
        }
        
    }

    public function canRead($id){

        return $this->getOption($id,false);
    }

    public function canWrite($id,$data = null){

        return $this->canRead($id);

    }
}