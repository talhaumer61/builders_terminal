<?php
if(isset($_POST['submit_add'])) {

		$values = array(
							'id_seller'			    =>	cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
							,'application_status'	=>	'1'
							,'id_job'				=>	cleanvars($_POST['id_job'])
							,'coverletter'			=>	cleanvars($_POST['coverletter'])
						); 
		$sqllms		=	$dblms->insert(JOB_APPLICATIONS, $values);

		if($sqllms) { 
			$latestID   =	$dblms->lastestid();
			sendRemark('Category Added ID:'.$latestID, '1');
			sessionMsg('Successfully', 'Record Successfully Added.', 'success');
			header("Location: leads.php?jobid=".$_POST['id_job']."", true, 301);
			exit();
		}
}
?>