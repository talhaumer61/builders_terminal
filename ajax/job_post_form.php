<?php
include "../include/dbsetting/classdbconection.php";
include "../include/dbsetting/lms_vars_config.php";
include "../include/functions/functions.php";
$dblms = new dblms();
if(isset($_POST['id_cat'])) {
    $selectedValue = $_POST['id_cat'];
    $condition	=	array ( 
        'select' 	=> "subcat_id, subcat_name",
        'where' 	=> array( 
                                 'subcat_status'		=>	'1'
                                ,'id_cat'		=>	$_POST['id_cat']
                            ),
        'return_type' 	=> 'all' 
      );
    $SUB_CATEGORIES=$dblms->getRows(SUB_CATEGORIES, $condition);
    
    $condition	=	array ( 
        'select' 	=> "question, question_desc",
        'where' 	=> array( 
                                 'cat_status'		=>	'1'
                                ,'cat_id'		    =>	$_POST['id_cat']
                            ),
        'return_type' 	=> 'single' 
      );
    $row=$dblms->getRows(CATEGORIES, $condition);

    echo '
        <p class="ques">'.$row['question'].'</p>
        '.(!empty($row['question_desc'])?"<p>".$row['question_desc']."</p>":"").'
        ';
        foreach ($SUB_CATEGORIES as $key => $value) {
        echo'
        <label class="radio-label">
            <input type="radio" id="subcat_option" name="id_subcat" value="'.$value['subcat_id'].'" required/>
            <div class="radio-button">
                <div class="radio-circle"></div>
                <div class="radio-content">
                    <span id="label-option1" class="radio-title">'.$value['subcat_name'].'</span>
                    <span class="radio-description"></span>
                </div>
            </div>
        </label>';
        }
    echo '
    <div id="continueButtonContainer2" class="button-container" style="display: none;">
        <button type="button" class="m-2 btn btn-danger" id="backButton2">Back</button>
        <button type="button" class="m-2 btn btn1" id="continueButton2">Continue</button>
    </div>
    ';
}
if(isset($_POST['id_sub_cat'])) {
    $selectedValue = $_POST['id_sub_cat'];
    $condition	=	array ( 
        'select' 	=> "option1_id, option1_name, option1_detail",
        'where' 	=> array( 
                                 'option1_status'		=>	'1'
                                ,'id_subcat'		=>	$_POST['id_sub_cat']
                            ),
        'return_type' 	=> 'all' 
      );
    $JOB_OPTION1=$dblms->getRows(JOB_OPTION1, $condition);
    if($JOB_OPTION1){
    $condition	=	array ( 
        'select' 	=> "question, question_desc",
        'where' 	=> array( 
                                 'subcat_status'		=>	'1'
                                ,'subcat_id'		    =>	$_POST['id_sub_cat']
                            ),
        'return_type' 	=> 'single' 
      );
    $row=$dblms->getRows(SUB_CATEGORIES, $condition);

        echo '
            <p class="ques">'.$row['question'].'</p>
            '.(!empty($row['question_desc'])?"<p>".$row['question_desc']."</p>":"").'
            ';
        foreach ($JOB_OPTION1 as $key => $value) {
            echo'
            <label class="radio-label">
                <input type="radio" id="job_option1'.$key.'" name="id_option1" value="'.$value['option1_id'].'" required/>
                <div class="radio-button">
                    <div class="radio-circle"></div>
                    <div class="radio-content">
                        <span id="label-option1" class="radio-title">'.$value['option1_name'].'</span>
                        '.(!empty($value['option1_detail'])?"<span class='radio-description'>".$value['option1_detail']."</span>":"").'
                    </div>
                </div>
            </label>';
            }
        echo '
            <div id="continueButtonContainer3" class="button-container" style="display: none;">
                <button type="button" class="m-2 btn btn-danger" id="backButton3">Back</button>
                <button type="button" class="m-2 btn btn1" id="continueButton3">Continue</button>
            </div>
        ';
    }
    // else{
    //     echo '
    //     <p class="ques">Add a description to your job:</p>
    //     <textarea data-testid="text-area-input" name="2958" id="2958" required="" minlength="20" placeholder="" class="job_desc sc-afba1195-0 bVCeBc"></textarea>
    //     ';
    // }
}
if(isset($_POST['id_option1'])) {
    $selectedValue = $_POST['id_option1'];

    $condition	=	array ( 
        'select' 	=> "option2_id, option2_name, option2_detail",
        'where' 	=> array( 
                                 'option2_status'		=>	'1'
                                ,'id_option1'		=>	$_POST['id_option1']
                            ),
        'return_type' 	=> 'all' 
      );
    $JOB_OPTION2=$dblms->getRows(JOB_OPTION2, $condition);
    if($JOB_OPTION2){
        $condition	=	array ( 
            'select' 	=> "question, question_desc",
            'where' 	=> array( 
                                    'option1_status'		=>	'1'
                                    ,'option1_id'		    =>	$_POST['id_option1']
                                ),
            'return_type' 	=> 'single' 
        );
        $row=$dblms->getRows(JOB_OPTION1, $condition);

        echo '
            <p class="ques">'.$row['question'].'</p>
            '.(!empty($row['question_desc'])?"<p>".$row['question_desc']."</p>":"").'
        ';
        foreach ($JOB_OPTION2 as $key => $value) {
            echo'
            <label class="radio-label">
                <input type="radio" id="job_option2'.$key.'" name="id_option2" value="'.$value['option2_id'].'" required/>
                <div class="radio-button">
                    <div class="radio-circle"></div>
                    <div class="radio-content">
                        <span id="label-option1" class="radio-title">'.$value['option2_name'].'</span>
                        '.(!empty($value['option2_detail'])?"<span class='radio-description'>".$value['option2_detail']."</span>":"").'
                    </div>
                </div>
            </label>';
            }
        echo '
            <div id="continueButtonContainer4" class="button-container" style="display: none;">
                <button type="button" class="m-2 btn btn1" id="continueButton4">Continue</button>
            </div>
        ';
    }
    
    // else{
    //     echo '
    //     <p class="ques">Add a description to your job:</p>
    //     <textarea data-testid="text-area-input" name="2958" id="2958" required="" minlength="20" placeholder="" class="job_desc sc-afba1195-0 bVCeBc"></textarea>
    //     ';
    // }
    
}
if(isset($_POST['jobpic'])) {
    echo '
        <p class="ques">Wanna add a photo for your job?</p>
        <label class="radio-label d-block">
            <input type="radio" id="job_pic" name="job_pic" value="1" required/>
            <div class="radio-button">
                <div class="radio-circle"></div>
                <div class="radio-content">
                    <span id="label-option1" class="radio-title">Yes</span>
                </div>
            </div>
        </label>
        <label class="radio-label d-block">
            <input type="radio" id="job_pic" name="job_pic" value="2" required/>
            <div class="radio-button">
                <div class="radio-circle"></div>
                <div class="radio-content">
                    <span id="label-option1" class="radio-title">No</span>
                </div>
            </div>
        </label>
    ';
}

