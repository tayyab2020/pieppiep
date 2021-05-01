<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Model1;
use App\vats;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest2;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\Generalsetting;
use Mollie\Laravel\Facades\Mollie;
use App\service_types;
use App\sub_services;
use App\handyman_products;
use App\carts;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $cats = Model1::leftjoin('brands','brands.id','=','models.brand_id')->orderBy('models.id','desc')->select('models.*','brands.cat_name as brand')->get();

        return view('admin.model.index',compact('cats'));
    }

    public function create()
    {
        $brands = Brand::all();

        return view('admin.model.create',compact('brands'));
    }

    public function store(StoreValidationRequest2 $request)
    {
        if($request->cat_id)
        {
            $cat = Model1::where('id',$request->cat_id)->first();
            Session::flash('success', 'Model edited successfully.');
        }
        else
        {
            $cat = new Model1;
            Session::flash('success', 'New Model added successfully.');
        }

        $input = $request->all();


        if($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
            $input['photo'] = $name;
        }

        $cat->fill($input)->save();

        return redirect()->route('admin-model-index');
    }

    public function edit($id)
    {
        $cats = Model1::where('id','=',$id)->first();
        $brands = Brand::all();

        return view('admin.model.create',compact('cats','brands'));
    }

    public function update(UpdateValidationRequest $request, $id)
    {

        $vat = vats::where('id',$request->vat)->first();

        if(!$request->main_service)
        {

            $i =0;

            foreach ($request->sub_service as $key) {

                if($request->s_id[$i] != 0)
                {

                    $update = sub_services::where('id',$request->s_id[$i])->update(['cat_id'=>$key]);

                }
                else
                {

                    $sub_services = new sub_services;
                    $sub_services->cat_id = $key;
                    $sub_services->sub_id = $id;
                    $sub_services->save();

                }

                $i++;

            }
        }

        if($request->variable_questions)
        {
            $request['variable_questions'] = 1;
        }
        else
        {
            $request['variable_questions'] = 0;
        }

        $cat = Category::findOrFail($id);

        $input = $request->all();

        $input['vat_id'] = $vat->id;
        $input['vat_percentage'] = $vat->vat_percentage;
        $input['vat_rule'] = $vat->rule;
        $input['vat_code'] = $vat->code;

        if ($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
            if($cat->photo != null)
            {
                \File::delete(public_path() .'/assets/images/'.$cat->photo);
            }
            $input['photo'] = $name;
        }

        $cat->update($input);
        Session::flash('success', 'Service updated successfully.');
        return redirect()->route('admin-cat-index');
    }

    public function destroy($id)
    {
        $cat = Model1::findOrFail($id);

        if($cat->photo == null){
            $cat->delete();
            Session::flash('success', 'Model deleted successfully.');
            return redirect()->route('admin-model-index');
        }

        \File::delete(public_path() .'/assets/images/'.$cat->photo);
        $cat->delete();
        Session::flash('success', 'Model deleted successfully.');
        return redirect()->route('admin-model-index');
    }
}
