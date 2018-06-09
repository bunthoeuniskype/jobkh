<?php

namespace App\Console\load;

use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\TranslateClient;
// use Google\Cloud\Translate\TranslateClient;
use App\Category;
use App\Content;
use App\City;
use App\Option;
use Illuminate\Support\Str;

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
        $this->site_url = Option::getVal('hr_url')->value;
        $this->trans_url = Option::getVal('trans_url')->value;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       
        $html = new \Htmldom($this->site_url);  

        $catTextArr = array();
        $catLinkArr = array();    
        $locationTextArr = array();
        
        $transFrom = 'zh-CN';
        $extraLang = array(
                array('code'=>'km','name'=>'Khmer'),
                array('code'=>'en','name'=>'English'),
                //array('code'=>'zh-CN','name'=>'Chinese'),
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

        $tr = new TranslateClient();
        $tr->setUrlBase($this->trans_url); // Set Google Translate URL base (This 
          //insert City
         foreach ($locationTextArr as $key => $val) {
            if(!City::where('name_compare',$val)->exists()){
             //save en
            $ci = new City;
            $ci->name = $val;
            $ci->name_compare = $val;
            $ci->country_id = 1;
            $ci->locale = 'zh-CN';
            $ci->save();
            $id = $ci->id;
            //save other
            foreach ($extraLang as $key => $v) {
                $ci = new City;
                $ci->id = $id;
                $ci->name = $tr->setSource($transFrom)->setTarget($v['code'])->translate($val);
                $ci->name_compare = $val;
                $ci->country_id = 1;
                $ci->locale = $v['code'];
                $ci->save();
            }                       
           }                      
         }        
         echo 'finish city'."\n";
         
         foreach ($catTextArr as $key => $val) {
            if(!Category::where('name_compare',$val)->exists()){
            //save en
            $cate = new Category;
            $cate->name = $val;
            $cate->name_compare = $val;
            $cate->locale = 'zh-CN';
            $cate->save();
            $id = $cate->id;
            //save other
            foreach ($extraLang as $key => $v) {
                $cate = new Category;
                $cate->id = $id;
                $cate->name = $tr->setSource($transFrom)->setTarget($v['code'])->translate($val);
                $cate->name_compare = $val;
                $cate->locale = $v['code'];
                $cate->save();
             }           
            }     
          }        
         echo 'finish category'."\n";
         
         $i = 0;
        //insert category
         foreach ($catTextArr as $key => $val) {
            if(!Category::where('name_compare',$val)->exists()){
            //save en
            $cate = new Category;
            $cate->name = $val;
            $cate->name_compare = $val;
            $cate->locale = 'zh-CN';
            $cate->save();
            $id = $cate->id;
            //save other
            foreach ($extraLang as $key => $v) {
                $cate = new Category;
                $cate->id = $id;
                $cate->name = $tr->setSource($transFrom)->setTarget($v['code'])->translate($val);
                $cate->name_compare = $val;
                $cate->locale = $v['code'];
                $cate->save();
            }           
           }     
           
           $catData = Category::where('name_compare',$val)->first();
           $category_id = $catData->id;

           $listUrl = $this->site_url.$catLinkArr[$key];
           $listContent = new \Htmldom($listUrl);  
           foreach ($listContent->find('table[class="main-job-list-tab"] tbody tr td div[class="jobtitlelist"] a') as $key => $value) {

                $contentDetail = new \Htmldom($this->site_url.'/pages/jobs/'.$value->href);

                $title_original = $value->text();               
                $hrId = trim(str_replace('job.jsp?jobId=', '',$value->href));
                $title = '';
                $description = '';
                $job_requirement = '';
                $experience = '';
                $level = '';
                $hiring = '';
                $salary = '';
                $sex = '';
                $age = '';
                $term = '';
                $function = '';
                $industry = '';
                $qualification = '';
                $language = '';
                $location = '';
                $publish_date = '';
                $close_date = '';
                $company = '';
                $contact = '';
                $phone = '';
                $email = '';
                $website = '';
                $address = '';
                $type = '';
                $employee = '';
                $company_profile = '';
                $city_id = 0;

                if(!Content::where('hr_id',$hrId)->exists()){                    

                foreach ($contentDetail->find('div[class="container"] div[class="main-job main-job-line"]') as $val) {
                    
                    if(!empty($val->find('h2[class="main-job-w-title"]',0))){
                        $title = $val->find('h2[class="main-job-w-title"]',0)->text();
                        $title = trim($title);
                        if(strlen(strip_tags($title))>255){
                           $title  = $title_original;
                        }
                    }
                     if(!empty($val->find('table[class="about-company"] tbody tr td',0))){
                            $company = $val->find('table[class="about-company"] tbody tr td',0)->text();
                            $company = trim($company);
                     }
                     if(!empty($val->find('table[class="about-company"] tbody tr td',2))){
                            $type = $val->find('table[class="about-company"] tbody tr td',2)->text();
                            $type = trim($type);
                     }                  
                    if(!empty($val->find('table[class="about-company"] tbody tr td',4))){
                            $employee = $val->find('table[class="about-company"] tbody tr td',4)->text();
                            $employee = trim($employee);
                     }
                     if(!empty($val->find('table[class="about-company"] tbody tr td',5))){
                            $location = $val->find('table[class="about-company"] tbody tr td',5)->text();
                            $location1 = trim($location);
                            if(strlen(strip_tags($location1))>255){
                                 $location1  = '';
                            }
                     }

                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',0))){
                            $level = $val->find('table[class="spec-tbl"] tbody tr td',0)->text();
                            $level = trim($level);
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',1))){
                            $term = $val->find('table[class="spec-tbl"] tbody tr td',1)->text();
                            $term = trim($term);
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',2))){
                            $experience = $val->find('table[class="spec-tbl"] tbody tr td',2)->text();
                            $experience = trim($experience);
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',3))){
                            $function = $val->find('table[class="spec-tbl"] tbody tr td',3)->text();
                            $function = trim($function);
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',4))){
                            $hiring = $val->find('table[class="spec-tbl"] tbody tr td',4)->text();
                            $hiring = trim($hiring);
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',5))){
                            $industry = $val->find('table[class="spec-tbl"] tbody tr td',5)->text();
                            $industry = trim($industry);
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',6))){
                            $salary = $val->find('table[class="spec-tbl"] tbody tr td',6)->text();
                            $salary = trim($salary);
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',7))){
                            $qualification = $val->find('table[class="spec-tbl"] tbody tr td',7)->text();
                            $qualification = trim($qualification);
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',8))){
                            $sex = $val->find('table[class="spec-tbl"] tbody tr td',8)->text();
                            $sex = trim($sex);
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',9))){
                            $language = $val->find('table[class="spec-tbl"] tbody tr td',9)->text();
                            $language = trim($language);
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',10))){
                            $age = $val->find('table[class="spec-tbl"] tbody tr td',10)->text();
                            $age = trim($age);
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',11))){
                            $location = $val->find('table[class="spec-tbl"] tbody tr td',11)->text();
                            $location = trim($location);
                            if(strlen(strip_tags($location))>255){
                                 $location  = $location1;
                            }
                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',12))){
                            $publish_date = $val->find('table[class="spec-tbl"] tbody tr td',12)->text();
                            $dArr = explode('-', trim($publish_date));
                            $publish_date = date('Y-m-d',strtotime($dArr[2].'-'.$dArr[0].'-'.$dArr[1]));


                     }
                     if(!empty($val->find('table[class="spec-tbl"] tbody tr td',13))){
                            $close_date = $val->find('table[class="spec-tbl"] tbody tr td',13)->text();
                            $dArr = explode('-', trim($close_date));
                            $close_date = date('Y-m-d',strtotime($dArr[2].'-'.$dArr[0].'-'.$dArr[1]));                          
                     }
                   
                    if(!empty($val->find('table[class="main-job-w main-job-tab"] td',0))){
                        $description = $val->find('table[class="main-job-w main-job-tab"] td"]',0)->text();
                        $description = trim($description);
                    }
                    if(!empty($val->find('table[class="main-job-w main-job-tab"] td',1))){
                        $job_requirement = $val->find('table[class="main-job-w main-job-tab"] td"]',1)->text();
                        $job_requirement = trim($job_requirement);
                    }
                    if(!empty($val->find('table[class="main-job-w main-job-tab"] tbody tr td',3))){
                        $contact = $val->find('table[class="main-job-w main-job-tab"] tbody tr td"]',3)->text();
                        $contact = trim(str_replace('联系人', '', $contact));
                    }
                   
                    if(!empty($val->find('table[class="main-job-w main-job-tab"] tbody tr td',4))){
                        $phone = $val->find('table[class="main-job-w main-job-tab"] tbody tr td"]',4)->text();
                        $phone = trim(str_replace('联系电话', '', $phone));
                    }

                    if(!empty($val->find('table[class="main-job-w main-job-tab"]  tbody tr td',5))){
                        $email = $val->find('table[class="main-job-w main-job-tab"]  tbody tr td"]',5)->text();
                        $email = trim(str_replace('邮箱', '', $email));
                    }
                    if(!empty($val->find('table[class="main-job-w main-job-tab"]  tbody tr td',6))){
                        $website = $val->find('table[class="main-job-w main-job-tab"]  tbody tr td"]',6)->text();
                        $website = trim(str_replace('网站', '', $website));
                    }
                     if(!empty($val->find('table[class="main-job-w main-job-tab"] tbody tr td',7))){
                        $address = $val->find('table[class="main-job-w main-job-tab"] tbody tr td"]',7)->text();
                        $address = trim(str_replace('地址', '', $address));
                    }
                                        
                    foreach ($contentDetail->find('div[class="container"] div[class="company-box main-job main-job-line"]') as $valC) {
                             if(!empty($valC->find('div[class="profile"]',0))){
                                $company_profile = $valC->find('div[class="profile"]',0)->text();
                                $company_profile = trim($company_profile);
                              }
                         }

                      if($location !== ''){
                        $city = City::where('name_compare',str_replace(';', '', $location1))->first();
                        if(count($city)>0){
                            $city_id = $city->id;
                        }else{
                             //save en
                            $ci = new City;
                            $ci->name = $location1;
                            $ci->name_compare = $location1;
                            $ci->country_id = 1;
                            $ci->locale = 'zh-CN';
                            $ci->save();
                            $id = $ci->id;
                            //save other
                            foreach ($extraLang as $key => $v) {
                                $ci = new City;
                                $ci->id = $id;
                                $ci->name = $tr->setSource($transFrom)->setTarget($v['code'])->translate($location);
                                $ci->name_compare = $location1;
                                $ci->country_id = 1;
                                $ci->locale = $v['code'];
                                $ci->save();
                            }               
                           $city_id = $id;     
                        }
                    }                    
                       
                  
                    $cont = new Content;
                    $cont->title = $title;
                    $cont->title_compare = $title;
                    $cont->description = $description;                    
                    $cont->locale = 'zh-CN';
                    $cont->city_id = $city_id;
                    $cont->category_id = $category_id;
                    $cont->job_requirement = $job_requirement;
                    $cont->experience = $experience;
                    $cont->level =  $level;
                    $cont->hiring = $hiring;
                    $cont->salary = $salary;
                    $cont->sex = $sex;
                    $cont->age = $age;
                    $cont->term = $term;
                    $cont->function = $function;
                    $cont->industry = $industry;
                    $cont->qualification = $qualification;
                    $cont->language = $language;
                    $cont->location = $location;
                    $cont->publish_date = $publish_date;
                    $cont->close_date = $close_date;
                    $cont->company = $company;
                    $cont->contact = $contact;
                    $cont->phone = $phone;
                    $cont->email = $email;
                    $cont->website = $website;
                    $cont->address = $address;
                    $cont->type = $type;
                    $cont->employee = $employee;
                    $cont->company_profile = $company_profile;
                    $cont->hr_id = $hrId;
                    $cont->save();
                    $id = $cont->id;
                    foreach ($extraLang as $key => $v) {
                        $cont = new Content;
                        $cont->id = $id;
                        $cont->title = $title;//?$tr->setSource($transFrom)->setTarget($v['code'])->translate($title):'';
                        $cont->title_compare = $title;
                        $cont->description = $description;                    
                        $cont->locale = 'zh-CN';
                        $cont->city_id = $city_id;
                        $cont->category_id = $category_id;
                        $cont->job_requirement = $job_requirement;
                        $cont->experience = $experience;
                        $cont->level =  $level;//?$tr->setSource($transFrom)->setTarget($v['code'])->translate($level):'';
                        $cont->hiring = $hiring;
                        $cont->salary = $salary;//?$tr->setSource($transFrom)->setTarget($v['code'])->translate($salary):'';
                        $cont->sex = $sex;//?$tr->setSource($transFrom)->setTarget($v['code'])->translate($sex):'';
                        $cont->age = $age;
                        $cont->term = $term;//?$tr->setSource($transFrom)->setTarget($v['code'])->translate($term):'';
                        $cont->function = $function;//?$tr->setSource($transFrom)->setTarget($v['code'])->translate($function):'';
                        $cont->industry = $industry;//?$tr->setSource($transFrom)->setTarget($v['code'])->translate($industry):'';
                        $cont->qualification = $qualification;//?$tr->setSource($transFrom)->setTarget('en')->translate($qualification):'';
                        $cont->language = $language;//?$tr->setSource($transFrom)->setTarget($v['code'])->translate($language):'';
                        $cont->location = $location;//?$tr->setSource($transFrom)->setTarget($v['code'])->translate($location):'';
                        $cont->publish_date = $publish_date;
                        $cont->close_date = $close_date;
                        $cont->company = $company;
                        $cont->contact = $contact;
                        $cont->phone = $phone;
                        $cont->email = $email;
                        $cont->website = $website;
                        $cont->address = $address;
                        $cont->type = $type;//?$tr->setSource($transFrom)->setTarget($v['code'])->translate($type):'';
                        $cont->employee = $employee;
                        $cont->company_profile = $company_profile;
                        $cont->hr_id = $hrId;
                        $cont->save();
                    }  
                  }
               } //check content not exists
                
                $i++;
                echo $i."\n";
           }
        }                 
         echo $i;
        
    }

     public function CTrim($input)
    {
        
        if ($input) {
            array_walk_recursive($input, function (&$item) {
                $item = trim($item);
                $item = ($item == "") ? null : $item;
            });
           return $input;          
        }

        return '';
    }
}
