<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Social;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $social=Social::orderBy('id','DESC')->paginate(10);
        return view('backend.social.index')->with('socials',$social);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.social.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'title'=>'required',
            'link'=>'required',
            'icon'=>'required',
        ]);
        $data=$request->all();
        $slug=Str::slug($request->title);
        $status=Social::create($data);
        if($status){
            request()->session()->flash('success','Social successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding social');
        }
        return redirect()->route('social.index');
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
        $social=Social::findOrFail($id);
        return view('backend.social.edit')->with('social',$social);
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
        $social=Social::findOrFail($id);
        $this->validate($request,[
            'title'=>'required',
            'link'=>'required',
            'icon'=>'required',
        ]);
        $data=$request->all();
        $status=$social->fill($data)->save();
        if($status){
            request()->session()->flash('success','Social successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating social');
        }
        return redirect()->route('social.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $social=Social::findOrFail($id);
        $status=$social->delete();
        if($status){
            request()->session()->flash('success','Social successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting social');
        }
        return redirect()->route('social.index');
    }
}
