
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

            //************fetch searching post starts here*******

            if (isset($_POST['submit'])){
                $search=$_POST['search'];
                $query="SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                $search_query=mysqli_query($connect,$query);
                if(!$search_query){
                    die("Failed Query".mysqli_error($connect));
                }
                $count=mysqli_num_rows($search_query);
                if($count==0){
                    echo"Post Not Found";
                }else{

                while( $rows=mysqli_fetch_assoc($search_query)):
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
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ;?> at 10:00 PM</p>
                <hr>
                <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
                <?php
                endwhile;
                    }
                }

                 //************fetch searching post end here*******
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