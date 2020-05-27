<?php
namespace YesPHP\EventManager\Traits;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\EventManagerAwareInterface;
use YesPHP\EventManager\EventManager;
use YesPHP\EventManager\SharedEventManager;

trait EventManagerTrait{

    protected $events;

    protected $sharedEvents;

    public function setEventManager(EventManagerInterface $events)
    {
        $events->addIdentifiers([
            __CLASS__,get_called_class()
        ]);
        $this->events = $events;
        return $this;
    }

    /**
     * @return EventManager
     */
    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager($this->getSharedEvents()));
        }
        return $this->events;
    }

            /**
     * Get the value of sharedEvents
     * @return SharedEventManager
     */ 
    public function getSharedEvents()
    {
        if (! $this->sharedEvents) {
            $this->setSharedEvents(new SharedEventManager());
        }

        return $this->sharedEvents;
    }

    /**
     * Set the value of sharedEvents
     *
     * @return  self
     */ 
    public function setSharedEvents($sharedEvents)
    {
        $this->sharedEvents = $sharedEvents;

        return $this;
    }
}