<script>
// Select the first div for class container
const div = document.querySelector('div');

// Assign the warning class to the first div
div.className = '';
</script>
<?php
if (($customer_id == '') || ($customer_id < 1)) {
        redirect('apponline-test/androidusernotfound');
        $this->session->set_userdata('customer_id', $customer_id);
        $customer_id=$this->session->userdata('customer_id');
        }     
?>
<style>
	#heading-breadcrumbs {
    background: url(<?php echo base_url();?>/assets/images/texture-frozen-window.jpg) center center;
    padding: 2px 0;
}
</style> 
		<?php
        $this->session->unset_userdata('exam_id');
        $this->session->unset_userdata('subject_id');
        $this->session->unset_userdata('chapter_id');
        $this->session->unset_userdata('onlinetest_id');
        $this->session->unset_userdata('total_time');
        $this->session->unset_userdata('current_user_id');
        $this->session->unset_userdata('current_exam_timestamp');
        $this->session->unset_userdata('ts'); 
        $usertest_session_value=$this->session->userdata('usertest_id');
        //$onlinetest_id=$this->session->userdata('onlinetest_id');
 if(isset($usertest_session_value)){
        if(isset($usertest_info[0]->id)){	
			$encoded = base64_encode($customer_id);			
        $resultUrl=base_url('apponline-test/examname/all/all/testname/'.$appcid.'/'.$onlinetest_id);
      
       	
        $this->session->unset_userdata('onlinetest_id');
        $this->session->unset_userdata('usertest_id');
            redirect($resultUrl);            
            }
        }
$exam_id=0;
$subject_id=0;
$chapter_id=0;
$onlinetest_id=0;
    if(isset($onlinetestinfo->exam_id)){
            $exam_id = $onlinetestinfo->exam_id;
    }
    if(isset($onlinetestinfo->subject_id)){
            $subject_id = $onlinetestinfo->subject_id;
    }
    if(isset($onlinetestinfo->chapter_id)){
            $chapter_id = $onlinetestinfo->chapter_id;
    }
    if(isset($onlinetestinfo->id)){
            $onlinetest_id = $onlinetestinfo->id;
    }
    if(isset($onlinetestinfo->time)){
            $total_time = $onlinetestinfo->time;
    }
    if(isset($onlinetestinfo->formula_id)){
            $formula_id = $onlinetestinfo->formula_id;
}
$timeresult =secondsToTime($onlinetestinfo->time); 
?>
<div id="wrapper" style="font-family: Roboto,Helvetica,Arial,sans-serif;">
    <!-- class="container" -->	
        <div>
             <?php
             //$this->load->view('common/breadcrumb');?> 		
                  <div class="instruct_panel">
                  <div>        
  <div class="accordion" id="accordionExample">
  <div class="card">
    <div id="proceed_test"><!--Point for start test scroll--></div> 
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">  
        <!-- <button class="btn btn-link" type="button"  style="text-decoration: underline;">data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"</button>--> 
        <h3 class="text-center">General Instructions
					<?php
					
					$showproceedButton='yes'; 
					$currenttime=time();
					if(($onlinetestinfo->assessment_type==4)){ 
					if(($currenttime > $onlinetestinfo->dt_start)&&($currenttime < $onlinetestinfo->dt_end)){
						$showproceedButton='yes';
					}else{
						$showproceedButton='no';
						?>
					<span style="font-size: 22px;line-height: 24%;font-family: Modak;color:red;"><br><br><?php echo "This Online Test is not Available."; ?></span><?php
					}
					} 
					?>
					
					</h3>
		<p style="text-decoration: underline;"><b>Please read the instructions carefully</b></p>
    <ol>
      <li>Total duration and maximum marks of this exam is mentioned in Exam specific instructions.</li>
      <li>The clock will be set at the server. The countdown timer in the top right corner of screen will display the remaining time available for you to complete the examination. When the timer reaches zero, the examination will end by itself. You will not be required to end or submit your examination.In case you finish exam before the timer reaches zero you can choose to press submit button to end the exam.
