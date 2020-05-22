<?php
namespace YesPHP\Traits;

use Laminas\Log\Logger;
use Laminas\Log\LoggerInterface;

trait Log{

    public static function defaultLog(){

        $stream = @fopen(__DIR__.'/../log.log', 'a', false);
        if (! $stream) {
            throw new \Exception('Failed to open stream');
        }
        $writer = new \Laminas\Log\Writer\Stream($stream);
        $log = new Logger();
        $log->addWriter($writer);

        return $log;

    }


    /**
     * Get the value of log
     *
     * @return  LoggerInterface
     */ 
    public function getLog()
    {
        if(!$this->log){

            $this->setLog(self::defaultLog());

        }

        return $this->log;
    }

    /**
     * Set the value of log
     *
     * @param  LoggerInterface  $log
     *
     * @return  self
     */ 
    public function setLog(LoggerInterface $log)
    {
        $this->log = $log;

        return $this;
    }

}