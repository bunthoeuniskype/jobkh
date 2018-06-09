<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Contents as ContentsResource;
use App\Http\Resources\ContentDetail as ContentDetailResource;
use App\Content;

class ApiContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          $cond = [];
          $cond[] = ['locale',config("app.locale")];        
          if($request->city_id){
            $cond[] = ['city_id',$request->city_id];
           }

           if($request->category_id){
            $cond[] = ['category_id',$request->category_id];
           }

       return new ContentsResource(Content::where($cond)->paginate());
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
          $cond = [];
          $cond[] = ['locale',config("app.locale")];        
          if($request->city_id){
            $cond[] = ['city_id',$request->city_id];
           }

           if($request->category_id){
            $cond[] = ['category_id',$request->category_id];
           }

           if($request->id){
            $cond[] = ['id',$request->id];
           }

       return new ContentDetailResource(Content::where($cond)->get());
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
