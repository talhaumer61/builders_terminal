<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include the Composer autoload file

if(isset($_POST['submit_add'])) {

	$values = array(
		'id_user'          => cleanvars($_POST['id_user']),
		'id_cat'           => cleanvars($_POST['id_cat']),
		'job_name'         => cleanvars($_POST['job_name']),
		'job_status'       => '1',
		'id_option1'       => cleanvars($_POST['id_option1']),
		'id_option2'       => cleanvars($_POST['id_option2']),
		'job_description'  => cleanvars($_POST['job_description']),
		'job_postcode'     => cleanvars($_POST['job_postcode']),
		'job_area'         => cleanvars($_POST['area_name']),
		'id_subcat'        => cleanvars($_POST['id_subcat']),
		'date_added'       => date('Y-m-d')
	);

	$sqllms = $dblms->insert(JOBS, $values);

	if ($sqllms) {
		$latestID = $dblms->lastestid();
		if ($_FILES['photo_name']) {
			foreach ($_FILES['photo_name']['name'] as $key => $value) {
				if (!empty($value)) {
					$path_parts = pathinfo($value);
					$extension = strtolower($path_parts['extension']);
					$allowed_extensions = array('jpeg', 'jpg', 'png', 'svg', 'pdf', 'ppt', 'docx', 'xls', 'xlsx');
					
					if (in_array($extension, $allowed_extensions)) {
						$img_dir = 'uploads/jobs/';
						$fileName = to_seo_url(cleanvars($_SESSION['userlogininfo']['LOGINNAME'])) . '-' . $latestID . $key . "." . $extension;
						$originalFile = $img_dir . $fileName;
						$dataFile = array(
							'photo_name' => $fileName,
							'id_job'     => $latestID
						);
						$sqllmsUpdateFile = $dblms->Insert(JOB_PHOTOS, $dataFile);
						unset($sqllmsUpdateFile);
						$mode = '0644';
						move_uploaded_file($_FILES['photo_name']['tmp_name'][$key], $originalFile);
						chmod($originalFile, octdec($mode));
					}
				}
			}
		}

		// Sending email notification
		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->isSMTP();                                            // Send using SMTP
			                // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			           // SMTP username (your Hostinger email address)
			                 // SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
			                        // TCP port to connect to

			//Recipients
			$mail->setFrom('info@buildersterminal.com', 'Builders Terminal');   // Your Hostinger email address
			$mail->addAddress('leads@buildersterminal.com');             // Send email to yourself (or any other recipient)

			// Content
			$mail->isHTML(true);                                        // Set email format to HTML
			$mail->Subject = 'New Job Added';

			// Detailed email body
			$mail->Body    = '
				<h2>New Job Added</h2>
				<p>A new job has been added with the following details:</p>
				<ul>
					<li><strong>Job ID:</strong> ' . $latestID . '</li>
					<li><strong>Added by:</strong> ' . $_SESSION['userlogininfo']['LOGINNAME'] . '</li>
					<li><strong>Category ID:</strong> ' . cleanvars($_POST['id_cat']) . '</li>
					<li><strong>Job Name:</strong> ' . cleanvars($_POST['job_name']) . '</li>
					<li><strong>Description:</strong> ' . cleanvars($_POST['job_description']) . '</li>
					<li><strong>Postcode:</strong> ' . cleanvars($_POST['job_postcode']) . '</li>
					<li><strong>Area:</strong> ' . cleanvars($_POST['area_name']) . '</li>
					<li><strong>Date Added:</strong> ' . date('Y-m-d') . '</li>
				</ul>';

			$mail->AltBody = 'A new job has been added with the following details: ' .
							'Job ID: ' . $latestID . ', ' .
							'Added by: ' . $_SESSION['userlogininfo']['LOGINNAME'] . ', ' .
							'Category ID: ' . cleanvars($_POST['id_cat']) . ', ' .
							'Job Name: ' . cleanvars($_POST['job_name']) . ', ' .
							'Description: ' . cleanvars($_POST['job_description']) . ', ' .
							'Postcode: ' . cleanvars($_POST['job_postcode']) . ', ' .
							'Area: ' . cleanvars($_POST['area_name']) . ', ' .
							'Date Added: ' . date('Y-m-d');

			$mail->send();
		} catch (Exception $e) {
			// echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

		// Redirecting to dashboard
		header("Location: dashboard.php", true, 301);
		exit();
	}
}
?>
