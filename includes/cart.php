<?php
require_once('../classes/init.php');
require_once('../includes/header.php');
global $session;
$status = null;
$error = null;

if (isset($_POST['action']) && $_POST['action']=="remove"){
    $shopping_cart = $session->get_shopping_cart();
    if(!empty($shopping_cart)) {
        foreach($shopping_cart as $key => $value) {
            if ($_POST["product_name"] == $key) {
                unset($shopping_cart[$key]);
                $session->set_shopping_cart($shopping_cart);
                $status = "<div class='box' style='color:red;'>
                    " . $key . " נמחק מהסל שלך</div>";
                break;
            }
        }
        if(empty($session->get_shopping_cart())){
            $session->clear_shopping_cart();
        }
    }
}
if (isset($_POST['action']) && $_POST['action']=="change"){
    foreach($session->get_shopping_cart() as &$value){
        if($value['product_name'] === $_POST["product_name"]){
            $value['amount-input'] = $_POST["amount-input"];
            break;
        }
    }
}
if(isset($_POST["action"]) && $_POST['action']=="checkout" && isset($_SESSION['user_id']) && !empty($session->get_shopping_cart())){
    $new_order=new Order();
    $user_id = $session->get_user_id();
    $with_delivery = $_POST['with_delivery'];
    $city_id = $_POST['city'];
    $branch = $_POST['branch'];
    $delivery_address = $_POST['delivery_address'];
    $delivery_time = $_POST['delivery_time_input'];
    $delivery_date = $_POST['delivery_date'];
    $total_price = 0;
    $product_total_price_in_order = 0;
    foreach ($_SESSION["shopping_cart"] as $product){
        $total_price += ($product["product_price"]*$product["amount"]);
    }
    $added_order=$new_order->create_order($user_id,$total_price,$delivery_address,$delivery_date, $delivery_time,$with_delivery,$city_id,$branch);
    if($added_order <= 0){
        $message = "שגיאה ביצירת ההזמנה";
        echo "<script type='text/javascript'>alert('$message');</script>";
        return;
    }
    foreach ($session->get_shopping_cart() as $product){
        $product_total_price_in_order = ($product["product_price"]*$product["amount"]);
        $product_id = $product["product_id"];
        $product_amount = $product["amount"];
        $products_in_order = $new_order->add_product_to_order($added_order, $product_id, $product_amount, $product_total_price_in_order);
    }
    $message = "הזמנה ".$added_order. " נוצרה בהצלחה!";
    echo "<script type='text/javascript'>alert('$message');</script>";
    $session->clear_shopping_cart();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>הסל שלי</title>
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
    <link rel="stylesheet" href="./../css/index.css" />
    <link rel="stylesheet" href="./../css/cart.css" />
</head>

<body dir="rtl">
<?php
if ($session->is_signed_in()) {
    navbar_user($session->get_name(), $session->get_user_id(), $session->is_admin());
} else {
    navbar_user(null, null,false);
}
?>
<div class="cart">
    <?php
    if(!empty($session->get_shopping_cart())){
        $total_price = 0;
        ?>
        <table class="table">
            <tbody>
            <tr>
                <td></td>
                <td>שם הפריט</td>
                <td>כמות</td>
                <td>מחיר ליחידה</td>
                <td>מחיר כולל</td>
            </tr>
            <?php
            foreach ($session->get_shopping_cart() as $product){
                ?>
                <tr>
                    <td>
                        <img src='<?php echo $product["product_img"]; ?>' width="50" height="40" />
                    </td>
                    <td>
                        <?php echo $product["product_name"]; ?><br />
                        <form method='post' action=''>
                            <input type='hidden' name='product_name' value="<?php echo $product["product_name"]; ?>" />
                            <input type='hidden' name='action' value="remove" />
                            <button type='submit' class='remove'>הסר</button>
                        </form>
                    </td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='product_name' value="<?php echo $product["product_name"]; ?>" />
                            <input type='hidden' name='action' value="change" />
                            <input type="number" name='amount-input' class='quantity' min ="1" readonly value="<?php echo $product["amount"]; ?>"/>
                        </form>
                    </td>
                    <td><?php echo "₪".$product["product_price"]; ?></td>
                    <td><?php echo "₪".$product["product_price"]*$product["amount"]; ?></td>
                </tr>
                <?php
                $total_price += ($product["product_price"]*$product["amount"]);
            }
            ?>
            <tr>
                <td colspan="5" align="right">
                    <input type='hidden' name="total_price" value="<?php $total_price ?>" />
                    <strong name="total_price">סך הכל לתשלום: <?php echo "₪".$total_price; ?></strong>
                </td>
            </tr>
            </tbody>
        </table>
        <?php
    }else{
        echo "<center ><br><br><br><br><br><br><h3>הסל שלך ריק</h3></center><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
    }
    ?>
</div>
<div style="clear:both;"></div>
<div class="message_box" style="margin:10px 0px;">
    <?php echo $status; ?>
</div>
<?php
if(!empty($session->get_shopping_cart())) {
    ?>
    <center>
        <form method="post" action="cart.php" class="form-group col-md-3">
            <div class="row">
                <div class="col-md-7 col-md-offset-2 ">
                    <div class="form-group">
                        <label for="with_delivery">בחירת אופן המשלוח:</label>
                        <select name="with_delivery" id="with_delivery" class="validate[required] form-control" required>
                            <option value="0">משלוח</option>
                            <option value="1">איסוף עצמי</option>
                        </select>
                    </div>
                    <div class="form-group" id="city-selector">
                        <label for="city">עיר:</label>
                        <select name="city" id="city" dir="rtl" class="form-control">
                            <option value="">בחר</option>
                            <option value="182" >אבן יהודה</option>
                            <option value="446" >אודים</option>
                            <option value="2400" >אור יהודה</option>
                            <option value="565" >אזור</option>
                            <option value="716" >אייל</option>
                            <option value="41" >אליכין</option>
                            <option value="1309" >אלעד</option>
                            <option value="9702" >אלפי מנשה</option>
                            <option value="1324" >ארסוף</option>
                            <option value="2530" >באר יעקב</option>
                            <option value="697" >בארותיים</option>
                            <option value="698" >בורגתה</option>
                            <option value="2043" >בחן</option>
                            <option value="1076" >בית ברל</option>
                            <option value="466" >בית דגן</option>
                            <option value="288" >בית יהושע</option>
                            <option value="200" >בית ינאי</option>
                            <option value="326" >בית יצחק-שער חפר</option>
                            <option value="202" >בית עובד</option>
                            <option value="6100" >בני ברק</option>
                            <option value="386" >בני דרור</option>
                            <option value="418" >בני ציון</option>
                            <option value="389" >בצרה</option>
                            <option value="1319" >בת חפר</option>
                            <option value="6200" >בת ים</option>
                            <option value="872" >גאולי תימן</option>
                            <option value="379" >גאולים</option>
                            <option value="870" >גבעת השלושה</option>
                            <option value="207" >גבעת ח"ן</option>
                            <option value="681" >גבעת שמואל</option>
                            <option value="6300" >גבעתיים</option>
                            <option value="346" >גליל ים</option>
                            <option value="836" >גנות</option>
                            <option value="862" >גני יוחנן</option>
                            <option value="218" >גני עם</option>
                            <option value="229" >גני תקווה</option>
                            <option value="842" >געש</option>
                            <option value="9700" >הוד השרון</option>
                            <option value="423" >העוגן</option>
                            <option value="6400" >הרצליה</option>
                            <option value="6401" >הרצלייה פיתוח</option>
                            <option value="235" >חבצלת השרון</option>
                            <option value="6600" >חולון</option>
                            <option value="115" >חופית</option>
                            <option value="807" >חניאל</option>
                            <option value="1024" >חרוצים</option>
                            <option value="2660" >יבנה</option>
                            <option value="9400" >יהוד</option>
                            <option value="417" >יקום</option>
                            <option value="718" >ירחיב</option>
                            <option value="183" >ירקונה</option>
                            <option value="1224" >כוכב יאיר</option>
                            <option value="187" >כפר הס</option>
                            <option value="217" >כפר הרא"ה</option>
                            <option value="190" >כפר ויתקין</option>
                            <option value="193" >כפר חיים</option>
                            <option value="168" >כפר יונה</option>
                            <option value="170" >כפר יעבץ</option>
                            <option value="387" >כפר מונש</option>
                            <option value="98" >כפר מל"ל</option>
                            <option value="316" >כפר נטר</option>
                            <option value="6900" >כפר סבא</option>
                            <option value="388" >כפר סבא א.ת.</option>
                            <option value="249" >כפר סירקין</option>
                            <option value="267" >כפר שמריהו</option>
                            <option value="722" >מגשימים</option>
                            <option value="1200" >מודיעין-מכבים-רעות</option>
                            <option value="606" >מזור</option>
                            <option value="382" >מכמורת</option>
                            <option value="197" >מעברות</option>
                            <option value="22" >מקווה ישראל</option>
                            <option value="194" >משמר השרון</option>
                            <option value="425" >משמרת</option>
                            <option value="1315" >מתן</option>
                            <option value="686" >נווה ימין</option>
                            <option value="858" >נווה ירק</option>
                            <option value="447" >נורדייה</option>
                            <option value="449" >נחלים</option>
                            <option value="705" >נחשונים</option>
                            <option value="808" >ניר אליהו</option>
                            <option value="331" >ניר צבי</option>
                            <option value="1748" >נמל תעופה בן-גוריון</option>
                            <option value="7200" >נס ציונה</option>
                            <option value="7400" >נתניה</option>
                            <option value="587" >סביון</option>
                            <option value="157" >עין ורד</option>
                            <option value="880" >עין שריד</option>
                            <option value="871" >עינת</option>
                            <option value="1875" >עמק חפר מזרח מ"א 16</option>
                            <option value="171" >פרדסייה</option>
                            <option value="7900" >פתח תקווה</option>
                            <option value="198" >צופית</option>
                            <option value="1345" >צור יצחק</option>
                            <option value="276" >צור משה</option>
                            <option value="1148" >צור נתן</option>
                            <option value="195" >קדימה-צורן</option>
                            <option value="2620" >קריית אונו</option>
                            <option value="2640" >ראש העין</option>
                            <option value="8300" >ראשון לציון</option>
                            <option value="8400" >רחובות</option>
                            <option value="616" >רינתיה</option>
                            <option value="206" >רמות השבים</option>
                            <option value="8500" >רמלה</option>
                            <option value="8600" >רמת גן</option>
                            <option value="184" >רמת הכובש</option>
                            <option value="2650" >רמת השרון</option>
                            <option value="8700" >רעננה</option>
                            <option value="247" >רשפון</option>
                            <option value="284" >שדה ורבורג</option>
                            <option value="2015" >שדי חמד</option>
                            <option value="1304" >שוהם</option>
                            <option value="232" >שפיים</option>
                            <option value="5000" >תל אביב -יפו</option>
                            <option value="287" >תל יצחק</option>
                            <option value="154" >תל מונד</option>
                            <option value="2002" >תנובות</option>
                            <option value="1749" >תעשיון צריפין</option>
                        </select>


                    </div>
                    <div class="form-group" id="branch-selector">
                        <label for="branch">סניף:</label>
                        <select name="branch" id="branch" dir="rtl" class="form-control">
                            <option value="">בחר</option>
                            <option value="2400" >אור יהודה</option>
                            <option value="565" >אזור</option>
                            <option value="2530" >באר יעקב</option>
                            <option value="6100" >בני ברק</option>
                            <option value="6200" >בת ים</option>
                            <option value="6300" >גבעתיים</option>
                            <option value="9700" >הוד השרון</option>
                            <option value="6400" >הרצליה</option>
                            <option value="6600" >חולון</option>
                            <option value="2660" >יבנה</option>
                            <option value="6900" >כפר סבא</option>
                            <option value="1200" >מודיעין-מכבים-רעות*</option>
                            <option value="7400" >נתניה</option>
                            <option value="7900" >פתח תקווה</option>
                            <option value="2640" >ראש העין</option>
                            <option value="8300" >ראשון לציון</option>
                            <option value="8400" >רחובות</option>
                            <option value="5000" >תל אביב -יפו</option>
                            <option value="154" >תל מונד</option>
                        </select>

                    </div>
                    <div class="form-group" id="delivery_address">
                        <label for="address">כתובת:</label>
                        <br>
                        <input name="delivery_address" placeholder="רחוב ומספר בית" type="text" minlength="2" maxlength="30" class="form-control">
                    </div>
                    <div class="form-group" id="name">
                        <label for="name">איש קשר:</label>
                        <br>
                        <input name="name" placeholder="שם מלא" type="text" minlength="2" maxlength="30" class="form-control" required>
                    </div>
                    <div class="form-group" id="date">
                        <label for="date">תאריך:</label>
                        <br>
                        <input id="delivery_date_input" type="date"  name="delivery_date" class="form-control" required onchange="check_delivery_time()">
                    </div>
                    <div class="form-group">
                        <label id="time"> שעה:</label>
                        <select name="delivery_time_input" id="delivery_time_input" class="validate[required] form-control" required onchange="check_delivery_time()">
                            <option value="" selected="selected">בחר</option>
                            <option value="07:00">07:00 - 09:00</option>
                            <option value="07:30">07:30 - 09:30</option>
                            <option value="08:00">08:00 - 10:00</option>
                            <option value="08:30">08:30 - 10:30</option>
                            <option value="09:00">09:00 - 11:00</option>
                            <option value="09:30">09:30 - 11:30</option>
                            <option value="10:00">10:00 - 12:00</option>
                            <option value="10:30">10:30 - 12:30</option>
                            <option value="11:00">11:00 - 13:00</option>
                            <option value="11:30">11:30 - 13:30</option>
                            <option value="12:00">12:00 - 14:00</option>
                            <option value="12:30">12:30 - 14:30</option>
                            <option value="13:00">13:00 - 15:00</option>
                            <option value="13:30">13:30 - 15:30</option>
                            <option value="14:00">14:00 - 16:00</option>
                        </select>
                    </div>
                    <div class="delivery-avaialbility">
                        <label id="delivery_availability_info"></label>
                    </div>
                        <input type='hidden' name='action' value="checkout" />

                        <br>
                        <br>
                        <button class="btn checkout-btn checkout" type="submit">סיום הזמנה</button>

                        <br>
                        <br>
                        <br>
                        <br>

        </form>
        <?php echo $error; ?>
    </center>
    <?php
}
?>

<script>
    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate()+1);
    minimium_date = tomorrow.toISOString().split('T')[0];
    document.getElementsByName("delivery_date")[0].setAttribute('min', minimium_date);
