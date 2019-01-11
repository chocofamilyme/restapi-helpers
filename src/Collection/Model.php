<?php

namespace Chocofamily\Collection;

use Chocofamily\Collection\Exceptions\MissingRequiredException;

abstract class Model extends Collection
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be assigned in arrays.
     *
     * @var array
     */
    protected $required = [];


    /**
     * @param array $attributes
     * @throws MissingRequiredException
     */
    public function fill(array $attributes)
    {
        foreach ($this->fillableAndRequiredFromArray($attributes) as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * Get fillable attributes
     *
     * @return array
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Set fillable attributes
     *
     * @param array $fillable
     * @return $this
     */
    public function setFillable(array $fillable)
    {
        $this->fillable = $fillable;

        return $this;
    }


    /**
     * Determine if the given key is fillable
     *
     * @param $key
     * @return bool
     */
    public function isFillable($key)
    {
        if (in_array($key, $this->getFillable())) {
            return true;
        }

        return empty($this->getFillable());
    }

    /**
     * @return array
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param array $required
     * @return $this
     */
    public function setRequired(array $required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @param array $attributes
     * @return array
     * @throws MissingRequiredException
     */
    protected function fillableAndRequiredFromArray(array $attributes)
    {
        $required = array_diff_key(array_flip($this->getRequired()), $attributes);

        if (count($required) > 0) {
            throw new MissingRequiredException('Missing required fields: '. implode(', ', array_keys($required)));
        }

        if (count($this->getFillable()) > 0) {
            return array_intersect_key($attributes, array_flip($this->getFillable()));
        }

        return $attributes;
    }
}