<?php
	include('config.php');
	
			$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$class_id = $_POST['class_id'];
	$subject_id = $_POST['subject_id'];
	$chapter_id = $_POST['chapter_id'];
	
  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	  while($ryu = mysqli_fetch_array($oppf)){
	$get_api = $ryu['user_key'];
	  }
  }
  
  
	$tmp = array();
	$subTmp = array();
	$postStatusString = "publish";
if($get_api){
    if($class_id && $subject_id && $chapter_id)
    {
		$qry = "SELECT V.id, title, V.video_source, V.video_url_code, V.video_file_name, V.video_image, V.short_video, V.is_featured, V.description, V.video_by, V.status, V.views, V.is_free, V.video_duration, V.custom_video_duration, V.androidapp_link, V.amazonaws_link, V.amazon_cloudfront_domain, L.name as playlist, C.name as exam, S.name as subject, CH.name as chapter FROM cmsvideos V JOIN cmsvideolist_details VD ON V.id=VD.video_id JOIN cmsvideolist_relations R ON R.videolist_id=VD.videolist_id JOIN categories C ON C.id=R.exam_id LEFT JOIN cmssubjects S ON R.subject_id=S.id LEFT JOIN cmschapters CH ON R.chapter_id=CH.id JOIN cmsvideoslist L ON L.id=VD.videolist_id WHERE V.video_source = 'youtube' AND V.is_featured = 1 AND V.video_tag != 'Career Point' AND V.video_url_code != '' AND R.exam_id = '$class_id' AND R.subject_id = '$subject_id' AND R.chapter_id = '$chapter_id' GROUP BY V.id";
    }
    else if($class_id && $subject_id)
    {
		$qry = "SELECT V.id, title, V.video_source, V.video_url_code, V.video_file_name, V.video_image, V.short_video, V.is_featured, V.description, V.video_by, V.status, V.views, V.is_free, V.video_duration, V.custom_video_duration, V.amazonaws_link, V.amazon_cloudfront_domain, L.name as playlist, L.id as playlist_id, C.name as exam, S.name as subject, CH.name as chapter FROM cmsvideos V JOIN cmsvideolist_details VD ON V.id=VD.video_id JOIN cmsvideolist_relations R ON R.videolist_id=VD.videolist_id JOIN categories C ON C.id=R.exam_id LEFT JOIN cmssubjects S ON R.subject_id=S.id LEFT JOIN cmschapters CH ON R.chapter_id=CH.id JOIN cmsvideoslist L ON L.id=VD.videolist_id WHERE V.video_source = 'youtube' AND V.video_url_code != '' AND V.video_tag !='Career Point' AND V.status='1' AND R.exam_id = '$class_id' AND R.subject_id = '$subject_id' GROUP BY V.id ORDER BY rand()";
	}
    else if($class_id)
    {
         $qry = "SELECT V.id, title, V.video_source, V.video_url_code, V.video_file_name, V.video_image, V.short_video, V.is_featured, V.description, V.video_by, V.status, V.views, V.is_free, V.video_duration, V.custom_video_duration, V.amazonaws_link, V.amazon_cloudfront_domain, L.name as playlist, L.id as playlist_id, C.name as exam, S.name as subject, CH.name as chapter FROM cmsvideos V JOIN cmsvideolist_details VD ON V.id=VD.video_id JOIN cmsvideolist_relations R ON R.videolist_id=VD.videolist_id JOIN categories C ON C.id=R.exam_id LEFT JOIN cmssubjects S ON R.subject_id=S.id LEFT JOIN cmschapters CH ON R.chapter_id=CH.id JOIN cmsvideoslist L ON L.id=VD.videolist_id WHERE V.video_source = 'youtube' AND V.video_url_code != '' AND V.video_tag !='Career Point' AND V.status='1' AND R.exam_id = '$class_id' GROUP BY V.id ORDER BY rand()";
    }
	$result = mysqli_query($conn,$qry);
}
	if($numrs = mysqli_num_rows($result) > 0)
	{
	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
	
    if($subTmp)
    {$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);
	mysqli_close($conn);
	}
	else
	{
	    $tmp['status'] = "false";$tmp['data'] = "No Free Videos Found";
	    echo json_encode($tmp);
	}
	/*else
	{
	     $qry = "SELECT V.id, title, V.video_source, V.video_url_code, V.video_file_name, V.video_image, V.short_video, V.is_featured, V.description, V.video_by, V.status, V.views, V.is_free, V.video_duration, V.custom_video_duration, V.amazonaws_link, V.amazon_cloudfront_domain, L.name as playlist, L.id as playlist_id, C.name as exam, S.name as subject, CH.name as chapter FROM cmsvideos V JOIN cmsvideolist_details VD ON V.id=VD.video_id JOIN cmsvideolist_relations R ON R.videolist_id=VD.videolist_id JOIN categories C ON C.id=R.exam_id LEFT JOIN cmssubjects S ON R.subject_id=S.id LEFT JOIN cmschapters CH ON R.chapter_id=CH.id JOIN cmsvideoslist L ON L.id=VD.videolist_id WHERE V.video_source = 'youtube' AND V.video_url_code != '' AND V.video_tag !='Career Point' AND V.status='1' AND R.exam_id = '28' GROUP BY V.id ORDER BY rand()";
	    $result = mysqli_query($conn,$qry);
	    while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['id'];
		$job = array();
		$job = getmarvelcategory($mar_id,$conn);
		$subTmp[] = $job;
	}
	
if($subTmp){$tmp['status'] = "success";$tmp['data'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['data'] = "Invalid key";}
	echo json_encode($tmp);
	mysqli_close($conn);
	    
	    
	}*/
	function getmarvelcategory($mar_id,$conn) {		
		$returnValue = array();
		
		$result = mysqli_query($conn,"SELECT * FROM cmsvideos where id = '$mar_id'");
		if($row = mysqli_fetch_array($result)) 
		{
		    $returnValue['title'] = preg_replace('/[^A-Za-z0-9]/', ' ', $row['title']);
		    $video_source = $row['video_source'];
		    if($video_source = "youtube")
		    {
		    $video_url_code = $row['video_url_code'];
			$amznlnk = "https://www.studyadda.com/upload_files/yt/QMMyovHVijg.mp4";
			$returnValue['amazonaws_link'] = $amznlnk;
			$returnValue['video_link'] = $row['video_url_code'];
		    }
		    else
		    {
			$amznlnk = "https://www.studyadda.com/upload_files/yt/QMMyovHVijg.mp4";
			$amznlnk = str_replace("https://s3-us-west-2.amazonaws.com/","https://www.studyadda.com/upload_files/",$amznlnk);
			$amznlnk = str_replace("https://s3.amazonaws.com/","https://www.studyadda.com/upload_files/",$amznlnk);
			$amznlnk = str_replace("+"," ",$amznlnk);
			$returnValue['amazonaws_link'] = $amznlnk;
		    }
			$returnValue['id'] = $iid = $row['id'];
			$num = $row['id'];
			$las = $num%10;
			$ytsource = $row['video_url_code'];
			$imurl = "https://img.youtube.com/vi/".$ytsource."/0.jpg";
			$imm = "http://dev.hybridinfotech.com/assets/frontend/images/";
	        $returnValue['video_image'] = $imurl;
			$results = mysqli_query($conn,"SELECT * FROM cmsvideoslist where id = '$iid'");
		if($rows = mysqli_fetch_array($results)) 
		{
		   
		  	$returnValue['display_image'] = $imurl; 
		}
        }
		return $returnValue;
	}
	
?>
