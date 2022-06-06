<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pagesetting;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Pages;

class PageSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $pages = Pages::orderBy('order_no','Asc')->get();
        return view('admin.pages.index',compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function edit($id)
    {
        $page = Pages::where('id',$id)->first();
        return view('admin.pages.create',compact('page'));
    }

    public function store(Request $request)
    {
        $name = NULL;

        if($request->page_id)
        {
            $page = Pages::where('id',$request->page_id)->first();

            if($file = $request->file('photo'))
            {
                \File::delete(public_path() .'/assets/images/'.$page->image);
            }
            else
            {
                $name = $page->image;
            }
        }
        else
        {
            $page = new Pages;
        }

        if($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
        }

        $page->page = $request->page;
        $page->title = $request->title;
        $page->order_no = $request->order_no;
        $page->description = $request->description;
        $page->meta_keywords = $request->meta_keywords;
        $page->meta_title = $request->meta_title;
        // $page->meta_url = $request->meta_url;
        $page->meta_description = $request->meta_description;
        $page->image = $name;
        $page->save();

        Session::flash('success', 'Task completed successfully!');
        return redirect()->back();

    }

    public function destroy($id)
    {
        $page = Pages::where('id',$id)->first();

        if(!$page)
        {
            return redirect()->back();
        }

        \File::delete(public_path() .'/assets/images/'.$page->image);
        $page->delete();

        Session::flash('success', 'Task completed successfully!');
        return redirect()->back();
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
