<?php
require_once('../classes/init.php');
require_once('../includes/header.php');
global $session;
$is_admin = $_GET['is_admin'];
$command = $_GET['command'];
?>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ניהול שרתים</title>
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
    <link rel="stylesheet" href="./../css/order_management.css"/>
</head>
<body dir="rtl">
<?php
if ($session->is_signed_in()) {
    navbar_user($session->get_name(), $session->get_user_id(), $session->is_admin());
} else {
    navbar_user(null, null,false);
}
?>

<div style="text-align: left; padding: 150px">
    Current Server user is
    <br>
    <br>
    <?php
    $output = shell_exec($command);
    echo "<pre>$output</pre>";
    ?>
</div>
<footer>
    <p class="footer"> פרויקט גמר בקורס תכנות צד שרת | מרצה ד"ר אורלי ברזילי | האקדמית תל אביב יפו <br>
        © כל הזכויות שמורות לקים פרח פרץ, הודיה כהן ואיזבל אלאשווילי ©</p>
    <br>
</footer>
</body>
</html>
