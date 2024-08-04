<?php
if(isset($_POST['submit_add'])) {

		$values = array(
							 'id_user'			    =>	cleanvars($_POST['id_user'])
							,'id_cat'				=>	cleanvars($_POST['id_cat'])
							,'job_name'			    =>	cleanvars($_POST['job_name'])
							,'job_status'			=>	'1'
							,'id_option1'			=>	cleanvars($_POST['id_option1'])
							,'id_option2'			=>	cleanvars($_POST['id_option2'])
							,'job_description'		=>	cleanvars($_POST['job_description'])
							,'job_postcode'			=>	cleanvars($_POST['job_postcode'])
							,'job_area'				=>	cleanvars($_POST['area_name'])
							,'id_subcat'			=>	cleanvars($_POST['id_subcat'])
							,'date_added'			=>	date('Y-m-d')
						); 
		$sqllms		=	$dblms->insert(JOBS, $values);

		if($sqllms) { 
			$latestID   =	$dblms->lastestid();
			foreach ($_FILES['photo_name']['name'] as $key => $value) {
				if (!empty($value)) { // Check if the file name is not empty
					$path_parts = pathinfo($value);
					$extension = strtolower($path_parts['extension']);
					$allowed_extensions = array('jpeg', 'jpg', 'png', 'svg', 'pdf', 'ppt', 'docx', 'xls', 'xlsx');
					
					if (in_array($extension, $allowed_extensions)) {
						$img_dir = 'uploads/jobs/';
						// $fileSize = formatSizeUnits($_FILES['file']['size']); // Uncomment if needed
						$fileName = to_seo_url(cleanvars($_SESSION['userlogininfo']['LOGINNAME'])) . '-' . $latestID . $key . "." . $extension;
						$originalFile = $img_dir . $fileName;
						$dataFile = array(
							'photo_name' => $fileName,
							'id_job' => $latestID
						);
						$sqllmsUpdateFile = $dblms->Insert(JOB_PHOTOS, $dataFile);
						unset($sqllmsUpdateFile);
						$mode = '0644';
						move_uploaded_file($_FILES['photo_name']['tmp_name'][$key], $originalFile);
						chmod($originalFile, octdec($mode));
					}
				}
			}
			
			sendRemark('Category Added ID:'.$latestID, '1');
			sessionMsg('Successfully', 'Record Successfully Added.', 'success');
			header("Location: dashboard.php", true, 301);
			exit();
		}
	// }
}
?>