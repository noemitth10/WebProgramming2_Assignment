<?php if (!defined('INDEX')) { exit; } ?>
<?php include_once "./views/head.php" ?>
<?php

$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $birth_date = $_POST['birth_date'];
    $registration_day = date("Y/m/d");
    $profile_pic = "none";

    if($email == null)
    {
        $errors['email'][] = "Az email megadása kötelező.";
    } else if (!validate_email($email)) {
        $errors['email'][] = "Az email formailag helytelen";
    } else {
         //Email létezik e már az adatbázisban.
        $emails = $db->prepare("SELECT `email` FROM users");
        $emails->execute();
        $takenEmails = $emails->get_result();
        foreach($takenEmails as $row) 
            if($row['email'] == $email)
                $errors['email'][] = 'Az email már foglalt.';
    }

    if($password == null) {
        $errors['password'][] = "A jelszó megadása kötelező.";
    } else if(strlen($password) < 6) {
        $errors['password'][] = "A jelszónak legalább 6 karakter hosszúnak kell lennie.";
    } else if(!(preg_match('~[0-9]~', $password))) {
        $errors['password'][] = "A jelszónak legalább 1 számot tartalmaznia kell.";
    }  else if(!(preg_match('~[A-Z]~', $password))) {
        $errors['password'][] = "A jelszónak legalább 1 nagy betűt tartalmaznia kell.";
    }

    if($username == null) {
        $errors['username'][] = 'A felhasználónév megadása kötelező.';
    } else if(strpos($username,"@")) {
        $errors['username'][] = 'A felhasználónév nem tartalmazhat @ karaktert.';
    } else if(strlen($username) < 6) {
        $errors['username'][] = 'A felhasználónévnek legalább 6 karkater hosszúnak kell lennie.';
    } else if(strlen($username) > 25) {
        $errors['username'][] = 'A felhasználónév nem lehet hosszabb mint 25 karakter.';
    } else {
        $sql = $db->prepare("SELECT `username` FROM users");
        $sql->execute();
        $userNames = $sql->get_result();
        foreach($userNames as $row)
            if($row['username'] == $username)
                $errors['username'][] = 'A kiválasztott felhasználónév már foglalt.';
    }

    if($fullname == null) {
        $errors['fullname'][] = "Név megadása kötelező.";
    } else if (strlen($fullname) > 20) {
        $errors['fullname'][] = 'A név nem lehet hosszabb mint 20 karakter.';
    } else if (strlen($fullname) < 5) {
        $errors['fullname'][] = 'A név nem lehet rövidebb mint 5 karakter.';
    }

    $curr_year = date('Y');
    $birth_year = date('Y', strtotime($birth_date));
    if($birth_date == null)
    {
        $errors['birth_date'][] = "A születési dátum megadása kötelező.";
    } else if($birth_date > $curr_year) {
        $errors['birth_date'][] = "A születési dátum nem lehet több a jelenlegi évnél.";
    } else if(($curr_year - $birth_year < 18)) {
        $errors['birth_date'][] = "Csak akkor regisztrálhat ha elmúlt 18 éves.";
    }



    if(count($errors) == 0)
    {
        $pw = password_hash($password,PASSWORD_DEFAULT);
        $sql = $db->prepare("INSERT INTO `users`(`username`, `email`, `fullname`, `birth_date`, `registration_date`, `password`, `profile_pic`) VALUES (?,?,?,?,?,?,?)");
        $sql->bind_param("sssssss", $username, $email, $fullname, $birth_date, $registration_day, $pw, $profile_pic);
        $sql->execute();
        $sql->close();
    }
}
?>

<h1 class="title-text">Registration</h1>
<form action="<?php echo url('registration'); ?>" method="POST">

    <label for="email">Email</label><br>
    <input type="text" name="email" value="<?php echo (isset($email) AND $email != null) ?  $email  : "" ?>"><br>
    <?php 
        if(isset($errors['email']))
        {
            foreach ($errors['email'] as $key => $value)
            {
                echo "<p class='error-text'>";
                echo $value;
                echo "</p>";
            }
        }
    ?><br>
    <label for="password">Password</label><br>
    <input type="password" name="password"><br>
    <?php 
        if(isset($errors['password']))
        {
            foreach ($errors['password'] as $key => $value)
            {
                echo "<p class='error-text'>";
                echo $value;
                echo "</p>";
            }
        }
    ?><br>
    <label for="username">User name</label><br>
    <input type="text" name="username" value="<?php echo (isset($username) AND $username != null) ?  $username  : "" ?>"><br>
    <?php 
        if(isset($errors['username']))
        {
            foreach ($errors['username'] as $key => $value)
            {
                echo "<p class='error-text'>";
                echo $value;
                echo "</p>";
            }
        }
    ?><br>
    <label for="fullname">Full name</label><br>
    <input type="text" name="fullname" value="<?php echo (isset($fullname) AND $fullname != null) ?  $fullname  : "" ?>"><br>
    <?php 
        if(isset($errors['fullname']))
        {
            foreach ($errors['fullname'] as $key => $value)
            {
                echo "<p class='error-text'>";
                echo $value;
                echo "</p>";
            }
        }
    ?><br>
    <label for="birth_date">Birth date</label><br>
    <input type="date" name="birth_date" value="<?php echo (isset($birth_date) AND $birth_date != null) ?  $birth_date  : "" ?>"><br>
    <?php 
        if(isset($errors['birth_date']))
        {
            foreach ($errors['birth_date'] as $key => $value)
            {
                echo "<p class='error-text'>";
                echo $value;
                echo "</p>";
            }
        }
    ?><br>
    <button type="submit">Register</button>
</form>


<?php include_once "./views/footer.php"?>