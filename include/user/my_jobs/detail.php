<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
include "query.php";
$dblms = new dblms();
// include "query.php";
$condition	=	array ( 
  'select' 	=> "j.job_id ,j.job_name, j.job_description, j.job_area, j.job_postcode, j.job_area, c.cat_name, c.cat_icon, sc.subcat_name",
  'join' 	=> "INNER JOIN ".CATEGORIES." c ON j.id_cat=c.cat_id
                INNER JOIN ".SUB_CATEGORIES." sc ON j.id_cat=sc.id_cat",
  'where' 	=> array( 
                           'j.job_status'		=>	'1'
                          ,'j.job_id'		=>	cleanvars($_GET['jobid'])
                      ),
  'return_type' 	=> 'single' 
);
$row=$dblms->getRows(JOBS.' j', $condition);

$condition	=	array ( 
  'select' 	=> "application_id",
  'where' 	=> array( 
                        'id_job'		=>	cleanvars($_GET['jobid'])
                      ),
  'return_type' 	=> 'all' 
);
$JOB_APPLICATIONS=$dblms->getRows(JOB_APPLICATIONS, $condition);
$condition	=	array ( 
  'select' 	=> "id",
  'where' 	=> array( 
                        'id_job'		=>	cleanvars($_GET['jobid'])
                      ),
  'return_type' 	=> 'all' 
);
$JOB_SHORTLISTS=$dblms->getRows(JOB_SHORTLISTS, $condition);
echo '
    <div class="container my-4 rounded bg-light">    
        <div class="row">
            <div class="col-xl-6 p-5 ps-3 ps-xl-5 align-self-center">
              <div class="team-about">
                <h3 class="team-about_title">'.$row['job_name'].'</h3>
                <p class="team-about_text mb-25">
                    '.$row['job_description'].'
                </p>
                <div class="team-info mb-35">
                  <ul>
                    <li>
                      <b>Category:</b>
                      <span>'.$row['cat_name'].'</span>
                    </li>
                    <li>
                      <b>Sub-Category:</b>
                      <span">'.$row['subcat_name'].'</a>
                    </li>
                    </li>
                    <li><b>Postcode:</b> <span>'.$row['job_postcode'].'</span></li>
                    <li>
                      <b>Area:</b> <span>'.$row['job_area'].'</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-xl-6 p-5 ps-3 pt-0 ps-xl-5 align-self-center d-flex">
                <div class="card m-3 bg-secondary ">
                    <div class="card-body">
                        <h5 class="text-white text-center card-title">'.(($JOB_APPLICATIONS)?sizeof($JOB_APPLICATIONS):"0").'</h5>
                        <p class="text-white text-center card-text">Sellers Responded</p>
                    </div>
                </div>
                <div class="card m-3 bg-success">
                    <div class="card-body">
                        <h5 class="text-white text-center card-title">'.(($JOB_SHORTLISTS)?sizeof($JOB_SHORTLISTS):"0").'</h5>
                        <p class="text-white text-center card-text ">Sellers Shortlisted</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2">
          <form method="post">
            <input type="hidden" name="job_id" value="'.$_GET['jobid'].'">
            <button name="close_job" class="btn btn-outline-danger" type="submit"><i class="fa-solid fa-xmark"></i> Close Job</button>
          </form>
        </div>';
     echo'   
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    function applyClicked(){
      $("#coverletterDiv").show();
    }
    function interestedButtonClicked(data) {
      $("#addbtn").hide();
      $("#removebtn").show();
        $.ajax({
            url: "ajax/job_interested.php",
            type: "POST", // Since you"re sending data, change this to POST
            dataType: "json",
            data: { idJob: data, id_adm:'.$_SESSION['userlogininfo']['LOGINIDA'].' }, // Pass your data here
            success: function(response) {}
        });
    }
    function removeButtonClicked(data) {
      $("#removebtn").hide();
      $("#addbtn").show();
        $.ajax({
            url: "ajax/job_interested.php",
            type: "POST", // Since you"re sending data, change this to POST
            dataType: "json",
            data: { removeidJob: data, id_adm:'.$_SESSION['userlogininfo']['LOGINIDA'].' }, // Pass your data here
            success: function(response) {}
        });
    }
</script>
';
?>