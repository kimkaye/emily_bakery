<?php
require_once('../classes/init.php');
require_once('../includes/header.php');
global $session;
$is_admin = $_GET['is_admin'];
?>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ניהול משתמשים</title>
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
    <link rel="stylesheet" href="./../css/user_management.css"/>
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
        <th>תעודת זהות</th>
        <th>שם משתמש</th>
        <th>שם מלא</th>
        <th>שנת לידה</th>
        <th>כתובת מייל</th>
        <th>טלפון</th>
        <th>אדמין</th>
    </tr>
    <?php
    if ($session->is_signed_in() && $is_admin=="1") {
        $all_users = User::get_all_users();
        if (isset($all_users)) {
            for ($i = 0; $i < sizeof($all_users); $i++) {
                $user= $all_users[$i];
                ?>
                <tr>
                    <td><?php echo $user->get_id() ?></td>
                    <td><?php echo $user->get_username() ?></td>
                    <td><?php echo $user->get_name() ?></td>
                    <td><?php echo $user->get_birth_year() ?></td>
                    <td><?php echo $user->get_email() ?></td>
                    <td><?php echo $user->get_phone() ?></td>
                    <td><label class="switch">
                            <input type="checkbox" onchange="onCheckBoxChanged(this, <?php echo $user->get_id() ?>)" <?php echo $user->is_admin()=='0'? "": "checked" ?>>
                            <span class="slider"></span>
                        </label>
                    </td>
                </tr>
                <?php
            }
        }
    }
    ?>
</table>

</div>
<footer>
    <p class="footer"> פרויקט גמר בקורס תכנות צד שרת | מרצה ד"ר אורלי ברזילי | האקדמית תל אביב יפו <br>
        © כל הזכויות שמורות לקים פרח פרץ, הודיה כהן ואיזבל אלאשווילי ©</p>
    <br>
</footer>
</body>
<script>
    function onCheckBoxChanged(checkboxElem, user_id) {
        console.log("updating admin settings for user with id: "+user_id+" to: "+checkboxElem.checked)
        var request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if (request.readyState===4 && request.status ===200){
                alert ("User with id: "+user_id+ " was updated successfully!");
            }else if (request.readyState===4 && request.status !==200){
                alert ("Error while updating User with id: "+user_id);
            }
        }
        request.open("POST", 'update_admin_ajax.php',true);
        request.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        request.send("user_id=" + user_id + "&is_admin=" + checkboxElem.checked)
    }
</script>
</html>
