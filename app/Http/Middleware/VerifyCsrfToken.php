<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{

//'admin/atributi',
//'admin/tipnekretnine',
//'nekretnine*',
//'stanovi',
//'kuće',
//"poljoprivredno_zemljište",
//"placevi",
//"lokali"

    protected $except = [
        "*"
    ];
}
