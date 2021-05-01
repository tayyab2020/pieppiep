<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\user_languages;
use App\Language;

class UserForgotController extends Controller
{

    public $lang;

    public function __construct()
    {
      $this->middleware('guest:user', ['except' => ['logout']]);

       if (!empty($_SERVER['HTTP_CLIENT_IP']))
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
//whether ip is from remote address
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }


$language = user_languages::where('ip','=',$ip_address)->first();



        if($language == '')
            {

                $language = new user_languages;
                $language->ip = $ip_address;
                $language->lang = 'eng';
                $language->save();
            }


        if($language->lang == 'eng')
        {

            $this->lang = Language::where('lang','=','eng')->first();

        }

        else
        {

            $this->lang = Language::where('lang','=','du')->first();

        }


    }

    public function showforgotform()
    {
    	return view('user.forgot');
    }

    public function forgot(Request $request)
    {
    	$input =  $request->all();
        if (User::where('email', '=', $request->email)->count() > 0) {
            // user found
            $user = User::where('email', '=', $request->email)->where('allowed',1)->firstOrFail();
            $autopass = str_random(8);
            $input['password'] = Hash::make($autopass);

            $user->update($input);

            $name = $user->name. ' ' .$user->family_name;


            if($this->lang->lang == 'eng') // English Email Template
            {

                \Mail::send(array(), array(), function ($message) use ($name, $autopass, $request) {
                    $message->to($request->email)
                        ->from('info@vloerofferte.nl')
                        ->subject('Reset Password Request')
                        ->setBody("Dear Mr/Mrs ". $name .",<br><br>Your New Password is : ".$autopass."<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
                });

            }
            else // Dutch Email Template
            {

                \Mail::send(array(), array(), function ($message) use ($name, $autopass, $request) {
                    $message->to($request->email)
                        ->from('info@vloerofferte.nl')
                        ->subject('Wachtwoord wijzigen')
                        ->setBody("Beste ". $name .",<br><br>Je hebt zojuist een nieuw wachtwoord aangevraagd, indien jij niet de aanvrager bent neem contact met ons. Hierbij je nieuw wachtwoord : ".$autopass."<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
                });

            }


            Session::flash('success', $this->lang->prst);
    		return redirect()->route('user-forgot');

        }
        else{
            // user not found
            Session::flash('unsuccess', $this->lang->naft);
    		return redirect()->route('user-forgot');
        }



    }
}
