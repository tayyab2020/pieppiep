<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sociallink;
use Illuminate\Support\Facades\Session;
use Auth;

class SocialSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$socialdata = Sociallink::findOrFail(1);
        return view('admin.socialsetting.socialsetting',compact('socialdata'));
    }


public function FilterSettings()
    {
        $socialdata = Sociallink::findOrFail(1);
        return view('admin.filter_settings',compact('socialdata'));
    }

    public function update(Request $request)
    {

        $socialdata = SocialLink::findOrFail(1);
        $input = $request->all();
        if ($request->f_status == ""){
            $input['f_status'] = 0;
        }
        if ($request->t_status == ""){
            $input['t_status'] = 0;
        }

        if ($request->g_status == ""){
            $input['g_status'] = 0;
        }

        if ($request->l_status == ""){
            $input['l_status'] = 0;
        }

        $socialdata->update($input);
        Session::flash('success', 'Social links updated successfully.');
        return redirect()->route('admin-social-index');
    }

     public function FilterUpdate(Request $request)
    {

        $socialdata = SocialLink::findOrFail(1);
        $input = $request->all();


        if ($request->ins == ""){
            $input['ins'] = 0;
        }
        if ($request->rat == ""){
            $input['rat'] = 0;
        }

        if ($request->pr == ""){
            $input['pr'] = 0;
        }

        if ($request->ey == ""){
            $input['ey'] = 0;
        }

        $socialdata->update($input);
        Session::flash('success', 'Filter settings updated successfully.');
        return redirect()->route('admin-filter-settings');
    }

}
