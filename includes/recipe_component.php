<?php  

function display_recipe($name, $thumbnail_url, $description, $video_url){

$element = <<<EOD

    
    <section class="col">
       <div class="recipe" style="float: left">
              <h5 style="float: left; margin-right: 90px; margin-left: 90px; margin-bottom:50px; color: white">$name</h5>
              <br>
            <video id="video" controls style="max-width: 300px; float: left; margin-right: 90px; margin-left: 90px; margin-bottom:50px;">
                <source src="$video_url">
            </video>
        </div>
    </section>
   
EOD;

echo $element;

}
    ?>
