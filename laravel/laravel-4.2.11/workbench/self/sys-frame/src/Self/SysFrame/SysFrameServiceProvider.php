<?php namespace Self\SysFrame;

use Illuminate\Support\ServiceProvider;

class SysFrameServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('self/sys-frame');
		// this command helps laravel to know how to server package resources . By default vendor/packageName will be used for namespaces and paths
        /// in order to override this we can pass custom namespace and path to resource in second and third argument
        /// $this -> package('vendor/package', 'customNamespace', 'path/to/resources');
        /// package resources are now accessed via custom-namespace
        /// View::make('customNamespace::viewname');
        /// whenever we need to refer any package resources we need to call the resources using :: (outside the package)
        /// View::make(package::viewname);
        /// Config::get(package::group.name);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
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
