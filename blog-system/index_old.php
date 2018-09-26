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
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->

                <?php
                $sql="SELECT * FROM posts WHERE post_status='published'";
                $result=mysqli_query($connect,$sql);
                while( $rows=mysqli_fetch_assoc($result)):
                    $post_id=$rows['post_id'];
                    $post_title=$rows['post_title'];
                    $post_author=$rows['post_author'];
                    $post_date =$rows['post_date'];
                    $post_image =$rows['post_image'];
                    $post_content =substr($rows['post_content'],0,100);
                    $post_status =$rows['post_status'];

                    if($post_status !== 'published'){
                        echo "<h1>No Post Sorry</h1>";

                    }else{
                    ?>
                <h2>
                    <a href="post.php?id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_post.php?author=<?php echo $post_author ?>&id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ;?> at 10:00 PM</p>
                <hr>
                <a href="post.php?id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php
            }
              endwhile;

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