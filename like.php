<?php

include ("classes/auto.php");

    $login = new Login();
    $user_data=$login->check_login($_SESSION['facebook_userid']);


if(isset($_SERVER['HTTP_REFERER'])) {
    $return_to = $_SERVER['HTTP_REFERER'];

}else{
    $return_to = "profile.php";
//    print_r($_GET);

}

if(isset($_GET['type']) && isset($_GET['id'])){

    if(is_numeric($_GET['id'])){

        $allowed[]='post';
        $allowed[]='user';
        $allowed[]='comment';

        if(in_array($_GET['type'], $allowed)){

            $post= new Post();
            $user_class= new User();
            $post->like_post($_GET['id'],$_GET['type'],$_SESSION['facebook_userid']);

            if($_GET['type'] == "user"){
            $post->follow_user($_GET['id'],$_GET['type'],$_SESSION['facebook_userid']);
            }
        }
    }

}

header("Location: profile.php" );
die;