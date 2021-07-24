<?php
require_once('../classes/init.php');
require_once('../includes/header.php');
global $session;
$status_error="";
$status="";

if(isset($_GET['social_media'])){
    $social_media_redirect = $_GET['social_media'];
    header('Location: '.$social_media_redirect);
//        include ('./recipes.php');
}
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $error=Contacts::add_contact($name, $email, $message);
    if ($error) {
        $status_error = "<div class='box' style='color:red; text-align: center'>קיימת שגיאה, נא לרענן את הדף</div>";
    }
    else{
        $status = "<div class='box' font-size='15px' style='color:green; text-align: center'>פנייתך נשלחה בהצלחה!</div>";
    }
}
?>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>צור קשר</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <link rel="stylesheet" href="./../css/index.css"/>
    <link rel="stylesheet" href="../css/ContactUs.css"/>
</head>
<body dir="rtl">
<?php
if ($session->is_signed_in()) {
    navbar_user($session->get_name(), $session->get_user_id(), $session->is_admin());
} else {
    navbar_user(null, null,false);
}
?>
<section>
    <div class="message_box" style="margin:10px 0px;">
        <?php echo $status; ?>
    </div>
    <?php
    if ($status_error == ""){?>
        <div class="container-contact">
            <div class="wrap-contact">
                <div class="listing-hero">
                    <div class="hero-heading">
                        <div class="hero-large">צור קשר</div>
                        <br>
                        <div class="hero-text"> <i>יש לכם שאלה? תרצו לספר לנו על חווית השירות? <br>אנו זמינים לשירותכם בכל עניין :) </i> </div>
                        <br>
                        <div class="hero-text">  באפשרותכם לשלוח לנו מכתב </i> </div>
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            Select image to upload:
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <br>
                            <br>
                            <input class="contact-form-btn" type="submit" value="שלח פנייה" name="submit_file">
                        </form>
                        <br>
                        <div class="hero-text">  או להשאיר לנו פנייה </i> </div>
                        <br>
                    </div>
                </div>
                <form name="contact" class="contact-form validate-form" action="ContactUs.php" method="post">
                    <div class="wrap-input validate-input" data-validate="Please enter your name">
                        <input class="input" type="text" name="name" minlength="2" maxlength="30" placeholder="שם מלא" required>
                    </div>
                    <div class="wrap-input validate-input" data-validate = "Please enter your email">
                        <input class="input" type="email" name="email" placeholder="כתובת מייל" required>
                    </div>
                    <div class="wrap-input validate-input" data-validate = "Please enter your message">
                        <textarea class="input" type="text" name="message" placeholder="ההודעה שלך" required></textarea>
                    </div>
                    <div class="container-contact-form-btn">
                        <button type="submit" class="contact-form-btn">
                            <span>שלח</span>
                        </button>
                    </div>
                </form>

                <div class="hero-text"> <i> אנו נשתדל לענות בהקדם האפשרי, </i> </div>
                <br>
                <div class="hero-text"> <i> במקרים דחופים ניתן להשיג אותנו גם בטלפון: 03-1231230 </i> </div>
                <div class="container-contact-form-btn">
                    <a class="button" href="ContactUs.php?social_media=https://www.facebook.com">לחץ למעבר לפייסבוק שלנו</a>
                </div>
                <div class="container-contact-form-btn">
                    <a class="button" href="ContactUs.php?social_media=https://www.instagram.com">לחץ למעבר לאינסטגרם שלנו</a>
                </div>
            </div>
        </div>

        <?php
    }else {
        echo $status_error;
    }
    ?>
    </div>

    <div class="container-contact2">
    </div>
    <br><br><br>
</section>
<footer>
    <p2 class="footer"> פרויקט גמר בקורס תכנות צד שרת | מרצה ד"ר אורלי ברזילי | האקדמית תל אביב יפו <br>
        © כל הזכויות שמורות לקים פרח פרץ, הודיה כהן ואיזבל אלאשווילי ©</p2>
    <br>
</footer>
</body>
</html>