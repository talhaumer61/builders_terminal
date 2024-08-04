<?php
    include "../dbsetting/classdbconection.php";
    include "../dbsetting/lms_vars_config.php";
    include "../functions/functions.php";
    $dblms = new dblms();
    include "query.php";
if(isset($_GET['response'])){
    $condition	=	array ( 
    'select' 	=> "ja.id_seller, ja.application_id, ja.id_job, ja.coverletter, a.adm_id, a.adm_fullname, s.seller_area",
    'join' 	    => "INNER JOIN ".ADMINS." a ON ja.id_seller=a.adm_id
                    INNER JOIN ".SELLERS." s ON ja.id_seller=s.id_adm",
    'where' 	=> array( 
                            'ja.application_id'		=>	cleanvars($_GET['response'])
                        ),
    'return_type' 	=> 'single' 
    );
    $row=$dblms->getRows(JOB_APPLICATIONS.' ja', $condition);
    echo'
    <div class="container bg-light p-3 rounded my-3">
        <b class="text-dark">Tradesperson Info:</b>
        <div class="px-5 row">
            <p class="text-dark col-md-3"><i class="fa-solid fa-user"></i> Name: '.$row['adm_fullname'].'</p>
            <p class="text-dark col-md-3"><i class="fa-solid fa-location-dot"></i> Area: '.$row['seller_area'].'</p>
        </div>
    </div>
    <div class="container bg-secondary p-3 rounded my-3">
        <b class="text-white">Coverletter:</b>
        <p class="bg-light text-dark p-2 rounded">'.html_entity_decode($row['coverletter']).'</p>
    </div>
    <div class="container bg-light p-3 rounded my-3">
        <b class="text-dark">Tradesperson Reviews:</b>
        <div class="row">';
            $condition	=	array ( 
                'select' 	=> "sr.review, a.adm_fullname",
                'join' 	    => "INNER JOIN ".ADMINS." a ON sr.id_adm=a.adm_id",
                'where' 	=> array( 
                                        'sr.id_seller'		=>	cleanvars($row['adm_id'])
                                    ),
                'return_type' 	=> 'all' 
            );
            $REVIEW=$dblms->getRows(SELLER_REVIEWS.' sr', $condition);
            if($REVIEW){
                
                foreach ($REVIEW as $key => $value) {
                    echo'<div class="col-lg-4">

                    <!-- CUSTOM BLOCKQUOTE -->
                    <blockquote class="blockquote blockquote-custom bg-white p-4 shadow rounded">
                        <div class="blockquote-custom-icon bg-info shadow-sm"><i class="fa fa-quote-left text-white"></i></div>
                        <p class="mb-0 mt-2 font-italic">"'.$value['review'].'"</p>
                        <footer class="blockquote-footer pt-4 mt-4 border-top">'.$value['adm_fullname'].'</footer>
                    </blockquote><!-- END -->
    
                </div>
                    ';
                }
                
            }
            else{
                echo '<h5 class="text-danger text-center">No Review Found</h5>';
            }
        echo'
        </div>
    </div>
    <div class="container d-flex justify-content-center p-4">
    <form method="post">
        <input type="hidden" name="id_application" value="'.$_GET['response'].'">
        <input type="hidden" name="id_job" value="'.$row['id_job'].'">
        <input type="hidden" name="id_seller" value="'.$row['id_seller'].'">
        <input type="hidden" name="id_adm" value="'.$_SESSION['userlogininfo']['LOGINIDA'].'">
        <button name="submit_shortlist" type="submit" class="btn btn-outline-success">Shortlist Tradesperson</button>
    </form>
    </div>
    ';
}
?>