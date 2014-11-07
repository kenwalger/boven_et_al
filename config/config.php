<?php
ini_set("display_errors", true); // set to false for production server
date_default_timezone_set("America/Los_Angeles");  // http://www.php.net/manual/en/timezones.php
define("DB_DBN", "mysql:host=localhost;dbname=boven");
define("DB_USERNAME", "admin");
define("DB_PASSWORD", md5("admin"));
define("CLASS_PATH", "classes");
define("TEMPLATE_PATH", "templates");
define("HOMEPAGE_NUM_MENUS", 1); // set to change number of menus on home 
define("ADMIN_USERNAME", "admin");
define("ADMIN_PASSWORD", md5("admin"));
require ( CLASS_PATH . "/menu.php");

function handleException ($exception) {
    echo "Sorry, a problem occurred. Please try later.";
    error_log( $exception->getMessage());
}

set_exception_handler('handleException');
?>