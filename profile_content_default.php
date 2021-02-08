<div style="display: flex;">
    <!--friends-->
    <div style=" min-height: 400px; flex:1;">
        <div id="friends-bar">
            Following<br>


            <?php

            if($friends){
                foreach ($friends as $friend){
                    $friend_row= $user->get_user($friend['userid']);
                    include ("user.php");
                }
            }



            ?>

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

            if($posts){
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