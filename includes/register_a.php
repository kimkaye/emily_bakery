<?php
require_once('../classes/init.php');
require_once('../includes/header.php');
global $session;

if (isset($_POST['reg_user'])){
    if(isset($_POST["user_name"]) && isset($_POST["password"])){
        $username=$_POST["user_name"];
        $password=$_POST["password"];
        $name=$_POST["name"];
        $id = $_POST["id"];
        $email=$_POST["email"];
        $phone=$_POST["phone"];
        $birth_year=$_POST["birth_year"];
        $emailRegEx = "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/";
        $username_exists=User::check_if_username_exists($username);
        if ($username_exists){
            header("Location: ../includes/register.php?signerror=invalidusername&username=".$username);
            exit();
        }
        $email_exists=User::check_if_email_exists($email);
        if ($email_exists){
            header("Location: ../includes/register.php?signerror=mailexists&mail=".$email);
            exit();
        }
        if (empty($name)) {
            header("Location: ../includes/register.php?signerror=invalidname&name=".$name);
            exit();
        }
        if(!preg_match($emailRegEx, $email)){
            header("Location: ../includes/register.php?signerror=invalidmailformat&mail=".$email);
            exit();
        }
        $user_id_exists=User::check_if_user_exists_by_id($id);
        if ($user_id_exists){
            header("Location: ../includes/register.php?signerror=duplicateid&id=".$id);
            exit();
        }
        if(!is_numeric($id)){
            header("Location: ../includes/register.php?signerror=invalidid&id=".$id);
            exit();
        }

        if ( empty($phone)) {
            header("Location: ../includes/register.php?signerror=invalidphone&mail=".$phone);
            exit();
        }
        if ( empty($birth_year)) {
            header("Location: ../includes/register.php?signerror=invalidbirth_year&birth_year=".$birth_year);
            exit();
        }
        if ( empty($password)) {
            header("Location: ../includes/register.php?signerror=invalidpassword&password=".$password);
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $error=User::add_user($username,$hashed_password,$id,$name,$email,$phone,$birth_year);
        if ($error) {
            header("Location: ../includes/register.php?signerror=internal&err=".$error);
            exit();
//                $message = "שגיאה בעת ההרשמה";
//                echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else{
            echo "המשתמש נוצר בהצלחה!";
            $user=new User();
            $error=$user->find_user_by_username_and_password($username,$hashed_password);
            if ($error=="True"){
                $session->login($user);
                header("location: ../includes/profile.php?user_id={$user->get_id()}");
                exit();
            }else {
                echo $error;
            }
        }
    }
}else{
    header("Location: ../register.php");
    exit();
}
