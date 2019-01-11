<?php

class ModelTest extends PHPUnit_Framework_TestCase
{
    public function test_constructor()
    {
        $collection = new ModelStub(['first_name' => 'John', 'last_name' => 'Doe']);

        $this->assertEquals('John', $collection->first_name);
        $this->assertEquals('Doe', $collection->last_name);
    }

    public function test_required_exception()
    {
        $this->expectException(\Chocofamily\Collection\Exceptions\MissingRequiredException::class);

        new ModelStub();
    }

    public function test_fillable()
    {
        $collection = new ModelStub(['first_name' => 'John', 'foo' => 'bar']);
        $this->assertFalse($collection->isFillable('foo'));
        $this->assertNull($collection->foo);
        $this->assertNotContains('foo', $collection->getFillable());
    }

}