<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
// include "query.php";

$condition	=	array ( 
  'select' 	=> "id_job",
  'where' 	=> array( 
                          'id_adm'		=>	cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
                      ),
  'return_type' 	=> 'all' 
);
$JOB_INTERESTS=$dblms->getRows(JOB_INTERESTS, $condition);
echo  '
    <section class="service-area overflow-hidden space" id="service-sec">
      <div class="container">
        <div class="row">
          <div class="title-area mb-3 text-center">
            <span class="sub-title">Interests</span>';
            if($JOB_INTERESTS){
            echo '<h2 class=" sec-title">Jobs You are Interested In</h2>';
          }else{
              echo '<h2 class="bg-secondary rounded p-3 text-danger sec-title">No Data Found</h2>';
            }
            echo'
          </div>
        </div>
        <div class="row gy-4 justify-content-center">';
        foreach ($JOB_INTERESTS as $key => $interest) {
          $condition	=	array ( 
            'select' 	=> "j.job_id ,j.job_name, j.job_area, c.cat_name, c.cat_icon",
            'join' 	  => "INNER JOIN ".CATEGORIES." c ON j.id_cat=c.cat_id",
            'where' 	=> array( 
                                     'j.job_status'		=>	'1'
                                    ,'j.job_id'		    =>	cleanvars($interest['id_job'])
                                ),
            'return_type' 	=> 'single' 
          );
          $row=$dblms->getRows(JOBS.' j', $condition);
          echo'      
          <div class="col-xl-6 col-md-6">
            <div class="service-box style2" data-bg-src="assets/img/bg/shape_bg_1.png">
              <div class="service-content me-3">
                <div class="service-box_icon">
                  <img src="assets/img/icon/cat_icons/'.$row['cat_icon'].'" alt="icon" />
                </div>
                <div class="service-box_number">'.$row['cat_name'].'</div>
              </div>
              <div>
                <h3 class="box-title">
                  <a href="leads.php?jobid='.$row['job_id'].'">'.$row['job_name'].'</a>
                </h3>
                <p class="service-box_text"><i class="fa-solid fa-location-dot"></i> '.$row['job_area'].'</p>
                <div>
                <a class="line-btn" href="leads.php?jobid='.$row['job_id'].'">
                  Read More <i class="fas fa-arrow-right ms-2"></i>
                </a>
                </div>
              </div>
            </div>
          </div>';
        }
        echo'
        </div>
      </div>
    </section>
';
?>