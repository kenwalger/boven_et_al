<?php include "templates/include/header.php" ?>

    <h1>Menu Archives</h1>

    <ul id="headlines" class="archive">

<?php foreach ($results['menus'] as $menu) { ?>

    <li>
        <h2>
            <span class="pubDate"><?php echo date('j F Y', $menu->publicationDate)?></span>
                <a href=".?action=viewMenu&amp;menuId=<?php echo $menu-id?>">
                    <?php echo htmlspecialchars ($menu->title)?>
                </a>
        </h2>
        <p class="summary"><?php echo htmlspecialchars($menu->summary)?></p>
    </li>

<?php } ?>

    </ul>

    <p><?php echo $results['totalRows']?> menu<?php echo ($results['totalRows'] != 1) ? 's' : '' ?> in total.</p>

    <p><a href="./">Return to Homepage</a></p>

<?php include "templates/include/footer.php" ?>
