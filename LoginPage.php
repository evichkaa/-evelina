<?php

session_start();

include ("classes/connect.php");
include ("classes/Login.php");


$email = "";
$password = "";

if($_SERVER ['REQUEST_METHOD'] == 'POST'){

    $login= new Login();
    $result = $login->evaluate($_POST);

    if($result != "") {

        echo "<div id='errors' style='text-align: center; font-size: 20px; color: white; background-color: grey; '>";
        echo "The following errors occured<br>";
        echo $result;
        echo "</div>";
    }else {

        header("Location: profile.php");
        die;

    }


//    echo "<pre>";
//    print_r($_SERVER);
//    echo "</pre>";

        $email = $_POST['email'];
        $password = $_POST['password'];
}






?>
<html>
<head>
<title>EvaBook Log in</title>
</head>
<style>
    body {
        padding: 0;
        margin: 0;
    }
    #bar{
        height: 100px;
        background-color:rgb(59,89,152);
        color: #d9dfeb;
        padding: 5px;
    }
    #signup_button{
        background-color: #42b72a;
        width: 100px;
        text-align: center;
        padding: 5px;
        border-radius: 4px;
        float:right;
    }
    #signup-box{
        background-color: white;
        font-size: 20px;
        font-weight: bold;
        font-family: Tahoma;
        width: 800px;
        height: 300px;
        margin: auto;
        margin-top: 30px;
        text-align: center;
        padding-top: 50px;

    }
    #text{
        height: 40px;
        width: 300px;
        border-radius: 5px;
        border: solid 1px #888;
        padding: 5px;
        font-size: 15px;
    }
    #button{
        width: 300px;
        height:40px;
        font-weight: bold;
        border-radius: 5px;
        border:none;
        background-color:rgb(59,89,152);
        color: white;
    }
</style>
<body style="font-family: Tahoma; background-color: #e9ebee;">
<div id="bar">
    <div style="font-size: 45px;"> EvaBook </div>
    <a href="Signup.php">
        <div id="signup_button"> Sign up </div></a>
    </div>
<div id="signup-box">
    <form method="post">Log in to EvaBook<br><br>
    <input name = "email" value= "<?php echo $email?>" type="text" id="text" placeholder="Email"><br><br>
    <input name = "password" value= "<?php echo $password?>" type="password" id="text" placeholder="Password"><br><br>
    <input type="submit" id="button" value="Log in"><br><br>
    </form>
</div>
</body>
</html>