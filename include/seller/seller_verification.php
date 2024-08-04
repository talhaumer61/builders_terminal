<?php
include "seller_verification/query.php";

$condition	=	array ( 
  'select' 	=> "question_id , question",
  'where' 	=> array( 
                          'id_cat'		=>	cleanvars($_SESSION['userlogininfo']['SELLERCAT'])
                      ),
  'return_type' 	=> 'all' 
);
$QUESTIONS=$dblms->getRows(VERIFICATION_QUESTIONS, $condition);
$condition	=	array ( 
  'select' 	=> "id_question",
  'where' 	=> array( 
                          'id_seller'		=>	cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
                      ),
  'return_type' 	=> 'all' 
);
$VERIFICATION_RESPONSES=$dblms->getRows(VERIFICATION_RESPONSES, $condition);
echo '
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .skill_ques {
            width: 100%; /* Ensures the textarea takes the full width of its container */
            height:170px;
            resize: none;
            padding: 10px; /* Adds padding inside the textarea */
            border: 1px solid #ccc; /* Adds a light grey border */
            border-radius: 5px; /* Rounds the corners */
            font-size: 16px; /* Sets a comfortable font size */
            line-height: 1.5; /* Improves readability */
            box-sizing: border-box; /* Ensures padding and border are included in the total width and height */
            transition: border-color 0.3s ease; /* Smooth transition for border color change */
        }

        .skill_ques:focus {
            border-color: #66afe9; /* Changes border color on focus */
            outline: none; /* Removes default outline */
            box-shadow: 0 0 5px rgba(102, 175, 233, 0.5); /* Adds a subtle shadow */
        }

        .skill_ques::placeholder {
            color: #999; /* Styles the placeholder text */
        }
</style>

  </head>
  <body>
    <div class="container d-flex justify-content-center p-5">';
        if($_SESSION['userlogininfo']['SELLERSTATUS']==2 && !empty($VERIFICATION_RESPONSES)){
            echo '
            <div id="status_div">
                <h4>Your Approval is Pending</h4>
                <div class="d-flex justify-content-center">
                <a href="dashboard.php" class="btn btn-outline-success">Back to Homepage</a>
                </div>
            </div>
            ';
        }else{
            $condition	=	array ( 
                'select' 	=> "seller_status",
                'where' 	=> array( 
                                        'id_adm'		=>	cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
                                    ),
                'return_type' 	=> 'single' 
              );
            $SELLERS=$dblms->getRows(SELLERS, $condition);
            if($SELLERS['seller_status']==1){
                echo '
                <div id="status_div">
                    <h4>Your Account is Approved</h4>
                    <p class="text-center">Login Again to Proceed</p>
                    <div class="d-flex justify-content-center">
                    <a href="login.php?logout_user" class="btn btn-success">Login</a>
                    </div>
                </div>
            ';
            }
            else{
                echo'
                <div id="tell_us">
                    <h2>Tell us about yourself</h2>
                    <p>Welcome, '.$_SESSION['userlogininfo']['LOGINNAME'].'! Let’s get started.</p>
                    <p>We want to know our tradespeople better so we can send you the right local leads, matched to your skills.</p>
                    <p>In this step, we’ll ask you about the work you undertake, your professional status, and location.</p>
                    <div>
                        <button type="button" class="btn btn-outline-danger">Back</button>
                        <button id="tell_btn" type="button" class="btn btn-outline-success">Continue</button>
                    </div>
                </div>
                <div id="confirm_identity" style="display:none;">
                    <h2>Confirm your identity</h2>
                    <p>This helps us check that you’re really you. Identity verification is one of the ways we keep MyBuilder secure.</p>
                    <p>Your ID will be handled securely and won’t be shared with anyone else.</p>
                    <div>
                        <button type="button" class="btn btn-outline-danger">Back</button>
                        <button id="identity_btn" type="button" class="btn btn-outline-success">Continue</button>
                    </div>
                </div>
                <div id="confirm_skills" style="display:none;">
                    <h2>Verify your skills</h2>
                    <p>Buildersterminal supports quality tradespeople.</p>
                    <p>In this step, we check the skills of all tradespeople joining so customers use MyBuilder with confidence.</p>
                    <p>Our application process is thorough, and only those who meet our high standards are accepted.</p>
                    <div>
                        <button type="button" class="btn btn-outline-danger">Back</button>
                        <button id="skills_btn" type="button" class="btn btn-outline-success">Continue</button>
                    </div>
                </div>
                <div id="verify_ques" style="display:none;">
                    <form method="post">
                        <div id="ques_div">
                        <h2>Skill Assesment</h2>
                        ';
                            $sr=0;
                            foreach ($QUESTIONS as $key => $value) {
                            $sr++;
                            echo'
                            <input type="hidden" id="custId" name="id_question[]" value="'.$value['question_id'].'">
                            <p><b>Question '.$sr.':</b> '.$value['question'].'</p>
                            <textarea name="verify_ques[]" id="jobdesc" required placeholder="" class="skill_ques w-100 job_desc sc-afba1195-0 bVCeBc"></textarea>
                            ';
                            }
                            echo'
                            <div>
                                <button type="button" class="btn btn-outline-danger">Back</button>
                                <button type="submit" name="submit_add" class="btn btn-outline-success">Continue</button>
                            </div>
                        </div>
                    </form>
                </div>';
            }
        }
        echo'
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $("#tell_btn").click(function() {
                $("#tell_us").hide();
                $("#confirm_identity").show();
            });
            $("#identity_btn").click(function() {
                $("#confirm_identity").hide();
                $("#confirm_skills").show();
            });
            $("#skills_btn").click(function() {
                $("#confirm_skills").hide();
                $("#verify_ques").show();
            });
        });
    </script>
  </body>
</html>


';
?>