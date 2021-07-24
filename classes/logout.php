<?php
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";  	
  }
  if (isset($_GET['logout'])) {
//  	session_destroy();
//      unset($_SESSION['user_id']);
      unset($_SESSION['username']);
      unset($_SESSION['name']);
      unset($_SESSION['shopping_cart']);
  }
?>
