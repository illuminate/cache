<?php

class StoreTest extends PHPUnit_Framework_TestCase {

	public function testGetReturnsInMemoryItems()
	{
		$store = $this->getMockStore();
		$store->setInMemory('foo', 'bar');
		$this->assertEquals('bar', $store->get('foo'));
	}


	public function testGetReturnsValueFromCache()
	{
		$store = $this->getMockStore();
		$store->expects($this->once())->method('retrieveItem')->with($this->equalTo('foo'))->will($this->returnValue('bar'));
		$this->assertEquals('bar', $store->get('foo'));
		$this->assertEquals('bar', $store->getFromMemory('foo'));
	}


	public function testDefaultValueIsReturned()
	{
		$store = $this->getMockStore();
		$this->assertEquals('bar', $store->get('foo', 'bar'));
		$this->assertEquals('baz', $store->get('boom', function() { return 'baz'; }));
	}


	protected function getMockStore()
	{
		return $this->getMock('Illuminate\Cache\Store', array('retrieveItem', 'storeItem', 'forgetItem'));
	}

}