<?php
error_reporting(0);
include("config.php");

 $package = $_POST['package']; 
  $ran_no = $_POST['ran_no'];
   $user_id = $_POST['user_id'];
    $password = $_POST['password'];


  if($first > $ran_no  AND $last > $ran_no)
  $pac = "com.studyadda";
  
     $self = "select * from diff where $ran_no BETWEEN first and last and pac = '$package'";
  $oppf = mysqli_query($conn, $self);
  $rww = mysqli_num_rows($oppf);
  if($rww > 0){
	 $tes_id = "123456TE123StudyYadda";
	  
  }
  
$array1=array();
	{
		if (!empty($_POST['password'])&&($_POST['user_id'])&&!empty($tes_id)) 
		{
    $user_id = $_POST['user_id'];
	$password = md5($_POST['password']);
	
     $sel = "select * from cmscustomers where id = '$user_id'";
	$userchk = mysqli_query($conn, $sel);
	while($rot = mysqli_fetch_array($userchk))
	{
		 $uid = $rot['id'];
		}
	if ($user_id!==$uid)
	{
		$array1['status']="Error";
	}
	else {
	
      $upd = "UPDATE cmscustomers SET password='$password' where id='$user_id'";
		$osd = mysqli_query($conn, $upd);
		
		if($osd)
		 {
		     	$array1['status']="true";
			$array1['msg']="Password changed successfully";
	
		}
	
		else
		{
			$array1['msg']="unsuccess";
			$array1["query"]= $query_req1;
		}
				
	}
		}
		
	else
	{
		$array1['status']="Enter all fields";
	}
	echo json_encode($array1);
	}
	
?>