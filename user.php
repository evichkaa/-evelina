<div id="friends" style="display: inline;">
<?php
    $image = "image/user_male.jpg";
        if($friend_row['gender'] == "Female"){
            $image = "image/user_female.png";
        }
    ?>

    <img id="friends_img" src="<?php echo $image ?>" style="width:75px; float: left; margin: 10px;">
    <br>
    <?php echo $friend_row['first_name'] . " " . $friend_row['last_name']?>
</div>