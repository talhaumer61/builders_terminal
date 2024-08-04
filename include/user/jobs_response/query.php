<?php
if(isset($_POST['submit_shortlist'])) {

		$values = array(
							 'id_seller'			    =>	cleanvars($_POST['id_seller'])
							,'id_job'                   =>	cleanvars($_POST['id_job'])
							,'id_adm'			        =>	cleanvars($_POST['id_adm'])
						); 
		$sqllms		=	$dblms->insert(JOB_SHORTLISTS, $values);

		if($sqllms) { 
			$values = array(
                'application_status'			=>	'2'
            ); 
            $sqllms = $dblms->Update(JOB_APPLICATIONS , $values , "WHERE application_id  = '".cleanvars($_POST['id_application'])."'");
			// sendRemark('Category Added ID:'.$latestID, '1');
			// sessionMsg('Successfully', 'Record Successfully Added.', 'success');
			// header("Location: leads.php?jobid=".$_POST['id_job']."", true, 301);
			// exit();
		}
}
?>