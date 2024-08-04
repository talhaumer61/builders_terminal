<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
// include "query.php";

$condition	=	array ( 
  'select' 	=> "js.id_job, j.job_name, a.adm_fullname, a.adm_phone, a.adm_email",
  'join' 	=> "INNER JOIN ".JOBS." j ON  js.id_job=j.job_id AND j.job_status=1
                INNER JOIN ".ADMINS." a ON  js.id_adm=a.adm_id
                ",
  'where' 	=> array( 
                           'js.id_seller'		=>	cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
                      ),
  'return_type' 	=> 'all' 
);
$JOB_SHORTLISTS=$dblms->getRows(JOB_SHORTLISTS. ' js', $condition);
echo'<div class="container p-3 my-3">
<h3 class="text-center p-3">Jobs You have been choosen for</h3>';
if($JOB_SHORTLISTS){
    echo '<div class="row justify-content-center">';
    foreach ($JOB_SHORTLISTS as $key => $value) {
        echo '
        <div class="card col-md-4 p-0">
        <div class="card-header">
            '.$value['job_name'].'
        </div>
        <div class="card-body">
            <h6 class="card-title">Customer: '.$value['adm_fullname'].'</h6>
            <b>Contact Info:</b>
            <p class="card-text mb-0"><b>Phone: </b>'.$value['adm_phone'].'</p>
            <p class="card-text"><b>Email: </b>'.$value['adm_email'].'</p>
        </div>
        </div>
        ';
    }
    echo '</div>';
}
else{
    echo'<h3 class="text-center text-danger">No Record Found</h3>';
}
echo '</div>';
?>