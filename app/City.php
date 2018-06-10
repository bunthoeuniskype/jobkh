<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
   protected $table='city';

    public function country($id)
    {
    	$data = Country::where(['country_id'=>$id,'locale'=>config('app.locale')])->first();
    	if($data){
    		return $data;
    	}
    	return null;
    	//return $this->belongsTo(City::class,'city_id','id');
    }
}
