<?php

class WincacheStoreTest extends PHPUnit_Framework_TestCase {

	public function testGetReturnsNullWhenNotFound()
	{
		$wincache = $this->getMock('Illuminate\Cache\WincacheWrapper', array('get'));
		$wincache->expects($this->once())->method('get')->with($this->equalTo('foobar'))->will($this->returnValue(null));
		$store = new Illuminate\Cache\WincacheStore($wincache, 'foo');
		$this->assertNull($store->get('bar'));
	}


	public function testMemcacheValueIsReturned()
	{
		$wincache = $this->getMock('Illuminate\Cache\WincacheWrapper', array('get'));
		$wincache->expects($this->once())->method('get')->will($this->returnValue('bar'));
		$store = new Illuminate\Cache\WincacheStore($wincache);
		$this->assertEquals('bar', $store->get('foo'));
	}


	public function testSetMethodProperlyCallsMemcache()
	{
		$wincache = $this->getMock('Illuminate\Cache\WincacheWrapper', array('put'));
		$wincache->expects($this->once())->method('put')->with($this->equalTo('foo'), $this->equalTo('bar'), $this->equalTo(60));
		$store = new Illuminate\Cache\WincacheStore($wincache);
		$store->put('foo', 'bar', 1);
	}


	public function testStoreItemForeverProperlyCallsMemcached()
	{
		$wincache = $this->getMock('Illuminate\Cache\WincacheWrapper', array('put'));
		$wincache->expects($this->once())->method('put')->with($this->equalTo('foo'), $this->equalTo('bar'), $this->equalTo(0));
		$store = new Illuminate\Cache\WincacheStore($wincache);
		$store->forever('foo', 'bar');
	}


	public function testForgetMethodProperlyCallsMemcache()
	{
		$wincache = $this->getMock('Illuminate\Cache\WincacheWrapper', array('delete'));
		$wincache->expects($this->once())->method('delete')->with($this->equalTo('foo'));
		$store = new Illuminate\Cache\WincacheStore($wincache);
		$store->forget('foo');
	}

}