<?php

use Chocofamily\Collection\Collection;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    public function test_array_access()
    {
        $collection = new Collection(['foo' => 'bar']);
        $collection['bar'] = 'foo';

        $this->assertEquals('bar', $collection['foo']);
        $this->assertEquals($collection->bar, $collection['bar']);
    }

    public function test_to_array()
    {
        $collection = new Collection(['foo' => 'bar']);
        $collection->bar = 'foo';

        $array = $collection->toArray();

        $this->assertTrue(is_array($array));
        $this->assertEquals('foo', $array['bar']);
    }

    public function test_new_instance()
    {
        $collection = new Collection(['foo' => 'bar']);
        $instance = $collection->newInstance(['foo' => 'test']);

        $this->assertInstanceOf(Collection::class, $instance);
        $this->assertEquals('test', $instance->foo);
    }

    public function test_first_returns_first_item_in_collection()
    {
        $collection = new Collection(['first_name' => 'John', 'last_name' => 'Doe']);
        $this->assertEquals('John', $collection->first());
    }

    public function test_last_returns_last_item_in_collection()
    {
        $collection = new Collection(['first_name' => 'John', 'last_name' => 'Doe', 'age' => 45]);
        $this->assertEquals(45, $collection->last());
    }
}