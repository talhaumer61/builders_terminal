<?php
    include "include/dbsetting/classdbconection.php";
    include "include/dbsetting/lms_vars_config.php";
    include "include/functions/functions.php";
    include "include/functions/login_func.php";
    // checkIMSLogin();
    // include_once "include/header.php";
    echo '
<!DOCTYPE html>
<html class="no-js" lang="zxx">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Builders Terminal</title>
    <meta name="author" content="Kotar" />
    <meta name="description" content="Kotar - Kotar Construction Service HTML Template"/>
    <meta name="keywords" content="Kotar - Kotar Construction Service HTML Template"/>
    <meta name="robots" content="INDEX,FOLLOW" />
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no"/>
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav-light.png"/>
    <link rel="manifest" href="assets/img/favicons/manifest.json" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="assets/img/favicons/ms-icon-144x144.png"/>
    <meta name="theme-color" content="#ffffff" />
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&amp;family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&amp;display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css" />
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
    .profile-card {
      padding: 20px;
      margin-bottom: 20px;
    }
    .profile-image {
      width: 100px;
      height: 100px;
      border-radius: 5%;
    }
    .social-links a {
      margin-right: 10px;
    }
    .job-container {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      
      background-color: #f0f0f0;
      border: 1px solid #ccc;
    }
    .div {
      width: 80%;
      padding: 20px;
      margin: 10px 0;
      display: none;
      transform: translateY(20px);
      transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .div.show {
      display: flex;
      transform: translateY(0);
    }
    // .button-container {
    //   display: flex;
    //   justify-content: space-between;
    // }
    .ques{
      font-weight:bold;
      color:black;
    }
    .job_desc{
      width: 100%;
      height: 150px;
      padding: 12px 20px;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 4px;
      background-color: #f8f8f8;
      font-size: 16px;
      resize: none;
    }
    .radio-container {
      position: relative;
      display: flex;
      flex-direction: column;
      max-width: 100%;
      padding: 1rem;
  }
  .radio-label input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
  }
  .radio-button {
      font-size: 1rem;
      line-height: 1.625rem;
      display: flex;
      align-items: center;
      border-radius: 0.25rem;
      cursor: pointer;
      color: rgb(49, 49, 51);
      background-color: rgb(245, 245, 245);
      border: 1px solid rgb(223, 223, 228);
      padding: calc(2px + 0.5rem);
      font: 400 1rem / 1.5rem Inter, "Helvetica Neue", Arial, sans-serif;
      margin-bottom: 1rem;
      width: 100%;
      box-sizing: border-box;
  }
  .radio-circle {
      border-radius: 9999px;
      background-color: rgb(255, 255, 255);
      border: 1px solid rgb(190, 190, 198);
      flex-shrink: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 1.5rem;
      height: 1.5rem;
      margin-right: 1rem;
      position: relative;
  }
  .radio-circle::after {
      content: "";
      width: 0;
      height: 0;
      border-radius: 50%;
      background-color: white;
      position: absolute;
      transition: width 0.3s ease, height 0.3s ease;
  }
  .radio-content {
      flex-grow: 1;
      padding-right: 1rem;
  }
  .radio-description {
      font: 400 0.875rem / 1.25rem Inter, "Helvetica Neue", Arial, sans-serif;
      display: block;
      color: rgb(79, 79, 82);
      margin-top: 0.25rem;
  }
  .radio-label input:checked + .radio-button .radio-circle {
      background-color: rgb(0, 0, 0);
      border-color: rgb(0, 0, 0);
  }
  .radio-label input:checked + .radio-button .radio-circle::after {
      width: 0.75rem;
      height: 0.75rem;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
      .radio-button {
          font-size: 0.875rem;
          line-height: 1.25rem;
          padding: calc(2px + 0.25rem);
      }
      .radio-circle {
          width: 1.25rem;
          height: 1.25rem;
          margin-right: 0.75rem;
      }
      .radio-circle::after {
          width: 0.625rem;
          height: 0.625rem;
      }
      .radio-description {
          font-size: 0.75rem;
          line-height: 1rem;
      }
  }
  @media (max-width: 480px) {
      .radio-button {
          font-size: 0.75rem;
          line-height: 1rem;
          padding: calc(2px + 0.25rem);
      }
      .radio-circle {
          width: 1rem;
          height: 1rem;
          margin-right: 0.5rem;
      }
      .radio-circle::after {
          width: 0.5rem;
          height: 0.5rem;
      }
      .radio-description {
          font-size: 0.625rem;
          line-height: 0.875rem;
      }
      .feature-img{
        height: 85px;
      }
  }
  .btn1{
    background-color: #37F826 !important;
    color:black;
  }
    .th-btn{
    color:black !important;
}
    swiper-container {
      width: 100%;
      height: 100%;
    }

    swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    </style>
  </head>
  <body>
';
    include "include/navbar.php";
    include "include/user/dashboard.php";
    include "include/footer.php";
?>