<?php include_once'includes/admin-header.php';?>
    <div id="wrapper">
        <!-- Navigation -->
       <?php include_once'includes/admin-navigation.php';?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>
                        <?php

                        //*********insert post************

                        if(isset($_POST['submit'])){
                        $post_title=escape($_POST['post_title']);                            
                        $post_category=escape($_POST['post_category']);
                        $post_user=escape($_POST['post_user']);
                        $post_status=escape($_POST['post_status']);
                        $post_tags=escape($_POST['post_tags']); 
                        $post_content=escape($_POST['post_content']);
                        $post_image_temp=$_FILES['post_image']['tmp_name'];
                        $post_image=basename($_FILES['post_image']['name']);
                        $location=move_uploaded_file($post_image_temp,"../images/$post_image");

                        $post_attachment_temp=$_FILES['post_attachment']['tmp_name'];
                        $post_attachment=$_FILES['post_attachment']['name'];
                        $post_attachment_location=move_uploaded_file($post_attachment_temp,"../images/$post_attachment");


                        $stmt1=mysqli_prepare($connect,"INSERT INTO `posts`(`post_title`,`post_category_id`,`post_user`,`post_date`,`post_image`,`post_content`,`post_tags`,`post_comment_count`,`post_status`,`post_attachment`) 
                            VALUES (?,?,?,now(),?,?,?,'',?,?);");

                        mysqli_stmt_bind_param($stmt1,"ssssssss", $post_title,$post_category,$post_user,$post_image,$post_content,$post_tags,$post_status,$post_attachment);
                        mysqli_stmt_execute($stmt1);
                        $post_id=mysqli_insert_id($connect);
                        if($stmt1){
                                echo "<div class='alert alert-success' role='alert'>
                                  Post Created Successfully <a href='../post.php?id={$post_id}'>View post</a> or <a href='posts.php'>Edit more post</a>
                                </div>";
                                }else{
                            die('QUERY FAILED'. mysqli_error($connect));
                        }


                        }


                        ?>
                          <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="post_title" class="control-label">Post Title</label>
                                <input type="text" class="form-control" id="post_title" name="post_title">
                            </div>
                            <div class="form-group">
                                <label for="post_category" class="control-label">Post Categoey 
                                </label>
                                <select name="post_category" id="post_category" class="form-control">
                                    <?php
                                    //***********all category starts here*******
                                        $stmt1=mysqli_prepare($connect,"SELECT cat_id,cat_title FROM category");
                                        mysqli_stmt_execute($stmt1);
                                        mysqli_stmt_bind_result($stmt1,$cat_id,$cat_title);
                                        if(!$stmt1){
                                            die('QUERY FAILED'. mysqli_error($connect));
                                        }
                                        while ($row=mysqli_stmt_fetch($stmt1)):
                                    ?>
                                    <option value="<?php echo escape($cat_id); ?>"><?php echo escape($cat_title); ?></option>
                                    <?php
                                    endwhile;
                                    //***********all category end here*******
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="users" class="control-label">Users</label>
                                <select name="post_user" id="users" class="form-control">
                                    <?php
                                    //***********all users starts here*******
                                        $stmt2=mysqli_prepare($connect,"SELECT username FROM users");
                                        mysqli_stmt_execute($stmt2);
                                        mysqli_stmt_bind_result($stmt2,$username);
                                        if(!$stmt2){
                                            die('QUERY FAILED'. mysqli_error($connect));
                                        }
                                        while ($row=mysqli_stmt_fetch($stmt2)):
                                    ?>
                                    <option value="<?php echo escape($username); ?>"><?php echo escape($username); ?></option>
                                    <?php
                                    endwhile;
                                    //***********all users starts here*******
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="post_status" class="control-label">Post Status</label>
                                <select name="post_status" id="post_status" class="form-control">
                                    <option value="draft">draft</option>
                                    <option value="published">published</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="post_image" class="control-label">Post Image</label>
                                <input type="file" id="post_image" name="post_image">
                            </div>
                            <div class="form-group">
                                <label for="post_attachment" class="control-label">Post Attachment</label>
                                <input type="file" id="post_attachment" name="post_attachment">
                            </div>
                            <div class="form-group">
                                <label for="post_tags" class="control-label">Post Tags</label>
                                <input type="text" class="form-control" id="post_tags" name="post_tags">
                            </div>
                            <div class="form-group">
                                <label for="post_content" class="control-label">Post Details</label>
                                <textarea rows="10" cols="10" class="form-control" id="body" name="post_content"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="submit" value="Add Post">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>
        <!-- /#page-wrapper -->
    <?php include_once'includes/admin-footer.php';?>







