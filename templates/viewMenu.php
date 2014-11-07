<?php include "templates/include/header.php" ?>
 
      <h1 style="width: 75%;"><?php echo htmlspecialchars( $results['menu']->title )?></h1>
      <div style="width: 75%; font-style: italic;"><?php echo htmlspecialchars( $results['menu']->summary )?></div>
      <div style="width: 75%;"><?php echo $results['menu']->content?></div>
      <p class="pubDate">Published on <?php echo date('j F Y', $results['menu']->publicationDate)?></p>
 
      <p><a href="./">Return to Homepage</a></p>
 
<?php include "templates/include/footer.php" ?>