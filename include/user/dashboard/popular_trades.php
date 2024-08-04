<?php
include "../dbsetting/classdbconection.php";
include "../dbsetting/lms_vars_config.php";
include "../functions/functions.php";
$dblms = new dblms();

$condition = array(
  'select' => "cat_id, cat_name, cat_icon",
  'where' => array(
    'cat_status' => '1'
  ),
  'return_type' => 'all'
);
$CATEGORIES = $dblms->getRows(CATEGORIES, $condition);

echo '
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <div class="p-md-3 p-1 my-3">
    <h3 class="p-md-3 p-1">Popular Trades</h3>
  <swiper-container class="mySwiper" loop="true" breakpoints=\'{
    "320": {
      "slidesPerView": 1,
      "spaceBetween": 10
    },
    "480": {
      "slidesPerView": 2,
      "spaceBetween": 10
    },
    "768": {
      "slidesPerView": 3,
      "spaceBetween": 10
    },
    "1024": {
      "slidesPerView": 4,
      "spaceBetween": 10
    }
  }\'>
';

foreach ($CATEGORIES as $key => $value) {
  echo '
    <swiper-slide class="">
      <div class="card align-items-center p-3" style="width: 18rem;">
        <img src="assets/img/icon/cat_icons/'.$value['cat_icon'].'" style="width:70px;" class="card-img-top" alt="...">
        <div class="card-body">
          <span class="card-title m-2 d-block">'.$value['cat_name'].'</span>
          <a href="find_trades.php?catid='.$value['cat_id'].'" class="btn btn1">Find Tradesperson</a>
        </div>
      </div>
    </swiper-slide>';
}

echo '
  </swiper-container>
  </div>
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".mySwiper", {
      loop: true,
      breakpoints: {
        320: {
          slidesPerView: 1
        },
        480: {
          slidesPerView: 2
        },
        768: {
          slidesPerView: 3
        },
        1024: {
          slidesPerView: 4
        }
      }
    });
  </script>
';
?>
