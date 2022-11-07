<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BasicPage;
use Illuminate\Support\Str;

class BasicPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $basicPage=BasicPage::orderBy('id','DESC')->paginate(10);
        return view('backend.basic-page.index')->with('basicPages',$basicPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.basic-page.create');
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
            'photo'=>'string|required',
        ]);
        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=BasicPage::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $slug;
        $status=BasicPage::create($data);
        if($status){
            request()->session()->flash('success','Basic Page successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding basic page');
        }
        return redirect()->route('basic-page.index');
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
        $basicPage=BasicPage::findOrFail($id);
        return view('backend.basic-page.edit')->with('basicPage',$basicPage);
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
        $banner=BasicPage::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'photo'=>'string|required',
        ]);
        $data=$request->all();
        $status=$banner->fill($data)->save();
        if($status){
            request()->session()->flash('success','Basic Page successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating basic page');
        }
        return redirect()->route('basic-page.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $basicPage=BasicPage::findOrFail($id);
        $status=$basicPage->delete();
        if($status){
            request()->session()->flash('success','Basic Page successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting basic page');
        }
        return redirect()->route('basic-page.index');
    }

}
