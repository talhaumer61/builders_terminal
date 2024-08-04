<?php
    if(isset($_GET['jobid'])){
        include "my_jobs/detail.php";
    }else{
    include "my_jobs/breadcrumbs.php";
    include "my_jobs/list.php";
    }
?>