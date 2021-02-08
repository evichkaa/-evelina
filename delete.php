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
if (isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "delete.php") ) {

    $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];

}

//if something was posted
if($_SERVER['REQUEST_METHOD'] == "POST") {

    $Post->delete_post($_POST['postid']);
    header("Location:" . $_SESSION['return_to']);
    die;
}

        $post = new Post();
        $error="";

        if(isset($_GET['id'])) {

            $row = $post->get_one_post($_GET['$id']);

            if(!$row){
                $error = "No such post found!";
            }else {
                if($row['userid'] != $_SESSION['facebook_userid']){
                    $error = "Access denied - you can`t delete this post!";
                }
            }
            } else {
                    $error = "No such post found!";

        }

        //if something was posted
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $Post->delete_post($_POST['postid']);
            header("Location: " . $_SESSION['return_to']);
            die;


        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Delete | Evabook </title>
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
                <h2>Delete Post</h2>
                <form method="post">

<!--                    <hr>-->
<!--                    --><?php

                    if($error!= ""){
                        echo $error;
                    }else {

                        echo"Are you sure you want to delete this post?";

                        $user = new User();
                        $row_user=$user->get_user($row['userid']);

                        include ("post_delete.php");
                      echo "  <input type='hidden' name='postid' value='$row[postid] '>";
                      echo "<input id='button-post' type='submit' value='Delete'>";
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