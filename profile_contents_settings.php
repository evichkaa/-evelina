<div style=" min-height: 400px; width:100%;  background-color:white; text-align: center;">
    <div style="padding: 20px; max-width:350px; display: inline-block;">

        <form method="post" enctype="multipart/form-data">


<?php
include ("classes/auto.php");

$settings_class = new Settings();

$settings=$settings_class->get_settings($_SESSION['facebook_userid']);

if($settings){
echo "<input type='text' id='text_box' name=' first_name' value='".htmlspecialchars($settings['first_name'])."' placeholder='First name'/>";
echo "<input type='text' id='text_box' name=' last_name' value='".htmlspecialchars($settings['last_name'])."' placeholder='Last name'/>";


echo "<select id='text_box' name=' email' style='height: 30px'> 
<option>".htmlspecialchars($settings['gender'])."</option>
<option>Male</option>
<option> Female </option>
</select>";

echo "<input type='text' id='text_box' name=' email' value='".htmlspecialchars($settings['email'])."'placeholder='Email'/>";
echo "<input type='password'' id='text_box' name=' password' value='".htmlspecialchars($settings['password']). "'placeholder='password'/>";
echo "<input type='password'' id='text_box' name=' password2' value='".htmlspecialchars($settings['password'])."' placeholder='password' />";

echo "<br> About me <br>
<textarea id='text_box' style='height: 200px;' name='about'> ".htmlspecialchars($settings['about'])."</textarea>
";
echo '<input id="button-post" type="submit" value="Save">';
}

?>
        </form>
    </div>
</div>