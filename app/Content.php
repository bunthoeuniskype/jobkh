<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table='content';

    public function city($id)
    {
    	$data = City::where(['id'=>$id,'locale'=>config('app.locale')])->first();
    	if($data){
    		return $data;
    	}
    	return null;
    	//return $this->belongsTo(City::class,'city_id','id');
    }

    public function category($id)
    {
    	$data = Category::where(['id'=>$id,'locale'=>config('app.locale')])->first();
    	if($data){
    		return $data;
    	}
    	return null;
    	//return $this->belongsTo(Category::class,'category_id','id');
    }
}
