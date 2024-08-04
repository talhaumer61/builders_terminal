<?php
session_start();
if(isset($_POST['user_signup'])){
	cpanelLMSSignUp();
}

function checkCpanelLMSSTDLogin() {

	if(isset($_POST['signin_as_instructor'])) {
		return cpanelLMSSignIn();
	}

	if(isset($_POST['user_signup'])) {
		return cpanelLMSSignUp();
	}

	if(isset($_POST['signup_as_student'])) {
		return cpanelLMSSignUpAsStudent();
	}

	if(isset($_POST['signin_as_student'])) {
		return cpanelLMSSignInAsStudent();
	}
	
	if(!isset($_SESSION['stdlogininfo'])) {
		header("Location: ".SITE_URL."");
		exit;
	}

}

function cpanelLMSSTDuserLogin() {

	require_once ("admin/include/dbsetting/lms_vars_config.php");
	require_once ("admin/include/dbsetting/classdbconection.php");
	require_once ("admin/include/functions/functions.php");
	$dblms = new dblms();
	
	$username   = cleanvars($_POST['username']);
	$password  = cleanvars($_POST['password']);
	$pass3  = ($password);
	
	if($username == '') {
		alert_msg('error','Error!','You must enter your User Name');
	} else if ($pass3 == '') {
		alert_msg('error','Error','You must enter the User Password');
	} else {
		
		$sqllms	= $dblms->querylms("SELECT * FROM ".ADMINS."
									WHERE adm_username = '".$username."' 
									AND adm_status = '1' LIMIT 1");
																
		if (mysqli_num_rows($sqllms) == 1) {
			$row = mysqli_fetch_array($sqllms); 
			$salt = $row['adm_salt'];
			$password = hash('sha256', $pass3 . $salt);
			for ($round = 0; $round < 65536; $round++) {
				$password = hash('sha256', $password . $salt);
			}
			if($password == $row['adm_userpass']) {

				$sqllms	= $dblms->querylms("SELECT `type`, `email`, `first_name`, `last_name`, `profile_image`
											FROM ".USERS." 
											WHERE user_id = '".$row['id_user']."' 
											AND status = '1' LIMIT 1");
				$user = mysqli_fetch_array($sqllms);
				$values = array (
									"login_type"	=>	cleanvars($user['type']),
									"id_login_id"	=>	cleanvars($row['adm_id']),
									"user_name"		=>	cleanvars($row['adm_username']),
									"email"				=>	cleanvars($user['email']),
									"user_pass"		=>	cleanvars($_POST['password']),
									"dated" 			=>	date('Y-m-d G:i:s')
								);	
				$sqllms  = $dblms->insert(LOGIN_HISTORY, $values);

				$settingSqllms	= $dblms->querylms("SELECT s.id_batch, b.batch_name
													FROM ".SETTINGS." s
													INNER JOIN ".BATCH." b ON b.batch_id  = s.id_batch
													WHERE  s.id_deleted = '0'
													AND s.status = '1'
													LIMIT 1
													"
												  );
        		$settingValues = mysqli_fetch_array($settingSqllms);

				$session_values = array(
											'adm_id'				=>		cleanvars($row['adm_id']),
											'user_id'				=>		cleanvars($row['id_user']),
											'name'					=>		cleanvars($user['first_name'])." ".cleanvars($user['last_name']),
											"type"					=>		cleanvars($user['type']),
											'profile_image'			=>		cleanvars($user['profile_image']),
											'current_batch'     	=>      cleanvars($settingValues['id_batch']),
									   );
					$userlogininfo['LOGINFROMWEB'] 		=	true;
				$_SESSION['stdlogininfo'] = $session_values;
				
				$remarks = 'Login to Software';
				$values = array (
													"id_user"		=>	cleanvars($_SESSION['stdlogininfo']['adm_id']),
													"filename"	=>	strstr(basename($_SERVER['REQUEST_URI']), '.php', true),
													"action"		=>	'4',
													"dated"			=>	date('Y-m-d G:i:s'),
													"ip"				=>	cleanvars($ip),
													"remarks" 	=>	cleanvars($remarks)
												);
				$sqllms  = $dblms->insert(LOGS, $values);
				alert_msg('success', 'Success!', 'You are Log on Successfully');
				header("Location: ".$_POST['url']."");
				exit();
			} else {
				alert_msg('error', 'Error!', 'Invalid User Password.');
			}	
		} else {
			alert_msg('error','Error!', 'Invalid Username or Password Password.');
		}
	}
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
	$adm_username		= cleanvars($_POST['adm_username']);
	$adm_email			= cleanvars($_POST['adm_email']);
	$adm_userpass		= cleanvars($_POST['adm_userpass']);
	

	if($adm_username == '') {
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
														,'adm_username'        => $adm_username
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
								,'adm_username'			=> $adm_username
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
						$userlogininfo['LOGINUSER'] 		=	$adm_username;
						$userlogininfo['LOGINNAME'] 		=	$adm_fullname;
						$userlogininfo['LOGINEMAIL'] 		=	$adm_email;
						$userlogininfo['LOGINPHOTO'] 		=	'default.png';
						$userlogininfo['LOGINCOMPANYID'] 	=	0;
						$userlogininfo['LOGINFROMWEB'] 		=	true;
					$_SESSION['userlogininfo'] 				=	$userlogininfo;

					sessionMsg('Successfully', 'You are Log on Successfully.', 'success');
					header("Location: http://localhost/myphp/ims/index.php", true, 301);
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

// LOGIN FUNCTION
function cpanelLMSSignIn() {
	
	require_once ("include/dbsetting/lms_vars_config.php");
	require_once ("include/dbsetting/classdbconection.php");
	require_once ("include/functions/functions.php");
	$dblms = new dblms();

	$errorMessage = '';
	$admin_user   = cleanvars($_POST['login_id']);
	$admin_pass1  = cleanvars($_POST['login_pass']);
	$admin_pass3  = ($admin_pass1);

	// CHECK USERNAME, PASSWORD NOT EMPTY
	if($admin_user == '') {
		$errorMessage = 'You must enter your User Name';
	} else if ($admin_pass3 == '') {
		$errorMessage = 'You must enter the User Password';
	} else {

		// CHECK USERNAME, PASSWORD EXISTS
		$loginconditions = array ( 
									 'select' 		=>	'a.*, e.emply_id'
									,'join' 		=>	'LEFT JOIN '.EMPLOYEES.' e ON e.emply_loginid = a.adm_id' 
									,'where' 		=>	array( 
																 'adm_status'		=> '1'
																,'adm_username' 	=> $admin_user 
															) 
									,'limit' 		=>	1
									,'return_type'	=>	'single'
								); 
		$row = $dblms->getRows(ADMINS.' a', $loginconditions);
		// IF EXISTS
		if (!empty($row)) {
			
			// PASSWORD HASHING
			// $salt 		= $row['adm_salt'];
			// $password 	= hash('sha256', $admin_pass3 . $salt);			
			// for ($round = 0; $round < 65536; $round++) {
			// 	$password = hash('sha256', $password . $salt);
			// }

			// if(get_PasswordVerify($admin_pass3, $row['adm_userpass'], $row['adm_salt'])) { 
			if(true) { 
				// MAKE LOGIN HISTORY
				$dataLog = array(
									 'login_type'		=> cleanvars($row['adm_logintype'])
									,'id_login_id'		=> cleanvars($row['adm_id'])
									,'user_pass'		=> cleanvars($_POST['login_pass'])
									,'id_campus'		=> cleanvars($row['id_campus'])
									,'dated'			=> date("Y-m-d G:i:s")
								);
				$sqllmslog  = $dblms->Insert(LOGIN_HISTORY , $dataLog);

				// SELECT ACTIVE SESSION				
				$settingconditions = array ( 
												 'select' 		=>	'st.*, s.sess_name'
												,'join' 		=>	'INNER JOIN '.ACADEMIC_SESSION.' s ON s.sess_id =  st.id_session'
												,'where' 		=>	array( 
																			'st.id_deleted'	=> 0
																		)
												,'return_type'	=>	'single'
											); 
				$values_setting = $dblms->getRows(SETTINGS.' st', $settingconditions);
					
				// Login time when the admin login
				$userlogininfo = array();
					$userlogininfo['LOGINIDA'] 			=	$row['adm_id'];
					$userlogininfo['LOGINTYPE'] 		=	$row['adm_type'];
					$userlogininfo['LOGINAFOR'] 		=	$row['adm_logintype'];
					$userlogininfo['LOGINUSER'] 		=	$row['adm_username'];
					$userlogininfo['LOGINNAME'] 		=	$row['adm_fullname'];
					$userlogininfo['LOGINPHOTO'] 		=	$row['adm_photo'];
					$userlogininfo['LOGINCAMPUS'] 		=	$row['id_campus'];
					$userlogininfo['EMPLYID'] 			=	$row['emply_id'];
					$userlogininfo['ACADEMICSESSION'] 	=	$values_setting['id_session'];
					$userlogininfo['ACA_SESSION_NAME'] 	=	$values_setting['sess_name'];
					// $userlogininfo['TRANSLATION'] 		=	$values_setting['translation'];
					$userlogininfo['LOGINFROMWEB'] 		=	true;
				$_SESSION['userlogininfo'] 				=	$userlogininfo;

				// ROLES IN ARRAY
				$rightdata = array();
				$roleconditions = array ( 
											 'select' 		=>	'*'
											,'where' 		=>	array( 
																		'id_adm' => cleanvars($row['adm_id'])
																	)
											,'order_by'		=>	'right_type ASC'
											,'return_type' 	=>	'all' 
										); 
				$Roles = $dblms->getRows(ADMIN_ROLES, $roleconditions);
				foreach($Roles as $valueroles) {
					$rightdata[] = 	array (
											 'right_name' 	=> $valueroles['right_name']
											,'add' 			=> $valueroles['added']
											,'edit'			=> $valueroles['updated']
											,'delete' 		=> $valueroles['deleted']
											,'view'			=> $valueroles['view']
											,'type'			=> $valueroles['right_type']
										);
				}
				$_SESSION['userroles'] = $rightdata;
				$remarks = 'Login to Software';
				$dataLogs = array(
									 'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
									,'filename'		=> strstr(basename($_SERVER['REQUEST_URI']),'.php', true)
									,'action'		=> '4'
									,'dated'		=> date("Y-m-d G:i:s")
									,'ip'			=> cleanvars($ip)
									,'remarks'		=> cleanvars($remarks)
									,'id_campus'	=> cleanvars($_SESSION['userlogininfo']['LOGINCAMPUS'])
								);
				$sqllmslogs  = $dblms->Insert(LOGS , $dataLogs);

				sessionMsg('Successfully', 'You are Log on Successfully.', 'success');
				header("Location: http://localhost/GPT/portal.odl.edu.pk/dashboard.php");
				exit();
			} else {
				$errorMessage = '<p class="text-danger">Invalid User  Password.</p>';
			}
			
		} else {
			$errorMessage = '<p class="text-danger">Invalid User Name or Password.</p>';
		}		
	}
	return $errorMessage;
	//mysql_close($link);
}

// STUDENT CREATE FUNCTION
function cpanelLMSSignUpAsStudent() {
	
	require_once ("include/dbsetting/lms_vars_config.php");
	require_once ("include/dbsetting/classdbconection.php");
	require_once ("include/functions/functions.php");
	$dblms = new dblms();

	$errorMsg 			= '';
	$std_fullname		= cleanvars($_POST['std_fullname']);
	$std_username		= cleanvars($_POST['std_username']);
	$std_email			= cleanvars($_POST['std_email']);
	$std_password		= cleanvars($_POST['std_password']);

	// echo '<pre>';
	// print_r($_POST);
	// echo '</pre>';
	// exit;

	if($std_username == '') {
		// alert_msg('error','Error!','You must enter your User Name');
		$errorMsg = 'You must enter your User Name';
	}else if(strlen($std_username) < 5){
		// alert_msg('error','Error!','You must enter your User Name');
		$errorMsg = 'User Name should be Greater than 5 characters';
	} else if ($std_password == '') {
		// alert_msg('error','Error','You must enter the User Password');
		$errorMsg = 'You must enter the User Password';
	} else if ($std_fullname == '') {
		// alert_msg('error','Error','You must enter the Full Name');
		$errorMsg = 'You must enter the Full Name';
	} else if ($std_email == '') {
		// alert_msg('error','Error','You must enter the Email');
		$errorMsg = 'You must enter the Email';
	} else {

		$array 				= get_PasswordVerify($std_password);
		$std_password 		= $array['hashPassword'];
		$salt 				= $array['salt'];

		
		$condition = array(
				'select'       =>  'adm_id'
				,'where'        =>  array(
											'is_deleted'          => 0
											,'adm_username'        => $std_username
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
						,'adm_username'			=> $std_username
						,'adm_salt'				=> $salt
						,'adm_userpass'			=> $std_password
						,'adm_fullname'			=> $std_fullname
						,'adm_email'			=> $std_email
						,'adm_photo'			=> 'default.png'
						,'date_added'			=> date('Y-m-d G:i:s')
			); 
			
			$sqllms		=	$dblms->insert(ADMINS, $values);

			if($sqllms) { 

				$latestID = $dblms->lastestid();	

				$values = array(
									'std_status'			=> '1'
									,'std_level'			=> '1'
									,'std_loginid'			=> $latestID
									,'std_name'				=> $std_fullname
									,'id_added'				=> $latestID
									,'date_added'			=> date('Y-m-d G:i:s')
				); 

				$sqllms		=	$dblms->insert(STUDENTS, $values);

				if ($sqllms) {

					sessionMsg('Successfully', 'You are Signup Successfully.', 'success');
					header("Location: ".SITE_URL."signin", true, 301);
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

// LOGIN FUNCTION
function cpanelLMSSignInAsStudent() {
	
	require_once ("include/dbsetting/lms_vars_config.php");
	require_once ("include/dbsetting/classdbconection.php");
	require_once ("include/functions/functions.php");
	$dblms = new dblms();

	$errorMessage = '';
	$std_user   = cleanvars($_POST['login_id']);
	$std_pass1  = cleanvars($_POST['login_pass']);
	$std_pass3  = ($std_pass1);

	// CHECK USERNAME, PASSWORD NOT EMPTY
	if($std_user == '') {
		$errorMessage = 'You must enter your User Name';
	} else if ($std_pass3 == '') {
		$errorMessage = 'You must enter the User Password';
	}
	 else {

		// CHECK USERNAME, PASSWORD EXISTS
		$loginconditions = array ( 
									 'select' 		=>	'a.*, e.std_id,e.std_level'
									,'join' 		=>	'LEFT JOIN '.STUDENTS.' e ON e.std_loginid = a.adm_id' 
									,'where' 		=>	array( 
																 'adm_status'		=> '1'
																,'a.is_deleted' 	=> '0' 
																,'adm_username' 	=> $std_user 
															) 
									,'return_type'	=>	'single'
								); 
		$row = $dblms->getRows(ADMINS.' a', $loginconditions);
		// IF EXISTS
		if (!empty($row)) {
			
			// PASSWORD HASHING
			// $salt 		= $row['adm_salt'];
			// $password 	= hash('sha256', $std_pass3 . $salt);			
			// for ($round = 0; $round < 65536; $round++) {
			// 	$password = hash('sha256', $password . $salt);
			// }

			if(get_PasswordVerify($std_pass3, $row['adm_userpass'], $row['adm_salt'])) { 
			// if(true) { 
				// MAKE LOGIN HISTORY
				$dataLog = array(
									 'login_type'		=> cleanvars($row['adm_logintype'])
									,'id_login_id'		=> cleanvars($row['adm_id'])
									,'user_name'		=> cleanvars($_POST['login_id'])
									,'user_pass'		=> cleanvars($_POST['login_pass'])
									,'id_campus'		=> cleanvars($row['id_campus'])
									,'dated'			=> date("Y-m-d G:i:s")
								);
				$sqllmslog  = $dblms->Insert(LOGIN_HISTORY , $dataLog);

				// SELECT ACTIVE SESSION				
				// $settingconditions = array ( 
				// 								 'select' 		=>	'st.*, s.sess_name'
				// 								,'join' 		=>	'INNER JOIN '.ACADEMIC_SESSION.' s ON s.sess_id =  st.id_session'
				// 								,'where' 		=>	array( 
				// 															'st.id_deleted'	=> 0
				// 														)
				// 								,'return_type'	=>	'single'
				// 							); 
				// $values_setting = $dblms->getRows(SETTINGS.' st', $settingconditions);
					
				// Login time when the admin login
				$userlogininfo = array();
					$userlogininfo['LOGINIDA'] 			=	$row['adm_id'];
					$userlogininfo['LOGINTYPE'] 		=	$row['adm_type'];
					$userlogininfo['LOGINAFOR'] 		=	$row['adm_logintype'];
					$userlogininfo['LOGINUSER'] 		=	$row['adm_username'];
					$userlogininfo['LOGINNAME'] 		=	$row['adm_fullname'];
					$userlogininfo['LOGINPHOTO'] 		=	$row['adm_photo'];
					$userlogininfo['LOGINCAMPUS'] 		=	$row['id_campus'];
					$userlogininfo['STDID'] 			=	$row['std_id'];
					$userlogininfo['STDLEVEL'] 			=	$row['std_level'];
					// $userlogininfo['ACADEMICSESSION'] 	=	$values_setting['id_session'];
					// $userlogininfo['ACA_SESSION_NAME'] 	=	$values_setting['sess_name'];
					// $userlogininfo['TRANSLATION'] 		=	$values_setting['translation'];
					$userlogininfo['LOGINFROMWEB'] 		=	true;
				$_SESSION['userlogininfo'] 				=	$userlogininfo;

				// ROLES IN ARRAY
				// $rightdata = array();
				// $roleconditions = array ( 
				// 							 'select' 		=>	'*'
				// 							,'where' 		=>	array( 
				// 														'id_adm' => cleanvars($row['adm_id'])
				// 													)
				// 							,'order_by'		=>	'right_type ASC'
				// 							,'return_type' 	=>	'all' 
				// 						); 
				// $Roles = $dblms->getRows(ADMIN_ROLES, $roleconditions);
				// foreach($Roles as $valueroles) {
				// 	$rightdata[] = 	array (
				// 							 'right_name' 	=> $valueroles['right_name']
				// 							,'add' 			=> $valueroles['added']
				// 							,'edit'			=> $valueroles['updated']
				// 							,'delete' 		=> $valueroles['deleted']
				// 							,'view'			=> $valueroles['view']
				// 							,'type'			=> $valueroles['right_type']
				// 						);
				// }
				// $_SESSION['userroles'] = $rightdata;
				// $remarks = 'Login to Software';
				// $dataLogs = array(
				// 					 'id_user'		=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
				// 					,'filename'		=> strstr(basename($_SERVER['REQUEST_URI']),'.php', true)
				// 					,'action'		=> '4'
				// 					,'dated'		=> date("Y-m-d G:i:s")
				// 					,'ip'			=> cleanvars($ip)
				// 					,'remarks'		=> cleanvars($remarks)
				// 					,'id_campus'	=> cleanvars($_SESSION['userlogininfo']['LOGINCAMPUS'])
				// 				);
				// $sqllmslogs  = $dblms->Insert(LOGS , $dataLogs);

				sessionMsg('Successfully', 'You are Log on Successfully.', 'success');
				if (isset($_SESSION['search_path'])) {
					header("Location: ".$_SESSION['search_path']);
				}
				else {
					header("Location: ".SITE_URL."dashboard");
				}
				exit();
			} else {
				$errorMessage = '<p class="text-danger">Invalid User Password.</p>';
			}
			
		} else {
			$errorMessage = '<p class="text-danger">Invalid User Name or Password.</p>';
		}		
	}
	return $errorMessage;
	//mysql_close($link);
}

// LOTOUT FUNCTION
function panelLMSSTDLogout() {
	if (isset($_SESSION['userlogininfo']['LOGINIDA'])) {
		unset($_SESSION['userlogininfo']);
		session_destroy();
	}
	session_start();
	sessionMsg("Logout","Your are Logout","danger");
	header("Location: ".SITE_URL);
	exit;
}
?>