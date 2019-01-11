<?php

namespace Chocofamily\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use ArrayIterator;
use Closure;

class Collection implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     * The collection attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Collection constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Fill the collection with an array of attributes
     *
     * @param array $attributes
     */
    public function fill(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param array $attributes
     * @return Collection
     */
    public function newInstance(array $attributes)
    {
        return new static($attributes);
    }

    /**
     * Dynamically retrieve attributes on the collection
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the collection.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Determine if an attribute exists on the collection.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->hasKey($key);
    }

    /**
     * Unset an attribute on the collection.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->attributes[$key]);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = new static;
        return call_user_func_array([$instance, $method], $parameters);
    }


    /**
     * Get attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return reset($this->attributes);
    }

    /**
     * @return int|null|string
     */
    public function key()
    {
        return key($this->attributes);
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return next($this->attributes);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->attributes);
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return end($this->attributes);
    }

    /**
     * Get all attributes in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->attributes;
    }

    /**
     * Run a map over each of the attributes.
     *
     * @param Closure $callback
     * @return Collection
     */
    public function map(Closure $callback)
    {
        return $this->newInstance(
            array_map($callback, $this->attributes)
        );
    }

    /**
     * Run an associative map over each of the attributes.
     *
     * @param Closure $callback
     * @return Collection
     */
    public function mapWithKeys(Closure $callback)
    {
        $result = [];
        foreach ($this->attributes as $key => $value) {
            $assoc = $callback($value, $key);
            foreach ($assoc as $mapKey => $mapValue) {
                $result[$mapKey] = $mapValue;
            }
        }
        return $this->newInstance($result);
    }

    /**
     * @param Closure $callback
     * @return Collection
     */
    public function filter(Closure $callback)
    {
        return $this->newInstance(
            array_filter($this->attributes, $callback, ARRAY_FILTER_USE_BOTH)
        );
    }

    /**
     * @param Closure $callback
     * @param null $initial
     * @return Collection
     */
    public function reduce(Closure $callback, $initial = null)
    {
        return $this->newInstance(
            array_reduce($this->attributes, $callback, $initial)
        );
    }

    /**
     * Get the attributes in the collection that are not present in the given attributes.
     *
     * @param array $attributes
     * @return Collection
     */
    public function diff(array $attributes)
    {
        return $this->newInstance(
            array_diff($this->attributes, $attributes)
        );
    }

    /**
     * Get the attributes in the collection that are not present in the given attributes.
     *
     * @param array $attributes
     * @param Closure $callback
     * @return Collection
     */
    public function diffUsing(array $attributes, Closure $callback)
    {
        return $this->newInstance(
            array_udiff($this->attributes, $attributes, $callback)
        );
    }

    /**
     * Get the attributes in the collection whose keys and values are not present in the given attributes.
     *
     * @param array $attributes
     * @return Collection
     */
    public function diffAssoc(array $attributes)
    {
        return $this->newInstance(
            array_diff_assoc($this->attributes, $attributes)
        );
    }

    /**
     * Get the attributes in the collection whose keys and values are not present in the given attributes.
     *
     * @param array $attributes
     * @param Closure $callback
     * @return Collection
     */
    public function diffAssocUsing(array $attributes, Closure $callback)
    {
        return $this->newInstance(
            array_diff_uassoc($this->attributes, $attributes, $callback)
        );
    }

    /**
     * Get the attributes in the collection whose keys are not present in the given attributes.
     *
     * @param array $attributes
     * @return Collection
     */
    public function diffKeys(array $attributes)
    {
        return $this->newInstance(
            array_diff_key($this->attributes, $attributes)
        );
    }

    /**
     * Get the attributes in the collection whose keys are not present in the given attributes.
     *
     * @param array $attributes
     * @param Closure $callback
     * @return Collection
     */
    public function diffKeysUsing(array $attributes, Closure $callback)
    {
        return $this->newInstance(
            array_diff_ukey($this->attributes, $attributes, $callback)
        );
    }

    /**
     * Execute a callback over each attribute.
     *
     * @param Closure $callback
     * @return $this
     */
    public function each(Closure $callback)
    {
        foreach ($this->attributes as $key => $value) {
            if ($callback($value, $key) === false) {
                break;
            }
        }

        return $this;
    }

    /**
     * Apply the callback if the value is truthy.
     *
     * @param  bool  $value
     * @param  Closure  $callback
     * @param  Closure|null  $default
     * @return static|mixed
     */
    public function when($value, Closure $callback, Closure $default = null)
    {
        if ($value) {
            return $callback($this, $value);
        } elseif ($default) {
            return $default($this, $value);
        }
        return $this;
    }

    /**
     * Flip the attributes in the collection.
     *
     * @return Collection
     */
    public function flip()
    {
        return $this->newInstance(
            array_flip($this->attributes)
        );
    }

    /**
     * Splice a portion of the underlying collection array.
     *
     * @param int $offset
     * @param int|null $length
     * @param array $replacement
     * @return Collection
     */
    public function splice(int $offset, int $length = null, $replacement = [])
    {
        if (func_num_args() === 1) {
            return $this->newInstance(
                array_splice($this->attributes, $offset)
            );
        }

        return $this->newInstance(
            array_splice($this->attributes, $offset, $length, $replacement)
        );
    }


    /**
     * Merge the collection with the given attributes.
     *
     * @param array $attributes
     * @return Collection
     */
    public function merge(array $attributes)
    {
        return $this->newInstance(
            array_merge($this->attributes, $attributes)
        );
    }

    /**
     * Create a collection by using this collection for keys and another for its values.
     *
     * @param array $attributes
     * @return Collection
     */
    public function combine(array $attributes)
    {
        return $this->newInstance(
            array_combine($this->attributes, $attributes)
        );
    }

    /**
     * Partition the collection into two arrays using the given callback or key.
     *
     * @param Closure $callback
     * @return array
     */
    public function partition(Closure $callback)
    {
        $matches = $noMatches = [];

        foreach ($this->attributes as $key => $value) {
            if ($callback($key, $value)) {
                $matches[$key] = $value;
            } else {
                $noMatches[$key] = $value;
            }
        }

        return [$this->newInstance($matches), $this->newInstance($noMatches)];
    }

    /**
     * Reverse attributes order.
     *
     * @return Collection
     */
    public function reverse()
    {
        return $this->newInstance(
            array_reverse($this->attributes, true)
        );
    }

    /**
     * Intersect the collection with the given attributes.
     *
     * @param array $attributes
     * @return Collection
     */
    public function intersect(array $attributes)
    {
        return $this->newInstance(
            array_intersect($this->attributes, $attributes)
        );
    }

    /**
     * Intersect the collection with the given attributes by key.
     *
     * @param array $attributes
     * @return Collection
     */
    public function intersectByKeys(array $attributes)
    {
        return $this->newInstance(
            array_intersect_key($this->attributes, $attributes)
        );
    }

    /**
     * Pad collection to the specified length with a value.
     *
     * @param $size
     * @param $value
     * @return Collection
     */
    public function pad($size, $value)
    {
        return $this->newInstance(
            array_pad($this->attributes, $size, $value)
        );
    }

    /**
     * @param $offset
     * @param null $length
     * @return array
     */
    public function slice($offset, $length = null)
    {
        return array_slice($this->attributes, $offset, $length, true);
    }

    /**
     * Chunk the underlying collection array.
     *
     * @param $size
     * @return Collection
     */
    public function chunk($size)
    {
        if ($size <= 0) {
            return new static;
        }

        $chunks = [];

        foreach (array_chunk($this->attributes, $size, true) as $chunk) {
            $chunks[] = new static($chunk);
        }
        return new static($chunks);
    }

    /**
     * @param Closure $callback
     * @return bool
     */
    public function exists(Closure $callback)
    {
        foreach ($this->attributes as $key => $value) {
            if ($callback($key, $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->hasKey($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset) || !isset($offset)) {
            $this->add($value);
        } else {
            $this->setAttribute($offset, $value);
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasKey($key)
    {
        return isset($this->attributes[$key]) || array_key_exists($key, $this->attributes);
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function hasAttribute($attribute)
    {
        return in_array($attribute, $this->attributes, true);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getAttribute($key)
    {
        return $this->hasKey($key) ? $this->attributes[$key] : null;
    }

    /**
     * @return array
     */
    public function values()
    {
        return array_values($this->attributes);
    }

    /**
     * @return array
     */
    public function keys()
    {
        return array_keys($this->attributes);
    }

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->attributes);
    }

    /**
     * Set a given attribute
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * @param $attribute
     * @return $this
     */
    public function add($attribute)
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    /**
     * Push an attribute onto the end of the collection.
     *
     * @param $attribute
     * @return $this
     */
    public function push($attribute)
    {
        $this->offsetSet(null, $attribute);

        return $this;
    }

    /**
     *  Sort through each attribute with a callback.
     *
     * @param Closure|null $callback
     * @return Collection
     */
    public function sort(Closure $callback = null)
    {
        $attributes = $this->attributes;

        $callback
            ? uasort($attributes, $callback)
            : asort($attributes);

        return $this->newInstance($attributes);
    }

    /**
     * @param $key
     * @return bool
     */
    public function remove($key)
    {
        if (!$this->hasKey($key)) {
            return false;
        }

        unset($this->attributes[$key]);

        return true;
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count($this->attributes);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->attributes);
    }

    /**
     * @param $attribute
     * @return false|int|string
     */
    public function indexOf($attribute)
    {
        return array_search($attribute, $this->attributes, true);
    }
}
