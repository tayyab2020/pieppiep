<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pagesetting;
use Illuminate\Support\Facades\Session;
use Auth;

class PageSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function about()
    {
        $pagedata = Pagesetting::find(1);
        return view('admin.pagesetting.about',compact('pagedata'));
    }

    public function faq()
    {
        $pagedata = Pagesetting::find(1);
        return view('admin.pagesetting.faq',compact('pagedata'));
    }

    public function contact()
    {
        $pagedata = Pagesetting::find(1);    
        return view('admin.pagesetting.contact',compact('pagedata'));
    }

    //Upadte About Page Section Settings
    public function aboutupdate(Request $request)
    {

        $page = Pagesetting::findOrFail(1);
        $input = $request->all();
        if ($request->a_status == ""){
            $input['a_status'] = 0;
        }
        $page->update($input);
        Session::flash('success', 'About Us page content updated successfully.');
        return redirect()->route('admin-ps-about');
    }

    //Upadte About Page Section Settings


    //Upadte FAQ Page Section Settings
    public function faqupdate(Request $request)
    {

        $page = Pagesetting::findOrFail(1);

        $input = $request->all();

        if ($request->f_status == ""){
            $input['f_status'] = 0;
        }
        $page->update($input);
        Session::flash('success', 'FAQ page content updated successfully.');
        return redirect()->route('admin-fq-index');;
    }

    //Upadte Contact Page Section Settings
    public function contactupdate(Request $request)
    {

        $page = Pagesetting::findOrFail(1);
        $input = $request->all();
        if ($request->c_status == ""){
            $input['c_status'] = 0;
        }
        $page->update($input);
        Session::flash('success', 'Contact page content updated successfully.');
        return redirect()->route('admin-ps-contact');;
    }
}
