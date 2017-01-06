<?php
 class Controller {

	public static function should_include_nav($page_str) {
		switch ($page_str):
			case 'signin':
				return false;
			case 'survey':
				return false;
		endswitch;
		
		return true;
	}
	 
  public static function get_js_includes($page_str) {
   //$js_includes_arr = array('common-1.3.0');
   $js_includes_arr = array();

	if (file_exists(SITE_PATH . '/view/js/' . $page_str . '.js')):
		$js_includes_arr[] = $page_str;
	endif;
	
	switch ($page_str):
		//case 'tasks':
		//	$js_includes_arr[] = 'tasks';
		//	break;
		default:
			break;
	endswitch;
   return $js_includes_arr;
  }

  public static function get_css_includes($page_str) {
   $css_includes_arr = array('bio');
	
	if (file_exists(SITE_PATH . '/view/css/' . $page_str . '.css')):
		$css_includes_arr[] = $page_str;
	endif;
	
	switch ($page_str):
		//case 'tasks':
		//	$css_includes_arr[] = 'tasks';
		//	break;
		default:
			break;
	endswitch;

   return $css_includes_arr;
  }

  public static function output_header($page_str) {
	include(SITE_PATH . '/view/templates/header.php');
  }

  public static function output_page($page_str) {
	if (file_exists(SITE_PATH . '/view/pages/' . $page_str . '.phtml')) {
	 include(SITE_PATH . '/view/pages/' . $page_str . '.phtml');
	}
  }

  public static function output_footer($page_str) {
	include(SITE_PATH . '/view/templates/footer.php');
  }
  
  
  public static function get_page_url($include_querystring) {
	  if (!$include_querystring) {
		$page_name = '';
		$str = $_SERVER['QUERY_STRING'];
		$args = split('&', $str);
		for ($i=0; $i<count($args); $i++) {
			$parts = split('=', $args[$i]);
			if (strtolower($parts[0]) == 'page') {
				$page_name = $parts[1];
				break;
			}
		}
		return '/?page=' . $page_name;
	  }
	  
	  return '/?' . $_SERVER['QUERY_STRING'];
  }
 }
?>
