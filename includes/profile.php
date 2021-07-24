<?php
require_once('../classes/init.php');
require_once('../includes/header.php');
require_once('../includes/profile_card.php');
require_once('../includes/product_component.php');
global $session;
$user_id = null;
$status = null;
$pass_change_info = "";
if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
}

if(isset($_GET['pwdcherror'])){
    $pwdcherror = $_GET['pwdcherror'];
    $pass_change_info = "<div class='box' style='color:red;text-align: center;margin-right: 100px'> שגיאה בעת שינוי הסיסמה!</div>";
}

if(isset($_GET['pwdch'])){
    $pwdch = $_GET['pwdch'];
    if ($pwdch=="success"){
        $pass_change_info = "<div class='box' style='color:green;text-align: center;margin-right: 100px'> הסיסמה שונתה בהצלחה!</div>";
    }

}

if ($_SERVER['REQUEST_URI']) {
    $_SESSION["bool"] = "false";
}
if (isset($_POST['product_name']) && $_POST['product_name'] != "" ) {
    $_SESSION["bool"] = "true";
    $product_name = $_POST['product_name'];
    $product = new Product();
    $found_product = $product->find_product_by_name($product_name);
    if ($found_product == null) {
        exit();
    }
    $category = $found_product->category;
    $product_name = $found_product->product_name;
    $product_amount = $_POST['amount-input'];
    echo $product_amount;
    $cartArray = array(
        $product_name => array(
            'product_id' => $found_product->id,
            'product_name' => $found_product->product_name,
            'product_price' => $found_product->product_price,
            'product_img' => $found_product->product_img,
            'amount' => $product_amount
        ));
    if (empty($session->get_shopping_cart())) {
        $session->set_shopping_cart($cartArray);
        $status = "<div class='box' style='color:green;text-align: center;margin-right: 100px'>" . $_POST['product_name'] . " נוסף לסל בהצלחה!</div>";
    } else {
        $array_keys = array_keys($session->get_shopping_cart());
        if (in_array($found_product->product_name, $array_keys)) {
            $status = "<div class='box' style='color:red;text-align:center;margin-right:100px'>
                            " . $_POST['product_name'] . " קיים בסל הקניות!</div>";
        } else {
            $session->set_shopping_cart(array_merge($session->get_shopping_cart(), $cartArray));
            $status = "<div class='box' style='color:green;text-align: center;margin-right: 100px'>" . $_POST['product_name'] . " נוסף לסל בהצלחה!</div>";
        }
    }
}
?>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>אזור אישי</title>
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
    <link rel="stylesheet" href="./../css/profile.css"/>
</head>
<body dir="rtl">
<?php
if ($session->is_signed_in()) {
    navbar_user($session->get_name(), $session->get_user_id(), $session->is_admin());
} else {
    navbar_user(null, null,false);
}
?>
<br>
<br>
<div id="rightbox">
    <main>
        <?php
        if ($session->is_signed_in()){
            $user = new User();
            $user_details = $user->find_user_by_id($user_id);
            display_profile($user_details->id, $user_details->username, $user_details->name, $user_details->mail, $user_details->phone, $user_details->birth_year, $pass_change_info);

            $delivery_distribution = order::get_delivery_distribution();
            arsort($delivery_distribution);

            $age_distribution = order::get_age_distribution();
            arsort($age_distribution);
        }

        ?>
    </main>
