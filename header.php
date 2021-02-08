<!--top bar-->
<?php
$top_image="images/user_male.jpg";
if(isset($USER)){
if(file_exists($USER['profile_pic']))
{
        $image_class = new  Image();
        $top_image = $image_class->get_thumb_profile($USER['profile_pic']);
    }else {
         if($USER['gender'] == 'Female'){
             $top_image="images/user_female.jpg";
         }
    }
}
?>
<div id="top-bar">
    <form method="get" action="search.php">
    <div style="width: 950px; margin: auto; font-size: 30px">
        <a href="Timeline.php" style="color: white; text-decoration: none; ">Facebook</a>

        &nbsp &nbsp &nbsp <label for="search-box"></label>
        <input type="text" id="search-box name='find'" placeholder="Search in Evabook">

           <a href="profile.php">
        <img src="<?php echo $top_image ?>" style="width: 50px; float: right; border-radius: 50%;"></a>
        <a href="Logout.php" >
            <span style="float: right;color: white; font-size: 14px; margin:10px;">Logout</span>
        </a>

    </div>
    </form>
</div>