<?php
//when I log out can`t back
session_start();

if(isset($_SESSION['facebook_userid'])){

    $_SESSION['facebook_userid']=NULL;
    unset ($_SESSION['facebook_userid']);
}


header("Location: LoginPage.php");
die;



?>