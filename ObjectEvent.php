<?php namespace Motokraft\Event;

/**
 * @copyright   2023 Motokraft. MIT License
 * @link https://github.com/motokraft/event
 */

use \Motokraft\Object\BaseObject;

class ObjectEvent extends BaseObject
{
    private string $_name;
    private EventTypeInterface $_target;
    private int $_timeStamp = 0;

    function __construct(string $name, EventTypeInterface $target)
    {
        $this->_timeStamp = microtime(true);

        $this->_name = $name;
        $this->_target = $target;
    }

    function getName() : string
    {
        return $this->_name;
    }

    function getTimeStamp() : int
    {
        return $this->_timeStamp;
    }

    function getTarget() : EventTypeInterface
    {
        return $this->_target;
    }
}