<?php
if(isset($_POST['submit_review'])) {

		$values = array(
							 'id_seller'			    =>	cleanvars($_POST['id_seller'])
							,'review'                   =>	cleanvars($_POST['review'])
							,'id_adm'			        =>	cleanvars($_POST['id_adm'])
						); 
		$sqllms		=	$dblms->insert(SELLER_REVIEWS, $values);

		if($sqllms) { 
			$values = array(
                'job_status'			=>	'2'
            ); 
            $sqllms = $dblms->Update(JOBS , $values , "WHERE job_id  = '".cleanvars($_POST['id_job'])."'");
			// sendRemark('Category Added ID:'.$latestID, '1');
			// sessionMsg('Successfully', 'Record Successfully Added.', 'success');
			header("Location: dashboard.php", true, 301);
			exit();
		}
}
?>