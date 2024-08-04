<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
// include "query.php";

$condition	=	array ( 
  'select' 	=> "j.job_id ,j.job_name, j.job_area, j.date_added, c.cat_name, c.cat_icon",
  'join' 	  => "INNER JOIN ".CATEGORIES." c ON j.id_cat=c.cat_id",
  'where' 	=> array( 
                           'j.job_status'		=>	'1'
                          ,'j.id_cat'		=>	cleanvars($_SESSION['userlogininfo']['SELLERCAT'])
                      ),
  'return_type' 	=> 'all' 
);
$JOBS=$dblms->getRows(JOBS.' j', $condition);
echo  '
    <section class="service-area overflow-hidden space" id="service-sec">
      <div class="container">
        <div class="row">
          <div class="title-area mb-3 text-center">
            <span class="sub-title">Leads</span>
            <h2 class=" sec-title">Jobs You Might be Interested In</h2>
          </div>
        </div>
        <div class="row gy-4 justify-content-center">';
        foreach ($JOBS as $key => $value) {
          echo'      
          <div class="col-xl-6 col-md-6">
            <div class="service-box style2" data-bg-src="assets/img/bg/shape_bg_1.png">
              <div class="service-content me-3">
                <div class="service-box_icon">
                  <img src="assets/img/icon/cat_icons/'.$value['cat_icon'].'" alt="icon" />
                </div>
                <div class="service-box_number">'.$value['cat_name'].'</div>
              </div>
              <div>
                <h3 class="box-title">
                  <a href="leads.php?jobid='.$value['job_id'].'">'.$value['job_name'].'</a>
                </h3>
                <p class="service-box_text"><i class="fa-solid fa-location-dot"></i> '.$value['job_area'].'</p>
                <p class="service-box_text"><i class="fa-solid fa-calendar-days"></i> '.$value['date_added'].'</p>
                <div>
                <a class="line-btn" href="leads.php?jobid='.$value['job_id'].'">
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