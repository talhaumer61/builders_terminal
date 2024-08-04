<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
include "query.php";

$condition	=	array ( 
  'select' 	=> "a.adm_fullname, s.seller_area",
  'join' 	=> "INNER JOIN ".ADMINS." a ON s.id_adm=a.adm_id",
  'where' 	=> array( 
                           'seller_area'		=>	cleanvars($_GET['city'])
                      ),
  'return_type' 	=> 'all' 
);
$SELLERS=$dblms->getRows(SELLERS.' s', $condition);
if(isset($_GET['city'])){
    echo'
    <div class="container p-3">
        <h3>Some of our top rated tradesperson</h3>
        <div class="row justify-content-center">';
            if($SELLERS){
                foreach ($SELLERS as $key => $value) {
                    echo '
                    <div class="seller_div col-12 col-md-5 d-flex flex-column m-1 rounded bg-light p-2">
                        <div class="p-2">
                            <img src="assets/img/icon/user.png" width="35px" />
                            <a href=""><span>'.$value['adm_fullname'].'</span></a>
                        </div>
                        <div>
                            <span class="ps-2"><i class="fa-solid fa-star"></i> 5/5 (10 Reviews)</span>
                        </div>
                        <div>
                            <p style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">My Name is Duane. I am a domestic & commercial flooring specialist. I fit carpet, vinyl, safety flooring, carpet tiles etc. I also undertake preperation work ie: Screeding, patching, Ply wood etc. I treat every job as if it was my home & always leave the area clean & tidy I have full public liability insurance and I am DBS checked for peace of mind. I am very organised & will keep you informed from start to finish. Please do not hesitate to contact me for an estimate.</p>
                        </div>
                        <div>
                            <span class="p-2"><i class="fa-solid fa-location-dot"></i> '.$value['seller_area'].'</span>
                        </div>
                    </div>

                    ';
                }
            }else{
                echo '<h2 class="p-5 text-danger text-center">No Seller Found</h2>';
            }
        echo'
        </div>
    </div>
    ';
}
?>