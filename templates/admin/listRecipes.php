<?php include "templates/include/header.php" ?>
 
      <div id="adminHeader">
        <h2>Boven et el Admin</h2>
        <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?action=logout"?>Log out</a></p>
      </div>
 <div >
<!--     <ul>
      <li><a href="#menus">Menus</a></li>
      <li><a href="#recipes">Recipes</a></li>
      <li><a href="#users">Users</a></li>
    </ul>
 -->
    <div id="recipes">

        <?php include "panels/recipes.php" ?>

    </div> <!--End Menus Panel -->
        

 </div> <!-- End tabbed Panel -->

 <script>
  $(document).ready(function() {
    $('#tabbedPanel').tabs();
  });
  </script>

<?php include "templates/include/footer.php" ?>