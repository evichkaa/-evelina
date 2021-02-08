<div style=" min-height: 400px; width:100%;  background-color:white; text-align: center;">
    <div style="padding: 20px; max-width:350px; display: inline-block;">

        <form method="post" enctype="multipart/form-data">


<?php
include ("classes/auto.php");

$settings_class = new Settings();

$settings=$settings_class->get_settings($_SESSION['facebook_userid']);

if($settings){

echo "<br> About me <br>
<div id='text_box' style='height: 200px;' > ".htmlspecialchars($settings['about'])."</div>";

}

?>
        </form>
    </div>
</div>