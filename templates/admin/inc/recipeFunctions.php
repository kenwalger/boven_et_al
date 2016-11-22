<?php 

function newRecipe() {
 
  $results = array();
  $results['pageTitle'] = "New Recipe";
  $results['formAction'] = "newRecipe";
 
  if ( isset( $_POST['saveChanges'] ) ) {
 
    // User has posted the menu edit form: save the new menu
    $recipe = new recipe;
    $recipe->storeFormValues( $_POST );
    $recipe->insert();
    header( "Location: admin.php?status=changesSaved" );
 
  } elseif ( isset( $_POST['cancel'] ) ) {
 
    // User has cancelled their edits: return to the recipe list
    header( "Location: admin.php" );
  } else {
 
    // User has not posted the recipe edit form yet: display the form
    $results['recipe'] = new Recipe;
    require( TEMPLATE_PATH . "/admin/editRecipe.php" );
  }
 
}
 
 
function editRecipe() {
 
  $results = array();
  $results['pageTitle'] = "Edit Recipe";
  $results['formAction'] = "editRecipe";
 
  if ( isset( $_POST['saveChanges'] ) ) {
 
    // User has posted the recipe edit form: save the recipe changes
 
    if ( !$recipe = Recipe::getById( (int)$_POST['recipeId'] ) ) {
      header( "Location: admin.php?error=recipeNotFound" );
      return;
    }
 
    $recipe->storeFormValues( $_POST );
    $recipe->update();
    header( "Location: admin.php?status=changesSaved" );
 
  } elseif ( isset( $_POST['cancel'] ) ) {
 
    // User has cancelled their edits: return to the recipe list
    header( "Location: admin.php" );
  } else {
 
    // User has not posted the recipe edit form yet: display the form
    $results['recipe'] = Recipe::getById( (int)$_GET['recipeId'] );
    require( TEMPLATE_PATH . "/admin/editMenu.php" );
  }
 
}
 
 
function deleteRecipe() {
 
  if ( !$recipe = Recipe::getById( (int)$_GET['recipeId'] ) ) {
    header( "Location: admin.php?error=recipeNotFound" );
    return;
  }
 
  $recipe->delete();
  header( "Location: admin.php?status=recipeDeleted" );
}
 
 
function listRecipes() {
  $results = array();
  $data = Recipe::getList();
  $results['recipes'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "All Recipes";
 
  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "recipeNotFound" ) $results['errorMessage'] = "Error: Recipe not found.";
  }
 
  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "recipeDeleted" ) $results['statusMessage'] = "Recipe deleted.";
  }
 
 // require( TEMPLATE_PATH . "/admin/listMenus.php" );
}

?>