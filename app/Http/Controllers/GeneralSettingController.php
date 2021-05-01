<?php

namespace App\Http\Controllers;

use App\vats;
use Illuminate\Http\Request;
use App\Generalsetting;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use Auth;

class GeneralSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function logo()
    {
        $data = Generalsetting::findOrFail(1);
        return view('admin.generalsetting.logo',compact('data'));
    }

    public function logoup(StoreValidationRequest $request)
    {

        $input = $request->all();
        $logo = Generalsetting::findOrFail(1);
            if ($file = $request->file('logo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($logo->logo != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$logo->logo);
                }
            $input['logo'] = $name;
            }
        $logo->update($input);

        $logo = Generalsetting::where('backend',1)->first();
        $logo->update($input);

        Session::flash('success', 'Successfully updated the logo');
        return redirect()->route('admin-gs-logo');
    }

  public function fav()
    {
        $data = Generalsetting::findOrFail(1);
        return view('admin.generalsetting.favicon',compact('data'));
    }

    public function favup(StoreValidationRequest $request)
    {

        $input = $request->all();
        $fav = Generalsetting::findOrFail(1);
            if ($file = $request->file('favicon'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($fav->fav != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$fav->fav);
                }
            $input['favicon'] = $name;
            }
        $fav->update($input);

        $fav = Generalsetting::where('backend',1)->first();
        $fav->update($input);

        Session::flash('success', 'Successfully updated the Favicon');
        return redirect()->route('admin-gs-fav');
    }

  public function load()
    {
        $data = Generalsetting::findOrFail(1);
        return view('admin.generalsetting.loader',compact('data'));
    }

    public function loadup(Request $request)
    {
        $this->validate($request, [
               'loader' => 'mimes:gif'
           ]);
        $input = $request->all();
        $fav = Generalsetting::findOrFail(1);
            if ($file = $request->file('loader'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($fav->loader != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$fav->loader);
                }
            $input['loader'] = $name;
            }
        $fav->update($input);

        $fav = Generalsetting::where('backend',1)->first();
        $fav->update($input);

        Session::flash('success', 'Successfully updated the Loader');
        return redirect()->route('admin-gs-load');
    }

    public function bgimg()
    {
        $data = Generalsetting::findOrFail(1);
        return view('admin.generalsetting.backgroundimage',compact('data'));
    }

    public function bgimgup(StoreValidationRequest $request)
    {

        $input = $request->all();
        $bgimg = Generalsetting::findOrFail(1);
            if ($file = $request->file('bgimg'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($bgimg->bgimg != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$bgimg->bgimg);
                }
            $input['bgimg'] = $name;
            }
        $bgimg->update($input);
        Session::flash('success', 'Successfully updated the background image');
        return redirect()->route('admin-gs-bgimg');
    }

    public function contents()
    {
        $data = Generalsetting::findOrFail(1);
        return view('admin.generalsetting.websitecontent',compact('data'));
    }

    public function contentsChange(Request $request)
    {
        $data = Generalsetting::where('backend',$request->office)->first();
        return view('admin.generalsetting.websitecontent',compact('data'));
    }

    public function contentsup(Request $request)
    {

        $office = $request->office;


        $content = Generalsetting::where('backend',$office)->first();
        $input = $request->all();
            if ($file = $request->file('bimg'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($content->bimg != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$content->bimg);
                }
            $input['bimg'] = $name;
            }


            if ($file = $request->file('h_sidebg'))
            {
                $name1 = time().$file->getClientOriginalName();
                $file->move('assets/images',$name1);
                if($content->h_sidebg != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$content->h_sidebg);
                }
            $input['h_sidebg'] = $name1;
            }



            if ($file = $request->file('h_dashbg'))
            {
                $name2 = time().$file->getClientOriginalName();
                $file->move('assets/images',$name2);
                if($content->h_dashbg != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$content->h_dashbg);
                }
            $input['h_dashbg'] = $name2;
            }


            if ($file = $request->file('c_sidebg'))
            {
                $name3 = time().$file->getClientOriginalName();
                $file->move('assets/images',$name3);
                if($content->c_sidebg != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$content->c_sidebg);
                }
            $input['c_sidebg'] = $name3;
            }


            if ($file = $request->file('c_dashbg'))
            {
                $name4 = time().$file->getClientOriginalName();
                $file->move('assets/images',$name4);
                if($content->c_dashbg != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$content->c_dashbg);
                }
            $input['c_dashbg'] = $name4;
            }
        $content->update($input);
        Session::flash('success', 'Successfully updated the data');
        return redirect()->route('admin-gs-contents');
    }

    public function payments()
    {
        $data = Generalsetting::findOrFail(1);

        $data['registration_fee'] = str_replace(".",",",$data->registration_fee);



        return view('admin.generalsetting.payments',compact('data'));
    }

    public function paymentsup(Request $request)
    {

        $request['registration_fee'] = str_replace(",",".",$request->registration_fee);


        $data = Generalsetting::findOrFail(1);
        $data->update($request->all());

        $data = Generalsetting::where('backend',1)->first();
        $data->update($request->all());

        Session::flash('success', 'Successfully updated the Data');
        return redirect()->route('admin-gs-payments');
    }

    public function vats()
    {
        $data = vats::all();

        return view('admin.generalsetting.vats',compact('data'));
    }

    public function viewVat($id)
    {
        $data = vats::where('id',$id)->first();

        return view('admin.generalsetting.create_vat',compact('data'));
    }

    public function deleteVat($id)
    {
        vats::where('id',$id)->delete();

        return redirect()->route('admin-gs-vats');
    }

    public function createVat()
    {
        return view('admin.generalsetting.create_vat');
    }

    public function vatsup(Request $request)
    {
        if($request->vat_id)
        {
            vats::where('id',$request->vat_id)->update(['vat_percentage' => $request->vat_percentage, 'code' => $request->code, 'rule' => $request->rule]);
        }
        else
        {
            $data = new vats;
            $data->vat_percentage = $request->vat_percentage;
            $data->rule = $request->rule;
            $data->code = $request->code;
            $data->save();
        }

        Session::flash('success', 'Task Successful');
        return redirect()->route('admin-gs-vats');
    }

    public function about()
    {
        $data = Generalsetting::findOrFail(1);
        return view('admin.generalsetting.about',compact('data'));
    }

    public function aboutup(Request $request)
    {

        $about = Generalsetting::findOrFail(1);
        $about->update($request->all());

        $about = Generalsetting::where('backend',1)->first();
        $about->update($request->all());

        Session::flash('success', 'Successfully updated the about section');
        return redirect()->route('admin-gs-about');
    }

    public function address()
    {
        $data = Generalsetting::findOrFail(1);
        return view('admin.generalsetting.address',compact('data'));
    }

    public function addressup(Request $request)
    {

        $address = Generalsetting::findOrFail(1);
        $address->update($request->all());

        $address = Generalsetting::where('backend',1)->first();
        $address->update($request->all());

        Session::flash('success', 'Successfully updated the address section');
        return redirect()->route('admin-gs-address');
    }

    public function footer()
    {
        $data = Generalsetting::findOrFail(1);
        return view('admin.generalsetting.footer',compact('data'));
    }

    public function footerup(Request $request)
    {
        $footer = Generalsetting::findOrFail(1);
        $footer->update($request->all());

        $footer = Generalsetting::where('backend',1)->first();
        $footer->update($request->all());

        Session::flash('success', 'Successfully updated the footer section');
        return redirect()->route('admin-gs-footer');
    }
    public function bginfo()
    {
        $data = Generalsetting::findOrFail(1);
        return view('admin.generalsetting.bg-info',compact('data'));
    }

    public function bginfoup(Request $request)
    {

        $bginfo = Generalsetting::findOrFail(1);
        $bginfo->update($request->all());

        $bginfo = Generalsetting::where('backend',1)->first();
        $bginfo->update($request->all());

        Session::flash('success', 'Background Information content updated successfully.');
        return redirect()->route('admin-gs-bginfo');
    }
}
