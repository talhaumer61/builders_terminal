<?php
    include "include/dbsetting/classdbconection.php";
    include "include/dbsetting/lms_vars_config.php";
    include "include/functions/functions.php";
    include "include/functions/login_func.php";
    // checkLogin();
    $title="Post a Job";
    include_once "include/header.php";
    include "include/navbar.php";
    include "include/user/job_post.php";
    include "include/footer.php";
?>