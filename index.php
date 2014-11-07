<?php

require("config.php");
$action = isset($_GET['action']) ? $_GET['action'] : "";

switch ($action) {
    case 'archive':
        archive();
        break;
    case 'viewMenu':
        viewMenu();
        break;
    default:
        homepage();
}

function archive() {
  $results = array();
  $data = Menu::getList();
  $results['articles'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Menu Archive | Widget News";
  require( TEMPLATE_PATH . "/menu.php" );
}

function viewMenu() {
    if ( !isset($_GET["menuId"]) || !$_GET["menuId"] ) {
        homepage();
        return;
    }

    $results = array();
    $results['menu'] = Menu::getById((int)$_GET["menuId"]);
    $results['pageTitle'] = $results['menu']->title. " | Boven et al";
    require( TEMPLATE_PATH . "/viewMenu.php");
}

function homepage() {
    $results = array();
    $data = Menu::getList (HOMEPAGE_NUM_MENUS);
    $results['menus'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Boven et al Menu";
    require( TEMPLATE_PATH . "/homepage.php");
}


?>