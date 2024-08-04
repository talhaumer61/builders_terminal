<?php
if(isset($_GET['catid'])){
include "find_trades/detail.php";
}
elseif(isset($_GET['id'])){
    include "find_trades/tradeperson.php";
}else{
    include "find_trades/list.php";
}
?>