<?php
$dblms = new dblms();
include "profile/query.php";

// Fetch admin details
$condition = array (
    'select' => "a.adm_id, a.adm_fullname, a.adm_email, a.adm_phone, a.adm_photo, s.id_cat, s.description",
    'join'   => "LEFT JOIN ".SELLERS." s ON a.adm_id=s.id_adm",
    'where'  => array('a.adm_id' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])),
    'return_type' => 'single'
);
$row = $dblms->getRows(ADMINS.' a', $condition);

$photo = !empty($row['adm_photo']) ? "uploads/user/".$row['adm_photo'] : "uploads/user.png";

// Fetch portfolio items
$portfolioCondition = array(
    'select' => 'id, photo_name',
    'where'  => array(
        'id_seller' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
    ),
    'return_type' => 'all'
);
$portfolioItems = $dblms->getRows(SELLER_PORTFOLIO, $portfolioCondition);
// Fetch customer revies
$portfolioCondition = array(
    'select' => 'r.review, a.adm_fullname',
    'join' => 'INNER JOIN '.ADMINS.' a ON r.id_adm=a.adm_id',
    'where'  => array(
        'r.id_seller' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
    ),
    'return_type' => 'all'
);
$SELLER_REVIEWS = $dblms->getRows(SELLER_REVIEWS.' r', $portfolioCondition);

