<?php
// MCDL LOGIN_FUNC
session_start();
// USER SIGNUP
if(isset($_POST['user_signup'])){
	cpanelLMSSignUp();
}
if(isset($_POST['seller_signup'])){
	sellerignUp();
}
// if(isset($_POST['submit_signin'])){
// 	IMSSignIn();
// }
if(isset($_GET['logout_user'])){
	panelLMSSTDLogout();
}

function checkLogin(){
	if(!isset($_SESSION['userlogininfo'])&& $_SESSION['userlogininfo']['LOGINTYPE']!=3){
		header("Location: login.php");
	}
}
// SIGN IN FUNCTION
function IMSSignIn() {
	// echo '<script>alert("entry")</script>';
	require_once ("include/dbsetting/lms_vars_config.php");
	require_once ("include/dbsetting/classdbconection.php");
	require_once ("include/functions/functions.php");
	$dblms = new dblms();
	
	$adm_email   = ((isset($_POST['login_id']) && !empty($_POST['login_id']))? cleanvars($_POST['login_id']): "");
	$adm_userpass  	= ((isset($_POST['user_pass']) && !empty($_POST['user_pass']))? cleanvars($_POST['user_pass']): cleanvars($e_row['user_pass']));

	$errorMessage 	= (empty($adm_email))?'You must enter your User Name'		:'';
	$errorMessage 	= (empty($adm_userpass))?'You must enter the User Password'		:'';

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
				header("Location: dashboard.php");
				
				exit();
			} else {
				$errorMessage = '<p class="text-danger">Invalid User Password.</p>';
			}
			
		} else {
			$errorMessage = '<p class="text-danger">Invalid Email or Password.</p>';
			
		}		
	}
	return $errorMessage;
}

// LOTOUT FUNCTION
function panelLMSSTDLogout() {
	require_once ("include/dbsetting/lms_vars_config.php");
	require_once ("include/dbsetting/classdbconection.php");
	require_once ("include/functions/functions.php");
	$dblms = new dblms();
	if (isset($_SESSION['userlogininfo']['LOGINIDA'])) {
		unset($_SESSION['userlogininfo']);
		session_destroy();
	}
	session_start();
	// sessionMsg("Logout","Your are Logout","danger");
	header("Location: dashboard.php");
	exit;
}

