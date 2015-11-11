<?php namespace AlistairShaw\YewCMS\App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class YewCMSServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'yewcms');

        // use artisan vendor:publish to copy config
        $this->publishes([
            __DIR__.'/../../config/yewcms.php' => config_path('yewcms.php'),
        ]);

        // use artisan vendor:publish to copy public assets
        // use artisan vendor:publish --tag=public --force   to force overwrite of assets tagged as "public"
        $this->publishes([
            __DIR__.'/../../public' => public_path('vendor/yewcms'),
        ], 'public');

        // include my package custom routes
        include __DIR__.'/../../routes.php';

        // load translation files
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'yewcms');

        // use artisan vendor:publish to copy over the database migrations and seeders
        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
            __DIR__.'/../../database/seeds' => database_path('seeds')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/yewcms.php', 'yewcms'
        );

        // register providers we need
        $this->app->register('AlistairShaw\YewCMS\App\Providers\ComposerServiceProvider');
        $this->app->register('Illuminate\Html\HtmlServiceProvider');

        // aliases
        $loader = AliasLoader::getInstance();
        $loader->alias('Form', 'Illuminate\Html\FormFacade');
        $loader->alias('HTML', 'Illuminate\Html\HtmlFacade');
    }
}
