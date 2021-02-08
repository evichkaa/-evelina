<?php

session_start();

include ("classes/connect.php");
include ("classes/Login.php");
include ("classes/user.php");
include ("classes/post.php");
include ("classes/image.php");


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$login = new Login();
$user_data=$login->check_login($_SESSION['facebook_userid']);
echo "<pre>";
print_r($_GET);
echo "</pre>";
if($_SERVER['REQUEST_METHOD'] == "POST") {


    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
        //image/jpeg
        if($_FILES['file']['type'] == "image/jpeg"){

            $allowed_size = (1024 *1024)*100;
            if($_FILES['file']['size']< $allowed_size){
            //everything is fine
                $folder= "Uploads/" . $user_data['userid'] . "/";
                // create folder
                if(!file_exists($folder)){
                    mkdir($folder,0777,true);
                }
                $image=new Image();
              $filename = $folder . $image->generate_filename(15) . "jpg";
              move_uploaded_file($_FILES['file']['tmp_name'],$filename);

                $change="profile";

                //check which pic to change
                if(isset($_GET['change'])){

                    $change=$_GET['change'];
                }

                if($change=="cover") {
                    if(file_exists($user_data['cover_pic'])){
                        unlink($user_data['cover_pic']);
                    }
                    $image->resize_image($filename, $filename, 1500, 1500);
                }else {
                    if(file_exists($user_data['profile_pic'])){
                        unlink($user_data['profile_pic']);
                    }
                    $image->resize_image($filename, $filename, 1500, 1500);
                }
              if(file_exists($filename)){

                  $userid=$user_data['userid'];




                  if($change=="cover") {
                      $query = "update users set cover_pic = '$filename' where userid = '$userid' limit 1";
                      $_POST['is_cover_image']=1;
                  }else {
                      $query = "update users set profile_pic = '$filename' where userid = '$userid' limit 1";
                      $_POST['is_profile_image']=1;
                  }


                  $DB = new Database();
                  $DB->save($query);

                  //create a post

                  $post=new Post();

                  $_POST['is_profile_image']=1;

                  $post->create_post($userid, $_POST,$filename);

                  header(("Location:profile.php"));
                  die;
              }

          }else {
              echo "<div id='errors' style='text-align: center; font-size: 20px; color: white; background-color: grey; '>";
              echo "The following errors occured<br>";
              echo "Only image of size 3Mb or lower are allowed!";
              echo "</div>";
          }
        }else {
            echo "<div id='errors' style='text-align: center; font-size: 20px; color: white; background-color: grey; '>";
            echo "The following errors occured<br>";
            echo "Please add a image of jpeg format.";
            echo "</div>";
        }

}else {
        echo "<div id='errors' style='text-align: center; font-size: 20px; color: white; background-color: grey; '>";
        echo "The following errors occured<br>";
        echo "Please add a valid image.";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Change profile image | Evabook </title>
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
    #cover-photo{
        width: 1000px;
        margin: auto;
        min-height: 400px;
    }




    #button-post{
        float: right;
        background-color: #405d9d;
        border: none;
        color:white;
        padding: 4px;
        font-size: 14px;
        border-radius: 2px;
        width: 70px;
    }

</style>
<body style=" font-family: Tahoma,serif; background-color: #d0d8e4">
<?php include ("header.php");?>

<!--cover-->
<div id="cover-photo" >
    <div style="width: 800px; margin: auto; ">

    </div>
    <div style="display: flex;">

        <!--timeline-->
        <div style=" min-height: 400px; flex: 2.5; padding: 20px 0 20px 20px;">
<form method="post" enctype="multipart/form-data">
            <div style="border: solid thin #aaa; padding: 10px; background-color:white; ">
                <input type="file" name="file">
                <input id="button-post" type="submit" value="Change">
                <br>
                <div style="text-align: center;">


                <?php
                $change="profile";

                //check which pic to change// to see the photo
                if(isset($_GET['change'])&& $_GET['change']=="cover"){

                    $change="cover";
                   echo "<img src='$user_data[cover_pic]' style='max-width: 500px;'>";
                }else {
                    echo "<img src='$user_data[profile_pic]' style='max-width: 500px;'>";
                }

                ?>
                </div>
            </div>

</form>





            </div>


        </div>
    </div>

</body>
</html>