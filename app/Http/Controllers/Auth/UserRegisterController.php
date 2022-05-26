<?php

namespace App\Http\Controllers\Auth;

use App\Generalsetting;
use App\Language;
use App\Sociallink;
use App\user_languages;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Category;
use App\User;
use App\terms_conditions;
use APP\Rules\Captcha;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRegisterController extends Controller
{

    public $lang;

    public function __construct()
    {
        // $this->middleware('guest:user', ['except' => ['logout']]);

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
        $this->sl = Sociallink::findOrFail(1);


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

        $this->gs = Generalsetting::findOrFail(1);
    }


 	public function showRegisterForm()
    {
        return view('user.register');
    }

    public function showHandymanRegisterForm()
    {
        $terms = terms_conditions::where('role',1)->first();

        return view('user.handyman_register',compact('terms'));
    }

    public function register(Request $request)
    {

        $secret_key = config('app.captcha_secret');
        $response_key = $_POST['g-recaptcha-response'];

        $userIP = $_SERVER['REMOTE_ADDR'];


        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret_key."&response=".$response_key."&remoteip=".$userIP;
        $response = file_get_contents($url);
        $response = json_decode($response);


        if($response->success)
        {
            // Validate the form data
            $this->validate($request, [
                'email' => [
                    'required',
                    'string',
                    'email',
                    Rule::unique('users')->where(function($query) {
                        $query->where('allowed', '=', '1')->where('deleted_at', NULL);
                    })
                ],
                'name'   => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
                'family_name' => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
                'postcode' => 'required',
                'address' => 'required',
                'city' => 'required',
                'phone' => 'required',
                'password' => 'required|min:8|confirmed',
                'g-recaptcha-response' => 'required',
            ],
                [
                    'email.required' => $this->lang->erv,
                    'email.unique' => $this->lang->euv,
                    'name.required' => $this->lang->nrv,
                    'name.max' => $this->lang->nmv,
                    'name.regex' => $this->lang->niv,
                    'family_name.required' => $this->lang->fnrv,
                    'family_name.max' => $this->lang->fnmrv,
                    'family_name.regex' => $this->lang->fniv,
                    'postcode.required' => $this->lang->pcrv,
                    'address.required' => $this->lang->arv,
                    'city.required' => $this->lang->crv,
                    'phone.required' => $this->lang->prv,
                    'password.required' => $this->lang->parv,
                    'password.min' => $this->lang->pamv,
                    'password.confirmed' => $this->lang->pacv,
                    'g-recaptcha-response.required' => $this->lang->grv,
                ]);

            $user = new User;
            $input = $request->all();
            $user_name = $input['name'] . ' ' . $input['family_name'];
            $user_email = $input['email'];
            $input['password'] = bcrypt($request['password']);
            $user->fill($input)->save();
            Auth::guard('user')->login($user);
            $link = url('/').'/aanbieder/quotation-requests';


            /*$headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $subject = "Account Created!";
            $msg = "Dear Mr/Mrs ".$user_name.",<br><br>Your account has been created. You can go to your dashboard through <a href='".$link."'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
            mail($user_email,$subject,$msg,$headers);*/


            $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $subject = "Welkom bij Vloerofferte!";
            $msg = "Beste ".$user_name.",<br><br>Je account is succesvol aangemaakt. Je kan vanaf nu binnen paar klikken een stoffeerder reserveren. Klik op account om je profiel te bezoeken <a href='".$link."'>account.</a><br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
            mail($user_email,$subject,$msg,$headers);

            return redirect()->route('client-quotation-requests');

        }
        else {

            Session::flash('message', $this->lang->grv);
            return redirect()->back();

        }
    }

    public function HandymanRegister(Request $request)
    {
        // Validate the form data

        $secret_key = config('app.captcha_secret');
        $response_key = $_POST['g-recaptcha-response'];

        $userIP = $_SERVER['REMOTE_ADDR'];


        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret_key."&response=".$response_key."&remoteip=".$userIP;
        $response = file_get_contents($url);
        $response = json_decode($response);


        if ($response->success)
        {
            $this->validate($request, [
                'email' => [
                    'required',
                    'string',
                    'email',
                    Rule::unique('users')->where(function($query) {
                        $query->where('allowed', '=', '1')->where('deleted_at', NULL);
                    })
                ],
                'name'   => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
                'family_name' => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
                'company_name' => 'required',
                'registration_number' => 'required',
                'postcode' => 'required',
                'city' => 'required',
                /*'bank_account' => 'required',*/
                /*'tax_number' => 'required',*/
                'address' => 'required',
                'phone' => 'required',
                'password' => 'required|min:8|confirmed',
                'g-recaptcha-response' => 'required',
            ],

            [
              'email.required' => $this->lang->erv,
              'email.unique' => $this->lang->euv,
              'name.required' => $this->lang->nrv,
              'name.max' => $this->lang->nmv,
              'name.regex' => $this->lang->niv,
              'family_name.required' => $this->lang->fnrv,
              'family_name.max' => $this->lang->fnmrv,
              'family_name.regex' => $this->lang->fniv,
              'company_name.required' => $this->lang->cnrv,
              'registration_number.required' => $this->lang->rnrv,
              /*'bank_account.required' => $this->lang->barv,
              'tax_number.required' => $this->lang->tnrv,*/
              'postcode.required' => $this->lang->pcrv,
              'city.required' => $this->lang->crv,
              'address.required' => $this->lang->arv,
              'phone.required' => $this->lang->prv,
              'password.required' => $this->lang->parv,
              'password.min' => $this->lang->pamv,
              'password.confirmed' => $this->lang->pacv,
              'g-recaptcha-response.required' => $this->lang->grv,
            ]);

            $user = new User;
            $input = $request->all();
            $user_name = $input['name'];
            $user_email = $input['email'];
            $input['password'] = bcrypt($request['password']);
            $input['status'] = 1;
            $input['active'] = 0;
            $input['is_featured'] = 1;
            $input['featured'] = 0;
            $user->fill($input)->save();

            $user->givePermissionTo(['show-dashboard','user-complete-profile']);

            /*Auth::guard('user')->login($user);*/

            $link = url('/').'/aanbieder/complete-profile';

            /*$headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $subject = "Account Created!";
            $msg = "Dear Mr/Mrs ".$user_name.",<br><br>Your account has been created. Kindly go to this <a href='".$link."'>link</a> to complete your profile. You can get orders only after completing your profile.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
            mail($user_email,$subject,$msg,$headers);*/


            // $headers =  'MIME-Version: 1.0' . "\r\n";
            // $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // $subject = "Welkom bij Vloerofferte";
            // $msg = "Beste ".$user_name.",<br><br>Welkom bij vloerofferte.nl<br><br>Je profiel is succesvol aangemaakt, bedankt! Je kan pas offerte aanvragen ontvangen, nadat je je profiel hebt geactiveerd. Klik dus snel op deze <a href='".$link."'>link</a> om je profiel te activeren.<br><br>Veel succes met jouw aanvraag!<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte<br><br>Voor de beste prijs.";
            // mail($user_email,$subject,$msg,$headers);

            $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Pieppiep <info@pieppiep.com>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $subject = "Account Created!";
            $msg = "Dear Mr/Mrs ".$user_name.",<br><br>Your account has been created. We will be reviewing your information within 24 hours. We will inform you when you can login. Thanks for your cooperation.<br><br>Kind regards,<br><br>Klantenservice<br><br> Pieppiep";
            mail($user_email,$subject,$msg,$headers);

            Session::flash('success', __('text.Your account has been created. Kindly wait for verification email.'));
            return redirect()->back();

        }

        else
        {
            Session::flash('message', $this->lang->grv);
            return redirect()->back();
        }

    }

}
