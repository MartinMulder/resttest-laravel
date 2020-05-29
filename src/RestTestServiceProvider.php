<?php

namespace RestTest\Laravel;

use Illuminate\Support\ServiceProvider;
use RestTest\Laravel\Container;
use RestTest\Laravel\Connection;

class RestTestServiceProvider extends ServiceProvider
{

	public function boot()
	{
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__.'/../config/resttest.php' => config_path('resttest.php'),
			]);
		}

		$this->commands([
			// resttest commands
		]);

		if(config('resttest.logging', true)) {
			Container::getInstance()->setLogger(logger());
		}

		Container::setDefaultConnection(config('resttest.default', 'default'));

		foreach(config('resttest.connections', []) as $name => $config) {
			$connection = new Connection($config);
			Container::addConnection($connection, $name);
		}
	}
}