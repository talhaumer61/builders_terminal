<?php
    include "include/dbsetting/classdbconection.php";
    include "include/dbsetting/lms_vars_config.php";
    include "include/functions/functions.php";
    include "include/functions/login_func.php";
    // include "include/header.php";
    // if(!isset($_SESSION['userlogininfo'])){
    //     include "include/signin.php";
    // }
    // else{
    //     include "dashboard.php";
    // }
    // include "include/footer.php";
    // if(isset($_SESSION['userlogininfo']['LOGINIDA'])) {
        
        header("Location:dashboard.php");
    //     exit();
    // } else { 
    //     header("Location:auth.php");
    //     exit();
    // }
?>