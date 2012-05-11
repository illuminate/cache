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


	public function testStoreMethodStoresItemInMemory()
	{
		$store = $this->getMockStore();
		$store->put('foo', 'bar', 10);
		$this->assertEquals('bar', $store->getFromMemory('foo'));
	}


	public function testStoreMethodCallsDriver()
	{
		$store = $this->getMockStore();
		$store->expects($this->once())->method('storeItem')->with($this->equalTo('foo'), $this->equalTo('bar'), $this->equalTo(10));
		$store->put('foo', 'bar', 10);
	}


	public function testForgetRemovesItemFromMemory()
	{
		$store = $this->getMockStore();
		$store->setInMemory('foo', 'bar');
		$store->forget('foo');
		$this->assertFalse($store->existsInMemory('foo'));
	}


	public function testForgetMethodCallsDriver()
	{
		$store = $this->getMockStore();
		$store->expects($this->once())->method('removeItem')->with($this->equalTo('foo'));
		$store->forget('foo');
	}


	public function testSettingDefaultCacheTime()
	{
		$store = $this->getMockStore();
		$store->setDefaultCacheTime(10);
		$this->assertEquals(10, $store->getDefaultCacheTime());
	}


	public function testHasMethod()
	{
		$store = $this->getMockStore();
		$this->assertFalse($store->has('foo'));
		$store->setInMemory('foo', 'bar');
		$this->assertTrue($store->has('foo'));
	}


	public function testArrayAccess()
	{
		$store = $this->getMockStore();
		$store['foo'] = 'bar';
		$this->assertEquals('bar', $store['foo']);
		$this->assertTrue(isset($store['foo']));
		unset($store['foo']);
		$this->assertFalse(isset($store['foo']));
	}


	protected function getMockStore()
	{
		return $this->getMock('Illuminate\Cache\Store', array('retrieveItem', 'storeItem', 'removeItem'));
	}

}