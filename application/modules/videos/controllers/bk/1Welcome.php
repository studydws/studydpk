<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Modulecontroller {

    public function __construct() {
        parent:: __construct();
        $this->load->model('Videos_model');
        $this->load->model('Studymaterial_model');
        $this->load->model('Pricelist_model');
        $purchases = $this->session->userdata('purchases');
        if (count($purchases) > 0) {
            if (array_key_exists(2, $purchases)) {
                $this->data['videopurchased'] = $purchases[2];
            }
        }
        $this->load->helper('text');
    }

    public function index($examname = null, $exam_id = 0, $subjectname = null, $subject_id = 0, $chapter_name = null, $chapter_id = 0) {
       
        $scripts = array(base_url() . 'assets/frontend/js/jquery.shorten.min.js', base_url() . 'assets/frontend/js/slider.js');
        $this->data['scripts'] = $scripts;
        $examdata = array();
        if ($examname == null) {
            $title = getTitle('Online Videos', $this->data['examcategories']);

            $titleStr[] = $title;
        } else {
            $titleStr[] = 'Online Videos for';
        }
        if ($exam_id > 0) {
            $exam = $this->Categories_model->getCategoryDetails($exam_id);
            $this->data['selectedexam'] = $exam;
            $titleStr[] = addSuffix($exam->name, 'Class');
        }
        if ($subject_id > 0) {
         $this->load->model('Subjects_model');
         $this->data['selectedsubject'] = $this->Subjects_model->getSubject($subject_id);
            $titleStr[] = $this->data['selectedsubject']->name;
        }
        if ($chapter_id > 0) {
            $this->load->model('Chapters_model');
            $this->data['selectedchapter'] = $this->Chapters_model->getChapter($chapter_id);
            $titleStr[] = $this->data['selectedchapter']->name;
        }
        if ($exam_id) {
            $data_array = array();
            $chaptersubjects = $this->Examcategory_model->getExamChapters($exam_id);
            $subjects_array = array();
            $chapters_array = array();

            if (count($chaptersubjects) > 0) {
                foreach ($chaptersubjects as $record) {

                    if (!in_array($record->sname, $subjects_array)) {
                        $subjects_array[$record->sid] = array('name' => $record->sname);
                    }
                    if ($subject_id > 0 && $subject_id == $record->sid) {
                        $videos = $this->Videos_model->getVideosCount($exam_id, $record->sid, $record->cid);
                        if (!in_array($record->cname, $chapters_array)) {

                            $chapters_array[$record->cid] = array('name' => $record->cname, 'count' => count($videos));
                        } else {
                            $chapters_array[$record->cid]['count'] = count($videos);
                        }
                    }

                    if (array_key_exists($record->sname, $data_array)) {
                        //$data_array[$record->name][]
                        array_push($data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                    } else {
                        $data_array[$record->sname]['id'] = $record->sid;
                        if (isset($data_array[$record->sname]['chapters'])) {
                            array_push($data_array[$record->sname]['chapters'], array($record->cid, $record->cname));
                        } else {
                            $data_array[$record->sname]['chapters'][0] = array($record->cid, $record->cname);
                        }
                    }
                }
            }

            $this->data['subject_chapters'] = $data_array;
            if (count($subjects_array) > 0) {
                foreach ($subjects_array as $key => $value) {
                    $videos = $this->Videos_model->getVideosCount($exam_id, $key, 0);
                    $subjects_array[$key]['count'] = count($videos);
                }
            }
            $this->data['subjects_array'] = $subjects_array;

            $this->data['chapters_array'] = $chapters_array;
        }
        $playlist = $this->Videos_model->getVideos($exam_id, $subject_id, $chapter_id);
        $videos = $this->Videos_model->getVideosCount($exam_id, $subject_id, $chapter_id);
        $videos_inform = $this->Videos_model->getVideosduration($exam_id, $subject_id, $chapter_id);
        $isProduct = $this->Pricelist_model->getProduct($exam_id, $subject_id, $chapter_id, 2);
        $product_id=0;
        if($isProduct){
        $product_id=$isProduct->id;
        $user_id=$customer_id=$this->session->userdata('customer_id');
        $orderInfo=$this->Pricelist_model->getOrderInfo($product_id, $user_id);        
        $this->data['orderInfo'] = $orderInfo;
        }
        $productslist = $this->Pricelist_model->getAllProducts($exam_id, $subject_id, $chapter_id, 2,0,$product_id);
		
		
        $mainPrdlist = $this->Pricelist_model->getAllProducts($exam_id,'','', 2,0,'');
		
        $freeVideos=$this->Videos_model->getAllFreeVideos($exam_id, $subject_id, $chapter_id,10);
        $this->data['isProduct'] = $isProduct;
        $this->data['productslist'] = $productslist;
		$this->data['mainPrdlist'] = $mainPrdlist;
		$this->data['title'] = implode(' ', $titleStr);
        $this->data['h1title'] = implode(' ', $titleStr);
        $this->data['videos_inform'] =$videos_inform ;
        $this->data['videos'] = $videos;
        $this->data['freevideos']=$freeVideos;
        $this->data['playlist'] = $playlist;
        $this->data['exam_id'] = $exam_id;
        $this->data['subject_id'] = $subject_id;
        $this->data['chapter_id'] = $chapter_id;
        $this->data['examdata'] = $examdata;
        $this->data['content'] = 'welcome';

        $data = $this->Videos_model->getVideoList($exam_id, $subject_id);

        $solutions_array = array();
        foreach ($data as $result) {

            if (!array_key_exists($result->exam_id, $solutions_array)) {
                $solutions_array[$result->exam_id] = array('name' => $result->exam, 'subjects' => array());
            }
            if (!array_key_exists($result->subject_id, $solutions_array[$result->exam_id]['subjects'])) {
                $solutions_array[$result->exam_id]['subjects'][$result->subject_id] = array('id' => $result->subject_id, 'name' => $result->subject);
            }
        }
        $this->data['solutions_array'] = $solutions_array;

        $this->load->view('template', $this->data);
    }

    public function playlist($name, $playlistid) {
        $url_segments = $this->uri->segment_array();
        array_pop($url_segments);
        if(count($url_segments)==4){
            $url_segments[]='all';
        }
        if(count($url_segments)==3){
            $url_segments[]='all';$url_segments[]='all';
        }
        if($url_segments[5]!=''){
          $chaptername =  $url_segments[5];
          
         $var_relationid_array = explode('relationid-',$chaptername);
         $var_relationid='';
        if(isset($var_relationid_array[1])){
         $var_relationid=$var_relationid_array[1];
        }
        }
        $this->data['url_segments'] = $url_segments;
        //update View Count
        $this->Pricelist_model->update_viewcount($playlistid,'cmsvideoslist');
        $scripts = array(base_url() . 'assets/frontend/js/jquery.sliderPro.min.js', base_url() . 'assets/frontend/js/slider.js');
        $this->data['scripts'] = $scripts;
        $styles = array(base_url() . 'assets/frontend/css/slider-pro.min.css', base_url() . 'assets/frontend/css/examples.css');
        $this->data['styles'] = $styles;
        $videolist = $this->Videos_model->getVideosList($playlistid);
        if($var_relationid>0){
        $playlist = $this->Videos_model->playlistdetails_byrelationid($playlistid,$var_relationid);
        }else{
        $playlist = $this->Videos_model->playlistdetails($playlistid);
        }
        $playlist1=array();
        //foreach($playlist as $pl){
        if(isset($playlist->id)){
            $playlist1[]=$playlist->id;
        }
        //}//
        $freeVideos=$this->Videos_model->getFreeVideos($playlist1);
        $videos=array();
        foreach($freeVideos as $video){
           
            $relation=$this->Videos_model->getRelations($video->id);
            $relation=$relation[0];
            
            $videos[]=array('id'=>$video->id,'title'=>$video->title,'source'=>$video->video_url_code,'exam'=>$relation->exam,'subject'=>$relation->subject,'chapter'=>$relation->chapter,'playlist'=>$relation->name);
        }
        $this->data['freevideos']=$videos;
        $price = $this->Pricelist_model->getcontentprice($playlist, 4, $playlistid);
        $this->data['productslist'] = array($price);
        $this->data['relation'] = $playlist;
        $playlist_name='';
        if(isset($playlist->name)){
            $playlist_name=$playlist->name;
        }
        $title = generateTitle('Online Videos for', $playlist, $playlist_name);
        $this->data['title'] = $title;
        $this->data['videolist'] = $videolist;

        $this->data['content'] = 'list';
        $this->load->view('template', $this->data);
    }

    public function play($name, $id) {
        if (!$this->session->userdata('customer_id')) {
            redirect('/login');
        }
        $url_segments = $this->uri->segment_array();
         //update View Count
        $this->Pricelist_model->update_viewcount($id,'cmsvideos');
        array_pop($url_segments);
        array_pop($url_segments);
        if(count($url_segments)==4){
            $url_segments[]='all';
        }
        if(count($url_segments)==3){
            $url_segments[]='all';$url_segments[]='all';
        }
        $var_relationid=0;
         if(isset($url_segments[5])&&$url_segments[5]!=''){
          $chaptername =  $url_segments[5];
          
         $var_relationid_array = explode('relationid-',$chaptername);
        if(isset($var_relationid_array[1])){
        $var_relationid=$var_relationid_array[1]; 
        
        }else{
            $var_relationid=0;
        }
        }
        $this->data['url_segments'] = $url_segments;
        $purchased = false;
        $pexam_array = array();
        $psubject_array = array();
        $pchapter_array = array();
        if (isset($this->data['videopurchased'])) {
            foreach ($this->data['videopurchased'] as $key => $value) {
                $pricedetails = $this->Pricelist_model->getDetails($value);
                if ($pricedetails->exam_id != 0 && $pricedetails->subject_id == 0 && $pricedetails->chapter_id == 0) {
                    $pexam_array[] = $pricedetails->exam_id;
                }
                if($pricedetails->exam_id != 0 && $pricedetails->subject_id != 0 && $pricedetails->chapter_id == 0) {
                    $psubject_array[] = $pricedetails->subject_id;
                }
                if ($pricedetails->exam_id != 0 && $pricedetails->subject_id != 0 && $pricedetails->chapter_id != 0) {
                    $pchapter_array[] = $pricedetails->chapter_id;
                }
            }
        }

        $scripts = array(base_url() . 'assets/frontend/js/jwplayer/jwplayer.js');
        $this->data['scripts'] = $scripts;
        $videodetails = $this->Videos_model->getVideoDetails($id);        
        $rela = $this->Videos_model->getVideoParent($id);
        $mproducts=array();
        foreach ($rela as $k => $v) {
            
            $mproducts[]=$this->Pricelist_model->getProduct($v->exam_id,$v->subject_id,$v->chapter_id,2);
            
            $mproducts[]=$this->Pricelist_model->getProduct($v->exam_id,$v->subject_id,0,2);
            
            $mproducts[]=$this->Pricelist_model->getProduct($v->exam_id,0,0,2);
            
            if (count($pexam_array > 0) && in_array($v->exam_id, $pexam_array)) {
                $purchased = true;
            } elseif (count($psubject_array > 0) && in_array($v->subject_id, $psubject_array)) {
                $purchased = true;
            } elseif (count($pchapter_array > 0) && in_array($v->chapter_id, $pchapter_array)) {
                $purchased = true;
            }            
        }
        
        $this->data['mproducts']=$mproducts;       
        
        if($this->session->userdata('customer_id')=='1' || $this->session->userdata('customer_id')=='13'){
		$purchased=true;
	}
        $this->data['purchased'] = $purchased;
        $relatedvideos = $this->Videos_model->getRelatedVideos($id);
        $relatedPlayList = $this->Videos_model->getRelatedPlayLists($id);
        
        $playlist=array();
        $products=array();
        $playlisttitle='';
        foreach($relatedPlayList as $pl){
            $playlistdetail = $this->Videos_model->playlistdetails($pl->videolist_id);
            $playlisttitle=$playlistdetail->name;
            $playlist[]=$pl->videolist_id;
            $price=$this->Pricelist_model->getModuleItemPrice($pl->videolist_id,2);
            if($price){
                $products[]=$this->Pricelist_model->getModuleItemPrice($pl->videolist_id,2);
            }else{
                
            }
        }
        $this->data['pltitle']=$playlisttitle;
        $freeVideos=$this->Videos_model->getFreeVideos($playlist);
        $videos=array();
        $relation=null;
        foreach($freeVideos as $video){
           
            $relation=$this->Videos_model->getRelations($video->id);
            $relation=$relation[0];
           
            $videos[]=array('id'=>$video->id,'title'=>$video->title,'source'=>$video->video_url_code,'exam'=>$relation->exam,'subject'=>$relation->subject,'chapter'=>$relation->chapter,'playlist'=>$relation->name);
        }
        $this->data['freevideos']=$videos;
        $this->data['videolist'] = $relatedvideos;
        $is_amazonvideo = false;
        $is_youtubevideo = false;
        $preview_image = '';
        if ($videodetails->amazon_cloudfront_domain != '' && $videodetails->amazonaws_link != '') {
            $is_amazonvideo = true;
            $resourceKey = getResourceKey($videodetails->amazonaws_link, 10);
            $this->data['resourceKey'] = $resourceKey;
            $this->data['signedURL'] = getSignedURL($resourceKey, 3);
            $this->data['streamHostUrl'] = $videodetails->amazon_cloudfront_domain;
            $this->data['preview_image'] = show_thumb($videodetails->video_image, 455, 850);
			
			$this->data['androidapp_link']=$videodetails->androidapp_link;
if($videodetails->androidapp_link!=''){
	
			$is_androidvideo = true;
}else{
	
			$is_androidvideo = false;
}       
	   }elseif($videodetails->androidapp_link!=''){
			$is_amazonvideo = true;
			
			$is_androidvideo = true;
			
			$this->data['androidapp_link']=$videodetails->androidapp_link;
			
			//https://www.studyadda.com/upload_files/11th-physics-i/Mathematical+Tools/1+Mathematical+Tools.mp4
		}
		$this->data['is_androidvideo']=$is_androidvideo;
        if ($videodetails->video_source == 'youtube' && $videodetails->video_url_code != '') {
            $is_youtubevideo = true;
        }
        if($var_relationid>0){
        $playlist = $this->Videos_model->playlistdetails_byrelationid($relatedPlayList[0]->videolist_id,$var_relationid);
        }else{
        $playlist = $this->Videos_model->playlistdetails($relatedPlayList[0]->videolist_id);
            
        }
         $exam_id=NULL;$subject_id=NULL;$chapter_id=NULL;
         if(isset($playlist->exam_id)&&$playlist->exam_id>0){
           $exam_id=$playlist->exam_id;
         }
         
         if(isset($playlist->subject_id)&&$playlist->subject_id>0){
           $subject_id=$playlist->subject_id;  
         }
         
         if(isset($playlist->chapter_id)&&$playlist->chapter_id>0){
             $chapter_id=$playlist->chapter_id;
         }
        //$productslist = $this->Studymaterial_model->getFilesProducts($exam_id, $subject_id, $chapter_id,100);
        //$this->data['productslist']=$productslist;
        if(count($playlist)>0){
            $this->data['relation']=$playlist;
        }else{
            $this->data['relation']=$relation;
        }    
        $this->data['video'] = $videodetails;
        //$this->data['relation']=$relation;
        $this->data['title']=$videodetails->title.' Online Videos';
        $this->data['is_amazonvideo'] = $is_amazonvideo;
        $this->data['is_youtubevideo'] = $is_youtubevideo;
        $this->data['content'] = 'play';
        $this->load->view('template', $this->data);
    }
    public function freevideos($exam=null,$exam_id=0){
        //28,29,22,23,24,30
        //$exams_array=array(28,29,22,23,24,30); 
           $this->load->model('Freevideo_model');           
            $videolist=$this->Freevideo_model->getVideolist();
            $featuredvideolist=$videolist->video_id;
            $featuredvideolist_array = explode(',',$featuredvideolist);
        $exams_array=$featuredvideolist_array;        
        
        if ($exam_id > 0) {
            $exam = $this->Categories_model->getCategoryDetails($exam_id);
            $this->data['exam'] = $exam;
            $videolist = $this->Videos_model->getExamFreeVideos($exam_id);
            $videos_array = array();
            foreach ($videolist as $videos) {
                if (array_key_exists('subject', $videos) && $videos->subject != '') {
                    if (array_key_exists($videos->subject, $videos_array)) {
                        $videos_array[$videos->subject][] = $videos;
                    } else {
                        $videos_array[$videos->subject][] = $videos;
                    }
                } else {
                    $videos_array['default'][] = $videos;
                }
            }
            $this->data['videolist'] = $videolist;
            $this->data['videolistfiltered']=$videos_array;
        } else {
            $this->data['mainexams']=$exams_array;
            $videos_array=array();
            foreach($exams_array as $key => $value){ 
                $videoslist=$this->Videos_model->getExamFreeVideos($value,12);
               
                $videos_array[$value]=$videoslist;
            }
            if(count($exams_array)>1){
                    
               
            $this->data['mainexams_videos']=$videos_array;
                }else{
             
            $this->data['mainexams_videos']=NULL;
                } 
        }
        if($exam_id > 0){
            $this->data['title']='Free Video Lectures for '.$exam->name;
            $this->data['h1title']='Free Video Lectures for '.$exam->name;
        }else{
            $this->data['title']='Free Video Lectures IIT, JEE Main and Advanced, NEET, 12th Class, 11th Class, 10th Class & 9th Class';
            $this->data['h1title']='Free Video Lectures';
        }
        
        
        $this->data['content'] = 'freevideos';
        $this->load->view('template', $this->data);
        
    }
    public function featured(){
        $this->load->model('Videos_model');
        /*   $this->load->model('Fvideo_model');           
            $videolist=$this->Fvideo_model->getVideolist();
            $featuredvideolist=$videolist->video_id;
            $featuredvideolist_array = explode(',',$featuredvideolist);
            //$videoarray=array(2161,1256,1706,1235,1990,2091,3397,3398,3399,3400,3401);
        $videoarray=$featuredvideolist_array;
        $videos=array();
       
        foreach ($videoarray as $k=>$v){
        $videos[]=$this->Videos_model->getfeaturedVideoDetails($v);
        }*/
        $videos=$this->Videos_model->getfeaturedVideoDetails();
        $this->data['videos']=$videos;
        $this->data['title']='Featured Videos - Free Video Lectures IIT, JEE Main and Advanced, NEET, 12th Class, 11th Class, 10th Class & 9th Class';
        $this->data['h1title']='Our Featured Video Lectures';
        $this->data['content'] = 'featuredvideos';
        $this->load->view('template', $this->data);
    }
    
    public function showbought_videos($examname = null, $exam_id = 0, $subjectname = null, $subject_id = 0, $chapter_name = null, $chapter_id = 0){
$this->load->helper('text'); 
        $productslist_html='';
        //$productslist = $this->Videos_model->getVideos($exam_id, $subject_id, $chapter_id);
        $productslist = $this->Videos_model->getVideosduration($exam_id, $subject_id, $chapter_id);
        $productslist_count=count($productslist);
        $this->data['downloadHistory']=NULL;
        $productslist_html .='<div class="col-xs-12 col-md-12 download_list_exam">';
         if($productslist_count>0){
        $productslist_html.='<div class="col-md-12 text-center bavl"><h3 class="bg-info">Watch Videos';
        if($subjectname!=''){
            $productslist_html.=' for ';
            if($examname!=''){
                //$productslist_html.=$examname.' ';
            }
           $chapter_name_title=str_replace("-"," ",$chapter_name);
            $productslist_html.=$chapter_name_title;
        }
        $productslist_html .='</h3></div>';
        $productslist_html.= '<div class="row">';
        $count = 1;
        $videobase=base_url('videos');
      
            foreach ($productslist as $product) {
                $product_relationid=$product->videolist_id;
                
                $st_productname=character_limiter($product->title ? $product->title : $product->video_file_name, 40); 
                           
                           if($st_productname==''){
                               $st_productname='Video';
                           }
                
               $playlist_videourl=$videobase.'/'. url_title($examname, '-', true).'/'. url_title($subjectname, '-', true).'/'. url_title($chapter_name, '-', true).'/'. url_title($chapter_name, '-', true).'-relationid-'.$product_relationid.'/'. url_title($st_productname, '-', true).'/'.$product->video_id;   
           
            $productslist_html .='<a href="'.$playlist_videourl.'" target="blank">';
            $productslist_html .='<div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="col-item offer offer-success style="height:100px;">
                       <div class="shape">
					<div class="shape-text">
					<span class="glyphicon glyphicon  glyphicon-facetime-video"></span>		
					</div>
				</div>
                                <div>';
                           $productslist_html .='<div class="offer-content">' ;                 $productslist_html .='<h6 class="vid_prod_hed" title="'.url_title($st_productname).'">'.$st_productname.'</h6>';  
                          $productslist_html .='<div class="photo">';
                           
                           if($product->video_source=='youtube'){ 
                               
                          $productslist_html .='<img style="width:100%;" src="https://i.ytimg.com/vi/'.$product->video_url_code.'/mqdefault.jpg" class="img-responsive lazy"/>';  
                               ?> 
                            <?php }else{ 
                                
                          $productslist_html .='<img style="width:100%;" src="'.show_thumb($product->video_image,250,250).'" class="img-responsive lazy"/>';  
                                ?>
                            <?php }
                                      
                           $productslist_html .='</div>';
                                            
                                    $productslist_html .='</div></div>';
                           $productslist_html.='<div class="separator btn_prod_ved">';
                             
                           $productslist_html .='<div class="separator btn_prod_ved">
                                        <p class="buy_btn">'; 
                          $productslist_html .='<button class="btn-md btn-xs btn btn-raised btn-success" name="btnAlreadyExist">Watch Now</button>
                                             ';
                           $productslist_html.='</p>
                                    </div>';
                           //$productslist_html.='<div class="clearfix"> </div>';
                           $productslist_html.='</div>';
                           $productslist_html.='</div></div>';
                $productslist_html .='</a>';
          
           $count++;
                           }
                        
        
                 $productslist_html .='</div>';
         }else{
             $productslist_html.='<div class="col-md-12 text-center bavl" id="no_download_info"><h2>No Video available.We are updating contanet.</h2></div>';
         }
                 
                $productslist_html .='</div>';
                
        $chapters_array=array();        
        $chapters_array[]=array('productslist_html'=>$productslist_html,'productslist_count'=>count($productslist));
        
        echo json_encode($chapters_array);
    }
    

}