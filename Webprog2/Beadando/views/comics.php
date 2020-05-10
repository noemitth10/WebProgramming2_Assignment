<?php if (!defined('INDEX')) { exit; } ?>
<?php include_once "./views/head.php" ?>
<h1 class="title-text">Comics</h1>
<?php 
    $comics = get_comic_list();
    if($comics->num_rows <= 0) : ?>
        <div>
            Nincs megjeleníthető adat.
        </div>
<?php else : ?>
        <div class="comic-placeholder">
        <?php while ($comic = $comics->fetch_assoc()) : ?>
                <?php include "comic_item.php"; ?>
            <?php endwhile; ?>
        </div>
<?php endif;  ?>

<?php include_once "./views/footer.php"?>