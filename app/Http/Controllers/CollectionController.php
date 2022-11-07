<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection=Collection::getAllCollection();
        // return $collection;
        return view('backend.collection.index')->with('collections',$collection);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats=Collection::orderBy('title','ASC')->get();
        return view('backend.collection.create')->with('parent_cats',$parent_cats);
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
            'title'=>'string|required',
            'summary'=>'string|nullable',
            'photo'=>'string|nullable',
            'status'=>'required|in:active,inactive',
        ]);
        $data= $request->all();
        $slug=Str::slug($request->title);
        $count=Collection::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $data;
        $status=Collection::create($data);
        if($status){
            request()->session()->flash('success','Collection successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('collection.index');


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
        $collection=Collection::findOrFail($id);
        return view('backend.collection.edit')->with('collection',$collection);
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
        // return $request->all();
        $collection=Collection::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|nullable',
            'photo'=>'string|nullable',
            'status'=>'required|in:active,inactive',
        ]);
        $data= $request->all();
        // return $data;
        $status=$collection->fill($data)->save();
        if($status){
            request()->session()->flash('success','Collection successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('collection.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collection=Collection::findOrFail($id);
        $status=$collection->delete();

        if($status){
            request()->session()->flash('success','Collection successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting collection');
        }
        return redirect()->route('collection.index');
    }
}
