<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
include "query.php";

$condition	=	array ( 
  'select' 	=> "j.job_name, a.application_id, a.coverletter, ad.adm_fullname",
  'join' 	=> "INNER JOIN ".JOB_APPLICATIONS." a ON j.job_id=a.id_job AND a.application_status=1
                INNER JOIN ".ADMINS." ad ON ad.adm_id=a.id_seller",
  'where' 	=> array( 
                           'j.job_status'		=>	'1'
                          ,'j.id_user'		=>	cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
                      ),
  'return_type' 	=> 'all' 
);
$JOBS=$dblms->getRows(JOBS.' j', $condition);
if($JOBS){
echo'
<div class="container">
    <div class="row p-3">';
    foreach ($JOBS as $key => $value) {
        echo'      
            <div class="col-xl-6 col-md-6">
                <div class="service-box style2" data-bg-src="assets/img/bg/shape_bg_1.png">
                    <div class="service-content me-3">
                    <div class="service-box_icon">
                    <b>Job: </b><a href="jobs_response.php?response='.$value['application_id'].'">'.$value['job_name'].'</a>
                    </div>
                    <div class="service-box_number">'.$value['cat_name'].'</div>
                    </div>
                    <div>
                    <p class="box-title text-bold">
                        Tradesperson: '.$value['adm_fullname'].'
                    </p>
                    <a class="line-btn" href="jobs_response.php?response='.$value['application_id'].'"
                        >Read More <i class="fas fa-arrow-right ms-2"></i
                    ></a>
                    </div>
                </div>
            </div>
        ';
    }
        echo'
    </div>
</div>
';
}else{
    echo'
    <div class"container p-5">
        <h4 class="p-5 my-5 text-center text-danger">No Response Found</h4>
    </div>
    ';
}
?>