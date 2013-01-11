<?php namespace Illuminate\Cache;

class WincacheWrapper {

	/**
	 * Get an item from the cache.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function get($key)
	{
		return wincache_ucache_get($key);
	}

	/**
	 * Store an item in the cache.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  int     $seconds
	 * @return void
	 */
	public function put($key, $value, $seconds)
	{
		return wincache_ucache_add($key, $value, $seconds);
	}

	/**
	 * Remove an item from the cache.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function delete($key)
	{
		return wincache_ucache_delete($key);
	}

	/**
	 * Remove all itesm from the cache.
	 *
	 * @return void
	 */
	public function flush()
	{
		wincache_ucache_clear();
	}

}