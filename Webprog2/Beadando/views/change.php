<?php if (!defined('INDEX')) { exit; } ?>
<?php include_once "./views/head.php" ?>
<?php
$errors = [];
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
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
        $sql = $db->prepare("INSERT INTO `comicbooks` (`title`, `writer`, `illustrator`, `year`, `cover`, `desc`) VALUES (?,?,?,?,?,?)");
        $sql->bind_param("sssiss", $title, $artist_w, $artist_i, $year, $fullpath, $desc);
        $sql->execute();
        $sql->close();
    }
}

?>

<h1 class="title-text">Upload Comic</h1>
<form action="<?php echo url('upload'); ?>" method="POST" enctype="multipart/form-data">
    <label for="title">Title</label><br>
    <input type="text" name="title" value="<?php echo (isset($title) AND $title != null) ?  $title  : "" ?>"><br>
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
    <input type="text" name="artist-w" value="<?php echo (isset($artist_w) AND $artist_w != null) ?  $artist_w  : "" ?>"><br>
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
    <input type="text" name="artist-i" value="<?php echo (isset($artist_i) AND $artist_i != null) ?  $artist_i  : "" ?>"><br>
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
    <input type="number" name="year" value="<?php echo (isset($year) AND $year != null) ?  $year  : "" ?>"><br>
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
    <textarea type="text" name="desc" value="<?php echo (isset($desc) AND $desc != null) ?  $desc  : "" ?>"></textarea><br>
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
    <img id="img" src="https://via.placeholder.com/300" alt="Cover"><br>
    <input type ="file" name ="cover" id ="cover" onchange="loadFile(event)" accept="image/png, image/jpeg, image/jpg" /> 

    <button type="submit">Upload</button>
</form>

<?php include_once "./views/footer.php"?>