<?php unset($_SESSION['logged']);
      unset($_SESSION['user_userId']);
      unset($_SESSION['user_username']);
      unset($_SESSION['logged']);
    header("Location:".url("home"));
?>