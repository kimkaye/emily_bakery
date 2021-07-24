<?php
require_once('../classes/init.php');
global $session;
$info ="";

if (isset($_POST["pwd"]) &&
    isset($_POST["pwd2"])
){
    $user_id = $session->get_user_id();
    $password = $_POST['pwd'];
    $passwordRepeated = $_POST['pwd2'];
    if (empty($password) || empty($passwordRepeated)){
        header("Location: ../includes/profile.php?pwdcherror=emptyfields&user_id=".$user_id);
        exit();
    }elseif ($password != $passwordRepeated){
        header("Location: ../includes/profile.php?pwdcherror=passwordcheck&user_id=".$user_id);
        exit();
    }
    else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $ok = User::change_password($user_id,$hashed_password);
        if($ok){
            header("Location: ../includes/profile.php?pwdch=success&user_id=".$user_id);
            exit();
        }
        else{
            header("Location: ../includes/profile.php?pwdcherror=sqlerror&user_id=".$user_id);
            exit();

        }
    }



}





if (isset($_POST["delivery_time"]) && isset($_POST["delivery_date"])){
    $delivery_time = $_POST["delivery_time"];
    $delivery_date = $_POST["delivery_date"];
    $available = order::check_if_delivery_time_available($delivery_date, $delivery_time);
    if ($available){
        $info = "<h2 style='color: #2b772e'>זמן המשלוח זמין!</h2>";
    }else{
        $info = "<h2 style='color: #a94442'>זמן המשלוח לא זמין!</h2>";
    }

}
echo $info;
?>