<?php
require_once('../classes/init.php');
global $session;
$info ="";

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