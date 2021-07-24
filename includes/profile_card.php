<?php
function display_profile($id, $username, $name, $mail, $phone, $date_year, $pass_change_info){
    $logout_link = "../index.php?logout='1'";
    $element = <<<EOD
<body dir="rtl">
        <div class="profile_card">
            <img src="../assets/kissclipart-cartoon-baker-woman-clipart-bakery-woman-clip-art-183ad7dd0dd0796f.jpg" alt="kim" style="width:100%">
            <br>
            <br>
            <h4>שלום $name</h4>
            <p class="title">שם משתמש: $username</p>
            <p class="title">מייל: $mail</p>
            <p class="title">תעודת זהות: $id</p>
            <p class="title">טלפון: $phone</p>
            <p class="title">שנת לידה: $date_year</p>
        </div>
        
        <form action="change_pass_ajax.php" name="change_pass" method="POST">
            <div class="form-group">
                <label>סיסמה</label>
                <input type="password" name="pwd" placeholder="סיסמה" minlength="9" maxlength="15" required>
            </div>
            <div class="form-group">
                <label>סיסמה שנית</label>
                <input type="password" name="pwd2" placeholder="סיסמה" minlength="9" maxlength="15" required>
            </div>
            <button class="btn1" type="submit">עדכן סיסמה</button>
        </form>
        {$pass_change_info}
  </body>
EOD;
    echo $element;
}
?>