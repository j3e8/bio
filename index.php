<?php
	session_start();

	require('global_vars.php');
	require('controller/Controller.php');

	require('lib/db.inc');

	$page_str = '';
	if (isset($_REQUEST['page']))
		$page_str = $_REQUEST['page'];
	$page_str = preg_replace('/[^a-z0-9_\-]/i', '', $page_str);

	if ($page_str == '' && isset($_REQUEST['action']) && $_REQUEST['action'] != ''):
		include(SITE_PATH . '/ajax.php');
		exit();
	elseif ($page_str == ''):
		$page_str = 'home';
	endif;
	$_page_title = preg_replace('/[_\-]/', ' ', $page_str);

	/*$action = '';
	if (isset($_REQUEST['action']))
		$action = $_REQUEST['action'];
	if ($action != '' && $page_str == ''):
		require('ajax.php');
		exit();
	endif;*/

	//echo SITE_PATH . '/includes/' . $page_str . '.php exists? ' . file_exists(SITE_PATH . '/includes/' . $page_str . '.php<br/>');
	//echo SITE_PATH . '/view/pages/' . $page_str . '.phtml exists? ' . file_exists(SITE_PATH . '/view/pages/' . $page_str . '.phtml<br/>');
	if (!file_exists(SITE_PATH . '/includes/' . $page_str . '.php') && !file_exists(SITE_PATH . '/view/pages/' . $page_str . '.phtml')):
		$page_str = '404';
		$_page_title = 'File not found';
	endif;

	if (file_exists(SITE_PATH . '/includes/' . $page_str . '.php'))
		include(SITE_PATH . '/includes/' . $page_str . '.php');

	$_js_includes_arr = Controller::get_js_includes($page_str);
	$_css_includes_arr = Controller::get_css_includes($page_str);

	$_with_nav = Controller::should_include_nav($page_str);

	Controller::output_header($page_str);

	Controller::output_page($page_str);

	Controller::output_footer($page_str);

	require('lib/db_close.inc');
?>

