<?php namespace Illuminate\Cache; use Memcache;

class MemcacheStore extends Store {

	/**
	 * The Memcache instance.
	 *
	 * @var Memcache
	 */
	protected $memcache;

	/**
	 * A string that should be prepended to keys.
	 *
	 * @var string
	 */
	protected $prefix;

	/**
	 * Create a new Memcache store.
	 *
	 * @param  Memcache  $memcache
	 * @param  string    $prefix
	 * @return void
	 */
	public function __construct(Memcache $memcache, $prefix = '')
	{
		$this->prefix = $prefix;
		$this->memcache = $memcache;
	}

	/**
	 * Retrieve an item from the cache by key.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	protected function retrieveItem($key)
	{
		$value = $this->memcache->get($this->prefix.$key);

		if ($value !== false)
		{
			return $value;
		}
	}

	/**
	 * Store an item in the cache for a given number of minutes.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  int     $minutes
	 * @return void
	 */
	protected function storeItem($key, $value, $minutes)
	{
		$this->memcache->set($this->prefix.$key, $value, 0, $minutes * 60);
	}

	/**
	 * Store an item in the cache indefinitely.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	protected function storeItemForever($key, $value)
	{
		return $this->storeItem($key, $value, 0);
	}

	/**
	 * Remove an item from the cache.
	 *
	 * @param  string  $key
	 * @return void
	 */
	protected function removeItem($key)
	{
		$this->memcache->delete($this->prefix.$key);
	}

	/**
	 * Remove all items from the cache.
	 *
	 * @return void
	 */
	protected function flushItems()
	{
		$this->memcache->flush();
	}

}