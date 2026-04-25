<?php

namespace App\Http\Controllers;

use App\Services\TipNekretnineServices;
use Illuminate\Http\Request;

class OwnController extends Controller
{
//    public $tipNekretnineServices;
//    public function __construct(TipNekretnineServices $tipNekretnineServices){
//
//        $this->tipNekretnineServices = $tipNekretnineServices;
//
//    }
    public function index(){
        return view("pages.user.onama");
    }
}
