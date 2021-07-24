<?php
function display_product($product_name, $product_price, $product_img){
    $element = <<<EOD
    <link rel="stylesheet" href="../css/products.css"/>

    <section class="col">
        <div class="card">
        <form method='post' action=''>
            <img src="$product_img" class="card-img-top product_img" alt="..." />
            <div class="card-body">
                <h5 class="card-title  name="product_name" value="product_name">
                <input type='hidden' name='product_name' value="$product_name" />
                $product_name</h5>
                <p class="product_price" name="product_price">מחיר: ₪$product_price</p>
                
                כמות: <input class="amount-input" id="amount-input" name="amount-input" type="number" min="1" value="1"/>
                <br><br>                
                <button class="add-to-cart buy">
                    <i class="fas fa-shopping-cart"></i> הוסף לסל
                </button>
            </div>
        </form>
        </div>
    </section>
EOD;
    echo $element;
}
?>