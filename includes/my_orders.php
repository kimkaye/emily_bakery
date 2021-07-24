<?php
require_once('../classes/init.php');
require_once('../includes/header.php');
global $session;

?>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ההזמנות שלי</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
            crossorigin="anonymous"
    />
    <script
            src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"
    ></script>
    <script
            src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"
    ></script>
    <script
            src="https://kit.fontawesome.com/8f0e178346.js"
            crossorigin="anonymous"
    ></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <link rel="stylesheet" href="./../css/index.css"/>
    <link rel="stylesheet" href="./../css/my_orders.css"/>
</head>
<body dir="rtl">
<?php
if ($session->is_signed_in()) {
    navbar_user($session->get_name(), $session->get_user_id(), $session->is_admin());
} else {
    navbar_user(null, null,false);
}
?>

<table>
    <tr>
        <th>מזהה הזמנה</th>
        <th>סה׳׳כ לתשלום</th>
        <th>משלוח/איסוף עצמי</th>
        <th>כתובת למשלוח</th>
        <th>תאריך משלוח/איסוף</th>
        <th>זמן משלוח/איסוף</th>
        <th>עיר</th>
        <th>סניף</th>
        <th>תאריך יצירת הזמנה</th>
        <th>לקבלה</th>
    </tr>
    <?php
    if ($session->is_signed_in()) {
        $my_orders = Order::get_user_orders($session->get_user_id());
        if (isset($my_orders)) {
            for ($i = 0; $i < sizeof($my_orders); $i++) {
                $order= $my_orders[$i];
                ?>
                <tr>
                    <td><?php echo $order->id ?></td>
                    <td><?php echo $order->total_price ?></td>
                    <td><?php echo $order->with_delivery==0? "איסוף עצמי": "משלוח" ?></td>
                    <td><?php echo $order->with_delivery==0? "-------": $order->delivery_address ?></td>
                    <td><?php echo $order->delivery_date ?></td>
                    <td><?php echo $order->delivery_time ?></td>
                    <td><?php echo $order->with_delivery==0? $order->city:"-----" ?></td>
                    <td><?php echo $order->with_delivery==0? $order->branch:"-----" ?></td>
                    <td><?php echo $order->created_at ?></td>
                    <td>
                        <a class="button" href="my_orders.php?receipt_id=../receipts/receipt.txt">לחץ לקבלה</a>
                    </td>
                </tr>
                <?php
            }
        }
    }
    ?>
</table>
<br>

<div id="receipt_info">
    <?php
    if (isset($_GET['receipt_id'])) {
        $receipt_id = $_GET['receipt_id'];
//        $file_content = file_get_contents('../classes/config_secrets.txt');
        $file_content = file_get_contents($receipt_id);
        echo $file_content;
    }
    ?>
</div>


</div>
<footer>
    <p class="footer"> פרויקט גמר בקורס תכנות צד שרת | מרצה ד"ר אורלי ברזילי | האקדמית תל אביב יפו <br>
        © כל הזכויות שמורות לקים פרח פרץ, הודיה כהן ואיזבל אלאשווילי ©</p>
    <br>
</footer>
</body>
</html>
