
<div id="posts" style="background-color: grey;">
    <div>

    <?php
    $image = "image/user_male.jpg";
        if($row_user ['gender'] == "Female"){
            $image = "image/user_female.jpg";
        }

        if(file_exists($row_user ['profile_pic'] )){
            $image = $image_class->get_thumb_profile($row_user ['profile_pic']) ;
        }


    ?>
        <img src="<?php echo $image ?>" style="width: 75px;margin-right: 4px;border-radius: 50%; ">


    <div style="width: 100%;">

        <div style="font-weight: bold; color:#405d9d; float: left; width: 100%;">

            <?php
            echo "<a href='profile.php?id=$comment[userid]'>";
            echo $row_user ['first_name'] . " ". $row_user['last_name'];
            echo "</a>";
            if($comment['is_profile_image']){
                $pronoun="his";
                if($row_user['gender'] == "Female"){
                    $pronoun="her";
                }
                echo "<span style='font-weight: normal; color: #888888;'>Updated  $pronoun profile image</span>";
                if($comment['is_cover_image']){
                    $pronoun="his";
                    if($row_user['gender'] == "Female"){
                        $pronoun="her";
                    }
                    echo "<span style='font-weight: normal; color: #888888;'>Updated  $pronoun cover image</span>";
                }
            }



            ?>

        </div>
        <?php echo $comment['post'] ?>
        <br><br>
        <?php
        if(file_exists($comment['image'])){
            $post_image = $image_class->get_thumb_post($comment['image']);
        echo "<img src='$post_image' style='width: 80%'/>";
        }
        ?>
         <br/><br/>
        <?php
        $likes = "";

        $likes = ($comment['likes']> 0) ? "  (" .$comment['likes']. ")  ":  "" ;
//        if($comment['likes']> 0){
//            $likes = $comment['likes'];
//        }else {
//            $likes = "";
//        }
        ?>

        <a href="like.php?type=post&id=<?php echo $comment['postid']?> "> Like <?php echo $likes ?> </a> .
        <a href="single_post.php?id=<?php echo $comment['postid']?>">Comment</a> .
        <span style="color: #aaaaaa;">
            <?php echo $comment['date'] ?>
        </span>

        <?php
        if($comment['is_image']){
            echo "<a href='image_view.php?id=$comment[postid]'>";
            echo "View full image";
            echo "</a>";
        }
        ?>
        ?>
        <span style="color: #aaaaaa; float: right;">
            <?php
            $post = new Post();

            if($post->i_own_post($comment['postid'],$_SESSION['facebook_userid'])){


            echo "
        
            <a href='edit.php'>Edit
                </a> .
            <a href='delete.php?id= $comment[postid]'>Delete
                </a>";

                }


            ?>
            </span>
        <?php
        $i_liked= false;
        if(isset($_SESSION['facebook_userid'])){

        $DB= new Database();

        $sql = "select likes from likes where type = 'post ' && id= '$comment[postid]' limit 1 ";
        $result = $DB->read($sql);
        if(is_array($result)){

        $likes = json_decode($result[0]['likes'],true);

        $user_ids = array_column($likes, "userid");

        if(in_array($_SESSION['facebook_userid'], $user_ids,0)) {
            $i_liked=true;
                 }
            }
        }
        if($comment['postid'] > 0){
        echo "<br/>";
        echo "<a href='likes.php?type=post&id=$comment[postid]'>";
        if($comment['likes'] == 1){

            if($i_liked){
        echo " <span style='text-align:left;'> You and  liked this post </span>";
            }else {
        echo " <span style='text-align:left;'> 1 person liked this post </span>";
        }
            }else{
            if($i_liked) {
                $text = "others";
                if($comment['likes'] - 1 == 1){
                    $text = "other";
                }
                echo " <span style='text-align:left;'>  You and " . ($comment['likes'] - 1). " ". $text. " liked this post </span>";
            }else {
            echo " <span style='text-align:left;'> ". $comment['likes'] . " other liked this post </span>";
            }

        }
        }
        ?>

    </div>
    </div>