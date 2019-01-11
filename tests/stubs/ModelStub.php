<?php

use Chocofamily\Collection\Model;

class ModelStub extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'age', 'sex', 'active'
    ];

    protected $required = [
        'first_name'
    ];
}