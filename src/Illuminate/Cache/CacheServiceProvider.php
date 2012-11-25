<?php namespace Illuminate\Cache;

use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['cache'] = $this->app->share(function($app)
		{
			return new CacheManager($app);
		});

		$this->app['memcached.connector'] = $this->app->share(function()
		{
			return new MemcachedConnector;
		});
	}

}