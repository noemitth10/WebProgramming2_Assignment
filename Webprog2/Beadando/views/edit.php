<?php if (!defined('INDEX')) { exit; } ?>
<?php include_once "./views/head.php" ?>
<?php
$errors = [];
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST["delete_btn"]) && $_POST["delete_btn"] != null){
        $sql = $db->prepare("DELETE FROM `comicbooks` WHERE `id` = ?");
        $sql->bind_param('i',$_SESSION["comic_id"]);
        $sql->execute();
        $sql->close();
        header("Location: ".url("comics"));
    }
    else{


    $title = $_POST['title'];
    $artist_w = $_POST['artist-w'];
    $artist_i = $_POST['artist-i'];
    $year = $_POST['year'];
    $desc = $_POST['desc'];

    if($title == null)
    {
        $errors['title'][] = "A cím megadása kötelező.";
    } else if(strlen($title) < 3) {
        $errors['title'][] = "A címnek legalább 3 karakternek kell lennie.";
    } else if(strlen($title) > 50) {
        $errors['title'][] = "A cím hossza maximum 50 karakter lehet.";
    }

    if($artist_w == null)
    {
        $errors['artist-w'][] = "Az író megadása kötelező.";
    } else if(strlen($artist_w) < 5) {
        $errors['artist-w'][] = "Az író neve nem lehet kisebb mint 5 karakter.";
    } else if(strlen($artist_w) > 50) {
        $errors['artist-w'][] = "Az író neve nem lehet hosszabb mint 50 karakter.";
    }

    if($artist_i == null)
    {
        $errors['artist-i'][] = "Az illusztrátor megadása kötelező.";
    } else if(strlen($artist_i) < 5) {
        $errors['artist-i'][] = "Az illusztrátor neve nem lehet kisebb mint 5 karakter.";
    } else if(strlen($artist_i) > 50) {
        $errors['artist-i'][] = "Az illusztrátor neve nem lehet hosszabb mint 50 karakter.";
    }

    $curr_year = date('Y');
    if($year == null)
    {
        $errors['year'][] = "A megjelenési dátum megadása kötelező.";
    } else if($year > $curr_year) {
        $errors['year'][] = "A megjelenési dátum nem lehet több a jelenlegi évnél.";
    } else if($year < 1900) {
        $errors['year'][] = "A megjelenési dátum nem lehet kisebb mint 1900.";
    }

     if(strlen($desc) < 5) {
        $errors['desc'][] = "A leírás szövege nem lehet rövidebb mint 5 karakter.";
    } else if(strlen($desc) > 255) {
        $errors['desc'][] = "A leírás szövege nem lehet hosszabb mint 255 karakter.";
    }

    $allow = array("jpg", "jpeg", "png");
    $dir = "covers\\";
    $cover = $_FILES['cover']['name'];
    $extension = explode(".", $cover);
    $extension = end($extension);
    $fullpath = $dir.$cover;
    if(in_array($extension, $allow) && !file_exists($fullpath))
        move_uploaded_file($_FILES['cover']['tmp_name'], $fullpath);
    else if(in_array($extension, $allow) && file_exists($fullpath)){
        $fullpath = $dir.GenerateID().$cover;
        move_uploaded_file($_FILES['cover']['tmp_name'], $fullpath);
    }

    if(count($errors) == 0)
    {
        if($fullpath == "covers\\"){
            $fullpath = $_SESSION["comic_cover"];
        }
        $sql = $db->prepare("UPDATE `comicbooks` SET `title`=?,`writer`=?,`illustrator`=?,`year`=?,`cover`=?,`desc`=?");
        $sql->bind_param("sssiss", $title, $artist_w, $artist_i, $year, $fullpath, $desc);
        $sql->execute();
        $sql->close();

        header("Location: ".url("details")."&id=".$_SESSION['comic_id']);
    }
}
}

?>

<h1 class="title-text">Upload Comic</h1>
<form action="<?php echo url('edit'); ?>" method="POST" enctype="multipart/form-data">
    <label for="title">Title</label><br>
    <input type="text" name="title" value="<?php echo (isset($title) AND $title != null) ?  $title  : $_SESSION["comic_title"] ?>"><br>
    <?php 
        if(isset($errors['title']))
        {
            foreach ($errors['title'] as $key => $value)
            {
                echo "<p class='error-text'>";
                echo $value;
                echo "</p>";
            }
        }
    ?><br>
    <label for="artist-w">Writer</label><br>
    <input type="text" name="artist-w" value="<?php echo (isset($artist_w) AND $artist_w != null) ?  $artist_w  : $_SESSION["comic_writer"] ?>"><br>
    <?php 
        if(isset($errors['artist-w']))
        {
            foreach ($errors['artist-w'] as $key => $value)
            {
                echo "<p class='error-text'>";
                echo $value;
                echo "</p>";
            }
        }
    ?><br>
    <label for="artist-i">Illustrator</label><br>
    <input type="text" name="artist-i" value="<?php echo (isset($artist_i) AND $artist_i != null) ?  $artist_i  : $_SESSION["comic_illustrator"] ?>"><br>
    <?php 
        if(isset($errors['artist-i']))
        {
            foreach ($errors['artist-i'] as $key => $value)
            {
                echo "<p class='error-text'>";
                echo $value;
                echo "</p>";
            }
        }
    ?><br>
    <label for="year">Release year</label><br>
    <input type="number" name="year" value="<?php echo (isset($year) AND $year != null) ?  $year  : $_SESSION["comic_year"] ?>"><br>
    <?php 
        if(isset($errors['year']))
        {
            foreach ($errors['year'] as $key => $value)
            {
                echo "<p class='error-text'>";
                echo $value;
                echo "</p>";
            }
        }
    ?><br>
    <label for="desc">Description</label><br>
    <textarea type="text" name="desc" ><?php echo (isset($desc) AND $desc != null) ?  $desc  : $_SESSION["comic_desc"] ?></textarea><br>
    <?php 
        if(isset($errors['desc']))
        {
            foreach ($errors['desc'] as $key => $value)
            {
                echo "<p class='error-text'>";
                echo $value;
                echo "</p>";
            }
        }
    ?><br>
    
    <label for="cover">Add Cover</label> <br>
    <img id="img" src="<?php echo $_SESSION["comic_cover"]?>" alt="Cover"><br>
    <input type ="file" name ="cover" id ="cover" onchange="loadFile(event)" accept="image/png, image/jpeg, image/jpg" /> 

    <button type="submit">Edit</button>

    <button type="submit" value ="Delete" name = "delete_btn">Delete</button>
</form>
<script>
var loadFile = function(event) {
	var image = document.getElementById('img');
	image.src = URL.createObjectURL(event.target.files[0]);
};
</script>
<?php include_once "./views/footer.php"?>