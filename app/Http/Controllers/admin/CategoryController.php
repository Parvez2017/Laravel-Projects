<?php

namespace App\Http\Controllers\admin;

use App\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
//use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::latest()->get();
        return view('admin.category.index',compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate($request,[

            'name'=> 'required|unique:categories',
            'image'=>'required|mimes:jpeg, png, bmp, jpg,tmp'

        ]);
        //get form image
        $image = $request->file('image');
        $slug = str_slug($request->name);
        if(isset($image)){

//            make unique nmae for image
          $currentDate = Carbon::now()->toDateString();
          $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
          //check category dir is exists
            if(!Storage::disk('public')->exists('category')){

                Storage::disk('public')->makeDirectory('category');
            }

            //resize image for category and upload

            $category = Image::make($image)->resize(1600,479);
            $category->save($imagename);
            Storage::disk('public')->put('category/'.$imagename, $category);

            if(!Storage::disk('public')->exists('category/slider')){

                Storage::disk('public')->makeDirectory('category/slider');
            }

            $slider = Image::make($image)->resize(500,333);
            $slider->save($imagename);
            Storage::disk('public')->put('category/slider/'.$imagename, $slider);

        }
        else{

            $imagename = "default.png";


        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Category successfully added', 'Success');
        return redirect()->route('admin.category.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = Category::find($id);

        return view('admin.category.edit',compact('category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[

            'name'=> 'required',
            'image'=>'mimes:jpeg, png, bmp, jpg,tmp'

        ]);
        //get form image
        $image = $request->file('image');
        $slug = str_slug($request->name);
        $categoryImage = Category::find($id);
        if(isset($image)){

//            make unique nmae for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //check category dir is exists
            if(!Storage::disk('public')->exists('category')){

                Storage::disk('public')->makeDirectory('category');
            }


            if(Storage::disk('public')->exists('category/'.$categoryImage->image)){

                Storage::disk('public')->delete('category/'.$categoryImage->image);

            }
            //resize image for category and upload

            $category = Image::make($image)->resize(1600,479);
            $category->save($imagename);
            Storage::disk('public')->put('category/'.$imagename, $category);

            if(!Storage::disk('public')->exists('category/slider')){

                Storage::disk('public')->makeDirectory('category/slider');
            }


            if(Storage::disk('public')->exists('category/slider'.$categoryImage->image)){

                Storage::disk('public')->delete('category/slider'.$categoryImage->image);

            }

            $slider = Image::make($image)->resize(500,333);
            $slider->save($imagename);
            Storage::disk('public')->put('category/slider/'.$imagename, $slider);

        }
        else{

            $imagename = $categoryImage->image;


        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Category successfully added', 'Success');
        return redirect()->route('admin.category.index');




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
      Category::find($id)->delete();
      Toastr::success('The category is deleted','Success');
      return redirect()->back();


    }
}
