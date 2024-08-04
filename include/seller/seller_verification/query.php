<?php
if(isset($_POST['submit_add'])) {

	// $condition	=	array ( 
	// 						'select' 	=> "adm_id",
	// 						'where' 	=> array( 
	// 												 'adm_username'		=>	cleanvars($_POST['subcat_name'])
	// 												,'is_deleted'	=>	'0'	
	// 											),
	// 						'return_type' 	=> 'count' 
	// 						); 
	// if($dblms->getRows(ADMINS, $condition)) {
	// 	sessionMsg('Error','Record Already Exists.','danger');
	// 	header("Location: dashboard.php", true, 301);
	// 	exit();
	// }else{
        $sr=0;
        foreach ($_POST['id_question'] as $question_id) {    
		$values = array(
							 'id_question'			    =>	cleanvars($question_id)
							,'id_seller'				=>	cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							,'response'			        =>	cleanvars($_POST['verify_ques'][$sr])
						); 
		$sqllms		=	$dblms->insert(VERIFICATION_RESPONSES, $values);
        $sr++;
		// if($sqllms) { 
		// 	$latestID   =	$dblms->lastestid();
		// 	sendRemark('Category Added ID:'.$latestID, '1');
		// 	sessionMsg('Successfully', 'Record Successfully Added.', 'success');
		// 	exit();
		// }
    }
    header("Location: dashboard.php", true, 301);
	// }
}
?>