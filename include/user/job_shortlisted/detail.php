<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
include "query.php";


if(isset($_GET['review'])){
        $condition	=	array ( 
        'select' 	=> "id_job",
        'where' 	=> array( 
                                 'id_adm'		    =>	cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
                                ,'id_seller'		=>	cleanvars($_GET['review'])
                            ),
        'return_type' 	=> 'single' 
      );
      $row=$dblms->getRows(JOB_SHORTLISTS, $condition);
      
 echo'
 <div class="container my-3 p-3">
    <form method="post">
        <input type="hidden" name="id_job" value="'.$row['id_job'].'">
        <input type="hidden" name="id_seller" value="'.$_GET['review'].'">
        <input type="hidden" name="id_adm" value="'.$_SESSION['userlogininfo']['LOGINIDA'].'">
        <h5>Describe your experience with the Tradesperson:</h5>
        <textarea name="review" required="" placeholder="" class="job_desc sc-afba1195-0 bVCeBc"></textarea>
        <div class="d-flex justify-content-center">
            <button type"submit" name="submit_review" class="btn btn-success">Submit</button>
        </div>
    </form>
 </div>
 ';
}
?>