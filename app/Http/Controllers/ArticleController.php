<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Image;

class ArticleController extends Controller
{
    public function __construct($value='')
    {
        $this->article = new Article();
    }
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
           
        $directory =  'public/upload/article';       
     $directoryThumb =  'public/upload/thumb/article';  
      
       $pathName = array();  
       
       
        dd($request->all());

     //   if($request->hasFile('image')){

          $destinationPaths = base_path().'/'.$directory;
          $destinationPathThumb = base_path().'/'.$directoryThumb;
     
      try {
         $file = $request->file('image');    
        foreach($file as $key => $value){
        $name = time().'-'.$value->getClientOriginalName();
        $img = Image::make($value->getRealPath());    
       // $img->fit(1200,820)->save($destinationPaths.'/'.$name);    
         //$img->fit(300,200)->save($destinationPathThumb.'/'.$name);
        //$file->move($destinationPaths,  $name);
        $pathName[] = 'article/'.$name; 
        } 
      } catch (Exception $e) {
        
      }  
      dd($pathName);


      $art = $this->article;
      $art->author_id = 1;
      $art->title = $request->title;
      $art->image = json_encode($pathName);
      $art->content = $request->content;
      if($art->save()){
          return response()->json(['code'=>200,'message'=>'Save Successfully!']);
      }
      return response()->json(['code'=>500,'message'=>'Save Failed!']);
    }

    public function uploadMultiple(Request $request)
    {
      
  	$file = $request->file('imageFiles');        
  	$directory =  'public/upload/article';
    $directoryThumb =  'public/upload/thumb/article';   
         
   $pathName = array();  

  	if($request->hasFile('imageFiles')){

      $destinationPaths = base_path().'/'.$directory;
      $destinationPathThumb = base_path().'/'.$directoryThumb;
    //   $name = time().'-'.$file->getClientOriginalName();

    //   $img = Image::make($file->getRealPath());
    //  /* $img->resize(300, 300, function ($constraint) {
    //     $constraint->aspectRatio();
    //   })->save($destinationPathThumb.'/'.$name); */
    //   $img->fit(1200,820)->save($destinationPaths.'/'.$name);
  	//   $img->fit(300,200)->save($destinationPathThumb.'/'.$name); 
    //  //$file->move($destinationPaths,  $name);
    //     }else{
    //     return response()->json(['error'=>'Upload Failed!','status'=>500]); 
    //     }	
    //     $pathName = 'article/'.$name;
    //     return response()->json(['status'=>200,'name'=>$pathName]);

      try {
        foreach($file as $key => $value){
        $name = time().'-'.$value->getClientOriginalName();
        $img = Image::make($value->getRealPath());    
       // $img->fit(1200,820)->save($destinationPaths.'/'.$name);    
        $img->fit(300,200)->save($destinationPathThumb.'/'.$name);
        //$file->move($destinationPaths,  $name);
        $pathName[] = 'article/'.$name; 
        } 
      } catch (Exception $e) {
       return response()->json(['error'=>'Upload Failed','response'=>['code'=>500, 'message'=>'Response upload image failed']]); 
      }    
    }     
    return response()->json(['data'=>['image'=>$pathName],'response'=>['code'=>200, 'message'=>'Response upload image successfully']]);
  
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
