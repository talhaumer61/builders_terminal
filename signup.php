<?php
include_once "include/functions/login_func.php";
if(isset($_SESSION['userlogininfo']['LOGINIDA'])) {
	header("Location: dashboard.php");	
} else { 

$login_id = (isset($_POST['login_id']) && $_POST['login_id'] != '') ? $_POST['login_id'] : '';	
	$errorMessage = '';
	if (isset($_POST['login_id'])) {
		$result = IMSSignIn();
		if ($result != '') {
			$errorMessage = $result;
		}
	}
}
echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Document</title>
    <style>
    @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap");
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }
    /* html,body{
      display: grid;
      height: 100%;
      width: 100%;
      place-items: center;
      background: -webkit-linear-gradient(left, #003366,#004080,#0059b3
    , #0073e6);
    } */
    ::selection{
      background: #1a75ff;
      color: #fff;
    }
    .wrapper{
      overflow: hidden;
      max-width: 390px;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0px 15px 20px rgba(0,0,0,0.1);
    }
    .wrapper .title-text{
      display: flex;
      width: 200%;
    }
    .wrapper .title{
      width: 50%;
      font-size: 35px;
      font-weight: 600;
      text-align: center;
      transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
    }
    .wrapper .slide-controls{
      position: relative;
      display: flex;
      height: 50px;
      width: 100%;
      overflow: hidden;
      margin: 30px 0 10px 0;
      justify-content: space-between;
      border: 1px solid lightgrey;
      border-radius: 15px;
    }
    .slide-controls .slide{
      height: 100%;
      width: 100%;
      color: #fff;
      font-size: 18px;
      font-weight: 500;
      text-align: center;
      line-height: 48px;
      cursor: pointer;
      z-index: 1;
      transition: all 0.6s ease;
    }
    .slide-controls label.signup{
      color: #000;
    }
    .slide-controls .slider-tab{
      position: absolute;
      height: 100%;
      width: 50%;
      left: 0;
      z-index: 0;
      border-radius: 15px;
      background: -webkit-linear-gradient(left,#003366,#004080,#0059b3
    , #0073e6);
      transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
    }
    input[type="radio"]{
      display: none;
    }
    #signup:checked ~ .slider-tab{
      left: 50%;
    }
    #signup:checked ~ label.signup{
      color: #fff;
      cursor: default;
      user-select: none;
    }
    #signup:checked ~ label.login{
      color: #000;
    }
    #login:checked ~ label.signup{
      color: #000;
    }
    #login:checked ~ label.login{
      cursor: default;
      user-select: none;
    }
    .wrapper .form-container{
      width: 100%;
      overflow: hidden;
    }
    .form-container .form-inner{
      display: flex;
      width: 200%;
    }
    .form-container .form-inner .auth-form{
      width: 50%;
      transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
    }
    .form-inner .auth-form .field{
      height: 50px;
      width: 100%;
      margin-top: 20px;
    }
    .form-inner .auth-form .field input{
      height: 100%;
      width: 100%;
      outline: none;
      padding-left: 15px;
      border-radius: 15px;
      border: 1px solid lightgrey;
      border-bottom-width: 2px;
      font-size: 17px;
      transition: all 0.3s ease;
    }
    .form-inner .auth-form .field input:focus{
      border-color: #1a75ff;
      /* box-shadow: inset 0 0 3px #fb6aae; */
    }
    .form-inner .auth-form .field input::placeholder{
      color: #999;
      transition: all 0.3s ease;
    }
    .auth-form .field input:focus::placeholder{
      color: #1a75ff;
    }
    .form-inner .auth-form .pass-link{
      margin-top: 5px;
    }
    .form-inner form .signup-link{
      text-align: center;
      margin-top: 30px;
    }
    .form-inner .auth-form .pass-link a,
    .form-inner .auth-form .signup-link a{
      color: #1a75ff;
      text-decoration: none;
    }
    .form-inner .auth-form .pass-link a:hover,
    .form-inner .auth-form .signup-link a:hover{
      text-decoration: underline;.auth-
    }
    
    </style>
</head>
<body>
    <div class="container" style="display: flex; justify-content: center; padding:20px;">
        <div class="wrapper">
            <div class="title-text">
            <div class="title signup">Signup Form</div>
            </div>
            <div class="form-container">
            <div class="form-inner px-3">
                <form class="signup auth-form" method="POST" autocomplete="off">
                    <div class="field">
                        <input type="text" name="adm_fullname" placeholder="Full Name" required>
                    </div>
                    <div class="field">
                        <input type="text" name="adm_email"  placeholder="Email Address" required>
                    </div>
                    <div class="field">
                        <input type="password" name="adm_userpass"  placeholder="Password" required>
                    </div>
                    <div class="p-1">
                      <button  class="btn btn-primary" name="user_signup" type="submit">Sign Up</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>  
      <script>
         const loginText = document.querySelector(".title-text .login");
      const loginForm = document.querySelector("form.login");
      const loginBtn = document.querySelector("label.login");
      const signupBtn = document.querySelector("label.signup");
      const signupLink = document.querySelector("form .signup-link a");
      signupBtn.onclick = (()=>{
        loginForm.style.marginLeft = "-50%";
        loginText.style.marginLeft = "-50%";
      });
      loginBtn.onclick = (()=>{
        loginForm.style.marginLeft = "0%";
        loginText.style.marginLeft = "0%";
      });
      signupLink.onclick = (()=>{
        signupBtn.click();
        return false;
      });

      </script>
</body>
</html>

';
?>