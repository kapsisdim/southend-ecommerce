<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable=['title','slug','summary','photo','status','added_by'];

    public static function getAllCollection(){
        return  Collection::orderBy('id','DESC')->paginate(10);
    }
    public function products(){
        return $this->hasMany('App\Models\Product','collection_id','id')->where('status','active');
    }
    public static function getProductByCollection($slug){
        // dd($slug);
        return Collection::with('products')->where('slug',$slug)->first();
        // return Product::where('collection_id',$id)->paginate(10);
    }
    public static function countActiveCollection(){
        $data=Collection::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
