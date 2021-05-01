<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Language;
use Illuminate\Support\Facades\Session;
use Auth;
use App\user_languages;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function lang(Request $request)
    {

       

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

  

if($request->lang_select != '')
{

    $language = user_languages::where('ip','=',$ip_address)->update(['lang' => $request->lang_select]);


}

$lang = user_languages::where('ip','=',$ip_address)->first();

  

        if($lang->lang == 'eng')
        {

            $data = Language::where('lang','=','eng')->first();

        }

        else
        {

            $data = Language::where('lang','=','du')->first();

        }
        
        return view('admin.language.index',compact('data'));
    }

    public function langup(Request $request)
    {   


        $input = $request->all(); 
        $lang = Language::where('lang','=',$request->lang_set)->first();                 
        $lang->update($input);

        
        Session::flash('success', 'Successfully updated the Data');
        return redirect()->route('admin-lang-index');
}

}
