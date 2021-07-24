<?php
require_once('../classes/init.php');
global $session;
$json = array();

if (!isset($_POST["username"])){
    $info = "Username is required";
}elseif (!isset($_POST["password"])){
    $info = "Password is required";
}else{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $new_user = new User();
    $found_user = $new_user->find_user_by_username($username);
    if ($found_user != null) {
        if (password_verify($password, $found_user->password)) {
            $session->login($found_user);
            $json['login_status'] = true;
            $json['info'] = "התחברות מוצלחת!";
            $json['user_id'] = $found_user->get_id();
        } else {
            $json['login_status'] = false;
            $json['info'] = "שם המשתמש או הסיסמה אינם תקינים";
        }
    } else {
        $json['login_status'] = false;
        $json['info'] = "שם המשתמש או הסיסמה אינם תקינים";
    }
}
$jsonstring = json_encode($json, JSON_UNESCAPED_UNICODE);
echo $jsonstring;
?>
