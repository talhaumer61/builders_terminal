<?php
include_once "include/functions/login_func.php";
include "include/dbsetting/classdbconection.php";
include "include/dbsetting/lms_vars_config.php";
include "include/functions/functions.php";
$dblms = new dblms();
include "query.php";

$condition	=	array ( 
  'select' 	=> "cat_id, cat_name, cat_status",
  'where' 	=> array( 
                           'cat_status'		=>	'1'
                          ,'is_deleted'		=>	'0'
                      ),
  'return_type' 	=> 'all' 
);
$CATEGORIES=$dblms->getRows(CATEGORIES, $condition);
// if (isset($_SESSION['userlogininfo']['LOGINIDA'])) {
//     header("Location: dashboard.php");
// } else {
//     $login_id = (isset($_POST['login_id']) && $_POST['login_id'] != '') ? $_POST['login_id'] : '';    
//     $errorMessage = '';
//     if (isset($_POST['login_id'])) {
//         $result = IMSSignIn();
//         if ($result != '') {
//             $errorMessage = $result;
//         }
//     }
// }
echo '
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">
    <title>Tradesperson Registeration</title>
    <link href="assets/seller_signup/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="assets/seller_signup/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="assets/seller_signup/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="assets/seller_signup/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="assets/seller_signup/css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-gra-02 p-10  font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Tradesperson Registration Form</h2>
                    <form method="POST">
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Full Name</label>
                                    <input class="input--style-4" type="text" name="adm_fullname">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Postcode</label>
                                    <input type="text" name="seller_postcode" class="input--style-4" id="postcode" data-postal-code-input="true" required maxlength="8" inputmode="text" pattern="^([A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}|GIR ?0A{2})$">
                                    <p id="error-message" style="color: red; display: none;">Invalid postcode format.</p>
                                </div>
                                <input type="hidden" id="hidden-area-name" name="area_name">
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Email</label>
                                    <input class="input--style-4" type="email" name="adm_email">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Phone Number</label>
                                    <input class="input--style-4" type="text" name="adm_phone">
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <label class="label">Category</label>
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select name="id_cat">
                                    <option disabled="disabled" selected="selected">Choose option</option>';
                                    foreach ($CATEGORIES as $key => $value) {
                                      echo'<option value="'.$value['cat_id'].'">'.$value['cat_name'].'</option>';
                                    }
                                echo'
                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div style="width:100%">
                                <div class="input-group">
                                    <label class="label">Password</label>
                                    <input class="input--style-4" type="password" name="adm_userpass">
                                </div>
                            </div>
                        </div>
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" name="seller_signup" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Jquery JS-->
    <script src="assets/seller_signup//vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="assets/seller_signup/vendor/select2/select2.min.js"></script>
    <script src="assets/seller_signup/vendor/datepicker/moment.min.js"></script>
    <script src="assets/seller_signup/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="assets/seller_signup/js/global.js"></script>

    <script>
      $(document).ready(function() {
        function validatePostcode(postcode) {
          // Regular expression to validate UK postcode formats
          var postcodeRegex = /^([A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}|GIR ?0AA)$/i;
          return postcodeRegex.test(postcode);
        }

        function fetchAreaName(postcode) {
          // Fetch area name using the Postcode.io API
          $.ajax({
            url: `https://api.postcodes.io/postcodes/${postcode}`,
            method: "GET",
            success: function(data) {
              if (data.status === 200 && data.result) {
                var areaName = data.result.admin_district;
                $("#hidden-area-name").val(areaName);
              } else {
                $("#hidden-area-name").val("Area not found.");
              }
            },
            error: function() {
              $("#hidden-area-name").val("Error fetching area name.");
            }
          });
        }

        $("#postcode").on("input", function() {
          var inputVal = $(this).val().trim();
          if (inputVal === "") {
            $("#error-message").hide();
            $("#hidden-area-name").val("");
            return; // Stop further execution if input is empty
          }

          var postcode = inputVal.split("|")[0].trim(); // Extract postcode before the "|"

          if (validatePostcode(postcode)) {
            $("#error-message").hide();
            fetchAreaName(postcode);
          } else {
            $("#error-message").show();
            $("#hidden-area-name").val("");
          }
        });

        $("#postcode").on("keydown", function(event) {
          var inputVal = $(this).val();
          var parts = inputVal.split("|");
          if (parts.length > 1 && event.which !== 8 && event.which !== 46) { // Prevent deleting with Backspace or Delete keys
            event.preventDefault();
          }
        });
      });
    </script>

</body>
</html>
<!-- end document-->
';
?>
