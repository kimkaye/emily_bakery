<?php
require_once('init.php');
class Product{
    private $id;
    private $category;
    private $product_name;
    private $product_price;
    private $product_img;

    public static function products_by_category($category){
        global $database;
        $result_set=$database->query("SELECT * FROM products WHERE category = '".$category."'");
        $products=null;
        if (isset($result_set)){
            $i=0;
            if ($result_set->num_rows > 0){ 
                while($row=$result_set->fetch_assoc()){ 
                    $product=new Product();
                    $product->instantation($row);
                    $products[$i]=$product;
                    $i+=1;
                }
            }
        }
        return $products;
    }

    public static function search_products($product_name){
        global $database;
        $result_set=$database->query("SELECT * FROM products WHERE product_name = '".$product_name."'");
        $products=null;
        if (isset($result_set)){
            $i=0;
            if ($result_set->num_rows > 0){
                while($row=$result_set->fetch_assoc()){
                    $product=new Product();
                    $product->instantation($row);
                    $products[$i]=$product;
                    $i+=1;
                }
            }
        }
        return $products;
    }

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
    public function find_product_by_name($product_name){
        global $database;
        $result_set=$database->query("SELECT * FROM products WHERE product_name='".$product_name."'");
        if(isset($result_set) && ($result_set->num_rows>0)){
            $found_product=$result_set->fetch_assoc();
            $this->instantation($found_product);
            return $this;
        }
        else{
            return null;
        }
    }
    public static function get_most_popular_products_of_my_last_order($user_id){

        global $database;
        $sql="SELECT P.product_name,P.category, P.product_price, P.product_img, PO.product_id as id, PO.order_id, PO.amount as product_amount, O.user_id as user_id, O.created_at as created_at
                FROM products_order PO
                LEFT JOIN orders O
                    ON PO.order_id = O.id 
                LEFT JOIN products P
                    ON PO.product_id = P.id
                WHERE user_id='$user_id' AND(user_id, created_at) in (
                    SELECT user_id, MAX(created_at) as created_at
                    FROM orders
                    GROUP BY user_id
                )
                ORDER BY product_amount DESC LIMIT 4;
             ";
        $result_set=$database->query($sql);
        $products=null;
        if (isset($result_set)){
            $i=0;
            if ($result_set->num_rows > 0){
                while($row=$result_set->fetch_assoc()){
                    $product=new Product();
                    $product->instantation($row);
                    $products[$i]=$product;
                    $i+=1;
                }
            }
        }
        return $products;
    }
    public static function get_most_popular_products_of_my_age_range($user_id){
        $user = new User();
        $user->find_user_by_id($user_id);
        $max_year = $user->get_birth_year()+5;
        $min_year = $user->get_birth_year()-5;
        global $database;
        $sql="SELECT P.product_name,P.category, P.product_price, P.product_img, PO.product_id as id, PO.order_id, PO.amount as product_amount, O.user_id as user_id, O.created_at as created_at
                FROM products_order PO
                LEFT JOIN orders O
	                ON PO.order_id = O.id 
                LEFT JOIN products P
	                ON PO.product_id = P.id
                WHERE user_id IN (
                    SELECT id FROM users WHERE id != '$user_id' AND birth_year BETWEEN '$min_year' AND '$max_year'
                )
                ORDER BY product_amount DESC LIMIT 4;
             ";
        $result_set=$database->query($sql);
        $products=null;
        if (isset($result_set)){
            $i=0;
            if ($result_set->num_rows > 0){
                while($row=$result_set->fetch_assoc()){
                    $product=new Product();
                    $product->instantation($row);
                    $products[$i]=$product;
                    $i+=1;
                }
            }
        }
        return $products;
    }
    public static function get_most_popular_product_by_category($category){

        global $database;
        $sql="SELECT P.product_name, P.category,P.product_price, P.product_img,PO.product_id as id, Sum(PO.amount) as product_amount
                FROM products_order PO
                    LEFT JOIN products P ON PO.product_id = P.id
                WHERE category='".$category."'
                GROUP BY product_id ORDER BY product_amount DESC LIMIT 1";
        $result_set=$database->query($sql);
        if(isset($result_set) && ($result_set->num_rows>0)){
            $found_product=$result_set->fetch_assoc();
            $product=new Product();
            $product->instantation($found_product);
            return $product;
        }
        else{
            return null;
        }
    }
}
 $product = new Product();
?>