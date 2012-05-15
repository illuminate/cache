<?php

use Illuminate\Cache\ArrayStore;

class ArrayStoreTest extends PHPUnit_Framework_TestCase {

	public function testItemsCanBeSetAndRetrieved()
	{
		$store = new ArrayStore;
		$store->put('foo', 'bar', 10);
		$this->assertEquals('bar', $store->get('foo'));
	}

	public function testStoreItemForeverProperlyCallsMemcached()
	{
		$mock = $this->getMock('Illuminate\Cache\ArrayStore', array('storeItem'));
		$mock->expects($this->once())->method('storeItem')->with($this->equalTo('foo'), $this->equalTo('bar'), $this->equalTo(0));
		$mock->forever('foo', 'bar');
	}

}