<?php
  session_start();
  
  // store to test if they *were* logged in
  unset($_SESSION['valid_user']);
  session_destroy();
  header("Location: authmain.php");
?>
