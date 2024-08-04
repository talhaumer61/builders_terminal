<?php

if(isset($_GET['response'])){
    include "jobs_response/detail.php";
}else{
include "jobs_response/list.php";
}
?>