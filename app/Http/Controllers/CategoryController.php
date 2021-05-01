<?php

namespace App\Http\Controllers;

use App\vats;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\Generalsetting;
use Mollie\Laravel\Facades\Mollie;
use App\service_types;
use App\sub_services;
use App\handyman_products;
use App\carts;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function preparePayment()
    {


        $api_key = Generalsetting::findOrFail(1);

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($api_key->mollie);
        $payment = $mollie->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => '10.00', // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => 'My first API payment',
            'webhookUrl' => route('webhooks.mollie'),
            'redirectUrl' => route('front.index'),
        ]);

        return redirect($payment->getCheckoutUrl(), 303);
    }


    public function index()
    {
        $cats = Category::orderBy('id','desc')->get();

        return view('admin.category.index',compact('cats'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(StoreValidationRequest $request)
    {

        $request['main_service'] = 1;

        if($request->cat_id)
        {
            $cat = Category::where('id',$request->cat_id)->first();
            Session::flash('success', 'Category edited successfully.');
        }
        else
        {
            $cat = new Category;
            Session::flash('success', 'New Category added successfully.');
        }

        $input = $request->all();


        if ($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
            $input['photo'] = $name;
        }

        $cat->fill($input)->save();

        return redirect()->route('admin-cat-index');
    }

    public function edit($id)
    {
        $cats = Category::where('id','=',$id)->first();

        return view('admin.category.create',compact('cats'));
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

        $cat = Category::findOrFail($id);

        if($cat->photo == null){
         $cat->delete();
         Session::flash('success', 'Category deleted successfully.');
         return redirect()->route('admin-cat-index');
        }

        \File::delete(public_path() .'/assets/images/'.$cat->photo);
        $cat->delete();
        Session::flash('success', 'Category deleted successfully.');
        return redirect()->route('admin-cat-index');
    }
}
