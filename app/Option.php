<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
 	protected $table = 'option';

 	public static function getVal($key)
 	{
 		return static::where('key',$key)->first();
 	}
}
