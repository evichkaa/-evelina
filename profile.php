<?php

//print_r($_SESSION);
//print_r($result);

include ("classes/auto.php");


$login = new Login();
$user_data=$login->check_login($_SESSION['facebook_userid']);
$USER= $user_data;

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $profile = new Profile();
    $profile_data = $profile->get_profile($_GET['id']);

    if (is_array($profile_data)) {
        $user_data = $profile_data[0];
    }
}
//POSTING Start here

if($_SERVER['REQUEST_METHOD'] == "POST"){

if(isset($_POST['firstname'])){
$settings_class = new Settings();
$settings_class->save_settings($_POST,$_SESSION['facebook_userid']);

}else {
    $post=new Post();
    $id=$_SESSION['facebook_userid'];
    $result=$post->create_post($id, $_POST,$_FILES);




//    print_r($_POST);
    if($result == ""){
        header("Location: profile.php");
        die;
    }else{
        echo "<div id='errors' style='text-align: center; font-size: 20px; color: white; background-color: grey; '>";
        echo "The following errors occured<br>";
        echo $result;
        echo "</div>";
    }
}

}
//to save the post

$post=new Post();
$id=$user_data['userid'];

$posts=$post->get_posts($id);

// to save friends

$user=new User();
$id=$user_data['userid'];

$friends=$user->get_following($user_data['userid'], $user);
$image_class = new Image();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> Profile | Facebook </title>
</head>
<style type="text/css">
    body {
        padding: 0;
        margin: 0;
    }
    #top-bar{
        height: 50px;
        background-color: #405d9d;
        color: #d9dfeb;
    }
 #search-box{
     width: 400px;
     height: 20px;
     border-radius: 5px;
     border: none;
     padding: 5px;
     background-image: url("search.png");
     background-repeat: no-repeat;
     background-position:right ;
 }
    #textbox{
        width: 100%;
        height: 20px;
        border-radius: 5px;
        border: none;
        padding: 5px;
        border: solid thin grey;
        margin:10px;
    }
 #cover-photo{
     width: 1000px;
     margin: auto;
     min-height: 400px;
 }
 #profile-picture{
     width: 150px;
     margin-top: -125px;
     border-radius: 50%;
     border: solid 3px white;
 }
 #menu-button{
     width:100px;
     display: inline-block;
     margin: 3px;
 }
 #friends-image{
     width:75px;
     float: left;
     margin: 10px;

 }
 #friends-bar{
     background-color: white;
     min-height: 400px;
     margin-top: 20px;
     color: grey;
     padding: 10px;

 }
  #friends{
      clear: both;
      font-size: 12px;
      font-weight: bold;
      color: #405d9d;
  }

  #post-box{
       width: 100%;
      border: none;
      font-family: Tahoma, serif;
      font-size: 14px;
      height: 50px;
  }

  #button-post{
      float: right;
      background-color: #405d9d;
      border: none;
      color:white;
      padding: 4px;
      font-size: 14px;
      border-radius: 2px;
      width: 50px;
      min-width: 50px;
      cursor: pointer;
  }
  #timeline-posts{
      margin-top: 20px;
      background-color: white;
      padding: 10px;
  }


</style>
<body style=" font-family: Tahoma, serif; background-color: #d0d8e4">
<?php include ("header.php");?>

<!--cover-->
<div id="cover-photo" >
    <div style="background-color: white; text-align:center; color: #405d9d  ">
        <?php
        $image="";
        if(file_exists($user_data['cover_pic'])){
            $image = $image_class->get_thumb_cover($user_data['cover_pic']) ;
        }
        ?>
        <img src="<?php echo $image ?>" style="width:100%" alt="">
            <?php
            $mylikes="";
            if ($user_data['likes']>0){
                $mylikes ="(" . $user_data['likes'] . "Followers )";
            }
            ?>

        <a href="profile.php?type=user&id= <?php echo $user_data['userid']?> " >
        <input id="button-post" type="button" value="Follow (<?php echo $mylikes ?> " style="margin-right: 10px; background-color: lightblue; width: "  >
        </a>

        <span style="font-size: 12px;">
            <?php
            $image="images/user_male.jpg";
            if($user_data['gender'] == "Female"){
                $image="images/user_female.jpg";
            }
            if(file_exists($user_data['profile_pic'])){
                $image = $image_class->get_thumb_profile($user_data['profile_pic']);
            }
            ?>
            <img alt=""  id="profile-picture" src="<?php echo $image ?>"><br/>

        <a style="text-decoration: none; color: black;" href="picture-change.php?change=profile&b=hello">Change Profile image</a> |
            <a style="text-decoration: none; color: black;" href="picture-change.php?change=cover">Change Cover</a>
        </span>
        <br>

        <div style="font-size: 25px;">
            <a href="profile.php?id=<?php echo $user_data['userid']?>">
            <?php echo $user_data['first_name'] . " " . $user_data['last_name']?> </div>
        <br> <br>
        <a href="Timeline.php?section=timeline"><div id="menu-button">Timeline</div></a>
        <a href="profile.php?section=about&id=<?php echo $user_data['userid']?>"><div id="menu-button">About</div></a>
        <a href="profile.php?section=about&followers<?php echo $user_data['userid']?>"><div id="menu-button">Followers</div></a>
        <a href="profile.php?section=following&id=<?php echo $user_data['userid']?>"><div id="menu-button">Following</div></a>
        <a href="profile.php?section=friends&id=<?php echo $user_data['userid']?>"><div id="menu-button">Friends</div></a>
        <a href="profile.php?section=photos&id=<?php echo $user_data['userid']?>"><div id="menu-button">Photos</div></a>
        <?php
        if($user_data['userid']== $_SESSION['facebook_userid']){
       echo  '<a href="profile.php?section=settings&id= '.$user_data['userid'].'"><div id="menu-button">Settings</div></a>';
        }
        ?>

</div>
    <?php

    $section = "default";
    if(isset($_GET['section'])){
        $section = $_GET['section'];
    }
    if($section == "default"){
    include ("profile_content_default.php");

    }else if($section == "followers") {

        include("profile_contents_followers.php");
    }
    else if($section == "photos") {

        include("profile_contents_photos.php");
    }else if($section == "following") {

        include("profile_contents_following.php");
    }
    else if($section == "settings") {

        include("profile_contents_settings.php");
    }else if($section == "about") {

        include("profile_contents_about.php");
    }
    ?>

</div>
</body>
</html>