if(!isset($_SESSION['userlogininfo']) && isset($_POST['login_id'])  && isset($_POST['user_pass'])){
    // require_once ("include/dbsetting/lms_vars_config.php");
	// require_once ("include/dbsetting/classdbconection.php");
	// require_once ("include/functions/functions.php");
	// $dblms = new dblms();
	
	$adm_email   = ((isset($_POST['login_id']) && !empty($_POST['login_id']))? cleanvars($_POST['login_id']): "");
	$adm_userpass  	= ((isset($_POST['user_pass']) && !empty($_POST['user_pass']))? cleanvars($_POST['user_pass']): cleanvars($e_row['user_pass']));

	// $errorMessage 	= (empty($adm_email))?'You must enter your User Name'		:'';
	// $errorMessage 	= (empty($adm_userpass))?'You must enter the User Password'		:'';

	if (!empty($adm_email) && !empty($adm_userpass)) {
        
		$loginconditions = array ( 
									 'select' 		=>	'a.*, s.seller_id, s.id_cat, s.seller_status'
									,'join' 		=>	'LEFT JOIN '.SELLERS.' s ON a.adm_id=s.id_adm'
									,'where' 		=>	array( 
																 'a.adm_status'		=> '1'
																,'a.is_deleted' 	=> '0' 
																,'a.adm_email' 		=> $adm_email 
															)
									,'return_type'	=>	'single'
		); 		
		$row = $dblms->getRows(ADMINS.' a', $loginconditions);
		if ($row) {

			// PASSWORD HASHING
			$salt 		= $row['adm_salt'];
			$password 	= hash('sha256', $adm_userpass . $salt);			
			for ($round = 0; $round < 65536; $round++) {
				$password = hash('sha256', $password . $salt);
			}

			if($password == $row['adm_userpass']) { 				
				
				if(!empty($row['adm_photo'])){
					$file_url = SITE_URL_PORTAL.'uploads/images/admin/'.$row['adm_photo'];
					if (check_file_exists($file_url)) {
						$adm_photo = $file_url;
					}
				}

				$userlogininfo = array();
					$userlogininfo['LOGINIDA'] 			=	$row['adm_id'];
					$userlogininfo['LOGINTYPE'] 		=	$row['adm_type'];
					$userlogininfo['LOGINAFOR'] 		=	$row['adm_logintype'];
					$userlogininfo['LOGINUSER'] 		=	$row['adm_username'];
					$userlogininfo['SELLERCAT'] 		=	$row['id_cat'];
					$userlogininfo['SELLERID'] 			=	$row['seller_id'];
					$userlogininfo['SELLERSTATUS'] 		=	$row['seller_status'];
					$userlogininfo['LOGINNAME'] 		=	$row['adm_fullname'];
					$userlogininfo['LOGINEMAIL'] 		=	$row['adm_email'];
					$userlogininfo['LOGINPHOTO'] 		=	$adm_photo;
					$userlogininfo['EMPLYREQUEST']		=	$row['emply_request']; // 1=approve, 2=pending, 3=rejected
				$_SESSION['userlogininfo'] 				=	$userlogininfo;


				sessionMsg('Successfully', 'You are Log on Successfully.', 'success');
				// header("Location: dashboard.php");
				echo '
                <input type="hidden" name="id_user" value="'.$_SESSION['userlogininfo']['LOGINIDA'].'">
                <button type="submit" name="submit_add" class="btn btn-success">Submit</button>';
				// exit();
			}
			
		} 	
	}
    
    
    
}
?>
