<?php include "templates/include/header.php" ?>
 
      <div id="adminHeader">
        <h2>Boven et al Admin</h2>
        <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?action=logout"?>Log out</a></p>
      </div>
 
      <h1><?php echo $results['pageTitle']?></h1>
 
      <form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
        <input type="hidden" name="recipeId" value="<?php echo $results['recipe']->recipeId ?>"/>
 
<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
 
        <ul>
 
          <li>
            <label for="title">Recipe Title</label>
            <input type="text" name="title" id="title" placeholder="Name of the Recipe" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['recipe']->title )?>" />
          </li>
 
          <li>
            <label for="category">Recipe Category</label>
            <textarea name="category" id="category" placeholder="Brief category of the recipe (appetizer, salad, entree, dessert)" required maxlength="1000" style="height: 5em;"><?php echo htmlspecialchars( $results['recipe']->category )?></textarea>
          </li>
 
          <li>
            <label for="description">Recipe Description</label>
            <textarea name="description" id="description" placeholder="The HTML description of the recipe" required maxlength="100000" style="height: 30em;"><?php echo htmlspecialchars( $results['recipe']->description )?></textarea>
          </li>

          <li>
            <label for="foodCost">Recipe Food Cost</label>
            <textarea name="foodCost" id="foodCost" placeholder="The Food Cost of the recipe" required maxlength="25" style="height: 30em;"><?php echo htmlspecialchars( $results['recipe']->foodCost )?></textarea>
          </li>

          <li>
            <label for="menuPrice">Recipe Menu Price</label>
            <textarea name="menuPrice" id="menuPrice" placeholder="The Menu Price of the recipe" required maxlength="25" style="height: 30em;"><?php echo htmlspecialchars( $results['recipe']->menuPrice )?></textarea>
          </li>
 
          <li>
            <label for="pubDate">Publication Date</label>
            <input type="date" name="pubDate" id="pubDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $results['recipe']->pubDate ? date( "Y-m-d", $results['recipe']->pubDate ) : "" ?>" />
          </li>
 
 
        </ul>
 
        <div class="buttons">
          <input type="submit" name="saveChanges" value="Save Changes" />
          <input type="submit" formnovalidate name="cancel" value="Cancel" />
        </div>
 
      </form>
 
<?php if ( $results['recipe']->recipeId ) { ?>
      <p><a href="admin.php?action=deleteRecipe&amp;recipeId=<?php echo $results['recipe']->recipeId ?>" onclick="return confirm('Delete This Recipe?')">Delete This Recipe</a></p>
<?php } ?>
 
<?php include "templates/include/footer.php" ?>