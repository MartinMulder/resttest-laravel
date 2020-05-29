<?php

namespace RestTest\Laravel\Models;

use JsonSerializable;
use ArrayAccess;
use RestTest\Laravel\Connection;
use RestTest\Laravel\Container;


abstract class Model implements ArrayAccess, JsonSerializable
{
	public $exists = false;

	protected $connection;

	/**
	 * Handle dynamic method calls into the model.
	 */
	public function __call($method, $parameters)
	{
		if (method_exists($this, $method)) {
			return $this->$method(...$parameters);
		}

		return $this->newQuery()->$method(...$parameters);
	}

	public static function __callStatic($method, $parameters)
	{
		return (new static())->$method(...$parameters);
	}

	public function getConnection()
	{
		return static::resolveConnection($this->connection);
	}

	public function getConnectionName()
	{
		return $this->connection;
	}

	public function setConnection($name)
    {
        $this->connection = $name;

        return $this;
    }

	public static function resolveConnection($connection = null)
    {
        return static::getConnectionContainer()->get($connection);
    }

    public static function getConnectionContainer()
    {
        return static::$container ?? static::getDefaultConnectionContainer();
    }

	public static function getDefaultConnectionContainer()
    {
        return Container::getInstance();
    }
	
	public static function setConnectionContainer(Container $container)
    {
        static::$container = $container;
    }

    public static function unsetConnectionContainer()
    {
        static::$container = null;
    }

    public function jsonSerialize()
    {
        return $this->attributesToArray();
    }

    protected function convertAttributesForJson(array $attributes = [])
    {
        return $attributes;
    }

    public function offsetExists($offset)
    {
        return !is_null($this->getAttribute($offset));
    }

    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }

	public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    public function __unset($key)
    {
        $this->offsetUnset($key);
    }
}
