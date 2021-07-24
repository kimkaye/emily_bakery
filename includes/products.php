<?php
require_once('../classes/init.php');
require_once('../includes/header.php');
require_once('../includes/product_component.php');
require_once('../includes/query_editor.php');
global $session;
$status = null;
$available_cookies = '';
$available_pastries = '';
$available_cakes = '';
$available_quiches = '';
$available_free_search = '';
$show_cookies = '';
$show_pastries = '';
$show_cakes = '';
$show_quiches = '';
$search_text = '';

if(isset($_GET['search_term'])){
    $search_text = $_GET['search_term'];
}
$show_free_search = '';
if ($_SERVER['REQUEST_URI']) {
    $_SESSION["bool"] = "false";
}

$default_cakes = '1';
$default_cookies = '12';
$default_pastries = '13';
$default_quiches = '14';
$default_free = '15';
if(isset($_GET['category'])){
    $category = $_GET['category'];
    if ($category == "CAKES") {
        $active_cakes = "active";
        $show_cakes = 'show';
        $default_cakes = "default_open";
    } else if ($category == "COOKIES") {
        $active_cookies = "active";
        $show_cookies = 'show';
        $default_cookies = "default_open";
    } else if ($category == "PASTRIES") {
        $active_pastries = "active";
        $show_pastries = 'show';
        $default_pastries = "default_open";
    } else if ($category == "QUICHES") {
        $active_quiches = "active";
        $show_quiches = 'show';
        $default_quiches = "default_open";
    }else {
        $active_free_search = "active";
        $show_free_search = 'show';
        $default_free = "default_open";
    }
}


