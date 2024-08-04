<?php
error_reporting(0);
ob_start();
ob_clean();
date_default_timezone_set("Asia/Karachi");
session_start();

define('LMS_HOSTNAME'			, 'localhost');
define('LMS_NAME'				, 'evrenlabs_bt');
define('LMS_USERNAME'			, 'root');
define('LMS_USERPASS'			, '');

// define('LMS_HOSTNAME'			, 'localhost');
// define('LMS_NAME'				, 'u563123144_evrenlabs_bt');
// define('LMS_USERNAME'			, 'u563123144_evrenlabs_bt');
// define('LMS_USERPASS'			, '!#Ge72^Ic');

// DB Tables
define('ADMINS'					                            , 'bt_admins');
define('SELLERS'					                        , 'bt_sellers');
define('JOBS'					                            , 'bt_jobs');
define('CATEGORIES'					                        , 'bt_categories');
define('SUB_CATEGORIES'					                    , 'bt_sub_categories');
define('JOB_OPTION1'					                    , 'bt_job_option1');
define('JOB_OPTION2'					                    , 'bt_job_option2');
define('JOB_INTERESTS'					                    , 'bt_job_interests');
define('JOB_APPLICATIONS'					                , 'bt_job_applications');
define('JOB_SHORTLISTS'					                    , 'bt_shortlists');
define('JOB_PHOTOS'					                        , 'bt_job_photos');
define('VERIFICATION_QUESTIONS'					            , 'bt_verification_questions');
define('VERIFICATION_RESPONSES'					            , 'bt_verify_responses');
define('SELLER_REVIEWS'					                    , 'bt_seller_reviews');
define('SELLER_PORTFOLIO'					                , 'bt_seller_portfolio');
define('CITIES'					                            , 'bt_cities');

// Variables
$ip	  		                = (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '') ? $_SERVER['REMOTE_ADDR'] : '';
$control 	                = (isset($_REQUEST['control']) && $_REQUEST['control'] != '') ? $_REQUEST['control'] : '';
$zone 	 	                = (isset($_REQUEST['zone']) && $_REQUEST['zone'] != '') ? $_REQUEST['zone'] : '';
$view 		                = (isset($_REQUEST['view']) && $_REQUEST['view'] != '') ? $_REQUEST['view'] : '';
$slug 		                = (isset($_REQUEST['slug']) && $_REQUEST['slug'] != '') ? $_REQUEST['slug'] : '';
$flag 		                = (isset($_REQUEST['flag']) && $_REQUEST['flag'] != '') ? $_REQUEST['flag'] : '';
$page    	                = (isset($_REQUEST['page']) && $_REQUEST['page'] != '') ? $_REQUEST['page'] : '1';
$pg    		                = (isset($_REQUEST['pg']) && $_REQUEST['pg'] != '') ? $_REQUEST['pg'] : '1';
$wrds    	                = (isset($_REQUEST['wrds']) && $_REQUEST['wrds'] != '') ? $_REQUEST['wrds'] : '';
$do                         = '';
$redirection                = '';

define('LMS_IP'			    , 		$ip);
define('ZONE'			    , 		$zone);
define('CONTROLER'			, 		strtolower($control));
define('LMS_DO'			    , 		$do);
define('LMS_EPOCH'		    , 		date("U"));
define('LMS_VIEW'		    , 		$view);
define("SITE_URL"			,       "https://localhost/myphp/work/bt/");
define("SITE_URL_PORTAL"	,       "https://localhost/myphp/work/bt/");
define('TITLE_HEADER'		, 		'Builders Terminal');
define("SITE_NAME"			, 		"");
define("COPY_RIGHTS"		, 		"Builders Terminal");
define("COPY_RIGHTS_ORG"	, 		"&copy; ".date("Y")." - All Rights Reserved.");
define("COPY_RIGHTS_URL"	, 		"http://www.gptech.pk/");

// DATA API
define('YTDATAAPI'          ,       'AIzaSyB8oaZ_V4iVfPjJEkaACSJUmo4kuC1gQ78');
?>