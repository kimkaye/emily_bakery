<?php
require_once('../classes/init.php');
require_once('../includes/header.php');
global $session;
$error='';

if(isset($_GET["signerror"])){
    $signerror = $_GET["signerror"];
    if ($signerror=='invalidusername'){
        $username = $_GET["username"];
        $error .= "שם המשתמש כבר קיים!<br> $username ";
    }elseif ($signerror=='mailexists'){
        $email = $_GET["mail"];
        $error .= "המייל תפוס!<br> $email";
    }elseif ($signerror=='invalidname'){
        $name = $_GET["name"];
        $error .= "$name נדרש למלא שם מלא!<br>  +";
    }elseif ($signerror=='invalidmailformat'){
        $email = $_GET["mail"];
        $error .=  " פורמט מייל לא תקין!<br>$email";
    }elseif ($signerror=='duplicateid'){
        $error .= "תעודת הזהות כבר קיימת!<br>";
    }elseif ($signerror=='invalidid'){
        $error .= $error."תעודת הזהות חייבת להכיל 9 ספרות!<br>";
    }elseif ($signerror=='invalidphone'){
        $error .= "נדרש למלא מספר טלפון!<br>";
    }elseif ($signerror=='invalidbirth_year'){
        $error .= "נדרש למלא שנת לידה!<br>";
    }elseif ($signerror=='invalidpassword'){
        $error .= "נדרש למלא סיסמה!<br>";
    }elseif ($signerror=='internal'){
        $message = "שגיאה בעת ההרשמה";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>
<html>
<head>
    <title>הרשמה</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" type="text/css" href="../css/register.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body dir="rtl">
<header>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-4 image-container">
                <img class="img-fluid logo " alt="header image" src="../assets/logo.png" style="max-width: 20%; height: 10vm" >
            </div>
            <div class="col-md-4 text-center" >
                <h2 class="my-md-3 site-title">הרשמה</h2>
            </div>
        </div>
    </section>
</header>
<main>
    <form action="register_a.php" name="register" method="POST" onsubmit="return ValidateForm();">
        <?php
        if (strlen($error) > 0)
        {
            echo "<div class='alert alert-info'><strong>מידע : </strong>".$error."</div>";
        }
        ?>
        <div class="input-group">
            <div class="input-group">
                <label>שם משתמש</label>
                <input type="text" name="user_name" placeholder="שם משתמש" minlength="2" maxlength="30" required>
            </div>
            <label>תעודת זהות</label>
            <input type="text" name="id"  placeholder="תעודת זהות" maxlength="9" minlength="9" required>
        </div>
        <div class="input-group">
            <label>סיסמה</label>
            <input type="password" name="password" placeholder="סיסמה" minlength="9" maxlength="15" required>
        </div>
        <div class="input-group">
            <label>כתובת מייל</label>
            <input type="text" name="email" placeholder="כתובת מייל" maxlength="50" required>
        </div>
        <div class="input-group">
            <label>שם מלא</label>
            <input type="text" name="name" placeholder="שם מלא" minlength="2" maxlength="100" required >
        </div>
        <div class="input-group">
            <label>מספר טלפון</label>
            <input type="tel" pattern="[0-9]{10}" placeholder="מספר טלפון" name="phone" maxlength="10" minlength = "10" required>
        </div>
        <div class="input-group">
            <label>שנת לידה</label>
            <input type="number" name="birth_year" placeholder="שנת לידה" min="1900" max = "2021" required>
        </div>
        <div class="input-group">
            <button type="submit" class="btn1" name="reg_user" >הירשם</button>
        </div>
        <p>
            <center>
            כבר רשום?
        </center>
            <a class="nav-link" href="Login.php" align="center"> התחבר </a>
            <a class="nav-link" href="home.php" align="center"> חזרה לדף הבית </a>
        </p>
    </form>
</main>
<footer>
    <p2 class="footer"> פרויקט גמר בקורס תכנות צד שרת | מרצה ד"ר אורלי ברזילי | האקדמית תל אביב יפו <br>
        © כל הזכויות שמורות לקים פרח פרץ, הודיה כהן ואיזבל אלאשווילי ©</p2>
    <br>
</footer>
<!--<script>alert("Gotcha!")</script>-->
</body>
</html>
