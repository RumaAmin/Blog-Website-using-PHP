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
                //*********author's posts starts here************
                if(isset($_GET['id'])){
                    $id=$_GET['id'];
                    $author=$_GET['author'];
                }
                $sql="SELECT * FROM posts WHERE post_user='$author'";
                $result=mysqli_query($connect,$sql);
                while( $rows=mysqli_fetch_assoc($result)):
                    $post_title=$rows['post_title'];
                    $post_author=$rows['post_author'];
                    $post_date =$rows['post_date'];
                    $post_image =$rows['post_image'];
                    $post_content =$rows['post_content'];
                    ?>
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    All post by <?php echo $post_author ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ;?> at 10:00 PM</p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>

                <?php
                endwhile;

               //*********author's posts end here************
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