// ACCOUNT CREATE FUNCTION
function cpanelLMSSignUp() {
	// echo'<script> alert("enter");</script>';
	
	require_once ("include/dbsetting/lms_vars_config.php");
	require_once ("include/dbsetting/classdbconection.php");
	require_once ("include/functions/functions.php");
	$dblms = new dblms();

	$errorMsg 			= '';
	$adm_fullname		= cleanvars(strtolower($_POST['adm_fullname']));
	$adm_email			= cleanvars($_POST['adm_email']);
	$adm_userpass		= cleanvars($_POST['adm_userpass']);
	

	if($adm_email == '') {
		alert_msg('error','Error!','You must enter your User Name');
		$errorMsg = 'You must enter your User Name';
	} else if ($adm_userpass == '') {
		alert_msg('error','Error','You must enter the User Password');
		$errorMsg = 'You must enter the User Password';
	} else {

		$array 				= get_PasswordVerify($adm_userpass);
		$adm_userpass 		= $array['hashPassword'];
		$salt 				= $array['salt'];

		$condition = array(
							 'select'       =>  'adm_id'
							,'where'        =>  array(
														 'is_deleted'          => 0
														,'adm_email'        	=> $adm_email
													)
							,'return_type'  =>  'count'
		);
		if ($dblms->getRows(ADMINS , $condition)) {
			alert_msg('error','Error','Username is already in use');
			$errorMsg = 'Username is already in use';
		} else {
			$values = array(
								 'adm_status'			=> '1'
								,'adm_type'				=> '3'
								,'adm_logintype'		=> '3'
								,'adm_salt'				=> $salt
								,'adm_userpass'			=> $adm_userpass
								,'adm_fullname'			=> $adm_fullname
								,'adm_email'			=> $adm_email
								,'date_added'			=> date('Y-m-d G:i:s')
			); 

			$sqllms		=	$dblms->insert(ADMINS, $values);

			if($sqllms) { 

				$latestID = $dblms->lastestid();	

				// $values = array(
				// 					 'emply_status'			=> '1'
				// 					,'emply_loginid'		=> $latestID
				// 					,'emply_username'		=> $adm_username
				// 					,'emply_password'		=> $adm_userpass
				// 					,'emply_name'			=> $adm_fullname
				// 					,'emply_email'			=> $adm_email
				// 					,'id_added'				=> $latestID
				// 					,'date_added'			=> date('Y-m-d G:i:s')
				// ); 

				// $sqllms		=	$dblms->insert(EMPLOYEES, $values);

				// if ($sqllms) {

					$userlogininfo = array();
						$userlogininfo['LOGINIDA'] 			=	$latestID;
						$userlogininfo['LOGINTYPE'] 		=	'3';
						$userlogininfo['LOGINAFOR'] 		=	'3';
						$userlogininfo['LOGINNAME'] 		=	$adm_fullname;
						$userlogininfo['LOGINEMAIL'] 		=	$adm_email;
						$userlogininfo['LOGINPHOTO'] 		=	'default.png';
						$userlogininfo['LOGINCOMPANYID'] 	=	0;
						$userlogininfo['LOGINFROMWEB'] 		=	true;
					$_SESSION['userlogininfo'] 				=	$userlogininfo;

					sessionMsg('Successfully', 'You are Log on Successfully.', 'success');
					header("Location: dashboard.php", true, 301);
					exit();

				// }
			}
		}
	
		// exit;
																
		// if (mysqli_num_rows($sqllms) == 1) {
		// 	$row = mysqli_fetch_array($sqllms); 
		// 	if($password == $row['adm_userpass']) {

		// 		$sqllms	= $dblms->querylms("SELECT `type`, `email`, `first_name`, `last_name`, `profile_image`
		// 																FROM ".USERS." 
		// 																WHERE user_id = '".$row['id_user']."' 
		// 																AND status = '1' LIMIT 1");
		// 		$user = mysqli_fetch_array($sqllms);
		// 		$values = array (
		// 											"login_type"	=>	cleanvars($user['type']),
		// 											"id_login_id"	=>	cleanvars($row['adm_id']),
		// 											"user_name"		=>	cleanvars($row['adm_username']),
		// 											"email"				=>	cleanvars($user['email']),
		// 											"user_pass"		=>	cleanvars($_POST['login_pass']),
		// 											"dated" 			=>	date('Y-m-d G:i:s')
		// 										);								
		// 		$sqllms  = $dblms->insert(LOGIN_HISTORY, $values);

		// 		$settingSqllms	= $dblms->querylms("SELECT s.id_batch, b.batch_name
		// 											FROM ".SETTINGS." s
		// 											INNER JOIN ".BATCH." b ON b.batch_id  = s.id_batch
		// 											WHERE  s.id_deleted = '0'
		// 											AND s.status = '1'
		// 											LIMIT 1
		// 											"
		// 										  );
        // 		$settingValues = mysqli_fetch_array($settingSqllms);

		// 		$session_values = array(
		// 								'adm_id'			=>		cleanvars($row['adm_id']),
		// 								'user_id'			=>		cleanvars($row['id_user']),
		// 								'name'				=>		cleanvars($user['first_name'])." ".cleanvars($user['last_name']),
		// 								"type"				=>		cleanvars($user['type']),
		// 								'profile_image'		=>		cleanvars($user['profile_image']),
		// 								'current_batch'     =>      cleanvars($settingValues['id_batch']),  
		// 								'batch_name'        =>      cleanvars($settingValues['batch_name'])  
		// 							);

		// 		$_SESSION['userlogininfo'] = $session_values;
		// 		$_SESSION['adm_id'] = $row['adm_id'];
				 
		// 		$remarks = 'Login to Software';
		// 		$values = array (
		// 											"id_user"		=>	cleanvars($_SESSION['userlogininfo']['adm_id']),
		// 											"filename"	=>	strstr(basename($_SERVER['REQUEST_URI']), '.php', true),
		// 											"action"		=>	'4',
		// 											"dated"			=>	date('Y-m-d G:i:s'),
		// 											"ip"				=>	cleanvars($ip),
		// 											"remarks" 	=>	cleanvars($remarks)
		// 										);
		// 		$sqllms  = $dblms->insert(LOGS, $values);
		// 		alert_msg('success', 'Success!', 'You are Log on Successfully');
		// 		header("Location: dashboard.php");
		// 		exit();
		// 	} else {
		// 		alert_msg('error', 'Error!', 'Invalid User Password.');
		// 	}	
		// } else {
		// 	alert_msg('error','Error!', 'Invalid Username or Password Password.');
		// }
	}
	return $errorMsg;
}
function sellerignUp() {
	// echo'<script> alert("enter");</script>';
	
	require_once ("include/dbsetting/lms_vars_config.php");
	require_once ("include/dbsetting/classdbconection.php");
	require_once ("include/functions/functions.php");
	$dblms = new dblms();

	$errorMsg 			= '';
	$adm_fullname		= cleanvars(strtolower($_POST['adm_fullname']));
	// $adm_username		= cleanvars($_POST['adm_username']);
	$adm_email			= cleanvars($_POST['adm_email']);
	$adm_userpass		= cleanvars($_POST['adm_userpass']);
	

	if($adm_email == '') {
		alert_msg('error','Error!','You must enter your User Name');
		$errorMsg = 'You must enter your User Name';
	} else if ($adm_userpass == '') {
		alert_msg('error','Error','You must enter the User Password');
		$errorMsg = 'You must enter the User Password';
	} else {

		$array 				= get_PasswordVerify($adm_userpass);
		$adm_userpass 		= $array['hashPassword'];
		$salt 				= $array['salt'];

		$condition = array(
							 'select'       =>  'adm_id'
							,'where'        =>  array(
														 'is_deleted'          => 0
														,'adm_email'        => $adm_email
													)
							,'return_type'  =>  'count'
		);
		if ($dblms->getRows(ADMINS , $condition)) {
			alert_msg('error','Error','Username is already in use');
			$errorMsg = 'Username is already in use';
		} else {
			$values = array(
								 'adm_status'			=> '1'
								,'adm_type'				=> '2'
								,'adm_logintype'		=> '2'
								// ,'adm_username'			=> $adm_username
								,'adm_salt'				=> $salt
								,'adm_userpass'			=> $adm_userpass
								,'adm_fullname'			=> $adm_fullname
								,'adm_phone'			=> $_POST['adm_phone']
								,'adm_email'			=> $adm_email
								,'date_added'			=> date('Y-m-d G:i:s')
			); 

			$sqllms		=	$dblms->insert(ADMINS, $values);

			if($sqllms) { 

				$latestID = $dblms->lastestid();	

				$values = array(
									 'seller_status'			=> '2'
									,'id_adm'					=> $latestID
									,'id_cat'					=> $_POST['id_cat']
									,'seller_postcode'		=> $_POST['seller_postcode']
									,'seller_area'		=> $_POST['area_name']
				); 

				$sqllms		=	$dblms->insert(SELLERS, $values);

				if ($sqllms) {
					$values = array(
							'select' 		=>	'seller_id, id_cat, seller_status'
							,'where' 		=>	array( 
									'seller_status'				=> '2'
									,'id_adm'					=> $latestID
									,'id_cat'					=> $_POST['id_cat']
									,'seller_postcode'			=> $_POST['seller_postcode']
									,'seller_area'				=> $_POST['area_name'] 
							)
							,'return_type'	=>	'single'
										
					); 

					$SELLERS		=	$dblms->getRows(SELLERS, $values);
					$userlogininfo = array();
						$userlogininfo['LOGINIDA'] 			=	$latestID;
						$userlogininfo['LOGINTYPE'] 		=	'2';
						$userlogininfo['LOGINAFOR'] 		=	'2';
						$userlogininfo['SELLERCAT'] 		=	$SELLERS['id_cat'];
						$userlogininfo['SELLERID'] 			=	$SELLERS['seller_id'];
						$userlogininfo['SELLERSTATUS'] 		=	$SELLERS['seller_status'];
						$userlogininfo['LOGINUSER'] 		=	$adm_username;
						$userlogininfo['LOGINNAME'] 		=	$adm_fullname;
						$userlogininfo['LOGINEMAIL'] 		=	$adm_email;
						$userlogininfo['LOGINPHOTO'] 		=	'default.png';
						$userlogininfo['LOGINCOMPANYID'] 	=	0;
						$userlogininfo['LOGINFROMWEB'] 		=	true;
					$_SESSION['userlogininfo'] 				=	$userlogininfo;

					sessionMsg('Successfully', 'You are Log on Successfully.', 'success');
					header("Location: seller_verification.php", true, 301);
					exit();

				}
			}
		}
	
		// exit;
																
		// if (mysqli_num_rows($sqllms) == 1) {
		// 	$row = mysqli_fetch_array($sqllms); 
		// 	if($password == $row['adm_userpass']) {

		// 		$sqllms	= $dblms->querylms("SELECT `type`, `email`, `first_name`, `last_name`, `profile_image`
		// 																FROM ".USERS." 
		// 																WHERE user_id = '".$row['id_user']."' 
		// 																AND status = '1' LIMIT 1");
		// 		$user = mysqli_fetch_array($sqllms);
		// 		$values = array (
		// 											"login_type"	=>	cleanvars($user['type']),
		// 											"id_login_id"	=>	cleanvars($row['adm_id']),
		// 											"user_name"		=>	cleanvars($row['adm_username']),
		// 											"email"				=>	cleanvars($user['email']),
		// 											"user_pass"		=>	cleanvars($_POST['login_pass']),
		// 											"dated" 			=>	date('Y-m-d G:i:s')
		// 										);								
		// 		$sqllms  = $dblms->insert(LOGIN_HISTORY, $values);

		// 		$settingSqllms	= $dblms->querylms("SELECT s.id_batch, b.batch_name
		// 											FROM ".SETTINGS." s
		// 											INNER JOIN ".BATCH." b ON b.batch_id  = s.id_batch
		// 											WHERE  s.id_deleted = '0'
		// 											AND s.status = '1'
		// 											LIMIT 1
		// 											"
		// 										  );
        // 		$settingValues = mysqli_fetch_array($settingSqllms);

		// 		$session_values = array(
		// 								'adm_id'			=>		cleanvars($row['adm_id']),
		// 								'user_id'			=>		cleanvars($row['id_user']),
		// 								'name'				=>		cleanvars($user['first_name'])." ".cleanvars($user['last_name']),
		// 								"type"				=>		cleanvars($user['type']),
		// 								'profile_image'		=>		cleanvars($user['profile_image']),
		// 								'current_batch'     =>      cleanvars($settingValues['id_batch']),  
		// 								'batch_name'        =>      cleanvars($settingValues['batch_name'])  
		// 							);

		// 		$_SESSION['userlogininfo'] = $session_values;
		// 		$_SESSION['adm_id'] = $row['adm_id'];
				 
		// 		$remarks = 'Login to Software';
		// 		$values = array (
		// 											"id_user"		=>	cleanvars($_SESSION['userlogininfo']['adm_id']),
		// 											"filename"	=>	strstr(basename($_SERVER['REQUEST_URI']), '.php', true),
		// 											"action"		=>	'4',
		// 											"dated"			=>	date('Y-m-d G:i:s'),
		// 											"ip"				=>	cleanvars($ip),
		// 											"remarks" 	=>	cleanvars($remarks)
		// 										);
		// 		$sqllms  = $dblms->insert(LOGS, $values);
		// 		alert_msg('success', 'Success!', 'You are Log on Successfully');
		// 		header("Location: dashboard.php");
		// 		exit();
		// 	} else {
		// 		alert_msg('error', 'Error!', 'Invalid User Password.');
		// 	}	
		// } else {
		// 	alert_msg('error','Error!', 'Invalid Username or Password Password.');
		// }
	}
	return $errorMsg;
}
?>