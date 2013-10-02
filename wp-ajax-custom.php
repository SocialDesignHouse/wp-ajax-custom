<?php

	/* ----------------------------- --------------------------------------------------------------------------------------

		Lightweight WordPress AJAX

		Inspired by:  http://wordpress.stackexchange.com/questions/28342/is-there-a-way-to-use-the-wordpress-users-but-without-loading-the-entire-wordpre#answer-45011

		Adds two new hooks for actions:

		wp_custom_ajax_[action] and	wp_custom_ajax_nopriv_[action]

		You'll need to use the URL of the wp-ajax-custom.php file instead of the admin-ajax URL.

	----------------------------- -------------------------------------------------------------------------------------- */

	//this should be the location of your wp-load.php file
	//dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php' will point to wp-load.php from your theme's directory
	$main_dir = dirname(dirname(dirname(dirname(__FILE__))));

	//mimic admin-ajax
	define('DOING_AJAX', true);
	define('WP_ADMIN', true);

	if (!isset($_REQUEST['action'])) {
		die('-1');
	} else {
		ini_set('html_errors', 0);
		//define('SHORTINIT', true); //if you want it to load even faster and don't need certain globals, uncomment this

		//include wp-load and admin
		require_once($main_dir . '/wp-load.php');
		//require_once($main_dir . '/wp-admin/includes/admin.php'); //if you find the plugin you need to reference isn't being loaded, uncomment this but know it won't be quite as fast

		//Typical headers
		header('Content-Type: text/html');
		send_nosniff_header();

		//Disable caching
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');

		//trim any whitespace from action name
		$action = trim($_REQUEST['action']);

		//call action and exit
		if(is_user_logged_in()) {
			do_action('wp_custom_ajax_' . $action);
		} else {
			do_action ('wp_custom_ajax_nopriv_' . $action);
		}

		die(0);
	}

?>