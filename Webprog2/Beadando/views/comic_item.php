<?php if (!defined('INDEX')) { exit; } ?>
<?php
    $url = url2('details', ['id' => $comic['id']]);
?>

<div class="comic">
    <a href="<?php echo $url; ?>">
        <?php if($comic['cover']) : ?>
            <img src="<?=$comic['cover']?>" alt="<?php echo $comic['title']; ?>">
        <?php else : ?>
            <img src="https://via.placeholder.com/300" alt="<?php echo $comic['title']; ?>">
        <?php endif; ?>
    </a>
    <p class="comic-title" title="<?php echo $comic['title']; ?>">
        <a href="<?php echo $url; ?>">
            <?php echo $comic['title']; ?>
        </a>
    </p>
    <p>
        <?php echo $comic['writer']; ?> (<?php echo $comic['year']; ?>)
    </p>

   
</div>
