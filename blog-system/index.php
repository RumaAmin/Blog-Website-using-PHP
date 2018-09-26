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
                <h2 class="page-header">
                    All posts
                </h2>
                <!-- First Blog Post -->
                <?php
                $per_page=2;
                if(isset($_GET['page'])){

                    $page_no=$_GET['page'];
                }else{
                    $page_no="";
                }
                if($page_no == "" || $page_no == 1){
                    $page_1=0;
                }else{

                    $page_1=($page_no * $per_page) -$per_page;
                }
                //*********** fetching all posts starts here*********
                $query="SELECT * FROM posts";
                $all_posts=mysqli_query($connect,$query);
                $all_rows=mysqli_num_rows($all_posts);
                $draft_post=mysqli_fetch_assoc($all_posts);
                $draft=$draft_post['post_status'];
                if($all_rows<1 || $draft=="draft"){
                     echo "NO POST FOUND";
                 }else{

                $count=ceil($all_rows/$per_page);
                $sql="SELECT * FROM posts WHERE post_status='published' LIMIT $page_1,$per_page";
                $result=mysqli_query($connect,$sql);
                while($rows=mysqli_fetch_assoc($result)):
                    $post_id=$rows['post_id'];
                    $post_title=$rows['post_title'];
                    $post_user=$rows['post_user'];
                    $post_date =$rows['post_date'];
                    $post_image =$rows['post_image'];
                    $post_attachment =$rows['post_attachment'];
                    $post_content =substr($rows['post_content'],0,100);
                    $post_status =$rows['post_status'];
                    ?>
                <h4>Post Title: 
                    <a href="post.php?id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h4>
                <p class="lead">
                    by <a href="author_post.php?author=<?php echo $post_user; ?>&id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ;?> at 10:00 PM</p>
                <hr>
                <a href="post.php?id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image); ?>" alt=""></a>
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
                <a class="btn btn-primary" href="post.php?id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                <?php
              endwhile;
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
        <!-- pagination -->
        <ul class="pager">
            <?php
            for($i=1;$i<=$count;$i++){
                if($i == $page_no){
            echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
        }else{

            echo "<li><a href='index.php?page=$i'>$i</a></li>";
        }  
        }
        ?>  
        </ul>
     <?php
    include_once 'includes/footer.php';
    ?>