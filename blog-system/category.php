    <?php
    include_once 'includes/db.php';
    include_once 'includes/header.php';
    ?>
    <!-- Navigation -->
    <?php
    include_once 'includes/navigation.php';
    ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                   Category Posts
                </h1>
                <!-- First Blog Post -->
                <?php

                //**********all category posts starts here*********
                if(isset($_GET['cat_id'])){
                    $id=$_GET['cat_id'];
                if(is_Admin($_SESSION['username'])){
                    $stmt1=mysqli_prepare($connect,"SELECT post_id,post_title,post_author,post_date,post_image,post_content,post_attachment FROM posts WHERE post_category_id=?");   
                 }else{

                    $stmt2=mysqli_prepare($connect,"SELECT post_id,post_title,post_author,post_date,post_image,post_content,post_attachment FROM posts WHERE post_category_id=? AND post_status=?");

                    $published="published";
                }
                if(isset($stmt1)){

                    mysqli_stmt_bind_param($stmt1, "i", $id);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_bind_result($stmt1, $post_id,$post_title,$post_author,$post_date,$post_image,$post_content,$post_attachment);
                    $stmt=$stmt1;
                }else{
                    mysqli_stmt_bind_param($stmt2, "is", $id,$published);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_bind_result($stmt2, $post_id,$post_title,$post_author,$post_date,$post_image,$post_content,$post_attachment);
                    $stmt=$stmt2;

                }
                while($rows=mysqli_stmt_fetch($stmt)):
                    
                    ?>
                <h2>
                    <a href="post.php?id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ;?> at 10:00 PM</p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
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
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
                <?php
                endwhile;

               //**********all category posts end here*********
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