<?php

namespace App\Http\Controllers;

use App\Services\NekretnineAtributiVrednostServices;
use App\Services\NekretnineServices;
use App\Services\TipNekretnineServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    protected $nekretnineServices;
    protected $nekretnineAtributiVrednostServices;

    protected $tipNekretnineServices;
    public function __construct(
        NekretnineServices $nekretnineServices,
        NekretnineAtributiVrednostServices $nekretnineAtributiVrednostServices,
        TipNekretnineServices $tipNekretnineServices
    ) {
        $this->nekretnineServices = $nekretnineServices;
        $this->nekretnineAtributiVrednostServices = $nekretnineAtributiVrednostServices;
        $this->tipNekretnineServices = $tipNekretnineServices;
    }


    public function index(): \Illuminate\View\View
    {
        $istaknuti = Cache::remember(
            NekretnineServices::CACHE_KEY_ISTAKNUTE,
            now()->addMinutes(30),
            fn() => $this->nekretnineServices->getIstaknuteSaAtributima()
        );

        return view('pages.user.index', compact('istaknuti'));
    }
}
