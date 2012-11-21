<?php namespace Illuminate\Cache;

use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public function register($app)
	{
		$app['cache'] = $app->share(function($app)
		{
			return new CacheManager($app);
		});

		$app['memcached.connector'] = $app->share(function()
		{
			return new MemcachedConnector;
		});
	}

}