</li>
<li>In case your test is paused when you lose internet connectivity or power off you need to log in again and start fresh test.
</li>
<li>
                                        The Questions Palette displayed on the right side of screen will show the status of each question using one of the following symbols:
                                        <ol>
                                            <li><img src="<?php echo base_url('assets/images/QuizIcons/Logo1.png');?>"> You have not visited the question yet.<br><br></li>
                                            <li><img src="<?php echo base_url('assets/images/QuizIcons/Logo2.png');?>"> You have not answered the question.<br><br></li>
                                            <li><img src="<?php echo base_url('assets/images/QuizIcons/Logo3.png');?>"> You have answered the question.<br><br></li>
                                            <li><img src="<?php echo base_url('assets/images/QuizIcons/Logo4.png');?>"> You have NOT answered the question, but have marked the question for review.<br><br></li>
                                            <li><img src="<?php echo base_url('assets/images/QuizIcons/Logo5.png');?>"> The question(s) "Answered and Marked for Review" will be considered for evalution.<br><br></li>
                                        </ol>
                                    </li>
									<li>You can click on the ">" arrow which apperes to the left of question palette to collapse the question palette thereby maximizing the question window.To view the question palette again, you can click on "<" which appears on the right side of question window.</li>
<li>You can click on your "Profile" image on top right corner of your screen to change the language during the exam for entire question paper. On clicking of Profile image you will get a drop-down to change the question content to the desired language.
</li>
<li>You can click on <img src="<?php echo base_url('assets/images/QuizIcons/down.png');?>"> to navigate to the bottom and <img src="<?php echo base_url('assets/images/QuizIcons/up.png');?>"> to navigate to top of the question are, without scrolling.
</li><br>
<h4><strong><u>Navigating to a Question:</u></strong></h4>
<li>
    To answer a question, do the following:
        a.Click on the question number in the Question Palette at the right of your screen to go to that numbered question directly. Note that using this option does NOT save your answer to the current question.
        <br>b.Click on Save & Next to save your answer for the current question and then go to the next question.
        <br>c.Click on Mark for Review & Next to save your answer for the current question, mark it for review, and then go to the next question.
</li>
<br>
<h4><strong><u>Answering a Question:</u></strong></h4>
<li>Procedure for answering a multiple choice type question:</li>

        a.To select you answer, click on the button of one of the options.<br>
        b.To deselect your chosen answer, click on the button of the chosen option again or click on the Clear Response button<br>
        c.To change your chosen answer, click on the button of another option<br>
        d.To save your answer, you MUST click on the Save & Next button.<br>
        e.To mark the question for review, click on the Mark for Review & Next button.
    <li>To change your answer to a question that has already been answered, first select that question for answering and then follow the procedure for answering that type of question.
</li><br>
<h4><strong><u>Navigating through sections:</u></strong></h4>

    <li>Sections in this question paper are displayed on the top bar of the screen. Questions in a section can be viewed by click on the section name. The section you are currently viewing is highlighted.</li>
    <li>After click the Save & Next button on the last question for a section, you will automatically be taken to the first question of the next section.</li>
    <li>You can shuffle between sections and questions anything during the examination as per your convenience only during the time stipulated.</li>
    <li>Candidate can view the corresponding section summery as part of the legend that appears in every section above the question palette.</li>
<hr>
<span class="text-danger">Please note all questions will appear in English language only.</span>
<hr>
<li>The marked for review status for a question simply indicates that you would like to look at that question again.If a question is answered and marked for review, your answer for that question will be considered in the evaluation after you submit the exam or the timer reaches zero.</li>
    </ol>  
      </div>
    </div> 
 </div>
 </div>
 </div>
 <?php if(isset($onlinetestinfo->instructions)&&$onlinetestinfo->instructions!=''){ ?>
  <div class="card">
    <div class="card-header bg-info" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Exam specific Instructions
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
       <?php 
         if(isset($onlinetestinfo->instructions)){
                             
        echo "<p>".$onlinetestinfo->instructions."</p>";
                    }
					
                         ?>
      </div>
    </div>
  </div>
     <?php
	 }
