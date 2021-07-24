<?php
require_once('init.php');
class User{
    private $id;
    private $username;
    private $password;
    private $name;
    private $mail;
    private $phone;
    private $birth_year;
    private $is_admin;

    private function has_attribute($attribute){
        $object_properties=get_object_vars($this);
        return array_key_exists($attribute,$object_properties);
    }
     private function  instantation($pass_array){
        foreach ($pass_array as $attribute=>$value){
            if ($result=$this->has_attribute($attribute))
                $this->$attribute=$value;
       }
     }
    public function find_user_by_username_and_password($username,$password){
        global $database;
        $sql="SELECT * FROM users WHERE username='".$username."' AND password='".$password."'";
        $result_set=$database->query($sql);
        if ($result_set->num_rows==0){
            return null;
        }

        $found_user=$result_set->fetch_assoc();
        $this->instantation($found_user);
        return "True";
    }
    public function find_user_by_id($id){
        global $database;
        $result_set=$database->query("SELECT * FROM users WHERE id='".$id."'");
        $user=$result_set->fetch_assoc();
        $this->instantation($user);
        return $this;
    }
    public function find_user_by_username($username){
        global $database;
        $sql="SELECT * FROM users WHERE username='".$username."' ";
        $result_set=$database->query($sql);
        if ($result_set->num_rows==0){
            return null;
        }
        $found_user=$result_set->fetch_assoc();
        $this->instantation($found_user);
        return $this;
    }

    public function update_user(){
        global $database;
        $sql="UPDATE users SET username = '".$this->username."', name = '".$this->name."', mail = '".$this->mail."', phone = '".$this->phone."', birth_year = '".$this->birth_year."', is_admin = '".$this->is_admin."' WHERE id='".$this->id."'";
        $result_set=$database->query($sql);
        if ($result_set === TRUE) {
            return $this;
        } else {
            return null;
        }
    }

    public static function change_password($user_id, $password){
        global $database;
        $sql="UPDATE users SET password = '".$password."' WHERE id='".$user_id."'";
        $result_set=$database->query($sql);
        if ($result_set === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public static function check_if_email_exists($username)
    {
        global $database;
        $result = $database->query("SELECT * FROM users WHERE username='$username'");
        if(mysqli_num_rows($result)>0)
        {
            return true;
        }
        return false;
    }
    public static function check_if_username_exists($username)
    {
        global $database;
        $result = $database->query("SELECT * FROM users where username='$username'");
        if(mysqli_num_rows($result)>0)
        {
            return true;
        }
        return false;
    }
    public static function check_if_user_exists_by_id($id)
    {
        global $database;
        $result = $database->query("SELECT * FROM users where id='$id'");
        if(mysqli_num_rows($result)>0)
        {
            return true;
        }
        return false;
    }

    public static function add_user($user,$password,$id,$name,$mail,$phone,$birth_year){
        global $database;
        $sql="INSERT INTO users(username,password,id,name,mail,phone,birth_year) VALUES ('".$user."','".$password."','".$id."','".$name."','".$mail."','".$phone."',".$birth_year.")";
        $result=$database->query($sql);
        if (!$result){
            $error='Can not add user! Error:'. $database->get_connection()->error;
            return $error;
        } else{
            echo 'New user was added!';
        }
    }
    public static function get_all_users(){
        global $database;
        $result_set=$database->query("SELECT * FROM users");
        $users=null;
        if (isset($result_set)){
            $i=0;
            if ($result_set->num_rows > 0){
                while($row=$result_set->fetch_assoc()){
                    $user=new User();
                    $user->instantation($row);
                    $users[$i]=$user;
                    $i+=1;
                }
            }
        }
        return $users;
    }

    public function get_id(){
        return $this->id;
    }
    public function get_username(){
        return $this->username;
    }
    public function get_name(){
        return $this->name;
    }
    public function get_email(){
        return $this->mail;
    }
    public function get_phone(){
        return $this->phone;
    }
    public function is_admin(){
        return $this->is_admin;
    }
    public function get_birth_year(){
        return $this->birth_year;
    }
    public function set_is_admin($is_admin){
        return $this->is_admin = $is_admin;
    }
    function __get($property){
        if (property_exists($this,$property))
            return $this->$property;
    }
}
$user = new User();
?>

