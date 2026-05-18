<?php

namespace App\Providers;

use App\Services\TipNekretnineServices;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    protected $tipNekretnineServices;
    public function __construct($app)
    {
        parent::__construct($app);
        $this->tipNekretnineServices = app(TipNekretnineServices::class);
    }

    public function register() {}
    public function boot()
    {
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
        View::composer('*', function ($view) {
            $tipovi = Cache::remember('tipovi_nekretnina_sa_slikama', 86400, function () {
                return $this->tipNekretnineServices->getAllWithRelation('slika');
            });
            $view->with('tipoviNekretnina', $tipovi);
        });
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
