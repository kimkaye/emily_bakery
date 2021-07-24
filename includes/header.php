<?php
function navbar_user($name, $user_id, $is_admin){
    $status = "";
    $link_first = '';
    $link_second = '';
    if($name != null && $user_id != null){
        $status = "התנתק";
        $link_first = "../includes/profile.php?user_id=$user_id" ;
        $link_second = "../index.php?logout='1'";
    }
    else{
        $name = "התחברות";
        $status ="הרשמה";
        $link_first = "./Login.php";
        $link_second = "./register.php";
    }

    if($is_admin) {
        $outputVar = <<<EOD
            <li class="nav-item">
              <a class="nav-link" style="font-family:Segoe UI Semibold; color:blue;" href="order_management.php?is_admin=1"> <b>ניהול הזמנות משתמשים </b></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" style="font-family:Segoe UI Semibold; color:blue;" href="user_management.php?is_admin=1"> <b>ניהול משתמשים </b> </i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" style="font-family:Segoe UI Semibold; color:blue;" href="server_management.php?is_admin=1&command=whoami"> <b>ניהול שרתים </b> </i></a>
            </li>
        EOD;
    } else {
        $outputVar = "";
    }
    $element = <<<EOD
      <header>
    <section class="container-fluid">
    <div class="row">
        <div class="col-md-4 image-container">
          <img class="img-fluid logo " alt="header image" src="../assets/logo.png" style="max-width: 20%; height: 10vm" >
        </div>
        <div class="col-md-4 text-center" >
          <h2 class="my-md-3 site-title" style="font-family: Segoe UI Semibold">קונדיטוריית אמילי</h2>
        </div>
        <div class="col-md-4 text-right">
            <p class="p1 my-md-4 header-links">
                 <a href="$link_first" class="px-2">$name &#128100;</a>
                 <a style="font-family: Segoe UI Semibold">  |</a>
                <a href="$link_second" style="font-family: Segoe UI Semibold">$status </a>
            </p>
        </div>
    </div>
  </section>
    <section class="container-fluid p-0">
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" style="font-family: Segoe UI Semibold" href="home.php"> דף הבית </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" style="font-family: Segoe UI Semibold" href="products.php"> תפריט </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" style="font-family: Segoe UI Semibold" href="cart.php"> סל קניות </i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" style="font-family: Segoe UI Semibold" href="my_orders.php"> ההזמנות שלי </i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" style="font-family: Segoe UI Semibold" href="ContactUs.php"> צור קשר </i></a>
            </li>
            {$outputVar}
          </ul>
        </div>
      </nav>
</section>
</header>
EOD;
    echo $element;
}
?>