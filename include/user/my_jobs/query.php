<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
if(isset($_POST['close_job'])) {
		$values = array(
							 'job_status'			    =>	'2'
						); 
		$sqllms		= $dblms->Update(JOBS , $values , "WHERE job_id  = '".cleanvars($_POST['job_id'])."'");

		if($sqllms) {
		// 	// sendRemark('Category Added ID:'.$latestID, '1');
		// 	// sessionMsg('Successfully', 'Record Successfully Added.', 'success');
			header("Location: my_jobs.php", true, 301);
			exit();
		}
}
?>