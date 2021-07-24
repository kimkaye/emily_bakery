<?php
require_once('../classes/init.php');
require_once('../includes/header.php');
require_once('../includes/recipe_component.php');
global $session;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>דף הבית</title>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script
            src="https://kit.fontawesome.com/8f0e178346.js"
            crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="../css/home.css">
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
    <div class="image">
    </div>
    <br>
    <h4 style="text-align: center; color: palevioletred; font-weight: lighter">אנו מזמינים אתכם לצפות במתכוני השייקים הנחשקים של העונה!</h4>
    <br>
    <h5 style="text-align: center; color: palevioletred; font-weight: lighter">משתלבים נהדר עם המאפים המלוחים של קולקציית קיץ 2021 :) </h5>
    <br>
    <?php
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        include ($page);
//        include ('./recipes.php');
    }
//    $curl = curl_init();
//
//    curl_setopt_array($curl, [
//        CURLOPT_URL => "https://tasty.p.rapidapi.com/recipes/list?from=0&size=3&tags=under_30_minutes&q=milkshake",
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_FOLLOWLOCATION => true,
//        CURLOPT_ENCODING => "",
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 30,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => "GET",
//        CURLOPT_HTTPHEADER => [
//            "x-rapidapi-host: tasty.p.rapidapi.com",
//            "x-rapidapi-key: be6bad8082msh722515159a95600p115708jsnf8b966d5b5e5"
//        ],
//    ]);
//
//    $response = curl_exec($curl);
//    $err = curl_error($curl);
//    curl_close($curl);
//    if ($err) {
//        echo "cURL Error #:" . $err;
//    } else {
//        $data = json_decode($response, true);
//        $list = $data['results'];
//
//        foreach ($list as $item){
//            $name = $item['name'];
//            $thumbnail_url = $item['thumbnail_url'];
//            $description = $item['description'];
//            $video_url = $item['original_video_url'];
//            display_recipe($name, $thumbnail_url, $description, $video_url);
//        }
//    }
    ?>
    </div>
</main>
<footer>
    <p class="footer"> פרויקט גמר בקורס תכנות צד שרת | מרצה ד"ר אורלי ברזילי | האקדמית תל אביב יפו <br>
        © כל הזכויות שמורות לקים פרח פרץ, הודיה כהן ואיזבל אלאשווילי ©</p>
    <br>
</footer>
</body>
</html>
