<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
include "query.php";

$condition	=	array ( 
  'select' 	=> "city_name",
  'where' 	=> array( 
                           'city_status'		=>	'0'
                      ),
  'return_type' 	=> 'all' 
);
$CITIES=$dblms->getRows(CITIES, $condition);
echo'
<div class="container py-5 my-3 p-3">
    <h3>Find tradespeople near you</h3>
    <div class="row justify-content-center ">';
    foreach ($CITIES as $key => $value) {
        echo '
        <div class="rounded col-md-2 col-6 p-4 bg-light justify-content-center">
            <a href="cities.php?city='.$value['city_name'].'"><span>'.$value['city_name'].'</span></a>
        </div>
        ';
    }
    echo'    
    </div>
</div>
';
?>