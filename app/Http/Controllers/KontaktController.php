<?php

namespace App\Http\Controllers;

use App\Http\Requests\KontantRequest;
use Illuminate\Http\Request;
use Mail;
use App\Mail\MailZaKorisnike;
class KontaktController extends Controller
{
    public function index(){

        return view("pages.user.kontakt");

    }


    public function posaljiMail(KontantRequest $request){



//        dd($request->get("email"));
//        $mailData =[
//            'title'=>'Mail za test',
//            'body'=>'Ovo je samo test mejl'
//        ];

        \Illuminate\Support\Facades\Mail::to('uros.dimitrijevic@ict.edu.rs')->send(new MailZaKorisnike($request->all()));


        echo json_encode(["poruka"=>"Mail je poslat"]);
    }
}
