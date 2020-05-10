<?php if (!defined('INDEX')) { exit; } ?>
<?php
    if (!isset($_GET['id'])) {
        url('404');
    }

    $comic = get_comic_by_id($_GET['id']);
    if ($comic == null) {
        url('404');
    }
    $_SESSION["comic_id"] = $comic["id"];
    $_SESSION["comic_title"] = $comic["title"];
    $_SESSION["comic_writer"] = $comic["writer"];
    $_SESSION["comic_illustrator"] = $comic["illustrator"];
    $_SESSION["comic_year"] = $comic["year"];
    $_SESSION["comic_cover"] = $comic["cover"];
    $_SESSION["comic_desc"] = $comic["desc"];
    $_SESSION["comic_userId"] = $comic["userId"];

?>
<?php include_once "head.php"; ?>
<h1 class="title-text"><?php echo $comic['title']; ?></h1>
<div class="page-details">
    <div class="comicimg">
    <?php if($comic['cover']) : ?>
            <img src="<?=$comic['cover']?>" alt="<?php echo $comic['title']; ?>">
        <?php else : ?>
            <img src="https://via.placeholder.com/300" alt="<?php echo $comic['title']; ?>">
        <?php endif; ?>
    </div>
    <div class="comictext">
    <p style="text-decoration: underline;">Writer</p>
    <p><?php echo $comic['writer']; ?></p>
    <p style="text-decoration: underline;">Illustrator</p>
    <p><?php echo $comic['illustrator']; ?></p>
    <p style="text-decoration: underline;">Release year</p>
    <p><?php echo $comic['year']; ?></p>
    <p style="text-decoration: underline;">Description</p>
    <p><?php echo $comic['desc']; ?></p>
    </div>
</div>

<?php if( isset($_SESSION["user_userId"]) AND $comic['userId'] == $_SESSION["user_userId"])  : ?>
        <button id = "edit" onclick="redirect()">edit</button>
    <?php endif; ?>

<script>    
function redirect(){
    window.location.href = "http://localhost:8080/Beadando/?p=edit";
}
</script>
<?php include_once "footer.php"; ?>