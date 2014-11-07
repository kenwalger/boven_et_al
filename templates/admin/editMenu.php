<?php include "templates/include/header.php" ?>
 
      <div id="adminHeader">
        <h2>Boven et al Admin</h2>
        <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?action=logout"?>Log out</a></p>
      </div>
 
      <h1><?php echo $results['pageTitle']?></h1>
 
      <form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
        <input type="hidden" name="menuId" value="<?php echo $results['menu']->id ?>"/>
 
<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
 
        <ul>
 
          <li>
            <label for="title">Menu Title</label>
            <input type="text" name="title" id="title" placeholder="Name of the menu" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['menu']->title )?>" />
          </li>
 
          <li>
            <label for="summary">Menu Summary</label>
            <textarea name="summary" id="summary" placeholder="Brief description of the menu" required maxlength="1000" style="height: 5em;"><?php echo htmlspecialchars( $results['menu']->summary )?></textarea>
          </li>
 
          <li>
            <label for="content">Menu Content</label>
            <textarea name="content" id="content" placeholder="The HTML content of the menu" required maxlength="100000" style="height: 30em;"><?php echo htmlspecialchars( $results['menu']->content )?></textarea>
          </li>
 
          <li>
            <label for="publicationDate">Publication Date</label>
            <input type="date" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $results['menu']->publicationDate ? date( "Y-m-d", $results['menu']->publicationDate ) : "" ?>" />
          </li>
 
 
        </ul>
 
        <div class="buttons">
          <input type="submit" name="saveChanges" value="Save Changes" />
          <input type="submit" formnovalidate name="cancel" value="Cancel" />
        </div>
 
      </form>
 
<?php if ( $results['menu']->id ) { ?>
      <p><a href="admin.php?action=deleteMenu&amp;menuId=<?php echo $results['menu']->id ?>" onclick="return confirm('Delete This Menu?')">Delete This Menu</a></p>
<?php } ?>
 
<?php include "templates/include/footer.php" ?>