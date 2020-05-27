<?php
namespace YesPHP\EventManager;

use Laminas\EventManager\EventManager as EventManagerEventManager;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\ResponseCollection;
use Laminas\EventManager\Exception;

class EventManager extends EventManagerEventManager{


        /**
     * Trigger listeners
     *
     * Actual functionality for triggering listeners, to which trigger() delegate.
     *
     * @param  EventInterface $event
     * @param  null|callable $callback
     * @return ResponseCollection
     */
    protected function triggerListeners(EventInterface $event, callable $callback = null)
    {
        $name = $event->getName();
        $target = $event->getTarget();

        if (empty($name)) {
            throw new Exception\RuntimeException('Event is missing a name; cannot trigger!');
        }

        if (isset($this->events[$name])) {
            $listOfListenersByPriority = $this->events[$name];

            if (isset($this->events['*'])) {
                foreach ($this->events['*'] as $priority => $listOfListeners) {
                    $listOfListenersByPriority[$priority][] = $listOfListeners[0];
                }
            }
        } elseif (isset($this->events['*'])) {
            $listOfListenersByPriority = $this->events['*'];
        } else {
            $listOfListenersByPriority = [];
        }

        if ($this->sharedManager) {

            $identifiers = $this->identifiers;

            if($target) {

                $target = is_object($target) ? get_class($target) : $target ;

                $identifiers = [$target];

            }

            foreach ($this->sharedManager->getListeners($identifiers, $name) as $priority => $listeners) {

                $listOfListenersByPriority[$priority][] = $listeners;

            }
        }

        // Sort by priority in reverse order
        krsort($listOfListenersByPriority);

        // Initial value of stop propagation flag should be false
        $event->stopPropagation(false);

        // Execute listeners
        $responses = new ResponseCollection();
        foreach ($listOfListenersByPriority as $listOfListeners) {
            foreach ($listOfListeners as $listeners) {
                foreach ($listeners as $listener) {
                    $response = $listener($event);
                    $responses->push($response);

                    // If the event was asked to stop propagating, do so
                    if ($event->propagationIsStopped()) {
                        $responses->setStopped(true);
                        return $responses;
                    }

                    // If the result causes our validation callback to return true,
                    // stop propagation
                    if ($callback && $callback($response)) {
                        $responses->setStopped(true);
                        return $responses;
                    }
                }
            }
        }

        return $responses;
    }

}