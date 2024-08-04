<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
// include "query.php";

$condition	=	array ( 
  'select' 	=> "a.adm_id, a.adm_fullname, c.cat_name",
  'join' 	=> "INNER JOIN ".SELLERS." s ON a.adm_id=s.id_adm
                INNER JOIN ".CATEGORIES." c ON s.id_cat=c.cat_id",
  'where' 	=> array( 
                           'a.adm_status'		=>	'1'
                      ),
  'return_type' 	=> 'all' 
);
$ADMINS=$dblms->getRows(ADMINS.' a', $condition);
echo'
<div class="container ">
    <div class="table-responsive m-3">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            ';
                foreach ($ADMINS as $key => $value) {
                    $condition	=	array ( 
                        'select' 	=> "response",
                        'where' 	=> array( 
                                                 'id_seller'		=>	$value['adm_id']
                                            ),
                        'return_type' 	=> 'all' 
                      );
                    $VERIFICATION_RESPONSES=$dblms->getRows(VERIFICATION_RESPONSES, $condition);
                    if($VERIFICATION_RESPONSES){
                    echo'
                    <tr>
                        <th scope="row">1</th>
                        <td>'.$value['adm_fullname'].'</td>
                        <td>'.$value['cat_name'].'</td>
                        <td><a class="btn btn-primary" href="seller_applications.php?seller='.$value['adm_id'].'">View</a></td>
                    </tr>';
                    }else{
                        echo'
                        <tr>
                            <td class="text-center text-danger" colspan="4">No Data Found</td>
                        </tr>
                        ';
                    }
                }
                echo'
            </tbody>
        </table>
    </div>
</div> 
';
?>