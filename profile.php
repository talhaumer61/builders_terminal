<?php
    include "include/dbsetting/classdbconection.php";
    include "include/dbsetting/lms_vars_config.php";
    include "include/functions/functions.php";
    include "include/functions/login_func.php";
    checkLogin();
    include_once "include/header.php";
    include "include/navbar.php";
    include "include/profile.php";
    include "include/footer.php";
?>