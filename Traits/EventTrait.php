<?php namespace Motokraft\Event\Traits;

/**
 * @copyright   2023 Motokraft. MIT License
 * @link https://github.com/motokraft/event
 */

use \Motokraft\Event\ObjectEvent;
use \Motokraft\Event\EventMethod;
use \Motokraft\Event\EventInterface;
use \Motokraft\Object\Collection;

trait EventTrait
{
    private static array $_classes = [];
    private static array $_events = [];

    static function addEventMethod(string $name, EventMethod $method) : void
    {
        if(!self::hasEventMethod($name))
        {
            self::$_events[$name] = new Collection;
        }

        self::$_events[$name]->append($method);
    }

    static function getEventMethod(string $name) : bool|Collection
    {
        if(!self::hasEventMethod($name))
        {
            return false;
        }

        return self::$_events[$name];
    }

    static function removeEventMethod(string $name) : bool
    {
        if(!self::hasEventMethod($name))
        {
            return false;
        }

        unset(self::$_events[$name]);
        return true;
    }

    static function hasEventMethod(string $name) : bool
    {
        return isset(self::$_events[$name]);
    }

    function getObjectEvent(string $name) : ObjectEvent
    {
        return new ObjectEvent($name, $this);
    }

    function dispatchEvent(ObjectEvent $event) : bool
    {
        if(!$name = (string) $event->getName())
        {
            throw new \Exception('Event name not found!', 404);
        }

        if(!$methods = self::getEventMethod($name))
        {
            return true;
        }

        $methods->uasort(function ($one, $two) {
            $o_priority = $one->getPriority();
            $t_priority = $two->getPriority();

            if($o_priority === $t_priority)
            {
                return 0;
            }

            if($o_priority < $t_priority)
            {
                return -1;
            }

            return 1;
        });

        $map = function ($method) use (&$event)
        {
            $class = $this->loadClass($method);
            return $method->invoke($class, $event);
        };

        $result = $methods->map($map);
        return !$result->hasValue(false, true);
    }

    private function loadClass(EventMethod $method) : EventInterface
    {
        $class = $method->getDeclaringClass();
        $name = (string) $class->getName();

        if(isset(self::$_classes[$name]))
        {
            return self::$_classes[$name];
        }

        $class = $class->newInstanceArgs([]);
        return self::$_classes[$name] = $class;
    }
}