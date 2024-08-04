<?php
if (isset($_POST['img_id'])){
	$row=$dblms->querylms("DELETE FROM ".SELLER_PORTFOLIO." WHERE id=".$_POST['img_id'].";");
	if($row){
		echo '<script>alert("done");</script>';
	}
}
?>