if (isset($_POST['product_name']) && $_POST['product_name'] != "" && isset($_SESSION['user_id'])) {
    $_SESSION["bool"] = "true";
    $product_name = $_POST['product_name'];
    $product = new Product();
    $found_product = $product->find_product_by_name($product_name);
    if ($found_product == null){
        exit();
    }
    $category = $found_product->category;


    if ($category == "CAKES") {
        $active_cakes = "active";
        $show_cakes = 'show';
        $default_cakes = "default_open";
    } else if ($category == "COOKIES") {
        $active_cookies = "active";
        $show_cookies = 'show';
        $default_cookies = "default_open";
    } else if ($category == "PASTRIES") {
        $active_pastries = "active";
        $show_pastries = 'show';
        $default_pastries = "default_open";
    } else if ($category == "QUICHES") {
        $active_quiches = "active";
        $show_quiches = 'show';
        $default_quiches = "default_open";
    }else {
        $active_free_search = "active";
        $show_free_search = 'show';
        $default_free = "default_open";
    }
    $product_name = $found_product->product_name;
    $product_amount = $_POST['amount-input'];
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
        $status = "<div class='box' style='color:green;margin-right: 100px'>" . $product_name . " נוסף לסל בהצלחה! </div>";
    } else {
        $array_keys = array_keys($session->get_shopping_cart());
        if (in_array($product_name, $array_keys)) {
            $status = "<div class='box' style='color:red;margin-right: 100px'>
                            " . $product_name . " המוצר קיים בסל הקניות!</div>";
        } else {
            $session->set_shopping_cart(array_merge($session->get_shopping_cart(), $cartArray));
            $status = "<div class='box' style='color:green; margin-right: 100px'>" . $product_name . " נוסף לסל בהצלחה!</div>";
        }
    }
} elseif (isset($_POST['product_name']) && $_POST['product_name'] != "" && !isset($_SESSION['user_id'])) {
    $message = "נדרש לבצע התחברות מראש";
    echo "<script type='text/javascript'>alert('$message');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>תפריט</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script
            src="https://kit.fontawesome.com/8f0e178346.js"
            crossorigin="anonymous"
    ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="dist/css/bootstrap-responsive-tabs.css">
    <script src="dist/js/jquery.bootstrap-responsive-tabs.min.js"></script>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/products.css">
    <script>
        function on_search_clicked(){
            console.log("on_search_clicked clicked")
            var search_term = document.getElementById("search_term").value;
            console.log(search_term);
            window.location.href = "/includes/products.php?category=free_search&search_term="+search_term;
        }
    </script>


</head>
<body dir="rtl">
<?php
if ($session->is_signed_in()) {
    navbar_user($session->get_name(), $session->get_user_id(), $session->is_admin());
} else {
    navbar_user(null, null,false);
}
?>
<main>
    <div class="bs-example">
        <ul class="nav nav-tabs" id="categories-navbar">
            <li class="nav-item">
                <a href="#cookies?category=COOKIES" class="nav-link <?php echo $available_cookies ?>" data-toggle="tab" id="<?php echo $default_cookies ?>">עוגיות</a>
            </li>
            <li class="nav-item">
                <a href="#cakes" class="nav-link <?php echo $available_cakes ?>" data-toggle="tab" id="<?php echo $default_cakes ?>">עוגות</a>
            </li>
            <li class="nav-item">
                <a href="#pastries" class="nav-link <?php echo $available_pastries ?>" data-toggle="tab" id="<?php echo $default_pastries ?>">מאפים</a>
            </li>
            <li class="nav-item">
                <a href="#quiches" class="nav-link <?php echo $available_quiches ?>" data-toggle="tab" id="<?php echo $default_quiches ?>">קישים</a>
            </li>
            <li class="nav-item">
                <a href="#free_search" class="nav-link <?php echo $available_free_search ?>" data-toggle="tab" id="<?php echo $default_free ?>">חיפוש חופשי</a>
            </li>
            <?php
            if (!empty($session->get_shopping_cart())) {
                $cart_count = count(array_keys($session->get_shopping_cart()));
                ?>
                <a href="cart.php">
                    <div class="cart_div">
                        <i class="fas fa-shopping-cart" style="padding-right: 50px"> <?php echo $cart_count; ?></i>
                        הסל שלי
                    </div>
                </a>
                <?php
            }
            ?>
            <li class="added_to_cart_message">
                <?php echo $status;
                $status = null; ?>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade <?php echo $show_cookies ?> <?php echo $available_cookies ?>" id="cookies">
                <div style="clear:both;"></div>
                <div class="message_box showMe" style="margin:10px 0px;">
                    <?php echo $status;
                    $status = null; ?>
                </div>
                <section class="row row-cols-2 row-cols-md-4 lg-4 contents">
                    <?php
                    $products = Product:: products_by_category("COOKIES");
                    if (isset($products)) {
                        for ($i = 0; $i < sizeof($products); $i++) {
                            display_product($products[$i]->product_name, $products[$i]->product_price, $products[$i]->product_img);
                        }
                    }
                    ?>
                </section>
            </div>
            <div class="tab-pane fade <?php echo $show_pastries ?> <?php echo $available_pastries ?>" id="pastries">
                <div style="clear:both;"></div>
                <div class="message_box showMe" style="margin:10px 0px;">
                    <?php echo $status;
                    $status = null; ?>
                </div>
                <section class="row row-cols-2 row-cols-md-4 lg-4 contents">
                    <?php
                    $products = product:: products_by_category("PASTRIES");
                    if (isset($products)) {
                        for ($i = 0; $i < sizeof($products); $i++) {
                            display_product($products[$i]->product_name, $products[$i]->product_price, $products[$i]->product_img);
                        }
                    }
                    ?>
                </section>
            </div>
            <div class="tab-pane fade <?php echo $show_cakes ?> <?php echo $available_cakes ?>" id="cakes">
                <div style="clear:both;"></div>
                <div class="message_box showMe" style="margin:10px 0px;">
                    <?php echo $status;
                    $status = null; ?>
                </div>
                <section class="row row-cols-2 row-cols-md-4 lg-4 contents">
                    <?php
                    $products = product:: products_by_category("CAKES");
                    if (isset($products)) {
                        for ($i = 0; $i < sizeof($products); $i++) {
                            display_product($products[$i]->product_name, $products[$i]->product_price, $products[$i]->product_img);
                        }
                    }
                    ?>
                </section>
            </div>
            <div class="tab-pane fade <?php echo $show_cakes ?> <?php echo $available_cakes ?>" id="quiches">
                <div style="clear:both;"></div>
                <div class="message_box showMe" style="margin:10px 0px;">
                    <?php echo $status;
                    $status = null; ?>
                </div>
                <section class="row row-cols-2 row-cols-md-4 lg-4 contents">
                    <?php
                    $products = product:: products_by_category("QUICHES");
                    if (isset($products)) {
                        for ($i = 0; $i < sizeof($products); $i++) {
                            display_product($products[$i]->product_name, $products[$i]->product_price, $products[$i]->product_img);
                        }
                    }
                    ?>
                </section>
            </div>
            <div class="tab-pane fade <?php echo $show_free_search ?> <?php echo $available_free_search ?>" id="free_search">
                <section class="row row-cols-2 row-cols-md-4 lg-4 contents">
                    <div class="col-md-7 col-md-offset-2 ">
                        <div class="form-group" id="name">
                            <label for="name">חיפוש לפי שם מוצר</label>
                            <br>
                            <input id="search_term" value="<?php echo $search_text ?>" name="search_term" placeholder="שם המוצר המדויק" type="text" minlength="2" maxlength="300" class="form-control" >
                        </div>

                        <button class="btn1" onclick="on_search_clicked()" type="submit" >חפש</button>
                        <br>
                </section>
                <div style="clear:both;"></div>
                <div class="message_box showMe" style="margin:10px 0px;">
                    <?php echo $status;
                    $status = null; ?>
                </div>
                <section class="row row-cols-2 row-cols-md-4 lg-4 contents">
                    <?php
                    $products = product::search_products($search_text);
                    if (isset($products)) {
                        for ($i = 0; $i < sizeof($products); $i++) {
                            display_product($products[$i]->product_name, $products[$i]->product_price, $products[$i]->product_img);
                        }
                    }
                    ?>
                </section>
            </div>
        </div>
    </div>
</main>
<script>
    document.getElementById("default_open").click();
</script>
<footer>
    <p class="footer"> פרויקט גמר בקורס תכנות צד שרת | מרצה ד"ר אורלי ברזילי | האקדמית תל אביב יפו <br>
        © כל הזכויות שמורות לקים פרח פרץ, הודיה כהן ואיזבל אלאשווילי ©</p>
    <br>
</footer>
</body>
</html>