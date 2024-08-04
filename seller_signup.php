<?php
include_once "include/functions/login_func.php";
include "include/dbsetting/classdbconection.php";
include "include/dbsetting/lms_vars_config.php";
include "include/functions/functions.php";
$dblms = new dblms();
include "include/header.php";
include "include/navbar.php";
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
<div class="container pt-4">
    <h3 class="fw-bold">The reliable way to get work you want</h3>
</div>
<div class="container justify-content-center p-3">
  <div class="row">
    <div class="formcontainer col-md-6 bg-light rounded">
      <form id="registration-form" method="post">
          <div class="form-section p-3 active" id="section-1">
              <h2>Register as Tradesperson</h2>
              <div class="form-group">
                  <label class="label">Postcode</label>
                  <input type="text" name="seller_postcode" class="form-control input--style-4" id="postcode" data-postal-code-input="true" required maxlength="8" inputmode="text" pattern="^([A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}|GIR ?0A{2})$">
                  <p id="error-message" style="color: red; display: none;">Invalid postcode format.</p>
                  <input type="hidden" id="hidden-area-name" name="area_name">
              </div>
              <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="adm_email" required>
              </div>
              <div class="form-group">
                  <label for="category">Category</label>
                  <select class="form-control" id="category" name="id_cat" required>
                      <option value="">Select Category</option>';
                      foreach ($CATEGORIES as $key => $value) {
                        echo'<option '.((isset($_GET['i']) && $_GET['i']==$value['cat_id'])?"selected":"").' value="'.$value['cat_id'].'">'.$value['cat_name'].'</option>';
                      }
                  echo'
                  </select>
              </div>
              <div class="py-2">
                <button type="button" class="btn btn1" id="continue-btn">Continue <i class="fa-solid fa-arrow-right"></i></button>
              </div>
          </div>
          <div class="form-section p-3" id="section-2">
              <h2>Register as Tradesperson</h2>
              <div class="form-group">
                  <label for="full-name">Full Name</label>
                  <input type="text" class="form-control" id="full-name" name="adm_fullname" required>
              </div>
              <div class="form-group">
                  <label for="phone">Phone Number</label>
                  <input type="tel" class="form-control" id="phone" name="adm_phone" required>
              </div>
              <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="adm_userpass" required>
              </div>
              <div class="py-2">
                <button class="btn btn-danger" id="back-btn">Back</button>
                <button type="submit" name="seller_signup" class="btn btn1">Submit</button>
              </div>
          </div>
      </form>
    </div>
    <div class="col-md">
      <img src="assets/img/normal/81.jpg" />
    </div>
  </div>
</div>
<div class="container mt-5">
  <h1 class="fw-bold text-center">How to find the work you want</h1>
  <div class="row p-md-3 p-1">
      <div class="col-md-4 text-center">
        <img src="assets/img/icon/job.svg" style="height:80px;"/>
        <h5 class="m-0 text-theme">Step 1</h5>
        <h3 class="fw-bold">Receive tailored leads</h3>
        <p>Set up your free professional profile and we’ll send you leads that match your skills and work area.</p>
      </div>
      <div class="col-md-4 text-center">
        <img src="assets/img/icon/interest.svg" style="height:80px;"/>
        <h5 class="m-0 text-theme">Step 2</h5>
        <h3 class="fw-bold">Express interest</h3>
        <p>Respond to as many leads as you like. Based on your profile, work history and reviews, customers decide who to share their details with.</p>
      </div>
      <div class="col-md-4 text-center">
        <img src="assets/img/icon/negotiate.svg" style="height:80px;"/>
        <h5 class="m-0 text-theme">Step 3</h5>
        <h3 class="fw-bold">Connect and arrange</h3>
        <p>If you are shortlisted, we charge you a fee for the customer  contact details so you can get in touch to exchange more details about the job.</p>
      </div>
  </div>
</div>
<div class="container d-flex justify-content-center my-4">
  <a class="btn btn-lg btn1 text-white fw-bold" href="">Sign up for free</a>
</div>
<div class="about_us d-flex align-items-center justify-content-between p-md-3 p-1 mb-5">
    <h1 class="fw-bold text-white">Sign up for free</h1>
    <a href="#">
        <svg aria-hidden="true" focusable="false" data-prefix="fass" data-icon="circle-arrow-right" class="svg-inline--fa fa-circle-arrow-right " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" color="#FFFFFF" style="width: 1.5rem; height: 1.5rem;">
            <path fill="currentColor" d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zm393 17L281 385l-17 17L230.1 368l17-17 71-71L136 280l-24 0 0-48 24 0 182.1 0-71-71-17-17L264 110.1l17 17L393 239l17 17-17 17z"></path>
        </svg>
    </a>
</div> 
<div class="container my-5">
  <h4 class="fw-bold">Other Popular Trades</h4>
  <div class="row justify-content-center">
  ';
  foreach ($CATEGORIES as $key => $value) {
    echo '
    <div class="col-md-2 col-6 text-center p-2 bg-light m-md-1 m-0 d-flex align-items-center justify-content-center" style="height:80px;">
      <a class="text-theme fw-bold" href="seller_signup.php?i='.$value['cat_id'].'">'.$value['cat_name'].'</a>
    </div>';
  }
  echo'
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
        $(document).ready(function() {
            $("#continue-btn").on("click", function() {
                let isValid = true;

                // Validate Section 1 fields
                $("#section-1 input, #section-1 select").each(function() {
                    if (!this.checkValidity()) {
                        isValid = false;
                        $(this).addClass("is-invalid");
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                if (isValid) {
                    $("#section-1").removeClass("active");
                    $("#section-2").addClass("active");
                }
            });
            $("#back-btn").on("click", function() {
                    $("#section-2").removeClass("active");
                    $("#section-1").addClass("active");
            });
        });
    </script>
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
include "include/footer.php";
?>
