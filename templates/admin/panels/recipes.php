      <h1>All Recipes</h1>
       
      <?php if ( isset( $results['errorMessage'] ) ) { ?>
              <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
      <?php } ?>
       
       
      <?php if ( isset( $results['statusMessage'] ) ) { ?>
              <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
      <?php } ?>
       
            <table>
              <tr>
                <th>Publication Date</th>
                <th>Recipe</th>
              </tr>
       
      <?php foreach ( $results['recipes'] as $recipe ) { ?>
       
              <tr onclick="location='admin.php?action=editRecipe&amp;recipeId=<?php echo $recipe->recipeId?>'">
                <td><?php echo date('j M Y', $recipe->pubDate)?></td>
                <td>
                  <?php echo $recipe->title?>
                </td>
              </tr>
       
      <?php } ?>
       
            </table>
       
            <p><?php echo $results['totalRows']?> recipe<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>
       
            <p>
              <a href="admin.php?action=newRecipe">Add a New Recipe</a>
              <a href="admin.php?action=listMenus">List Menus</a>
            </p>
