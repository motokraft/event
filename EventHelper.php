<?php namespace Motokraft\Event;

/**
 * @copyright   2023 Motokraft. MIT License
 * @link https://github.com/motokraft/event
 */

abstract class EventHelper
{
    private static array $types = [];

    static function addTypeClass(string $name, string $class) : void
    {
        self::$types[$name] = $class;
    }

    static function getTypeClass(string $name) : bool|string
    {
        if(!self::hasTypeClass($name))
        {
            return false;
        }

        return self::$types[$name];
    }

    static function removeTypeClass(string $name) : bool
    {
        if(!self::hasTypeClass($name))
        {
            return false;
        }

        unset(self::$types[$name]);
        return true;
    }

    static function hasTypeClass(string $name) : bool
    {
        return isset(self::$types[$name]);
    }

    static function getTypes() : array
    {
        return self::$types;
    }
}