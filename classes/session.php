<?php
require_once('init.php');
class Session{
    private $signed_in = false;
    private $is_admin;
    private $session_id;
    private $user_id;
    private $username;
    private $name;
    private $shopping_cart;
    public function __construct(){
        session_start();
        $this->session_id = session_id();
        $this->verify_login();
    }
     private function verify_login(){
        if (isset($_SESSION['user_id'])){
            $this->user_id=$_SESSION['user_id'];
            $this->is_admin=$_SESSION['is_admin'];
            $this->username=$_SESSION['username'];
            $this->name=$_SESSION['name'];
            $this->signed_in=true;
            if(isset($_SESSION['shopping_cart']))
                $this->shopping_cart=$_SESSION['shopping_cart'];
        }
        else{
            unset($this->user_id);
            $this->signed_in=false;
            unset($this->shopping_cart);
        }
    }
    public function login($user){
        if($user){
            $this->user_id=$user->get_id();
            $this->username=$user->get_username();
            $this->name=$user->get_name();
            $this->is_admin=$user->is_admin();
            // set user id in session
            $_SESSION['user_id']=$user->get_id();
            $_SESSION['username']=$this->username;
            $_SESSION['is_admin']=$this->is_admin;
            $_SESSION['name']=$this->name;
            $this->signed_in=true;
        }
    }
    public function logout(){
        echo 'logout';
        unset($_SESSION['user_id']);
        unset($_SESSION['is_admin']);
        unset($_SESSION['username']);
        unset($_SESSION['name']);
        unset($_SESSION['shopping_cart']);
        unset($this->is_admin);
        unset($this->user_id);
        unset($this->shopping_cart);
        $this->signed_in=false;
    }
    public function clear_shopping_cart(){
        echo 'clearing the cart from products';
        unset($_SESSION['shopping_cart']);
        unset($this->shopping_cart);
    }
    public function get_shopping_cart(){
        return $this->shopping_cart;
    }
    public function set_shopping_cart($cartArray){
        $_SESSION["shopping_cart"] = $cartArray;
        $this->shopping_cart=$_SESSION['shopping_cart'];
    }
    public function is_signed_in(){
        return $this->signed_in;
    }
    public function is_admin(){
        return $this->is_admin;
    }
    public function get_user_id(){
        return $this->user_id;
    }
    public function get_username(){
        return $this->username;
    }
    public function get_name(){
        return $this->name;
    }
    function __get($property){
        if (property_exists($this,$property)) return $this->$property;
    }
}
$session=new Session();
?>

