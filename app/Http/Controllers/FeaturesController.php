<?php

namespace App\Http\Controllers;

use App\features;
use App\User;
use App\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\Generalsetting;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeaturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        $features = features::leftjoin('users','users.id','=','features.user_id')->orderBy('features.id','desc')->select('features.*','users.name','users.family_name')->get();

        return view('admin.features.index',compact('features'));
    }

    public function create()
    {
        $handymen = User::where('role_id',2)->where('active',1)->get();

        return view('admin.features.create',compact('handymen'));
    }

    public function store(Request $request)
    {

        $features = new features;
        $input = $request->all();

        $features->title = $request->title;
        $features->user_id = $request->handyman;
        $features->save();


        Session::flash('success', 'New Feature added successfully.');
        return redirect()->route('admin-feature-index');
    }

    public function edit($id)
    {
        $feature = features::findOrFail($id);

        $handymen = User::where('role_id',2)->where('active',1)->get();

        return view('admin.features.edit',compact('feature','handymen'));
    }

    public function update(Request $request, $id)
    {
        features::where('id',$id)->update(['title' => $request->title, 'user_id' => $request->handyman]);

        Session::flash('success', 'Feature updated successfully.');
        return redirect()->route('admin-feature-index');
    }

    public function destroy($id)
    {
        $feature = features::findOrFail($id);
        $feature->delete();
        Session::flash('success', 'Feature deleted successfully.');
        return redirect()->route('admin-feature-index');

    }
}
