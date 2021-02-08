
<div id="posts">
    <div>

        <?php
        include ("classes/auto.php");


            $image = "image/user_male.jpg";
                if($row_user ['gender'] == "Female"){
                    $image = "image/user_female.jpg";
                }
             $image_class= new Image();
                if(file_exists($row_user ['profile_pic'] )){
                    $image = $image_class->get_thumb_profile($row_user ['profile_pic']) ;
                }


        ?>
        <img src="<?php echo $image ?>" style="width: 75px;margin-right: 4px;border-radius: 50%; ">

    </div>
    <div style="width: 100%;">

        <div style="font-weight: bold; color:#405d9d; float: left; width: 100%;">

            <?php
            echo $row_user ['first_name'] . " ". $row_user['last_name'];

            if($row['is_profile_image']){
                $pronoun="his";
                if($row_user['gender'] == "Female"){
                    $pronoun="her";
                }
                echo "<span style='font-weight: normal; color: #888888;'>Updated  $pronoun profile image</span>";
                if($row['is_cover_image']){
                    $pronoun="his";
                    if($row_user['gender'] == "Female"){
                        $pronoun="her";
                    }
                    echo "<span style='font-weight: normal; color: #888888;'>Updated  $pronoun cover image</span>";
                }
            }



            ?>

        </div>
        <?php echo $row['post'] ?>
        <br><br>
        <?php
        if(file_exists($row['image'])){
            $post_image = $image_class->get_thumb_post($row['image']);
            echo "<img src='$post_image' style='width: 80%'/>";
        }
        ?>
        <br/><br/>



    </div>

</div>