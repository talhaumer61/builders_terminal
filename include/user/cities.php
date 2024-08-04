<?php
if(isset($_GET['city'])){
include "cities/detail.php";
}else{
include "cities/list.php";
}
?>