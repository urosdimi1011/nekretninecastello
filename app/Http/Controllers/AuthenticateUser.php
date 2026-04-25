<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticateUser extends Controller
{
    public function prikaz()
    {
        return view("login");
    }


    public function doLogin(LoginRequest $request){
        $email = $request->input('emailLogin');
        $password = $request->input('passwordLogin');
        try {
            $user = DB::table('users')
                ->where('email', '=', $email)->first();

            if (!$user) {
                return redirect()->back()->withInput()->with('error-msg', 'Pogresan email');
            }
            if (!Hash::check($password, $user->password)) {
                return redirect()->back()->withInput()->with('error-msg', 'Pogresan lozinka');
            }

            $request->session()->put('user', $user);


            return redirect()->route('tabelarniPrikazNekretnina');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error-msg', $e->getMessage());
        }

    }
    public function doLogout(Request $request){
        if($request->session()->has('user')){
            $user = $request->session()->get('user');
//            $this->insertLog($user->id, 'Logged Out', $request->getUri());
            $request->session()->forget('user');
        }
        return redirect()->route('login');
    }

    public function registracija()
    {
        return view("register");
    }


    public function registracijaKorisnika(Request $request){
        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

        }
        catch(\Exception $e){
            return redirect()->back()->with('error-msg', $e->getMessage());
        }

        // Slanje verifikacionog emaila
        $user->sendEmailVerificationNotification();

    }
}
