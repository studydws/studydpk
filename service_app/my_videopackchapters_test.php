<?php
	include('config.php');
	error_reporting(0);
	$user_key = $_POST['user_key'];
	$user_id = $_POST['user_id'];
	$device_id = $_POST['device_id'];
	$class_id = $_POST['class_id'];
	$subject_id = $_POST['subject_id'];

  $self = "select * from cmscustomers where user_key = '$user_key' and id = '$user_id' and device_id = '$device_id'";
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
    //SELECT cmschapters.id as chapter_id, cmschapters.name as cname, cmssubjects.id as sid, cmssubjects.name as sname FROM cmschapter_details cd JOIN cmschapters ON cd.chapter_id = cmschapters.id JOIN cmssubjects ON cd.subject_id = cmssubjects.id WHERE cd.class_id = '$class_id' AND cd.subject_id='$subject_id' ORDER BY cd.sortorder ASC, cd.id ASC
    //SELECT cmsvideolist_relations.chapter_id as chapter_id FROM cmsvideolist_relations JOIN categories ON cmsvideolist_relations.exam_id=categories.id LEFT JOIN cmssubjects ON cmsvideolist_relations.subject_id=cmssubjects.id LEFT JOIN cmschapters ON cmsvideolist_relations.chapter_id=cmschapters.id JOIN cmsvideoslist ON cmsvideolist_relations.videolist_id=cmsvideoslist.id WHERE cmsvideolist_relations.exam_id = '$class_id' AND cmsvideolist_relations.subject_id = '$subject_id' GROUP BY cmsvideolist_relations.videolist_id ORDER BY cmsvideoslist.id DESC
	$result = mysqli_query($conn,"SELECT cmschapters.id as chapter_id, cmschapters.name as cname, cmssubjects.id as sid, cmssubjects.name as sname FROM cmschapter_details cd JOIN cmschapters ON cd.chapter_id = cmschapters.id JOIN cmssubjects ON cd.subject_id = cmssubjects.id WHERE cd.class_id = '$class_id' AND cd.subject_id='$subject_id' ORDER BY cd.sortorder ASC, cd.id ASC" );


	while($row = mysqli_fetch_array($result)) {
		 $mar_id = $row['chapter_id'];
		 $result_rel = mysqli_query($conn,"SELECT cmsvideolist_relations.id, cmsvideolist_details.id FROM cmsvideolist_relations JOIN cmsvideolist_details ON cmsvideolist_details.videolist_id=cmsvideolist_relations.videolist_id WHERE cmsvideolist_relations.chapter_id = '$mar_id'" );
		if($row_rel = mysqli_num_rows($result_rel) >= 1)
		{
		$job = array();
		$job = getmarvelcategoryn($mar_id,$conn);
		$subTmp[] = $job;
		}
	}
if($subTmp){$tmp['status'] = "success";$tmp['datatwo'] = $subTmp; }
		else {$tmp['status'] = "false";$tmp['datatwo'] = "no data";}
	echo json_encode($tmp,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
	mysqli_close($conn);
	function getmarvelcategoryn($mar_id,$conn) {
		$returnValue = array();

		$result = mysqli_query($conn,"SELECT * FROM cmschapters WHERE id = '$mar_id'");
		if($rows = mysqli_fetch_array($result))
		{
			$class_id = $_POST['class_id'];
	        $subject_id = $_POST['subject_id'];
			$returnValue['class_id'] = $class_id;
			$returnValue['subject_id'] = $subject_id;
			$returnValue['chapter_id'] = $rows['id'];
			$str = $rows['name'];
		    /*$str = utf8_encode($str);
            $str = strip_tags($str, '<img>,<table>,<td>,<tr>,<th>,<tbody>,<ul>,<li>'); 
            $str = htmlentities($str, ENT_QUOTES, "UTF-8");
            $str = preg_replace("!\r?\n!", "", $str);
            $str = str_replace("&nbsp;", "", $str);
            $str = str_replace("nbsp;", "", $str);
            $str = str_replace("&amp;", "", $str);*/
            //$returnValue['question'] = $str;
            $str = preg_replace("/[\r\n]+/", " ", $str);
            $str = utf8_encode($str);
			$returnValue['chapter_name'] = $str;
		}
		return $returnValue;
	}

?>
