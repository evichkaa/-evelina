<?php
include ("classes/connect.php");
include ("classes/Signup.php");


$first_name = "";
$last_name = "";
$gender = "";
$email = "";
$password = "";

if($_SERVER ['REQUEST_METHOD'] == 'POST'){

    $signup= new SignUp();
    $result = $signup->evaluate_date($_POST);

    if($result != "") {

        echo "<div id='errors' style='text-align: center; font-size: 20px; color: white; background-color: grey; '>";
        echo "The following errors occured<br>";
        echo $result;
        echo "</div>";
    }else {

        header("Location: LoginPage.php");
        die;

    }


//    echo "<pre>";
//    print_r($_SERVER);
//    echo "</pre>";

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
}






?>


<html lang="en">
<head>
    <title>Facebook Sign up</title>
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
        font-family: Tahoma, serif;
        width: 800px;
        height: auto;
        margin: 30px auto auto;
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
<body style="font-family: Tahoma,serif; background-color: white;">
<div id="bar">
    <div style="font-size: 45px;"> Evabook </div>
    <a href="LoginPage.php" id="signup_button"> Login </a>
</div>
<div id="signup-box">Sign up to Facebook<br><br>
    <form method="post" action="Signup.php">
        <input value="<?php echo $first_name ?>" name="first_name" id="text" placeholder="First name"><br><br>
        <input value="<?php echo $last_name ?>" name="last_name" id="text" placeholder="Last name"><br><br>
        <span style="font-weight: normal">Gender:</span> <br>
        <select id="text" name = "gender">
            <option selected disabled>Choose gender</option>
            <option>Male</option>
            <option>Female</option>
        </select> <br> <br>
        <input  value="<?php echo $email ?>" name = "email" type="text" id="text" placeholder="Email"><br><br>
        <input  name = "password" type="password" id="text" placeholder="Password"><br><br>
        <input  name = "password2" type="password" id="text" placeholder="Retype password"><br><br>

        <input  type="submit" id="button" value="Sign up"><br><br>
    </form>
</div>
</body>
</html>