?> 
</div>
<div name="online_btn_test">
               <div class="col-sm-12 col-md-12">
              <?php             
        if(!isset($customer_id)&&($customer_id=='')){
            ?>
              <span class="ts-btn">
              <a href="<?php echo base_url('login')?>" >
                  <button type="button" class=" btn-md btn btn-success btn-raised btn-lg searchgo">Login Requred To Start Test</button>
              </a>
              </span>
<?php  }else{
			$encoded = base64_encode($customer_id );
		?><a href="<?php echo base_url('apponline-test/'.$exam_id.'/'.$subject_id.'/'.$chapter_id.'/'.$onlinetest_id.'/'.$total_time.'/'.$total_question.'/'.$formula_id.'/-encid-'.$encoded)?>">
                  <button type="button" class=" btn-md btn btn-success btn-raised btn-lg searchgo">PROCEED</button>
              </a><?php			

}
?>
        </div>
                    <div class="col-sm-6 col-md-6 text-right"> <label class="btn btn-sm btn-primary btn-simple" id="0">
					<?php
					if(isset( $timeresult['h'])&& $timeresult['h']>0){
						$hrsTomin=60* intval($timeresult['h']);
					}else{
						$hrsTomin=0;
					}
						if(isset( $timeresult['m'])&& $timeresult['m']>0){
							$minsTomin=intval($timeresult['m']);
						}else{
							$minsTomin=0;
						}
						if(isset( $timeresult['s'])&& $timeresult['s']>0){
							$secTomin=intval($timeresult['s'])/60;
						}else{
							$secTomin=0;
						}
						$durationInMin=$hrsTomin+$minsTomin+$secTomin;
					?>
					
               <font size='3px'>Exam Duration  - <?php echo $timeresult['h'].' HRS : '.$timeresult['m'].' MIN ';
			   if(isset($timeresult['s'])&&$timeresult['s']>0){
			   echo ': '.$timeresult['s'].' SEC';
			   } 
			   ?><br>(<em>In Minutes - <?php echo intval($durationInMin);?> MIN </em>)
               </font>
              <?php ///echo 'Test Type'. $onlinetestinfo->type; ?>
                      </label>
                    </div>
</div>

    <?php
	if(isset($customer_id)&&($customer_id>0)){
	?>
<ul style="list-style: none; text-transform: uppercase;"><li>
<a href="#wrapper"><h5>Go To Top <img src="<?php echo base_url('assets/images/QuizIcons/up.png');?>">  </h5> </a></li>
<li class="text-primary">
I have read and understood the instructions. All computer hardware allotted to me are in proper working condition. I declare that I am not in possession of / not wearing / not carrying any prohibited gadget like mobile phone, bluetooth devices etc. /any prohibited material with me into the Examination Hall.I agree that in case of not adhering to the instructions, I shall be liable to be debarred from this Test and/or to disciplinary action, which may include ban from future Tests / Examinations
</li>
</ul> 
<?php } ?> 
</div>            
                 <?php if(isset($customer_id)&&($customer_id!='')){ ?> 
                  <div class="col-sm-12 col-md-12">
                  <div class="panel panel-success">
                  <div class="panel-heading">
                 	 <h4><i class="material-icons">history</i>Recent Test Results</h4>
                     </div>
                     <ul class="row startexampanel">
<?php 
foreach($usertest_info as $testvalue){
   // echo "<li class='col-xs-12 col-sm-6 col-md-6'><i class='material-icons'>update</i>  <a href='".base_url('online-test/result/'.$testvalue->id)."' >".$testvalue->name."</a></li>";
    echo "<li class='col-xs-12 col-sm-6 col-md-6'><i class='material-icons'>update</i>  <a href='".base_url('apponline-test/userresult/'.$appcid.'/'.$testvalue->id)."' >".$testvalue->name."</a></li>";
}
?>
                  </ul>                  
				  </div>
                  </div>   
                 <?php } ?>  
                  </div> 
                <!-- right panel -->
                <!--
<div class="col-sm-12 col-md-3">  <div class="rht_status_mat">
                    <div class="panel panel-primary">
                	<div class="panel-heading">
                            <h4> <i class="material-icons">book</i>Statistics</h4>
                        </div>
                	<div class="panel-body">
                            <ul>
                                <li><i class="material-icons">&#xE037;</i> <a href="#"><span class="text-warning"></span>Total Time -<?php //echo $timeresult['h'].':'.$timeresult['m'].':'.$timeresult['s']; ?></a> </li>
                                <li><i class="material-icons">&#xE037;</i><a href="#"> <span class="text-warning"></span>Test Type -<?php //echo $onlinetestinfo->type; ?></a></li>
                            </ul>
                        </div>
                    </div>
             </div>
                <div class="hidden-xs hidden-sm right_advertisepanel"><img alt="adversite" src="<?php //echo base_url('assets/images/150adv_2.jpg')?>">
                    </div>
                </div>
				-->
                </div> 
  
             <!-- /. PAGE INNER  -->
   
</div>

<script>
function check_instruction(){
var valen_ch=document.getElementById("en_ch").checked;
if(valen_ch==true){
return true;
}else{
alert('Warning! Please accept terms and conditions before proceeding.');
return false;
}
}
</script>
