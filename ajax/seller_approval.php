<?php
include "../include/dbsetting/classdbconection.php";
include "../include/dbsetting/lms_vars_config.php";
include "../include/functions/functions.php";
$dblms = new dblms();
if(isset($_POST['id_approve'])){
    $sqllms = $dblms->querylms("DELETE FROM ".VERIFICATION_RESPONSES." WHERE id_seller=".$_POST['id_approve'].";");
    if($sqllms){
        $values = array(
            'seller_status'			=>	'1'
        ); 
        $sqllms = $dblms->Update(SELLERS , $values , "WHERE id_adm  = '".cleanvars($_POST['id_approve'])."'");
    }
}
if(isset($_POST['id_reject'])){
    $sqllms = $dblms->querylms("DELETE FROM ".VERIFICATION_RESPONSES." WHERE id_seller=".$_POST['id_reject'].";");
}


?>