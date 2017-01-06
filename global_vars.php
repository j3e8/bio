<?php
define('SITE_PATH', '/home/madisonavenueinc/public_html/bio');
define('DOMAIN', 'flooreight.com');
define('SECURE_URL', 'https://flooreight.com');
define('BASE_URL', '//flooreight.com');
define('AJAX_URL', '//flooreight.com');

function __autoload($class_name) {
   include 'model/' . $class_name . '.php';
}
