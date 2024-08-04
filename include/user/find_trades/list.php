<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
include "query.php";

$condition	=	array ( 
  'select' 	=> "cat_id, cat_name, cat_icon",
  'where' 	=> array( 
                           'cat_status'		=>	'1'
                      ),
  'return_type' 	=> 'all' 
);
$CATEGORIES=$dblms->getRows(CATEGORIES, $condition);
echo'
<div class="container py-5 my-3 p-3">
    <h3>All trades</h3>
    <div class="row justify-content-center ">';
    foreach ($CATEGORIES as $key => $value) {
        echo '
        <div class="rounded col-md-2 col-6 p-4 bg-light justify-content-center">
            <div>
                <img src="assets/img/icon/cat_icons/'.$value['cat_icon'].'"/>
            </div>
            <a href="find_trades.php?catid='.$value['cat_id'].'"><span>'.$value['cat_name'].'</span></a>
        </div>
        ';
    }
    echo'    
    </div>
</div>
';
?>