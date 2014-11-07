<?php
 
require( "config.php" );
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";
 
if ( $action != "login" && $action != "logout" && !$username ) {
  login();
  exit;
}
 
switch ( $action ) {
  case 'login':
    login();
    break;
  case 'logout':
    logout();
    break;
  case 'newArticle':
    newArticle();
    break;
  case 'editArticle':
    editArticle();
    break;
  case 'deleteArticle':
    deleteArticle();
    break;
  default:
    listArticles();
}
 
 
function login() {
 
  $results = array();
  $results['pageTitle'] = "Admin Login | Boven et al";
 
  if ( isset( $_POST['login'] ) ) {
 
    // User has posted the login form: attempt to log the user in
 
    if ( $_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD ) {
 
      // Login successful: Create a session and redirect to the admin homepage
      $_SESSION['username'] = ADMIN_USERNAME;
      header( "Location: admin.php" );
 
    } else {
 
      // Login failed: display an error message to the user
      $results['errorMessage'] = "Incorrect username or password. Please try again.";
      require( TEMPLATE_PATH . "/admin/loginForm.php" );
    }
 
  } else {
 
    // User has not posted the login form yet: display the form
    require( TEMPLATE_PATH . "/admin/loginForm.php" );
  }
 
}
 
 
function logout() {
  unset( $_SESSION['username'] );
  header( "Location: admin.php" );
}
 
 
function newMenu() {
 
  $results = array();
  $results['pageTitle'] = "New Menu";
  $results['formAction'] = "newMenu";
 
  if ( isset( $_POST['saveChanges'] ) ) {
 
    // User has posted the menu edit form: save the new menu
    $menu = new menu;
    $menu->storeFormValues( $_POST );
    $menu->insert();
    header( "Location: admin.php?status=changesSaved" );
 
  } elseif ( isset( $_POST['cancel'] ) ) {
 
    // User has cancelled their edits: return to the menu list
    header( "Location: admin.php" );
  } else {
 
    // User has not posted the menu edit form yet: display the form
    $results['menu'] = new Menu;
    require( TEMPLATE_PATH . "/admin/editMenu.php" );
  }
 
}
 
 
function editMenu() {
 
  $results = array();
  $results['pageTitle'] = "Edit Menu";
  $results['formAction'] = "editMenu";
 
  if ( isset( $_POST['saveChanges'] ) ) {
 
    // User has posted the menu edit form: save the menu changes
 
    if ( !$menu = Menu::getById( (int)$_POST['menuId'] ) ) {
      header( "Location: admin.php?error=menuNotFound" );
      return;
    }
 
    $menu->storeFormValues( $_POST );
    $menu->update();
    header( "Location: admin.php?status=changesSaved" );
 
  } elseif ( isset( $_POST['cancel'] ) ) {
 
    // User has cancelled their edits: return to the menu list
    header( "Location: admin.php" );
  } else {
 
    // User has not posted the menu edit form yet: display the form
    $results['menu'] = Menu::getById( (int)$_GET['menuId'] );
    require( TEMPLATE_PATH . "/admin/editMenu.php" );
  }
 
}
 
 
function deleteMenu() {
 
  if ( !$menu = Menu::getById( (int)$_GET['menuId'] ) ) {
    header( "Location: admin.php?error=menuNotFound" );
    return;
  }
 
  $menu->delete();
  header( "Location: admin.php?status=menuDeleted" );
}
 
 
function listMenus() {
  $results = array();
  $data = Menu::getList();
  $results['menus'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "All Menus";
 
  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "menuNotFound" ) $results['errorMessage'] = "Error: Menu not found.";
  }
 
  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "menuDeleted" ) $results['statusMessage'] = "Menu deleted.";
  }
 
  require( TEMPLATE_PATH . "/admin/listMenus.php" );
}
 
?>