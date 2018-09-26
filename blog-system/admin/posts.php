<?php include_once'includes/admin-header.php';?>
    <div id="wrapper">
        <!-- Navigation -->
       <?php include_once'includes/admin-navigation.php';?>
       <?php include_once'includes/delete-modal.php';?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>
                        <div class="table-responsive">
                        <?php
                        if(isset($_POST['allChechBox'])){
                            $bluk_option=escape($_POST['bluk_option']);
                            post_bluk_options("posts","post_status","post_id",$bluk_option);
                           
                        }
                        ?>
                            <form action="" method="post">
                                <div class="row">
                                    <div id="posts" class="col-xs-4">
                                        <div class="form-group">
                                            <select name="bluk_option" id="" class="form-control">
                                            <option value="">Select Options</option>
                                            <option value="published">Publish</option>
                                            <option value="draft">Draft</option>
                                            <option value="delete">Delete</option>
                                            <option value="clone">Clone</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-success" name="submit" value="Apply">
                                        <a class='btn btn-primary' href='new-post.php'>Add New</a>
                                    </div>    
                                </div>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkboxes"></th>
                                            <th>Id</th>
                                            <th>User</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Image</th>
                                            <th>Attachment</th>
                                            <th>Tags</th>
                                            <th>Post Details</th>
                                            <th>Comments</th>
                                            <th>Date</th>
                                            <th>View post count</th>
                                            <th>View post</th>
                                            <th>Delete</th>
                                            <th>Edit</th>
                                        </tr> 
                                    </thead>
                                    <tbody>
                                        <?php
                                      
                                      //*******fetching all posts starts here**********

                                        $sql="SELECT posts.post_id,posts.post_author,posts.post_user,posts.post_title,posts.post_category_id,posts.post_status,posts.post_image,posts.post_date,posts.post_tags,posts.post_content,posts.post_views_count,posts.post_attachment,category.cat_id,category.cat_title FROM posts LEFT JOIN category ON posts.post_category_id=category.cat_id ORDER BY posts.post_id DESC";
                                        $posts=mysqli_query($connect,$sql);
                                         if(!$posts){
                                              die('QUERY FAILED'. mysqli_error($connect));
                                            }
                                        while ($rows=mysqli_fetch_assoc($posts)){
                                            $post_id=escape($rows['post_id']);
                                            $post_author=escape($rows['post_author']);
                                            $post_user=escape($rows['post_user']);
                                            $post_title=escape($rows['post_title']);
                                            $post_category_id=escape($rows['post_category_id']);
                                            $post_status=escape($rows['post_status']);
                                            $post_image=escape($rows['post_image']);
                                            $post_attachment=escape($rows['post_attachment']);
                                            $post_date=escape($rows['post_date']);
                                            $post_tags=escape($rows['post_tags']);
                                            $post_content=escape($rows['post_content']); 
                                            $cat_title=escape($rows['cat_title']);
                                            $cat_id=escape($rows['cat_id']);
                                            $post_views_count=escape($rows['post_views_count']);
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" class="checkboxes" value="<?php echo $post_id; ?>" name="allChechBox[]"></td>
                                                <td><?php echo $post_id;?></td>
                                               <?php
                                                if(!empty($post_author)):
                                                    ?>
                                                <td><?php echo $post_author; ?></td>
                                                    <?php
                                                elseif (!empty($post_user)):
                                                    ?>
                                                <td><?php echo $post_user; ?></td>
                                                <?php
                                                endif;
                                                ?>
                                                <td><?php echo $post_title; ?></td>
                                                <td><?php echo $cat_title; ?></td>
                                                <td><?php echo $post_status ; ?></td>
                                                <td><img src='../images/<?php echo $post_image ; ?>' width='100' alt='post-img'></td>
                                                <td><?php echo $post_attachment; ?></td>
                                                <td><?php echo $post_tags ; ?></td>
                                                <td><?php echo $post_content ; ?></td>

                                                <?php
                                                //********* number of comment starts here********
                                                
                                                    $query="SELECT * FROM comment WHERE comment_post_id='$post_id'";
                                                    $comment_count=mysqli_query($connect,$query);
                                                    if(!$comment_count){
                                                        die('QUERY FAILED'. mysqli_error($connect));
                                                    }
                                                    $allcomment_rows=mysqli_fetch_assoc($comment_count);
                                                    $comments_id=$allcomment_rows['comment_id'];
                                                    $all_comment=mysqli_num_rows($comment_count);

                                                    //********** number of comment end here******
                                                    ?>
                                                <td><a href='post_comment.php?id=<?php echo $post_id;?>'><?php echo $all_comment;?></a></td>
                                                <td><?php echo $post_date; ?></td>
                                                <td><a href='posts.php?reset=<?php echo $post_id;?>'><?php echo $post_views_count;?></a></td>
                                                <td><a class='btn btn-primary' href='../post.php?id=<?php echo $post_id;?>'>View post</a></td>
                                                <td><a rel="<?php echo $post_id; ?>" class='btn btn-danger delete_link' href='javascript:void(0)'>Delete</a></td>
                                                <td><a class='btn btn-success' href='edit-post.php?edit=<?php echo $post_id;?>'>Edit</a></td>
                                            </tr>
                                            <?php
                                             }

                                             //*******fetching all posts end here**********

                                           //*********delete post starts here********

                                            if(isset($_GET['delete'])){
                                                if(isset($_SESSION['user_role'])){
                                                    if($_SESSION['user_role'] == 'admin'){
                                            $del_post_id=$_GET['delete'];
                                            $query="DELETE FROM posts WHERE post_id='$del_post_id'";
                                            $delete_post=mysqli_query($connect,$query);
                                            if(!$delete_post){
                                                die('QUERY FAILED' . mysqli_error($connect));
                                            }
                                            header("location:posts.php");
                                                }
                                            }
                                            }

                                            //*********delete post end here********

                                            //************reset views count starts here********
                                             if(isset($_GET['reset'])){
                                            $views_count_id=escape($_GET['reset']);
                                            $query="UPDATE posts SET post_views_count=0 WHERE post_id='$views_count_id'";
                                            $reset_views_count=mysqli_query($connect,$query);
                                            if(!$reset_views_count){
                                                die('QUERY FAILED' . mysqli_error($connect));
                                            }
                                            header("location:posts.php");
                                            }  

                                            //************reset views count end here********
                                        ?>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $(".delete_link").on('click',function(){
                                                    var id=$(this).attr("rel");
                                                    var delete_url="posts.php?delete="+ id +" ";
                                                    $(".modal_delete_link").attr("href",delete_url);
                                                    $("#myModal").modal("show");
                                                });

                                                });
                                        </script>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    <?php include_once'includes/admin-footer.php';?>
