<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
$condition	=	array ( 
  'select' 	=> "cat_id, cat_name, cat_status",
  'where' 	=> array( 
                           'cat_status'		=>	'1'
                          ,'is_deleted'		=>	'0'
                      ),
  'return_type' 	=> 'all' 
);
$CATEGORIES=$dblms->getRows(CATEGORIES, $condition);
echo '
    <div class="popup-search-box">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#" class="p-3 d-flex flex-column align-items-center">
            <div class="col-12 form-group">
                <select class="form-select" name="id_cat">
                    <option>Choose Job Category...</option>';
                foreach ($CATEGORIES as $key => $value) {
                    echo '<option value="'.$value['cat_id'].'">'.$value['cat_name'].'</option>';
                }
                echo'
                </select>
            </div>
            <button type="submit" class="btn btn-primary m-5">Continue</button>
        </form>
    </div>    
';
?>