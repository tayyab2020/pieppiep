<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advertise;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;

class AdvertiseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

  public function index()
    {
        $ads = Advertise::orderBy('id','desc')->get();
        return view('admin.advertise.index',compact('ads'));
    }

  public function status($id1,$id2)
    {

        $ad = Advertise::findOrFail($id1);
        $ad->status = $id2;
        $ad->update();
        return redirect()->route('admin-adv-index');
    }


    public function create()
    {
        return view('admin.advertise.create');
    }


    public function store(UpdateValidationRequest $request)
    {

        $ad = new Advertise();
        $data = $request->all();
        if ($file = $request->file('photo')) 
         {      
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);           
            $data['photo'] = $name;
        } 
        $ad->fill($data)->save();
        return redirect()->route('admin-adv-index')->with('success','New Advertisement Added Successfully.');
    }


    public function edit($id)
    {
        $ad = Advertise::findOrFail($id);
        return view('admin.advertise.edit',compact('ad'));
    }

    public function update(UpdateValidationRequest $request, $id)
    {
        $ad = Advertise::findOrFail($id);
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
        return redirect()->route('admin-adv-index')->with('success','Advertisement Updated Successfully.');
    }


    public function destroy($id)
    {

        $ad = Advertise::findOrFail($id);
        if($ad->photo == null){
        $ad->delete();
        return redirect()->route('admin-adv-index')->with('success','Advertisement Deleted Successfully.');
        }
        unlink(public_path().'/assets/images/'.$ad->photo);
        $ad->delete();
        return redirect()->route('admin-adv-index')->with('success','Advertisement Deleted Successfully.');
    }
}
