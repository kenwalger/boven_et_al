<?php include "templates/include/header.php" ?>

    <ul id="headlines">

<?php foreach ( $results['menus'] as $menu ) { ?>

    <li>
        <h2>
            <span class="pubDate"><?php echo date('j F', $menu->publicationDate)?></span>
                <a href=".?action=viewArticle&amp;menuId=<?php echo $menu->id?>">
                    <?php echo htmlspecialchars( $menu->title)?>
                </a>
        </h2>
        <p class="summary"><?php echo htmlspecialchars( $menu->summary)?></p>
    </li>
<?php } ?>
    
    </ul>

    <p><a href="./?action=archive">Menu Archive</a></p>

<?php include "templates/include/footer.php" ?>