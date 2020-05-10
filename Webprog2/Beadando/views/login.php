<?php include_once "./views/head.php" ?>
<?php 
$errors = [];
if($_SERVER['REQUEST_METHOD'] == "POST"){

    $username = $_POST['username'];
    $pw = $_POST['pw'];

    //User name
    if($username == null) {
        $errors['username'][] = 'A felhasználónév megadása kötelező.';
    } else if(strpos($username,"@")) {
        $errors['username'][] = 'A felhasználónév nem tartalmazhat @ karaktert.';
    } else if(strlen($username) < 6) {
        $errors['username'][] = 'A felhasználónévnek legalább 6 karkater hosszúnak kell lennie.';
    } else if(strlen($username) > 25) {
        $errors['username'][] = 'A felhasználónév nem lehet hosszabb mint 25 karakter.';
    }

    

    $dbpw = $db->prepare("SELECT `password` FROM `users` WHERE `username` = ?");
    $dbpw->bind_param('s',$username);
    $dbpw->execute();
    $result = $dbpw->get_result();
    
    foreach ($result as $key => $value) {
        $actual_result = $value['password'];
     }
    if(!password_verify($pw,$actual_result)){
        $errors['pw'][] = "Invalid password";
    }

    if(count($errors) == 0){
        $user = $db->prepare("SELECT * FROM `users` WHERE `username` = ?");
        $user->bind_param('s',$username);
        $user->execute();

        $result = $user->get_result();


        foreach ($result as $key => $value) {
            $_SESSION['user_userId'] = $value['userId'];
            $_SESSION['user_username'] = $value['username'];
            $_SESSION['logged'] = 1;
        }
           
    
        
        header("Location:".url('home'));
    }
}


?>
<h1 class="title-text">Login</h1>
<div class="login-form">
    <form action ="<?php echo url('login'); ?>" method ="POST" autocomplete="off">
        <label for="username">User Name</label><br>
        <input type ="text" name ="username" value = "<?php echo isset($username) ? $username : '' ?>"> <br>
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
        <label for="pw">Password</label><br>
        <input type ="password" name ="pw"><br>
        <?php 
        if(isset($errors['pw']))
        {
            foreach ($errors['pw'] as $key => $value)
            {
                echo "<p class='error-text'>";
                echo $value;
                echo "</p>";
            }
        }
    ?><br>
        <button type="submit">Login</button>
    </form>
    </div>
<?php include_once "./views/footer.php"?>