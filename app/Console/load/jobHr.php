<?php

namespace App\Console\load;

use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\TranslateClient;
use App\Category;
use App\Content;
use App\City;

class jobHr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobhr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->site_url = '';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $tr = new TranslateClient(); // Default is from 'auto' to 'en'
        // $tr->setSource('zh'); // Translate from English
        // $tr->setTarget('en'); // Translate to Georgian
        $tr->setUrlBase('http://translate.google.cn/translate_a/single'); // Set Google Translate URL base (This is not necessary, only for some countries)

        $html = new \Htmldom($this->site_url);  

        $catTextArr = array();
        $catLinkArr = array();    
        $locationTextArr = array();
        
        $transFrom = 'zh-CN';
        $extraLang = array(
                array('code'=>'km','name'=>'Khmer'),
               //array('code'=>'en','name'=>'English'),
                array('code'=>'zh-CN','name'=>'Chinese'),
                array('code'=>'ko','name'=>'Korean'),
                array('code'=>'th','name'=>'Thai'),
                array('code'=>'ja','name'=>'Japanese')
            );

        //category 
         foreach($html->find('div[id="content_1"] ul[class="browse-jobs-list"] li label[class="browse-jobs-title"]') as $key => $element){
             $catLinkArr[$key] = $element->find('a',0)->href;
             $catTextArr[$key] = $element->find('a',0)->text();
         }

         foreach($html->find('div[id="content_3"] ul[class="browse-jobs-list"] li label[class="browse-jobs-title"]') as $key => $element){            
             $locationTextArr[$key] = $element->find('a',0)->text();
         }         
         
        //insert category
         foreach ($catTextArr as $key => $val) {
            if(!Category::where('name_compare',$val)->exists()){
            //save en
            $cate = new Category;
            $cate->name = $tr->setSource($transFrom)->setTarget('en')->translate($val);
            $cate->name_compare = $val;
            $cate->locale = 'en';
            $cate->save();
            $id = $cate->id;
            //save other
            foreach ($extraLang as $key => $v) {
                $cate = new Category;
                $cate->id = $id;
                $cate->name = $tr->setSource($transFrom)->setTarget($v->code)->translate($val);
                $cate->name_compare = $val;
                $cate->locale = $v->code;
                $cate->save();
            }           
           }                      
         }                 
        
        //insert City
         foreach ($catTextArr as $key => $val) {
            if(!City::where('name_compare',$val)->exists()){
             //save en
            $ci = new City;
            $ci->name = $tr->setSource($transFrom)->setTarget('en')->translate($val);
            $ci->name_compare = $val;
            $ci->country_id = 1;
            $ci->locale = 'en';
            $ci->save();
            $id = $ci->id;
            //save other
            foreach ($extraLang as $key => $v) {
                $ci = new City;
                $ci->id = $id;
                $ci->name = $tr->setSource($transFrom)->setTarget($v->code)->translate($val);
                $ci->name_compare = $val;
                $ci->country_id = 1;
                $ci->locale = $v->code;
                $ci->save();
            }                       
           }                      
         }     
    }
}
