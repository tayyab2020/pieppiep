<?php

namespace App\Http\Controllers;

use App\Faq;
use App\Pagesetting;
use Illuminate\Http\Request;
use Auth;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

  public function index()
    {
        $faqs = Faq::orderBy('id','desc')->get();
        $pagedata = Pagesetting::find(1); 
        return view('admin.faq.index',compact('faqs','pagedata'));
    }


    public function create()
    {
        return view('admin.faq.create');
    }


    public function store(Request $request)
    {
        $faq = new Faq();
        $data = $request->all();
        $faq->fill($data)->save();
        return redirect()->route('admin-fq-index')->with('success','New Faq Added Successfully.');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faq.edit',compact('faq'));
    }

    public function update(Request $request, $id)
    {

        $faq = Faq::findOrFail($id);
        $data = $request->all();
        $faq->update($data);
        return redirect()->route('admin-fq-index')->with('success','Faq Updated Successfully.');
    }


    public function destroy($id)
    {

        $faq = Faq::findOrFail($id);
        $faq->delete();
        return redirect()->route('admin-fq-index')->with('success','Faq Deleted Successfully.');
    }
}
