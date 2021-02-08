<?php


//include ("classes/Login.php");
//include ("classes/user.php");
//include ("classes/post.php");
//include ("classes/image.php");
//include ("classes/profile.php");



include ("classes/auto.php");


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

        $post= new Post();
        $likes=false;

        $error="";


        if(isset($_GET['id'])&& isset($_GET['type'])) {

            $likes = $post->get_likes($_GET['id'], $_GET['type']);
            } else {
                    $error = "No information was found!";

        }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> People who like | Evabook </title>
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
                <h2>How many people like this post?</h2>

            </div>
            <?php
                $user= new User();
                $image_class= new Image();
                if(is_array($likes)){
                    foreach ($likes as $row){
                        $friend_row = $user->get_user($row['userid']);

                       include("user.php");
                    }
                }
            ?>
            <br style="clear: both;">

                </div>


                </div>




            </div>


        </div>


</body>
</html>