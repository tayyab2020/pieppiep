<?php

namespace App\Http\Controllers;

use App\product_features;
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
        $features = features::orderBy('id','desc')->get();

        return view('admin.features.index',compact('features'));
    }

    public function create()
    {
        return view('admin.features.create');
    }

    public function store(Request $request)
    {
        if($request->heading_id)
        {
            features::where('id',$request->heading_id)->update(['title' => $request->title, 'order_no' => $request->order_no]);
            Session::flash('success', 'Feature updated successfully.');
        }
        else
        {
            $feature = new features;

            $feature->title = $request->title;
            $feature->order_no = $request->order_no;
            $feature->save();

            Session::flash('success', 'New Feature added successfully.');
        }

        return redirect()->route('admin-feature-index');
    }

    public function edit($id)
    {
        $feature = features::findOrFail($id);

        return view('admin.features.create',compact('feature'));
    }

    public function destroy($id)
    {
        $feature = features::findOrFail($id);
        $feature->delete();

        product_features::where('heading_id',$id)->delete();
        Session::flash('success', 'Feature deleted successfully.');
        return redirect()->route('admin-feature-index');

    }
}
