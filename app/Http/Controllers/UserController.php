<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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


            'title'=>'required',
            'image'=>'required|mimes:jpeg, png, bmp, jpg,tmp',
//            'categories'=>'required',
            'tags'=>'required',
            'body'=>'required'


        ]);

        $image = $request->file('image');
        $slug = str_slug($request->title);

        if(isset($image)){

            $currentDate = Carbon::now()->toDateString();

            $imageName = $slug. '-'. $currentDate. '-'. uniqid().'-'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('post')){

                Storage::disk('public')->makeDirectory('post');

            }

            $postImage = Image::make($image)->resize(1600,1066);
            $postImage->stream();
            Storage::disk('public')->put('post/'.$imageName, $postImage);

        }

        else{

            $imageName = "default.png";
        }

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;
        if(isset($request->status)){

            $post->status = true;


        }

        else{

            $post->status = false;

        }

        $post->is_approved = true;
        $post->save();
        $post->categories()->attach($request->categories);
        $post->categories()->attach($request->tags);

        return redirect()->route('author.index');




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
        //
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
    }
}
