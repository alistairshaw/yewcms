<?php namespace AlistairShaw\YewCMS\App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

/**
 * Class ComposerServiceProvider
 * @package AlistairShaw\YewCMS\App\Providers
 */
class ComposerServiceProvider extends ServiceProvider {

    protected $app;

    public function register()
    {
        // for when we need it
        // $this->app->view->composer('vendirun::common.head', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@head');
    }
}