</div>
<div id="leftbox">
    <div class="container">
        <div class="row">
            <div class="col-sm-4" id="order_type_chart_div">
            </div>
            <div class="col-sm-4" id="age_chart_div">
            </div>

        </div>
    </div>


    <li class="added_to_cart_message">
        <?php echo $status!=null? $status:'';
        $status = null; ?>
    </li>
    <br>
    <br>
    <br>
    <h1 style="font-weight: bold; color: hotpink; text-align: center">המוצרים הנמכרים ביותר בקונדיטוריית אמילי</h1>
    <div class="infographic__grid">
        <div class="infographic__grid__item">
            <section class="row row-cols-2 row-cols-md-4 lg-4 contents">
            </section>
            <p class="infographic__grid__item__p title-pink">המוצר הכי נמכר בקטגוריית העוגות:</p>
            <br>
            <?php
            $product = product:: get_most_popular_product_by_category("CAKES");
            if (isset($product)) {
                display_product($product->product_name, $product->product_price, $product->product_img);
            }
            ?>
        </div>
        <div class="infographic__grid__item">
            <p class="infographic__grid__item__p title-pink">המוצר הכי נמכר בקטגוריית העוגיות:</p>
            <br>
            <?php
            $product = product:: get_most_popular_product_by_category("COOKIES");
            if (isset($product)) {
                display_product($product->product_name, $product->product_price, $product->product_img);
            }
            ?>
        </div>
        <div class="infographic__grid__item">
            <p class="infographic__grid__item__p title-pink">המוצר הכי נמכר בקטגוריית הקישים:</p>
            <br>
            <?php
            $product = product:: get_most_popular_product_by_category("QUICHES");
            if (isset($product)) {
                display_product($product->product_name, $product->product_price, $product->product_img);
            }
            ?>
        </div>
        <div class="infographic__grid__item">
            <p class="infographic__grid__item__p title-pink">המוצר הכי נמכר בקטגוריית המאפים:</p>
            <br>
            <?php
            $product = product:: get_most_popular_product_by_category("PASTRIES");
            if (isset($product)) {
                display_product($product->product_name, $product->product_price, $product->product_img);
            }
            ?>
        </div>
    </div>

    <h1 style="font-weight: bold; color: hotpink; text-align: center">בהזמנתך האחרונה רכשת הכי הרבה:</h1>
    <div class="infographic__grid">
        <?php
        $products = product::get_most_popular_products_of_my_last_order($session->get_user_id());
        if (isset($products)) {
            for ($i = 0; $i < sizeof($products); $i++) {
                ?>
                <div class="infographic__grid__item">
                    <section class="row row-cols-2 row-cols-md-4 lg-4 contents">
                    </section>
                    <br>
                    <?php
                    display_product($products[$i]->product_name, $products[$i]->product_price, $products[$i]->product_img);
                    ?>
                </div>
                <?php
            }
        }else{
            ?>
                <br>
                <br>
                <br>
            <h2 style="font-weight: bold; color: pink; text-align: center">טרם ביצעת הזמנה בקונדיטוריית אמילי, מזמינים אותך לנסות ולהתאהב </h2>
            <br>
            <br>
            <br>
            <?php
        }
        ?>
    </div>
<br>
    <h1 style="font-weight: bold; color: hotpink; text-align: center">אנשים בגילך בדרך כלל מזמינים הכי הרבה:</h1>
    <div class="infographic__grid">
        <?php
        $products = product::get_most_popular_products_of_my_age_range($session->get_user_id());
        if (isset($products)) {
            for ($i = 0; $i < sizeof($products); $i++) {
                ?>
                <div class="infographic__grid__item">
                    <section class="row row-cols-2 row-cols-md-4 lg-4 contents">
                    </section>
                    <?php
                    display_product($products[$i]->product_name, $products[$i]->product_price, $products[$i]->product_img);
                    ?>
                </div>
                <?php
            }
        }else{
            ?>
            <h2 style="font-weight: bold; color: pink; text-align: center">אנשים בגילך טרם הזמינו דרכנו </h2>
            <?php
        }
        ?>
    </div>
    <br><br><br>
</div>
<footer>
    <p class="footer"> פרויקט גמר בקורס תכנות צד שרת | מרצה ד"ר אורלי ברזילי | האקדמית תל אביב יפו <br>
        © כל הזכויות שמורות לקים פרח פרץ, הודיה כהן ואיזבל אלאשווילי ©</p>
    <br>
</footer>
</body>
<script>
    var delivery_distribution = <?php echo json_encode($delivery_distribution); ?>;
    var age_distribution = <?php echo json_encode($age_distribution); ?>;

    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawDistributionChart);
    google.charts.setOnLoadCallback(drawAgeChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawDistributionChart() {
        console.log(delivery_distribution);
        var delivery = delivery_distribution[0]
        var no_delivery = delivery_distribution[1]
        console.log("delivery: "+delivery);
        console.log("no delivery: "+no_delivery);
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'order type');
        data.addColumn('number', 'amount');
        data.addRows([
            ['הזמנות במשלוח', delivery | 0],
            ['הזמנות באיסוף עצמי', no_delivery | 0]
        ]);

        // Set chart options
        var options = {'title':'התפלגות אופן ההזמנות',
            'width':400,
            'height':300};
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('order_type_chart_div'));
        chart.draw(data, options);
    }
    function drawAgeChart() {
        // Create the data table.
        var data2 = new google.visualization.DataTable();
        data2.addColumn('string', 'age group');
        data2.addColumn('number', 'age');
        var arr = [];
        for (const [key, value] of Object.entries(age_distribution)) {
            arr.push([key+' ילידי שנת ', value | 0]);
            console.log(`${key}: ${value}`);
        }
        data2.addRows(arr);
        // Set chart options
        var options = {'title':'התפלגות גילאי המזמינים',
            'width':400,
            'height':300};
        // Instantiate and draw our chart, passing in some options.
        var chart2 = new google.visualization.PieChart(document.getElementById('age_chart_div'));
        chart2.draw(data2, options);
    }
</script>
</html>