echo '
<div class="container-fluid my-5 p-md-3 ">
    <div class="rounded-top">
    <div class="text-center">
        <div class="position-relative d-inline-block">
            <img id="profilePhoto" class="profile-photo" src="'.$photo.'" alt="Profile Photo">
            <div class="change-photo-icon" data-toggle="modal" data-target="#uploadPhotoModal">
                <i class="fas fa-camera"></i>
            </div>
        </div>
    </div>

    <!-- Modal for uploading profile photo -->
    <div class="modal fade" id="uploadPhotoModal" tabindex="-1" role="dialog" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadPhotoModalLabel">Upload Profile Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="uploadPhotoForm" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="profilePhotoInput">Choose Photo:</label>
                            <input type="hidden" name="adm_id" class="form-control-file" value="'.$row['adm_id'].'">
                            <input type="hidden" name="adm_name" class="form-control-file" value="'.$row['adm_fullname'].'">
                            <input type="file" name="adm_photo" class="form-control-file" id="profilePhotoInput">
                        </div>
                        <button type="submit" name="upload_profile_photo" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center  mt-3">
        <h3 id="sellerName">'.ucwords($row['adm_fullname']).'</h3>';
       /* echo'
        <p id="sellerBio">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
        <div class="social-icons">
            <a href="#" id="twitterLink"><i class="fab fa-twitter"></i></a>
            <a href="#" id="linkedinLink"><i class="fab fa-linkedin"></i></a>
            <a href="#" id="githubLink"><i class="fab fa-github"></i></a>
        </div>';*/
        echo'
    </div>
    </div>
    <div class="bg-light rounded">
        <ul class="profilenav nav nav-tabs mt-0" id="profileTab" role="tablist row">
            <li class="nav-item col-md-2">
                <a class="profile_navlinks nav-link active" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true">Contact Information</a>
            </li>
            <li class="nav-item col-md-2">
                <a class="profile_navlinks nav-link" id="security-tab" data-toggle="tab" href="#security" role="tab" aria-controls="security" aria-selected="false">Security</a>
            </li>';
            if($_SESSION['userlogininfo']['LOGINTYPE']==2){
            echo'
            <li class="nav-item col-md-2">
                <a class="profile_navlinks nav-link" id="portfolio-tab" data-toggle="tab" href="#portfolio" role="tab" aria-controls="portfolio" aria-selected="false">Portfolio</a>
            </li>
            <li class="nav-item col-md-2">
                <a class="profile_navlinks nav-link" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="false">Description</a>
            </li>
            <li class="nav-item col-md-2">
                <a class="profile_navlinks nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="description" aria-selected="false">Reviews</a>
            </li>
            ';
            }
            echo'
        </ul>
        
        <div class="tab-content" id="profileTabContent">
            <div class="p-2 tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <h4 class="mt-3">Contact Information</h4>
                <form method="post">
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" value="'.$row['adm_email'].'" class="form-control" id="email" placeholder="Enter email" name="adm_email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone number:</label>
                        <input type="text" value="'.$row['adm_phone'].'" class="form-control" id="phone" placeholder="Enter phone number" name="adm_phone">
                    </div>
                    <button type="submit" name="update_info" class="btn btn-primary profile-btn">Update Contact Info</button>
                </form>
            </div>
            <div class="p-2 tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                <h4 class="mt-3">Security</h4>
                <form method="post">
                    <div class="form-group">
                        <label for="currentPassword">Current Password:</label>
                        <input type="password" name="adm_pass" class="form-control" id="currentPassword" placeholder="Enter current password" name="currentPassword">
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" minlength="6" name="new_pass" class="form-control" id="newPassword" placeholder="Enter new password" name="newPassword">
                    </div>
                    <div id="errorMessage" class="text-danger mt-2">Password must be atleast 6 characters long.</div>
                    <button type="submit" name="update_pass" class="btn btn-primary profile-btn">Update Password</button>
                </form>
            </div>
            <div class="p-2 tab-pane fade" id="portfolio" role="tabpanel" aria-labelledby="portfolio-tab">
                <h4 class="mt-3">Portfolio</h4>
                <button class="btn btn-primary profile-btn mb-3" data-toggle="modal" data-target="#portfolioModal">Add Portfolio Item</button>
                <div class="portfolio-items row">
                    <!-- Portfolio items will be appended here -->
            ';
                if($portfolioItems){
                    foreach ($portfolioItems as $item) {
                        echo '
                        <div class="col-md-3 portfolio-item" data-id="'.$item['id'].'">
                            <img src="uploads/portfolio/'.$item['photo_name'].'" alt="Portfolio Item" class="img-thumbnail" onclick="previewImage(\'uploads/portfolio/'.$item['photo_name'].'\', '.$item['id'].')">
                            <form method="post">
                                <input name="img_id" type="hidden" value="'.$item['id'].'">
                                <button type="submit" class="delete-icon" name="delete_img">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                        ';
                    }
                }
                else{
                    echo '<h4 class="text-center">No Item to Preview</h4>';
                }

                echo '
                </div>
            </div>
            <div class="p-2 tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
                <h4 class="mt-3">Description</h4>
                <form method="post">
                    <div class="form-group">
                        <label for="profileDescription">Profile Description:</label>
                        <textarea class="form-control" name="description" id="profileDescription" rows="5" placeholder="Enter profile description">'.$row['description'].'</textarea>
                    </div>
                    <button type="submit" name="upload_description" class="btn btn-primary profile-btn">Update Description</button>
                </form>
            </div>
            <div class="p-2 tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="description-tab">
                    <div class="row py-3">';
                    if($SELLER_REVIEWS){
                        foreach ($SELLER_REVIEWS as $key => $value) {
                            echo'<div class="col-lg-4">

                            <!-- CUSTOM BLOCKQUOTE -->
                            <blockquote class="blockquote blockquote-custom bg-white p-4 shadow rounded">
                                <p class="mb-0 mt-2 font-italic">"'.$value['review'].'"</p>
                                <footer class="blockquote-footer pt-4 mt-4 border-top">'.ucwords($value['adm_fullname']).'</footer>
                            </blockquote><!-- END -->
            
                        </div>';
                        }
                    }else{
                        echo '<h4 class="text-center">No Review Found</h4>';
                    }
                echo'
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for adding portfolio items -->
<div class="modal fade" id="portfolioModal" tabindex="-1" role="dialog" aria-labelledby="portfolioModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="portfolioModalLabel">Add Portfolio Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="portfolioForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="portfolioUpload">Upload Portfolio Item:</label>
                        <input type="file" name="portfolio_item" class="form-control-file" id="portfolioUpload">
                    </div>
                    <button type="submit" name="upload_portfolio_item" class="btn btn-primary">Add to Portfolio</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for previewing portfolio item -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Portfolio Item Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
<script>
    let currentPreviewId = null;

    // Handle profile photo change
    document.getElementById("profilePhotoInput").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("profilePhoto").src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Handle portfolio item upload
    // document.getElementById("portfolioForm").addEventListener("submit", function(event) {
    //     event.preventDefault();
    //     const formData = new FormData(this);
    //     $.ajax({
    //         url: "profile/upload_portfolio_item.php", // Your PHP file for handling upload
    //         type: "POST",
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function(response) {
    //             // Reload the page or update the portfolio items dynamically
    //             location.reload();
    //         }
    //     });
    // });

    // Preview portfolio image
    function previewImage(src, id) {
        document.getElementById("previewImage").src = src;
        currentPreviewId = id;
        $("#previewModal").modal("show");
    }

    // Delete portfolio item
    function deletePortfolioItem(id) {
        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                url: "ajax/upload_portfolio.php", // Your PHP file for handling delete
                type: "POST",
                data: { img_id: id },
                success: function(response) {
                    // Reload the page or update the portfolio items dynamically
                    location.reload();
                }
            });
        }
    }

    document.getElementById("deleteImageButton").addEventListener("click", function() {
        if (currentPreviewId !== null) {
            deletePortfolioItem(currentPreviewId);
            $("#previewModal").modal("hide");
        }
    });
</script>
';
?>
