<?php
if(isset($_GET['seller'])){
    include "seller_applications/detail.php";
}
else{
    include "seller_applications/list.php";
}
?>