<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;
use Illuminate\Support\Str;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $policy=Policy::orderBy('id','DESC')->paginate(10);
        return view('backend.policy.index')->with('policies',$policy);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.policy.create');
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
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'type'=>'in:privacy,terms,cookies|required',
        ]);
        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Policy::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $status=Policy::create($data);
        if($status){
            request()->session()->flash('success','Policy successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding policy');
        }
        return redirect()->route('policy.index');
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
        $policy=Policy::findOrFail($id);
        return view('backend.policy.edit')->with('policy',$policy);
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
        $policy=Policy::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'type'=>'in:privacy,terms,cookies|required',
        ]);
        $data=$request->all();
        $status=$policy->fill($data)->save();
        if($status){
            request()->session()->flash('success','Policy successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating policy');
        }
        return redirect()->route('policy.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $policy=Policy::findOrFail($id);
        $status=$policy->delete();
        if($status){
            request()->session()->flash('success','Policy successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting policy');
        }
        return redirect()->route('policy.index');
    }

}