</script>
<script>
    function check_delivery_time(){
        console.log("check_delivery_time clicked")
        var delivery_time = document.getElementById("delivery_time_input").value;
        var delivery_date = document.getElementById("delivery_date_input").value;
        console.log(delivery_time);
        console.log(delivery_date);
        if(delivery_time && delivery_date){
            console.log("sending ajax....")
            var request = new XMLHttpRequest();
            request.onreadystatechange = function(){
                if (request.readyState===4 && request.status ===200){
                    console.log("ok")
                    document.getElementById("delivery_availability_info").innerHTML = request.responseText
                }
            }
            request.open("POST", 'cart_ajax.php',true);
            request.setRequestHeader('Content-type','application/x-www-form-urlencoded');
            request.send("delivery_time=" + delivery_time + "&delivery_date=" + delivery_date)
        }else {
            console.log("not sending ajax....")
        }

    }
</script>
<script>
    function init(){
        console.log('init')
        var input = document.getElementById('delivery_address');
        new google.maps.places.Autocomplete(input);
    }
</script>
<script>
    var input_date = document.getElementById('delivery_date_input'); // <input type="date">
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    input_date.value = today
    $('#branch-selector').hide('slow');
    document.getElementById("branch").required = false;
    document.getElementById("city").required = true;
    $(function(){
        $(document).on('change','#with_delivery',function(e){
            $("#date").val('');
            if($(this).val()=='0'){
                $('#city-selector').show('slow');
                $('#delivery_address').show('slow');
                $('#branch-selector').hide('slow');
                document.getElementById("branch").required = false;
                document.getElementById("city").required = true;
            }else{
                $('#city-selector').hide('slow');
                $('#delivery_address').hide('slow');
                $('#branch-selector').show('slow');
                document.getElementById("branch").required = true;
                document.getElementById("city").required = false;
            }
        });
    });
</script>
<footer>
    <p class="footer"> פרויקט גמר בקורס תכנות צד שרת | מרצה ד"ר אורלי ברזילי | האקדמית תל אביב יפו <br>
        © כל הזכויות שמורות לקים פרח פרץ, הודיה כהן ואיזבל אלאשווילי ©</p>
    <br>
</footer>
</div>
</main>
</div>
</body>
</html>