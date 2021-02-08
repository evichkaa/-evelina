<?php


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
if($_SERVER['REQUEST_METHOD'] == "POST"){


    $post=new Post();
    $id=$_SESSION['facebook_userid'];
    $result=$post->create_post($id, $_POST,$_FILES);




//    print_r($_POST);
    if($result == ""){
        header("Location: Timeline.php");
        die;
    }else{
        echo "<div id='errors' style='text-align: center; font-size: 20px; color: white; background-color: grey; '>";
        echo "The following errors occured<br>";
        echo $result;
        echo "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Profile | Evabook </title>
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
    <div style="width: 800px; margin: auto; ">

    </div>
    <div style="display: flex;">
        <!--friends-->
        <div style=" min-height: 400px; flex:1;">
            <div id="friends-bar">
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
                <a href="profile.php" style="text-decoration: none;"><?php echo $user_data['first_name']. " " . $user_data['last_name']?></a>

            </div>
        </div>
        <!--timeline-->
        <div style=" min-height: 400px; flex: 2.5; padding: 20px 0 20px 20px;">

            <div style="border: solid thin #aaa; padding: 10px; background-color:white; ">
                <form method="post" enctype="multipart/form-data">
                    <label for="post-box"></label><input name="post" id="post-box" placeholder="Whats on your mind?">
                    <input type="file" name="file">
                    <input id="button-post" type="submit" value="Post">
                    <br>
                </form>
            </div>
            <!--timeline-posts-->
            <div id="timeline-posts">

                <?php
                $DB= new Database();
                $user_class=new User();
                $image_class=new Image();

                $followers = $user_class->get_following($_SESSION['facebook_userid'], "user");
                $follower_id=false;
                if(is_array($followers)){

                    $follower_ids=array_column($followers, "userid");
                    $follower_ids=implode("',", $follower_ids);

                }

                if(isset($follower_ids)&& $follower_ids){
                    $myuserid=$_SESSION['facebook_userid'];
                $sql="select * from posts where parent=0 userid = '$myuserid' || userid in('".$follower_ids."') order by id desc limit 30";
                $posts=$DB->read($sql);
                }


                if(isset($posts)&& $posts){
                    foreach ($posts as $row){
                        $user = new User();
                        $row_user = $user->get_user($row['userid']);
                        include ("post.php");
                    }
                }



                ?>




            </div>


        </div>
    </div>
</div>
</body>
</html>