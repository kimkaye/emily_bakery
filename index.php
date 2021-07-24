<?php
if(isset($_GET['session'])){
  $session_id = $_GET['session'];
  session_id($session_id);
}
require_once('classes/init.php');

header("Location: includes/home.php?page=./recipes.php");
exit();
?>
