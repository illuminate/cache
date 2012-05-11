<?php namespace Illuminate\Cache; use Closure;

abstract class Store {

	/**
	 * The items retrieved from the cache.
	 *
	 * @var array
	 */
	protected $items = array();

	/**
	 * Retrieve an item from the cache by key.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		if (array_key_exists($key, $this->items))
		{
			return $this->items[$key];
		}

		$value = $this->retrieveItem($key);

		if (is_null($value))
		{
			return ($default instanceof Closure) ? $default() : $default;
		}

		return $this->items[$key] = $value;
	}

	/**
	 * Retrieve an item from the cache by key.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	abstract function retrieveItem($key);

	/**
	 * Store an item in the cache for a given number of minutes.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  int     $minutes
	 * @return void
	 */
	public function put($key, $value, $minutes)
	{
		$this->items[$key] = $value;

		return $this->storeItem($key, $value, $minutes);
	}

	/**
	 * Store an item in the cache for a given number of minutes.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  int     $minutes
	 * @return void
	 */
	abstract function storeItem($key, $minutes);

	/**
	 * Remove an item from the cache.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function forget($key)
	{
		unset($this->items[$key]);

		return $this->forgetItem($key);
	}

	/**
	 * Remove an item from the cache.
	 *
	 * @param  string  $key
	 * @return void
	 */
	abstract function forgetItem($key);

	/**
	 * Get the value of an item in memory.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function getFromMemory($key)
	{
		return $this->items[$key];
	}

	/**
	 * Set the value of an item in memory.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function setInMemory($key, $value)
	{
		$this->items[$key] = $value;
	}

}