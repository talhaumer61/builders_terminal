<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();
if(isset($_GET['seller'])){
    $condition	=	array ( 
        'select' 	=> "vr.response, vq.question",
        'join' 	    => "INNER JOIN ".VERIFICATION_QUESTIONS." vq ON vr.id_question=vq.question_id",
        'where' 	=> array( 
                                 'id_seller'		=>	$_GET['seller']
                            ),
        'return_type' 	=> 'all' 
      );
    $VERIFICATION_RESPONSES=$dblms->getRows(VERIFICATION_RESPONSES. ' vr', $condition);
        echo'<div class="container bg-dark p-3 rounded my-3">
                <h4 class="text-center text-white">Skill Assesment</h4>';
        $sr=0;
        foreach ($VERIFICATION_RESPONSES as $key => $value) {
                $sr++;
                echo'
                <div class="bg-secondary rounded p-3 m-1">
                    <p class="text-white"><b>Question '.$sr.': </b>'.$value['question'].'</p>
                    <p class="bg-light rounded p-2">'.$value['response'].'</p>
                </div>';
        }
            
        echo'
                <div class="d-flex justify-content-center p-2">
                    <a href="seller_applications.php" onclick="approveButtonClicked()" class="btn btn-success mx-1">Approve</a>
                    <a href="seller_applications.php" onclick="rejectButtonClicked()" class="btn btn-outline-danger">Reject</a>
                </div>
            </div>
            
            
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            function approveButtonClicked() {
                $.ajax({
                    url: "ajax/seller_approval.php",
                    type: "POST", 
                    dataType: "json",
                    data: {id_approve:'.$_GET['seller'].' }, // Pass your data here
                    success: function(response) {}
                });
            }
            function rejectButtonClicked() {
                $.ajax({
                    url: "ajax/seller_approval.php",
                    type: "POST", 
                    dataType: "json",
                    data: {id_reject:'.$_GET['seller'].' }, // Pass your data here
                    success: function(response) {}
                });
            }
        </script>
            ';
}
?>