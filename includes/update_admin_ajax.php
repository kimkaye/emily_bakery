<?php
require_once('../classes/init.php');
global $session;
$info ="ok";

if (!isset($_POST["user_id"])){
    throw new Error("missing user id");
}elseif (!isset($_POST["is_admin"])){
    throw new Error("missing is_admin");
}else{
    $user_id = $_POST["user_id"];
    $is_admin = $_POST["is_admin"];
    $is_admin = $is_admin=="true"? 1: 0;
    $new_user = new User();
    $found_user = $new_user->find_user_by_id($user_id);
    if ($found_user != null) {
        $found_user->set_is_admin($is_admin);
        $found_user->update_user();
    } else {
        throw new Error("error");
    }
}
echo $info;
?>
