<?php
require_once('init.php');
class Order{
    public $id;
    public $user_id;
    public $total_price;
    public $delivery_address;
    public $delivery_time;
    public $delivery_date;
    public $branch;
    public $city;
    public $with_delivery;
    public $created_at;
    public $phone;
    public $mail;
    public $name;

    private function has_attribute($attribute){
        $object_properties=get_object_vars($this);
        return array_key_exists($attribute,$object_properties);
    }
     private function  instantation($product_array){
        foreach ($product_array as $attribute=>$value){
            if ($result=$this->has_attribute($attribute))
                $this->$attribute=$value;
       }
     }
    function __get($property){
        if (property_exists($this,$property))
            return $this->$property;
    }


    public function create_order($user_id, $total_price, $delivery_address, $delivery_date, $delivery_time, $with_delivery, $city_id, $branch){
        global $database;
        $sql="INSERT INTO orders(user_id,total_price,delivery_address,with_delivery,city,branch,delivery_date,delivery_time) values (".$user_id.",".$total_price.",'".$delivery_address."','".$with_delivery."','".$city_id."','".$branch."','".$delivery_date."','".$delivery_time."')";
        $result=$database->query($sql);
        if ($result){
            $new_order_id = $database->get_connection()->insert_id;
            return $new_order_id;
        }
    }
    public function add_product_to_order($order_id, $product_id, $amount, $total_product_price){
        global $database;
        $sql="INSERT INTO products_order(order_id,product_id,amount,total_product_price) values (".$order_id.",'".$product_id."',".$amount.",".$total_product_price.")";
        $result=$database->query($sql);
    }
    public static function check_if_delivery_time_available($delivery_date, $delivery_time){
        global $database;
        $sql="SELECT * FROM orders WHERE delivery_time='".$delivery_time."' AND delivery_date='".$delivery_date."'";
        $result_set=$database->query($sql);
        if ($result_set->num_rows==0){
            return true;
        }
        return false;
    }
    public static function get_delivery_distribution(){
        global $database;
        $result_set=$database->query("SELECT with_delivery,COUNT(*) FROM orders GROUP BY with_delivery;");
        if (!$result_set){
            return 'Can not find the delivery distribution.  Error is:'.$database->get_connection()->error;
        }
        $array = [];
        while ($row = $result_set->fetch_assoc()) {
            $array[$row["with_delivery"]] = $row["COUNT(*)"];
        }
        return $array;
    }

    public static function get_age_distribution(){
        global $database;
        $result_set=$database->query("SELECT U.birth_year, COUNT(*) FROM orders O LEFT JOIN users U
	                ON O.user_id = U.id GROUP BY birth_year;");
        if (!$result_set){
            return 'Can not find the age distribution.  Error is:'.$database->get_connection()->error;
        }
        $array = [];
        while ($row = $result_set->fetch_assoc()) {
            $array[$row["birth_year"]] = $row["COUNT(*)"];
        }
        return $array;
    }

    public static function get_all_orders(){
        global $database;
        $result_set=$database->query("SELECT O.id, U.name, U.phone, U.mail, O.user_id, O.total_price, O.delivery_address, O.delivery_time, O.delivery_date, O.branch, O.city, O.with_delivery, O.created_at
FROM orders O
LEFT JOIN users U
	ON O.user_id = U.id
ORDER BY created_at DESC;");
        $orders=null;
        if (isset($result_set)){
            $i=0;
            if ($result_set->num_rows > 0){
                while($row=$result_set->fetch_assoc()){
                    $order=new Order();
                    $order->instantation($row);
                    $orders[$i]=$order;
                    $i+=1;
                }
            }
        }
        return $orders;
    }

    public static function get_user_orders($user_id){
        global $database;
        $result_set=$database->query("SELECT O.id, U.name, U.phone, U.mail, O.user_id, O.total_price, O.delivery_address, O.delivery_time, O.delivery_date, O.branch, O.city, O.with_delivery, O.created_at
FROM orders O
LEFT JOIN users U
	ON O.user_id = U.id
WHERE O.user_id='".$user_id."'
ORDER BY created_at DESC;");
        $orders=null;
        if (isset($result_set)){
            $i=0;
            if ($result_set->num_rows > 0){
                while($row=$result_set->fetch_assoc()){
                    $order=new Order();
                    $order->instantation($row);
                    $orders[$i]=$order;
                    $i+=1;
                }
            }
        }
        return $orders;
    }
}
$order = new Order();
?>