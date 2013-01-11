<?php namespace Illuminate\Cache;

class WincacheStore extends Store {

	/**
	 * The Wincache wrapper instance.
	 *
	 * @var Illuminate\Cache\WincacheWrapper
	 */
	protected $winCache;

	/**
	 * A string that should be prepended to keys.
	 *
	 * @var string
	 */
	protected $prefix;

	/**
	 * Create a new WinCache store.
	 *
	 * @param  Illuminate\Cache\WinCacheWrapper  $winCache
	 * @param  string                       	 $prefix
	 * @return void
	 */
	public function __construct(WinCacheWrapper $wincache, $prefix = '')
	{
		$this->wincache = $wincache;
		$this->prefix = $prefix;
	}

	/**
	 * Retrieve an item from the cache by key.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	protected function retrieveItem($key)
	{
		$value = $this->wincache->get($this->prefix.$key);

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
		$this->wincache->put($this->prefix.$key, $value, $minutes * 60);
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
		$this->wincache->delete($this->prefix.$key);
	}

	/**
	 * Remove all items from the cache.
	 *
	 * @return void
	 */
	protected function flushItems()
	{
		$this->wincache->flush();
	}

}