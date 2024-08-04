<?php
echo '
    <div class="sidemenu-wrapper sidemenu-info">
      <div class="sidemenu-content">
        <button class="closeButton sideMenuCls">
          <i class="far fa-times"></i>
        </button>
        <div class="widget">
          <div class="th-widget-about">
            <div class="about-logo">
              <a href="home-company.html"
                ><img src="assets/img/logo.png" alt="Kotar"
              /></a>
            </div>
            <p class="about-text">
              Construction services offer tailored solutions to meet the unique
              needs and specifications of each project.
            </p>
            <div class="th-social style2">
              <a href="https://www.facebook.com/"
                ><i class="fab fa-facebook-f"></i
              ></a>
              <a href="https://www.twitter.com/"
                ><i class="fab fa-twitter"></i
              ></a>
              <a href="https://www.linkedin.com/"
                ><i class="fab fa-linkedin-in"></i
              ></a>
              <a href="https://www.whatsapp.com/"
                ><i class="fab fa-whatsapp"></i
              ></a>
            </div>
          </div>
        </div>
        <div class="widget">
          <h3 class="widget_title">Recent Posts</h3>
          <div class="recent-post-wrap">
            <div class="recent-post">
              <div class="media-img">
                <a href="blog-details.html"
                  ><img
                    src="assets/img/blog/recent-post-1-1.jpg"
                    alt="Blog Image"
                /></a>
              </div>
              <div class="media-body">
                <div class="recent-post-meta">
                  <a href="blog.html"
                    ><i class="far fa-calendar"></i>24 Feb , 2024</a
                  >
                </div>
                <h4 class="post-title">
                  <a class="text-inherit" href="blog-details.html"
                    >Where Vision Meets Concrete Reality</a
                  >
                </h4>
              </div>
            </div>
            <div class="recent-post">
              <div class="media-img">
                <a href="blog-details.html"
                  ><img
                    src="assets/img/blog/recent-post-1-2.jpg"
                    alt="Blog Image"
                /></a>
              </div>
              <div class="media-body">
                <div class="recent-post-meta">
                  <a href="blog.html"
                    ><i class="far fa-calendar"></i>22 Feb , 2024</a
                  >
                </div>
                <h4 class="post-title">
                  <a class="text-inherit" href="blog-details.html"
                    >Raising the Bar in Construction.</a
                  >
                </h4>
              </div>
            </div>
          </div>
        </div>
        <div class="widget">
          <h3 class="widget_title">Contact Us</h3>
          <div class="th-widget-about">
            <h4 class="footer-info-title">Address Location</h4>
            <p class="footer-info">
              <i class="fas fa-map-marker-alt"></i>138 MacArthur Ave, USA
            </p>
            <h4 class="footer-info-title">Phone Number</h4>
            <p class="footer-info">
              <i class="fa-sharp fa-solid fa-phone"></i
              ><a class="text-inherit" href="tel:+19524357106"
                >+1 952-435-7106</a
              >
            </p>
            <h4 class="footer-info-title">Email Address</h4>
            <p class="footer-info">
              <i class="fas fa-envelope"></i
              ><a class="text-inherit" href="mailto:info@kotar.com"
                >info@kotar.com</a
              >
            </p>
          </div>
        </div>
      </div>
    </div>

    
    <div class="th-menu-wrapper">
      <div class="th-menu-area text-center">
        <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
        <div class="mobile-logo">
          <a href="dashboard.php"
            ><img src="assets/img/logo.png" style="width:60%" alt="Builders Terminal"/></a>
        </div>
        <div class="th-mobile-menu">
          <ul>
            <li class=""><a href="job_post.php">Post a Job</a></li>';
                        if(!isset($_SESSION['userlogininfo'])){
                          echo '<li class=""><a href="login.php">Login</a></li>';
                        }
                        if($_SESSION['userlogininfo']['LOGINTYPE']==1){
                          echo'<li class=""><a href="seller_applications.php">Applications</a></li>';
                        }
                        if($_SESSION['userlogininfo']['LOGINTYPE']==2){
                          echo'<li class=""><a href="leads.php">Leads</a></li>';
                        }
                        if($_SESSION['userlogininfo']['LOGINTYPE']==3){
                        echo'
                        <li class=""><a href="my_jobs.php">My Jobs</a></li>
                        <li class=""><a href="jobs_response.php">Responses</a></li>
                        <li class=""><a href="job_shortlisted.php">Shortlisted</a></li>
                        ';
                        }
                        if($_SESSION['userlogininfo']['LOGINTYPE']==2){
                          echo'
                        <li class=""><a href="interests.php">Interested</a></li>
                        <li class=""><a href="shortlisted.php">Contacts</a></li>
                        ';
                        }
                        if(isset($_SESSION['userlogininfo'])){
                          echo'
                          <li class="menu-item-has-children">
                            <a href="#">My Account</a>
                            <ul class="sub-menu">';
                            if(isset($_SESSION['userlogininfo'])){
                              echo'
                              <li><a href="profile.php">Profile</a></li>';
                              if($_SESSION['userlogininfo']['SELLERSTATUS']==2){
                              echo'<li><a class="text-primary" href="seller_verification.php">Account Verification</a></li>';
                              }
                              echo'
                              <li><a href="dashboard.php?logout_user">Logout</a></li>
                              ';
                            }
                        }
              echo'
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    
    <!-- Header -->
    <header class="th-header header-layout2">
        <div class="header_top" style="text-align: center; background-color: #37F826;">
          <div class="container th-container">
            <div class="row p-2">
              <p class="m-0 text-dark fw-medium">Are you a tradesperson looking for leads? <b><a class="text-dark" href="seller_signup.php" >Join for free</a> </b></p>
            </div>
          </div>
        </div>
        <div class="sticky-wrapper">
          <div class="container th-container">
            <div class="menu-area">
              <div class="row align-items-center justify-content-between">
                <div class="col-auto" style="width: 35%;">
                  <div class="web-logo">
                    <a href="dashboard.php">
                      <img id="web-logo main_logo" src="assets/img/logo.png" style="height:50px;" alt="Builders Terminal"/>
                    </a>
                  </div>
                </div>
                <div class="col-auto d-flex p-0">
                  <div class="">
                    <nav class="main-menu d-none d-lg-inline-block">
                      <ul>';
                      if($_SESSION['userlogininfo']['LOGINTYPE']!=2){
                        echo'<li class=""><a href="job_post.php">Post a Job</a></li>';
                      }
                        if(!isset($_SESSION['userlogininfo'])){
                          echo '<li class=""><a href="login.php">Login</a></li>';
                        }
                        if($_SESSION['userlogininfo']['LOGINTYPE']==1){
                          echo'<li class=""><a href="seller_applications.php">Applications</a></li>';
                        }
                        if($_SESSION['userlogininfo']['LOGINTYPE']==2){
                          echo'<li class=""><a href="leads.php">Leads</a></li>';
                        }
                        if($_SESSION['userlogininfo']['LOGINTYPE']==3){
                        echo'
                        <li class="mx-2"><a href="my_jobs.php">My Jobs</a></li>
                        <li class="mx-2"><a href="jobs_response.php">Responses</a></li>
                        <li class="mx-2"><a href="job_shortlisted.php">Shortlisted</a></li>
                        ';
                        }
                        if($_SESSION['userlogininfo']['LOGINTYPE']==2){
                          echo'
                        <li class="mx-2"><a href="interests.php">Interested</a></li>
                        <li class="mx-2"><a href="shortlisted.php">Contacts</a></li>
                        ';
                        }
                          if(isset($_SESSION['userlogininfo'])){
                            echo'
                            <li class="menu-item-has-children">
                              <a href="#">My Account</a>
                              <ul class="sub-menu">';
                              if(isset($_SESSION['userlogininfo'])){
                                echo'
                                <li><a href="profile.php">Profile</a></li>';
                                if($_SESSION['userlogininfo']['SELLERSTATUS']==2){
                                echo'<li><a class="text-primary" href="seller_verification.php">Account Verification</a></li>';
                                }
                                echo'
                                <li><a href="dashboard.php?logout_user">Logout</a></li>
                                ';
                              }
                          }
                          echo'
                          </ul>
                        </li>
                      </ul>
                    </nav>
                    <button type="button" class="th-menu-toggle d-block d-lg-none">
                      <i class="fa-solid fa-bars fa-fw"></i>
                    </button>
                  </div>';
                  if(!isset($_SESSION['userlogininfo'])){
                  echo'
                  <div class="col-auto d-none d-xl-block px-3">
                    <div class="header-button">
                      <a href="seller_signup.php" class="th-btn th-icon"
                        >Tradesperson Sign Up<i class="fa-regular fa-arrow-right ms-2"></i
                      ></a>
                    </div>
                  </div>';
                  }
                  echo'
                </div>
              </div>
            </div>
          </div>
        </div>
    </header>
';
?>