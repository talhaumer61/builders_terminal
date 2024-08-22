<?php
    include "include/dbsetting/classdbconection.php";
    include "include/dbsetting/lms_vars_config.php";
    include "include/functions/functions.php";
    include "include/functions/login_func.php";
    checkLogin();
    $title="My Jobs";
    include_once "include/header.php";
    include "include/navbar.php";
    include "include/user/my_jobs.php";
    include "include/footer.php";
?>