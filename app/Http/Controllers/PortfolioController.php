<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

  public function index()
    {
        $ads = Portfolio::orderBy('id','desc')->get();
        return view('admin.portfolio.index',compact('ads'));
    }


    public function create()
    {
        return view('admin.portfolio.create');
    }


    public function store(StoreValidationRequest $request)
    {

        $ad = new Portfolio();
        $data = $request->all();
        if ($file = $request->file('photo')) 
         {      
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);           
            $data['photo'] = $name;
        } 
        $ad->fill($data)->save();
        return redirect()->route('admin-ad-index')->with('success','New Data Added Successfully.');
    }


    public function edit($id)
    {
        $ad = Portfolio::findOrFail($id);
        return view('admin.portfolio.edit',compact('ad'));
    }

    public function update(StoreValidationRequest $request, $id)
    {

        $ad = Portfolio::findOrFail($id);
        $data = $request->all();

            if ($file = $request->file('photo')) 
            {              
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($ad->photo != null)
                {
                    unlink(public_path().'/assets/images/'.$ad->photo);
                }            
            $data['photo'] = $name;
            } 
        $ad->update($data);
        return redirect()->route('admin-ad-index')->with('success','Data Updated Successfully.');
    }


    public function destroy($id)
    {

        $ad = Portfolio::findOrFail($id);
        if($ad->photo == null){
        $ad->delete();
        return redirect()->route('admin-ad-index')->with('success','Data Deleted Successfully.');
        }
        unlink(public_path().'/assets/images/'.$ad->photo);
        $ad->delete();
        return redirect()->route('admin-ad-index')->with('success','Data Deleted Successfully.');
    }
}
