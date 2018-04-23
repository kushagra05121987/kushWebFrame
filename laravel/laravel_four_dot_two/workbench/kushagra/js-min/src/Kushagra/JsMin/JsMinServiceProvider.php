<?php namespace Kushagra\JsMin;
use Illuminate\Support\ServiceProvider;
use Kushagra\JsMin\Minify;

class JsMinServiceProvider extends ServiceProvider {

    /**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        include_once __DIR__.'/../../routes.php';
        $this -> app -> bind('jmin', 'Kushagra\JsMin\Minify');
	}

    /**
     *
     */
	public function boot() {
        $this->package('kushagra/js-min');
        \Config::addNamespace('js-min', __DIR__.'/../../config/');
        \View::addNamespace('js-min', __DIR__.'/../../views/');
        \App::setLocale('en');
        \Lang::addNamespace('js-min', __DIR__.'/../../lang/');
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
