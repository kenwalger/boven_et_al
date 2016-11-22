<?php
ini_set("display_errors", true);        // set to false for production server
date_default_timezone_set("America/Los_Angeles");  // http://www.php.net/manual/en/timezones.php
define("DB_DBN", "mysql:host=localhost;dbname=boven");
define("DB_USERNAME", "admin");
define("DB_PASSWORD", "admin");
define("CLASS_PATH", "classes");
define("TEMPLATE_PATH", "templates");
define("HOMEPAGE_NUM_MENUS", 5);        // set to change number of menus on home 
define("ADMIN_USERNAME", "admin");
define("ADMIN_PASSWORD", "admin");
require ( CLASS_PATH . "/menu.php");
require ( CLASS_PATH . "/recipes.php");

function handleException ($exception) {
    echo "Sorry, a problem occurred connecting to the database. Please try later.";
    echo ($exception->getMessage());
    error_log( $exception->getMessage());
}

set_exception_handler('handleException');
?>