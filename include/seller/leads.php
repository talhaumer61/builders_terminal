<?php
if(isset($_GET['jobid'])){
    include "leads/detail.php";
}else{
    include "leads/list.php";

}
?>