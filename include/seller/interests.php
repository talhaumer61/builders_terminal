<?php
if(isset($_GET['jobid'])){
    include "leads/detail.php";
}else{
    include "interests/list.php";

}
?>