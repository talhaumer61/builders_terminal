<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
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
echo'
<div class="job-container my-5 d-flex justify-content-center">
    <form method="post" enctype="multipart/form-data" class="w-100 d-flex flex-column align-items-center">

        <div id="categroyDiv" class="p-5 p-0 mb-0 div flex-column show">
            <h2 class="p-0 fw-bold">Post <span id="job_head">a</span> job</h2>
            <h6 class="p-0">What would you like to have done?</h6>
            <div class="p-0 col-12 form-group">
                <select id="selectCategory" class="form-select" name="id_cat">
                    <option>Choose Job Category...</option>';
                    foreach ($CATEGORIES as $key => $value) {
                    echo '<option value="'.$value['cat_id'].'">'.$value['cat_name'].'</option>';
                    }
                    echo'
                </select>
            </div>
            <div id="continueButtonContainer" class="button-container" style="display:none;">
              <button type="button" class="m-2 btn btn1" id="continueButton">Continue</button>
            </div>
        </div>

        <div id="subcategory" class="div px-5 pb-0 radio-container"></div>

        <div id="option1" class="div px-5 pb-0"></div>

        <div id="option2" class="div px-5 pb-0"></div>

        <div id="job_desc" class="div px-5 pb-0 flex-column">
          <p class="ques">Add a description to your job:</p>
          <textarea name="job_description" id="jobdesc" required="" minlength="20" placeholder="" class="job_desc sc-afba1195-0 bVCeBc"></textarea>
          <div id="desc_button_container" style="display:none";>
            <button id="desc_button" type="button"  class="btn btn1 m-2">Continue</button>
          </div>
        </div>

        <div id="job_header" class="div px-5 mb-0 flex-column">
          <p class="ques">Add a Header/Title to your job:</p>
          <input id="job_title" name="job_name" type="text" class="form-control" placeholder="">
          <div id="header_button_container" style="display:none";>
            <button id="header_button" type="button"  class="btn btn1 m-2">Continue</button>
          </div>
        </div>
        <div id="job_picture" class="div px-5 mb-0 flex-column"></div>
        <div id="photo_div" class="div px-5 mb-0 flex-column">
            <p class="ques">Select photo/files to describe your job:</p>        
            <input id="photo_name" name="photo_name[]" type="file" multiple class="form-control" placeholder="">
            <div id="piccontinueButtonContainer" class="button-container">
                <button type="button" class="m-2 btn btn1" id="piccontinueButton">Continue</button>
            </div>
        </div>

        <div id="job_postcode" class="div px-5 mb-0 flex-column">
          <p class="ques">Add Postcode for your job:</p>
          <input type="text" name="job_postcode" class="form-control" id="postcode" data-postal-code-input="true" required maxlength="8" inputmode="text" pattern="^([A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}|GIR ?0A{2})$">
          <p id="error-message" style="color: red; display: none;">Invalid postcode format.</p>
          <input type="hidden" id="hidden-area-name" name="area_name">
          <div id="submit_button_container" style="display:none";>';
          if(isset($_SESSION['userlogininfo'])){
            echo'
            <input type="hidden" name="id_user" value="'.$_SESSION['userlogininfo']['LOGINIDA'].'">
            <button id="submit_btn" name="submit_add" type="submit" class="btn btn-success m-2">Post</button>
            ';
          } else {
            echo'
            <button id="next_btn" name="submit_add" type="button" class="btn btn-success m-2">Continue</button>
            ';
          }
            echo'
          </div>
        </div>

        <div id="email_container" class="div px-5 mb-0 flex-column">
          <p class="ques">Enter Your Email</p>
          <input id="adm_email" name="adm_email" type="text" class="form-control" placeholder="">
          <div id="email_button_container" style="display:none";>
            <button id="email_button" type="button"  class="btn btn1 m-2">Continue</button>
          </div>
        </div>
        
        <div id="userpass_container" class="div px-5 mb-0 flex-column">
          <p class="ques">Enter Password</p>
          <input id="adm_userpass" name="adm_userpass" type="password" class="form-control" placeholder="">
          <div id="userpass_button_container" style="display:none";>
            <button id="userpass_button" type="button"  class="btn btn1 m-2">Continue</button>
          </div>
        </div>
        <div class="sub p-2"></div>
    </form> 
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $("#next_btn").click(function() {
          $("#submit_button_container").hide();
          $("#email_container").show();
    });
    $("#adm_email").on("input", function() {
      $("#email_button_container").show();
    });
    $("#email_button").click(function() {
          $("#email_button_container").hide();
          $("#userpass_container").show();
    });
    $("#adm_userpass").on("input", function() {
      $("#userpass_button_container").show();
    });


    $("#userpass_button").on("click", function() {
      const adm_email = $("#adm_email").val();
      const adm_userpass = $("#adm_userpass").val();
        $.ajax({
          url: "ajax/job_post_form.php",
          method: "POST",
          data: { login_id: adm_email , user_pass: adm_userpass },
          success: function(response) {
              const r=response;
              if(r!=""){
              $("#userpass_button_container").hide();
        }
            $(".sub").html(response);
          }
        });
    });


    // $("html, body").animate({
    //   scrollTop: $("#categroyDiv").offset().top
    // }, 1000); 
    $("#jobdesc").on("input", function() {
      if ($(this).val().length >= 20) {
        $("#desc_button_container").show();
      }
    });
    $("#desc_button").on("click", function() {
      $("#desc_button_container").hide();
      $("#job_header").show();
      $("html, body").animate({
        scrollTop: $("#job_header").offset().top-150
      }, 1000);
    });

    $("#header_button").on("click", function() {
      $("#header_button_container").hide();
      $.ajax({
          url: "ajax/job_post_form.php",
          method: "POST",
          data: { jobpic: 1 },
          success: function(response) {
              $("#job_picture").html(response);
              $("#job_picture").show();
              $("#job_picture").addClass("show");
          }
        });
    });
    $(document).on("change", "input[name=\"job_pic\"]",function() {
          if($(this).val()==1){
          $("#job_postcode").hide();
          $("#photo_div").show();
          }else{
            $("#photo_div").hide();
            $("#job_postcode").show();
          }
    });
    $("#piccontinueButton").on("click", function() {
          $("#job_postcode").show();
    });

    $("#job_title").on("input", function() {
      $("#header_button_container").show();
    });

    // Category
    $("#selectCategory").change(function() {
      $("#subcategory").removeClass("radio-container");
      $("#subcategory").removeClass("show");
      $("#option1").html("");
      $("#option1").removeClass("show");
      $("#option2").html("");
      $("#option2").removeClass("show");
      $("#job_desc").removeClass("show");
      $("#job_header").hide();
      $("#job_postcode").hide();
      $("#email_container").hide();
      $("#userpass_container").hide();
      
      // $("#continueButtonContainer").show();

      if ($(this).val() !== "Choose Job Category...") {
        $("#continueButtonContainer").fadeIn(1000);
      } else {
        $("#continueButtonContainer").fadeOut(500);
      }
      $("#continueButton").click(function() {
        $("#continueButtonContainer").hide();
        const id_cat = $("#selectCategory").val();
  
        $.ajax({
          url: "ajax/job_post_form.php",
          method: "POST",
          data: { id_cat: id_cat },
          success: function(response) {
            
            $("#subcategory").html(response);
            $("#subcategory").addClass("show");
            $("#subcategory").addClass("radio-container");
            $("html, body").animate({
              scrollTop: $("#subcategory").offset().top
            }, 1000); 
          }
        });
      });
    });
    
    // Sub-category
    $(document).on("change", "input[name=\"id_subcat\"]",function() {
        $("#option1").html("");
        $("#option1").removeClass("show");
        $("#option2").html("");
        $("#option2").removeClass("show");
        $("#job_desc").removeClass("show");
        $("#job_header").removeClass("show");
        $("#job_postcode").removeClass("show");
        $("#email_container").removeClass("show");
        $("#userpass_container").removeClass("show");
      if ($(this).val() !== "Choose Sub-Category...") {
        $("#continueButtonContainer2").fadeIn(1000);
      } else {
        $("#continueButtonContainer2").fadeOut(500);
      }
      $("#backButton2").click(function(){
        $("#continueButtonContainer").show();
        $("#subcategory").html("");
        $("#subcategory").removeClass("show");
        $("#subcategory").removeClass("radio-container");
        $("html, body").animate({
          scrollTop: $("#categroyDiv").offset().top
        }, 1000);
      });
      $("#continueButton2").click(function() {
        $("#continueButtonContainer2").hide();
        const id_sub_cat = $("input[name=\"id_subcat\"]:checked").val();
        $.ajax({
          url: "ajax/job_post_form.php",
          method: "POST",
          data: { id_sub_cat: id_sub_cat },
          success: function(response) {
            if(response !=""){
              $("#option1").html(response);
              $("#option1").addClass("show");
              $("#option1").addClass("radio-container");
              $("html, body").animate({
                scrollTop: $("#option1").offset().top-190
              }, 1000); 
            }else{
              $("#job_desc").addClass("show");
              $("html, body").animate({
                scrollTop: $("#option1").offset().top-190
              }, 1000); 
            }
          }
        });
      });
    });

    // Option-1
    $(document).on("change", "input[name=\"id_option1\"]",function() {
        $("#option2").html("");
        $("#option2").removeClass("show");
        $("#job_desc").removeClass("show");
        $("#job_header").removeClass("show");
        $("#job_postcode").removeClass("show");
        $("#email_container").removeClass("show");
        $("#userpass_container").removeClass("show");
      if ($(this).val() !== "Choose Option...") {
        $("#continueButtonContainer3").fadeIn(1000);
      } else {
        $("#continueButtonContainer3").fadeOut(500);
      }
      $("#backButton3").click(function(){
        $("#continueButtonContainer3").show();
        $("#option1").html("");
        $("#option1").removeClass("show");
        $("#option1").removeClass("radio-container");
        $("html, body").animate({
          scrollTop: $("#subcategory").offset().top
        }, 500);
        $("#continueButtonContainer2").show();
      });
      $("#continueButton3").click(function() {
        $("#continueButtonContainer3").hide();
        const id_option1 = $("input[name=\"id_option1\"]:checked").val();
  
        $.ajax({
          url: "ajax/job_post_form.php",
          method: "POST",
          data: { id_option1: id_option1 },
          success: function(response) {
            if(response !=""){
              $("#option2").html(response);
              $("#option2").addClass("show");
              $("#option2").addClass("radio-container");
              $("html, body").animate({
                scrollTop: $("#option2").offset().top-190
              }, 1000);
            }else{
              $("#job_desc").addClass("show");
              $("html, body").animate({
                scrollTop: $("#job_desc ").offset().top-190
              }, 1000);
            } 
          }
        });
      });
    });

    // Option-2
    $(document).on("change", "input[name=\"id_option2\"]",function() {
        $("#job_desc").removeClass("show");
        $("#job_header").removeClass("show");
        $("#job_postcode").removeClass("show");
        $("#email_container").removeClass("show");
        $("#userpass_container").removeClass("show");
      if ($(this).val() !== "Choose Option...") {
        $("#continueButtonContainer4").show();
      } else {
        $("#continueButtonContainer4").fadeOut(500);
      }
      $("#backButton4").click(function(){
        $("#div4").html("");
      });
      $("#continueButton4").click(function() {
        $("#continueButtonContainer4").fadeOut(500);
        $("#job_desc").fadeIn(1000);
        $("html, body").animate({
          scrollTop: $("#job_desc").offset().top-190
        }, 1000);
        // const id_option2 = $("#selectOption2").val();
  
        // $.ajax({
        //   url: "ajax/job_post_form.php",
        //   method: "POST",
        //   data: { id_option2: id_option2 },
        //   success: function(response) {
        //     $("#div5").html(response);
        //     $("#div5").addClass("show");
        //   }
        // });

      });
    });

  });
</script>

</body>
';
?>