<?php include "templates/include/header.php" ?>
 
      <div id="adminHeader">
        <h2>Boven et el Admin</h2>
        <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?action=logout"?>Log out</a></p>
      </div>


        <?php include "panels/menus.php" ?>




 <script>
  $(document).ready(function() {
    $('#tabbedPanel').tabs();
  });
  </script>

<?php include "templates/include/footer.php" ?>