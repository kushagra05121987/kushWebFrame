<?php

namespace App\Providers;

use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Blade::component('components.alerts', 'alert');
        //
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('m/d/Y H:i'); ?>";
//            echo $expression;exit;
//            return ($expression)->format('m/d/Y H:i');
//            var_dump(new \DateTime('2016-33-09'));exit;1
//            return (new \DateTime($expression)) -> format('m/d/Y H:i');
        });

        $this -> app -> bind('dump', \App\Classes\Dumper::class);

        Blade::if('envIf', function($environment) {
            return app()->environment($environment);
        });

//        \DB::listen(function($sql) {
//            \Dumper::dump($sql);
////            \Dumper::dump(\DB::getQueryLog());
//        });

        \Validator::replacer("Uppercase", function($message, $attribute, $rule, $parameters) {
            return str_replace(':kushagra', "Hahahah");
        });
//        \Validator::resolver();
        \View::composers([
            \App\Classes\ViewComposerOne::class => "components"
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
//        $this -> app -> bind('appUtility', \App\Classes\FireUtility::class);
    }
}
