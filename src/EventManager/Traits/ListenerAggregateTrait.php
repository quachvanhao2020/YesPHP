<?php
namespace YesPHP\EventManager\Traits;
use Laminas\EventManager\EventManagerInterface;

trait ListenerAggregateTrait{

    private $listeners = [];

    public function attach(EventManagerInterface $events,$priority = 1)
    {
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

}