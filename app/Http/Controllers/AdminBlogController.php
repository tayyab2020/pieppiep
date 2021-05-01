<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
class AdminBlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

  public function index()
    {
        $blogs = Blog::orderBy('id','desc')->get();
        return view('admin.blog.index',compact('blogs'));
    }


    public function create()
    {
        return view('admin.blog.create');
    }


    public function store(UpdateValidationRequest $request)
    {
        $blog = new Blog();
        $data = $request->all();
        if ($file = $request->file('photo'))
         {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
            $data['photo'] = $name;
        }
        $blog->fill($data)->save();
        return redirect()->route('admin-blog-index')->with('success','New Blog Added Successfully.');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit',compact('blog'));
    }

    public function update(UpdateValidationRequest $request, $id)
    {

        $blog = Blog::findOrFail($id);
        $data = $request->all();

            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($blog->photo != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$blog->photo);
                }
            $data['photo'] = $name;
            }
        $blog->update($data);
        return redirect()->route('admin-blog-index')->with('success','Blog Updated Successfully.');
    }


    public function destroy($id)
    {

        $blog = Blog::findOrFail($id);
        if($blog->photo == null){
        $blog->delete();
        return redirect()->route('admin-blog-index')->with('success','Blog Deleted Successfully.');
        }

        \File::delete(public_path() .'/assets/images/'.$blog->photo);
        $blog->delete();
        return redirect()->route('admin-blog-index')->with('success','Blog Deleted Successfully.');
    }
}
