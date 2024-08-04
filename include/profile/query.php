<?php
// Upload Profile Photo
if(isset($_POST['upload_profile_photo'])) {

	// $latestID   =	$dblms->lastestid();
	if(!empty($_FILES['adm_photo']['name'])) {
		$path_parts 	= pathinfo($_FILES["adm_photo"]["name"]);
		$extension 		= strtolower($path_parts['extension']);
		if(in_array($extension , array('jpeg','jpg', 'png', 'JPEG', 'JPG', 'PNG', 'svg', 'pdf','ppt', 'docx', 'xls', 'xlsx'))) {
			$img_dir 		=	'uploads/user/';
			// $fileSize 		=	formatSizeUnits($_FILES['file']['size']);
			$originalFile	=	$img_dir.to_seo_url(cleanvars($_POST['adm_name'])).'-'.$_POST['adm_id'].$_SESSION['userlogininfo']['LOGINTYPE'].".".($extension);
			$fileName		=	to_seo_url(cleanvars($_POST['adm_name'])).'-'.$_POST['adm_id'].$_SESSION['userlogininfo']['LOGINTYPE'].".".($extension);
			$dataFile		=	array(
										 'adm_photo'			=>	$fileName
									);
			$sqllmsUpdateFile = $dblms->Update(ADMINS, $dataFile, "WHERE adm_id  = '".$_SESSION['userlogininfo']['LOGINIDA']."'");
			unset($sqllmsUpdateFile);
			$mode = '0644';
			move_uploaded_file($_FILES['adm_photo']['tmp_name'],$originalFile);
			chmod ($originalFile, octdec($mode));
		}
	}
	sendRemark('Category Added ID:'.$latestID, '1');
	sessionMsg('Successfully', 'Record Successfully Added.', 'success');
	header("Location: profile.php", true, 301);
	exit();
}
// Change Password
if(isset($_POST['update_pass'])) {
	require_once ("include/dbsetting/lms_vars_config.php");
	require_once ("include/dbsetting/classdbconection.php");
	require_once ("include/functions/functions.php");
	$dblms = new dblms();
	$adm_userpass=$_POST['adm_pass'];
	if(!empty($adm_userpass)){
		$loginconditions = array ( 
				'select' 		=>	'a.*, s.seller_id, s.id_cat, s.seller_status'
			,'join' 		=>	'LEFT JOIN '.SELLERS.' s ON a.adm_id=s.id_adm'
			,'where' 		=>	array( 
											'a.adm_status'		=> '1'
										,'a.is_deleted' 	=> '0' 
										,'a.adm_email' 		=> $_SESSION['userlogininfo']['LOGINEMAIL']
									)
			,'return_type'	=>	'single'
	); 		
	$row = $dblms->getRows(ADMINS.' a', $loginconditions);
	
		if ($row) {
			$new_pass=$_POST['new_pass'];
			$salt 		= $row['adm_salt'];
			$password 	= hash('sha256', $adm_userpass . $salt);			
			for ($round = 0; $round < 65536; $round++) {
				$password = hash('sha256', $password . $salt);
			}
			if($password == $row['adm_userpass']) {
				$array 				= get_PasswordVerify($new_pass);
				$new_pass 		= $array['hashPassword'];
				$salt 				= $array['salt'];
				$values = array(
					'adm_salt'				=> $salt
					,'adm_userpass'			=> $new_pass
				); 

				$sqllms		=	$dblms->Update(ADMINS, $values , "WHERE adm_id  = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'");
			}
			if($sqllms){
				
			}
			sessionMsg('Successfully', 'Record Successfully Added.', 'success');
			header("Location: profile.php", true, 301);
			exit();
		}
	}
	
}

// Upload Portfolio Item
if(isset($_POST['upload_portfolio_item'])){
	if(!empty($_FILES['portfolio_item']['name'])) {
		$path_parts 	= pathinfo($_FILES["portfolio_item"]["name"]);
		$extension 		= strtolower($path_parts['extension']);
		if(in_array($extension , array('jpeg','jpg', 'png', 'JPEG', 'JPG', 'PNG', 'svg', 'pdf','ppt', 'docx', 'xls', 'xlsx'))) {
			$img_dir 		=	'uploads/portfolio/';
			$sr=rand(1,1000);
			// $fileSize 		=	formatSizeUnits($_FILES['file']['size']);
			$originalFile	=	$img_dir.to_seo_url(cleanvars($_SESSION['userlogininfo']['LOGINNAME'])).$_SESSION['userlogininfo']['LOGINIDA'].'-'.$sr.".".($extension);
			$fileName		=	to_seo_url(cleanvars($_SESSION['userlogininfo']['LOGINNAME'])).$_SESSION['userlogininfo']['LOGINIDA'].'-'.$sr.".".($extension);
			$dataFile		=	array(
										 'photo_name'			=>	$fileName
										,'id_seller'			=>	$_SESSION['userlogininfo']['LOGINIDA']
									);
			$sqllmsUpdateFile = $dblms->Insert(SELLER_PORTFOLIO, $dataFile);
			unset($sqllmsUpdateFile);
			$mode = '0644';
			move_uploaded_file($_FILES['portfolio_item']['tmp_name'],$originalFile);
			chmod ($originalFile, octdec($mode));
		}
	}
	sendRemark('Category Added ID:'.$latestID, '1');
	sessionMsg('Successfully', 'Record Successfully Added.', 'success');
	header("Location: profile.php", true, 301);
	exit();
}
// Delete Portfolio Item
if (isset($_POST['delete_img'])){
	
	$row=$dblms->querylms("DELETE FROM ".SELLER_PORTFOLIO." WHERE id=".$_POST['img_id'].";");
	if($row){}
}
// Update Profile Description
if(isset($_POST['upload_description'])){
	$values		=	array(
		'description'			=>	cleanvars($_POST['description'])
   );
$sqllms = $dblms->Update(SELLERS, $values, "WHERE id_adm  = '".$_SESSION['userlogininfo']['LOGINIDA']."'");
}
// Update Contact Info
if(isset($_POST['update_info'])){
	$values		=	array(
		 'adm_email'			=>	cleanvars($_POST['adm_email'])
		,'adm_phone'			=>	cleanvars($_POST['adm_phone'])
   );
$sqllms = $dblms->Update(ADMINS, $values, "WHERE adm_id  = '".$_SESSION['userlogininfo']['LOGINIDA']."'");
}
?>