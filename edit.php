<?php


include ("classes/Login.php");
include ("classes/user.php");
include ("classes/post.php");
include ("classes/image.php");
include ("classes/profile.php");




$login = new Login();
$user_data=$login->check_login($_SESSION['facebook_userid']);
$USER= $user_data;

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $profile = new Profile();
    $profile_data = $profile->get_profile($_GET['id ']);

    if (is_array($profile_data)) {
        $user_data = $profile_data[0];
    }
}
        $post = new Post();
        $error="";

        if(isset($_GET['id'])) {

            $row = $post->get_one_post($_GET['$id']);

            if (!$row) {
                $error = "No such post found!";
            } else {
                if ($row['userid'] != $_SESSION['facebook_userid']) {
                    $error = "Access denied - you can`t delete this post!";
                }
            }
        }else {
            $error = "No such post found!";

        }



        if (isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "edit.php") ) {

            $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];

        }
        //if something was posted
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $Post->delete_post($_POST['postid']);
             header("Location:" . $_SESSION['return_to']);
                        die;
                    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Edit | Evabook </title>
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
    #profile-picture{
        width: 150px;
        border-radius: 50%;
        border: solid 3px white;
    }

    #friends-bar{
        min-height: 400px;
        margin-top: 20px;
        padding: 10px;
        text-align: center;
        font-size: 20px;
        color:#405d9d;

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
    }
    #timeline-posts{
        margin-top: 20px;
        background-color: white;
        padding: 10px;
    }
    #posts{
        padding: 5px;
        font-size: 13px;
        display: flex;
        margin-bottom: 20px;
    }

</style>
<body style=" font-family: Tahoma,serif; background-color: #d0d8e4">
<?php include ("header.php");?>

<!--cover-->
<div id="cover-photo" >
    <div style="width: 800px; margin: auto; min-height: 400px;">


    <div style="display: flex;">

        <!--Delete-timeline-->
        <div style=" min-height: 400px; flex: 2.5; padding: 20px 0 20px 20px;">

            <div style="border: solid thin #aaa; padding: 10px; background-color:white; ">

                <form method="post" enctype="multipart/form-data">

<!--                    <hr>-->
<!--                    --><?php

                    if($error!= ""){
                        echo $error;
                    }else {

                        echo"Edit Post <br><br>";
                        echo '<label for="post-box"></label><input name="post" id="post-box" placeholder="Whats on your mind?">'.$row['userid'].'
            <input type="file" name="file">';

                      echo "  <input type='hidden' name='postid' value='$row[postid] '>";
                      echo "<input id='button-post' type='submit' value='Save'>";

                        if(file_exists($row['image'])){
                            $image_class = new Image();
                            $post_image = $image_class->get_thumb_post($row['image']);


                            echo "<br><div style='text-align: center;'><img src='$post_image' style='width: 50%'/></div>";
                        }
                    }



                    ?>


                    <br>
                </form>

            </div>


                </div>


                </div>




            </div>


        </div>


</body>
</html>