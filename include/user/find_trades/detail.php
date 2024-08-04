<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
include "query.php";

$condition	=	array ( 
  'select' 	=> "a.adm_id,a.adm_fullname, s.seller_area,s.description, a.adm_photo",
  'join' 	=> "INNER JOIN ".ADMINS." a ON s.id_adm=a.adm_id",
  'where' 	=> array( 
                           'id_cat'		=>	cleanvars($_GET['catid'])
                      ),
  'return_type' 	=> 'all' 
);
$SELLERS=$dblms->getRows(SELLERS.' s', $condition);
if(isset($_GET['catid'])){
    echo'
    <div class="container p-3">
        <h3>Some of our top rated tradesperson</h3>
        <div class="row justify-content-center">';
        if($SELLERS){
            foreach ($SELLERS as $key => $value) {
                echo '
                <div class="seller_div col-12 col-md-5 d-flex flex-column m-1 rounded bg-light p-2">
                    <div class="px-2">
                        <img class="rounded-circle h-75" src="uploads/user/'.$value['adm_photo'].'" width="35px" />
                        <a href="find_trades.php?id='.$value['adm_id'].'"><span>'.$value['adm_fullname'].'</span></a>
                    </div>
                    <div>
                        <span class=""><i class="fa-solid fa-star"></i> 5/5 (10 Reviews)</span>
                    </div>
                    <div>
                        <p style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">'.$value['description'].'</p>
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