<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
// include "query.php";

$condition	=	array ( 
  'select' 	=> "js.id_job, j.job_name, a.adm_id, a.adm_fullname, a.adm_phone, a.adm_email",
  'join' 	=> "INNER JOIN ".JOBS." j ON  js.id_job=j.job_id AND j.job_status=1
                INNER JOIN ".ADMINS." a ON  js.id_seller=a.adm_id
                ",
  'where' 	=> array( 
                           'js.id_adm'		=>	cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
                      ),
  'return_type' 	=> 'all' 
);
$JOB_SHORTLISTS=$dblms->getRows(JOB_SHORTLISTS. ' js', $condition);
echo'<div class="container p-3 my-3">
<h3 class="text-center p-3">Tradesperson You have Choosen</h3>';
if($JOB_SHORTLISTS){
    echo '<div class="row justify-content-center">';
    foreach ($JOB_SHORTLISTS as $key => $value) {
        echo '
        <div class="card col-md-4 p-0">
        <div class="card-header">
            '.$value['job_name'].'
        </div>
        <div class="card-body">
            <h5 class="card-title">'.ucwords($value['adm_fullname']).'</h5>
            <b>Contact Info:</b>
            <p class="card-text"><b>Phone: </b>'.$value['adm_phone'].'</p>
            <p class="card-text"><b>Email: </b>'.$value['adm_email'].'</p>
            <a href="job_shortlisted.php?review='.$value["adm_id"].'" class="btn btn-success">Job Completed</a>
        </div>
        </div>
        ';
    }
    echo '</div>';
}
else{
    echo'<h3 class="text-center">No Record Found</h3>';
}
echo '</div>';
?>