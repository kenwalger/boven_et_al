<?php include "templates/include/header.php" ?>
 
      <div id="adminHeader">
        <h2>Boven et el Admin</h2>
        <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?action=logout"?>Log out</a></p>
      </div>
 
      <h1>All Menus</h1>
 
<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
 
 
<?php if ( isset( $results['statusMessage'] ) ) { ?>
        <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>
 
      <table>
        <tr>
          <th>Publication Date</th>
          <th>Menu</th>
        </tr>
 
<?php foreach ( $results['menus'] as $menu ) { ?>
 
        <tr onclick="location='admin.php?action=editMenu&amp;menuId=<?php echo $menu->id?>'">
          <td><?php echo date('j M Y', $menu->publicationDate)?></td>
          <td>
            <?php echo $menu->title?>
          </td>
        </tr>
 
<?php } ?>
 
      </table>
 
      <p><?php echo $results['totalRows']?> menu<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>
 
      <p><a href="admin.php?action=newMenu">Add a New Menu</a></p>
 
<?php include "templates/include/footer.php" ?>