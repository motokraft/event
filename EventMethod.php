<?php namespace Motokraft\Event;

/**
 * @copyright   2023 Motokraft. MIT License
 * @link https://github.com/motokraft/event
 */

class EventMethod extends \ReflectionMethod
{
    private int $priority = 0;

    function __construct(object|string $object, string $method, int $priority = 0)
    {
        parent::__construct($object, $method);
        $this->priority = (int) $priority;
    }

    function getPriority() : int
    {
        return $this->priority;
    }
}