<?php
echo '
<footer class="footer-wrapper bg-title footer-layout3">
      <div class="container">
        <div class="widget-area">
          <div class="container">
            <div class="row justify-content-between">

              <div class="col-md-6 col-lg-3">
                <div class="widget footer-widget">
                  <div class="th-widget-about">
                    <div class="about-logo">
                      <a href="dashboard.php"
                        ><img src="assets/img/logo-light.png" alt="Builders Terminal"
                      /></a>
                    </div>
                    <p class="about-text">
                      Construction services offer tailored solutions to meet the
                      unique needs and specifications of each project.
                    </p>
                    <div class="th-social style2">
                      <a href="https://www.facebook.com/buildersterminal035"
                        ><i class="fab fa-facebook-f"></i
                      ></a>';
                      /*echo'
                      <a href="https://www.twitter.com/"
                        ><i class="fab fa-twitter"></i
                      ></a>';*/
                      echo'
                      <a href="https://www.pinterest.co.uk/buildersterminal035/">
                        <i class="fa-brands fa-pinterest"></i>
                      </a>
                      <a href="https://www.youtube.com/channel/UCU_b_R09Ab2dZLy9TUx_7tQ"
                        ><i class="fab fa-youtube"></i
                      ></a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-auto">
                <div class="widget widget_nav_menu footer-widget">
                  <h3 class="widget_title">Useful Links</h3>
                  <div class="menu-all-pages-container">
                    <ul class="menu">
                    <li><a href="about_us.php">About us</a></li>
                      <li><a href="job_post.php">Post a Job</a></li>
                      <li><a href="how_it_works.php">How it Works</a></li>
                      <li><a href="find_trades.php">Find Trades</a></li>
                      <li><a href="cities.php">Cities</a></li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-auto">
                <div class="widget widget_nav_menu footer-widget">
                  <h3 class="widget_title">Our Services</h3>
                  <div class="menu-all-pages-container">
                    <ul class="menu">
                      <li><a href="seller_signup.php">Register as tradesperson</a></li>
                      <li><a href="quality_standards.php">Quality requirements</a></li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-auto">
                <div class="widget widget_nav_menu footer-widget">
                  <h3 class="widget_title">Categories</h3>
                  <div class="menu-all-pages-container">
                    <ul class="menu">
                      <li><a href="find_trades.php?catid=2">Batroom Fitting</a></li>
                      <li><a href="find_trades.php?catid=5">Carpets, Lino & Flooring</a></li>
                      <li><a href="find_trades.php?catid=13">Electrical</a></li>
                      <li><a href="find_trades.php">More...</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-auto">
                <div class="widget widget_nav_menu footer-widget">
                  <h3 class="widget_title">Cities</h3>
                  <div class="menu-all-pages-container">
                    <ul class="menu">
                      <li><a href="cities.php?city=Manchester">Manchester</a></li>
                      <li><a href="cities.php?city=Liverpool">Liverpool</a></li>
                      <li><a href="cities.php?city=Newcastle Upon Tyne">Newcastle Upon Tyne</a></li>
                      <li><a href="cities.php">More...</a></li>
                    </ul>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
      <div class="flinks_container my-2">
        <a class="f-link mx-3" href="privacy_policy.php">Privacy</a>
        <a class="f-link mx-3" href="cookies.php">Cookies</a>
        <a class="f-link mx-3" href="terms.php">Terms and conditions</a>
      </div>
      <div class="copyright-wrap text-center">
        <p class="copyright-text">Developed by <a target="_blank" href="https://nextonsoft.com/">NextOn Soft</a>. <i class="fal fa-copyright"></i> 2024 
          <a href="dashboard.php">Builders Terminal Limited</a>. All Rights Reserved.
        </p>
      </div>
    </footer>';
    echo'
    <!-- Button for Scrool to Top -->
    <div class="scroll-top">
      <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style=" transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
      </svg>
    </div>';
    echo'
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
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
                $("#submit_button_container").show();

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
    
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/gsap.min.js"></script>
    <script src="assets/js/ScrollTrigger.min.js"></script>
    <script src="assets/js/circle-progress.js"></script>
    <script src="assets/js/nice-select.min.js"></script>
    <script src="assets/js/smooth-scroll.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
';
?>