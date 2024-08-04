<?php
include "../include/dbsetting/classdbconection.php";
include "../include/dbsetting/lms_vars_config.php";
include "../include/functions/functions.php";
$dblms = new dblms();
if(isset($_POST['idJob'])){
    $values = array(
        'id_adm'			    =>	cleanvars($_POST['id_adm'])
       ,'id_job'				=>	cleanvars($_POST['idJob'])
   ); 
$sqllms		=	$dblms->insert(JOB_INTERESTS, $values);
}
if(isset($_POST['removeidJob'])){
    $sqllms		=	$dblms->querylms("DELETE FROM ".JOB_INTERESTS." WHERE id_job=".$_POST['removeidJob']." AND id_adm=".$_POST['id_adm'].";");
}
?>