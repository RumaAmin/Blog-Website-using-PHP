    <?php
    include_once 'includes/db.php';
    include_once 'includes/header.php';
    ?>
    <!-- Navigation -->
    <?php
    include_once 'includes/navigation.php';
    ?>

    <?php

if(isset($_POST['liked'])){
    $post_id=$_POST['post_id'];
    $user_id=$_POST['user_id'];

    //select post

    $searchPost="SELECT * FROM posts WHERE post_id='$post_id'";
    $postResult=mysqli_query($connect,$searchPost);
    $posts=mysqli_fetch_assoc($postResult);
    $likes=$posts['likes'];


    //Update post with incrementing likes

   $update=mysqli_query($connect,"UPDATE posts SET likes=$likes+1 WHERE post_id='$post_id'");

     if(!$update){
        die('QUERY FAILED'. mysqli_error($connect));
     }

    //Create like  for posts

     $insert=mysqli_query($connect,"INSERT INTO likes(user_id,post_id) VALUES($user_id,$post_id)");

      if(!$insert){
        die('QUERY FAILED'. mysqli_error($connect));
     }
     //header("location:post.php");

     exit();

}


if(isset($_POST['unliked'])){
    $post_id=$_POST['post_id'];
    $user_id=$_POST['user_id'];

    //select post

    $searchPost="SELECT * FROM posts WHERE post_id='$post_id'";
    $postResult=mysqli_query($connect,$searchPost);
    $posts=mysqli_fetch_assoc($postResult);
    $likes=$posts['likes'];

    //deleting likes

    $delete=mysqli_query($connect,"DELETE FROM likes WHERE post_id='$post_id' AND user_id='$user_id'");

    if(!$delete){
        die('QUERY FAILED'. mysqli_error($connect));
     }

    //Update post with dicrementing likes

    $update=mysqli_query($connect,"UPDATE posts SET likes=$likes-1 WHERE post_id='$post_id'");
     if(!$update){
        die('QUERY FAILED'. mysqli_error($connect));
     }

    // header("location:post.php");

     exit();

}


?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    Posts  
                </h1>
                <!-- First Blog Post -->
                <?php

                //******** single post starts here*********

                if(isset($_GET['id'])){
                $id=$_GET['id'];
                $query="UPDATE posts SET post_views_count=post_views_count+1 WHERE post_id='$id'";
                $views_count=mysqli_query($connect,$query);
                if(!$views_count){
                   die('QUERY FAILED'. mysqli_error($connect));
                 }
                 if(isset($_SESSION['user_role']) && isset($_SESSION['user_role']) =='admin'){
                    $sql="SELECT * FROM posts WHERE post_id='$id'";      
                     }else{
                        $sql="SELECT * FROM posts WHERE post_id='$id' AND post_status='published'";
                    }
                  $select_all_post_query=mysqli_query($connect,$sql);
                  $count=mysqli_num_rows($select_all_post_query);
                  $postStatus=$count['post_status'];
                if($count<1){
                    echo "<h2>POST NOT FOUND </h2>";
                }else{
                while( $rows=mysqli_fetch_assoc($select_all_post_query)):
                    $post_title=$rows['post_title'];
                    $post_author=$rows['post_author'];
                    $post_date =$rows['post_date'];
                    $post_image =$rows['post_image'];
                    $post_attachment =$rows['post_attachment'];
                    $post_content =$rows['post_content'];
                    ?>
                <h2>
                    <a href="#">Post Title: <?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ;?> at 10:00 PM</p>
                <hr>
                <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                <hr>
                <?php
                if(isset($post_attachment)):

                ?>
                <p style="font-size: 20px;">Attachment: <a download="images/<?php echo $post_attachment; ?>" href="images/<?php echo $post_attachment; ?>"><?php echo $post_attachment; ?></a></p>
                <?php
                endif;
                ?>
                <hr>
                <p><?php echo $post_content ?></p>
                <hr>
                <?php
                if(isset($_SESSION['user_role'])):
                if(userLinkedThisPost($id)): 

                    ?>

                <div class="row">
                    <p class="pull-right"><a class="unlike" href="post.php?id=<?php echo $id; ?>" style="font-size: 22px;"><span class="glyphicon glyphicon-thumbs-down" data-toggle="tooltip" data-placement="top" title="I like this before"></span>Unlike</a></p>
                </div>
                <?php
               
                else:
                ?>
                <div class="row">
                    <p class="pull-right"><a class="like" href="post.php?id=<?php echo $id; ?>" style="font-size: 22px;"><span class="glyphicon glyphicon-thumbs-up"  data-toggle="tooltip" data-placement="top" title="want to like it?"></span>Like</a></p>
                </div>

                <?php
                
                endif;
                 else:
                    ?>

                    <div class="row">
                    <p class="pull-right" style="font-size: 20px;">You need to <a  href="login.php">Login </a>to like</p>
                </div>
                <?php

                 endif;
                ?>
                <div class="row">
                    <p class="pull-right" style="font-size: 22px;">Like: <?php echo getPostLikes($id); ?></p>
                </div>
                <div class="clearfix"></div>
                <?php

                endwhile;

                //******** single post end here*********
                
                ?>
                <?php
                //********insert comment**********
                    insert_comment();
                ?>
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" name="comment_author" id="author" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                             <input type="email" name="comment_email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="comment">Your comment</label>
                            <textarea class="form-control" rows="3" id="comment" name="comment"></textarea>
                        </div>
                        <button type="submit" name="submit_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <hr>
                <!-- Posted Comments -->
                <!-- Comment -->
                <?php
                //*********fetch all comment per post starts here*********

                    $comment_post_id=$_GET['id'];
                    $query="SELECT * FROM comment WHERE comment_post_id='$comment_post_id' AND comment_status='approved' ORDER BY comment_id DESC";
                    $approve_comment=mysqli_query($connect,$query);
                    if(!$approve_comment){
                                die('QUERY FAILED'. mysqli_error($connect));
                       }

                    while( $rows=mysqli_fetch_assoc($approve_comment)):
                        $comment_date=$rows['comment_date'];
                        $comment_author=$rows['comment_author'];
                        $comment_content=$rows['comment_content'];
                        
                ?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author;?>
                            <small><?php echo $comment_date; ?> at 9:30 PM</small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>
            <?php

            endwhile;

             //*********fetch all comment per post end here*********
            }
            }else{
                    header("location:index.php");
            }
       
           ?>

            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php
            include_once 'includes/sidebar.php';
            ?>
        </div>
        <!-- /.row -->
        <hr>
      <?php
        include_once 'includes/footer.php';
      ?>

       <script>
            
            $(document).ready(function(){

                $("[data-toggle='tooltip']").tooltip();

                var post_id=<?php echo $id; ?>;
                var user_id=<?php echo loggedInId(); ?>;

                //liking
                $(".like").click(function(){
                    $.ajax({
                        url:"post.php?id=<?php echo $id; ?>",
                        type:'post',
                        data:{
                            'liked':1,
                            'post_id':post_id,
                            'user_id':user_id

                        }
                       
                        
                    });
                    
                });

                //unliking

                $(".unlike").click(function(){
                    $.ajax({

                        url:"post.php?id=<?php echo $id; ?>",
                        type:'post',
                        data:{
                            'unliked':1,
                            'post_id':post_id,
                            'user_id':user_id

                        }
                       
                    });

                });
            });
        </script>