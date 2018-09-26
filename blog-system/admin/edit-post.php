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
                        //***************post edit starts here*************
                            if(isset($_GET['edit'])){
                                $edit_id=escape($_GET['edit']);
                                $stmt1="SELECT * FROM posts WHERE post_id='$edit_id'";
                                $posts=mysqli_query($connect,$stmt1);
                                if(!$posts){
                                    die('QUERY FAILED'. mysqli_error($connect));
                                }
                                while ($rows=mysqli_fetch_assoc($posts)):
                                    $post_id=$rows['post_id'];
                                    $post_author=$rows['post_author'];
                                    $post_user=$rows['post_user'];
                                    $post_title=$rows['post_title'];
                                    $post_category_id=$rows['post_category_id'];
                                    $post_status=$rows['post_status'];
                                    $post_image=$rows['post_image'];
                                    $post_attachment=$rows['post_attachment'];
                                    $post_date=$rows['post_date'];
                                    $post_tags=$rows['post_tags'];
                                    $post_content=$rows['post_content'];
                                    $post_comment_count=$rows['post_comment_count'];
                        ?>
                        <?php
                        //*************post update starts here*************

                          if(isset($_POST['update_post'])){
                            $post_id=escape($_POST['post_id']);
                            $post_title=escape($_POST['post_title']);
                            $post_category=escape($_POST['post_category']);
                            $post_user=escape($_POST['post_user']);
                            $post_status=escape($_POST['post_status']);
                            $post_tags=escape($_POST['post_tags']);
                            $post_comment_count=escape($_POST['post_comment_count']);
                            $post_content=escape($_POST['post_content']);
                            $post_image=escape($_FILES['post_image']['name']);
                            $post_image_temp=escape($_FILES['post_image']['tmp_name']);
                             move_uploaded_file($post_image_temp,"../images/$post_image");

                            $post_attachment_temp=$_FILES['post_attachment']['tmp_name'];
                            $post_attachment=$_FILES['post_attachment']['name'];
                            $post_attachment_location=move_uploaded_file($post_attachment_temp,"../images/$post_attachment");

                             if(empty($post_attachment)){

                                $stmt1=mysqli_prepare($connect,"SELECT post_attachment FROM posts WHERE post_id=?");
                                mysqli_stmt_bind_param($stmt1, "i", $edit_id);
                                mysqli_stmt_execute($stmt1);
                                mysqli_stmt_bind_result($stmt1,$post_attachment);
                                if(!$stmt1){
                                die('QUERY FAILED'. mysqli_error($connect));
                                }

                                while ($all_rows=mysqli_stmt_fetch($stmt1)) {
                                }
                                
                             }

                              if(empty($post_image)){

                                $stmt1=mysqli_prepare($connect,"SELECT post_image FROM posts WHERE post_id=?");
                                mysqli_stmt_bind_param($stmt1, "i", $edit_id);
                                mysqli_stmt_execute($stmt1);
                                mysqli_stmt_bind_result($stmt1,$post_image);
                                if(!$stmt1){
                                die('QUERY FAILED'. mysqli_error($connect));
                                }

                                while ($all_rows=mysqli_stmt_fetch($stmt1)) {
                                }
                                
                             }
                             $stmt2=mysqli_prepare($connect,"UPDATE posts SET post_category_id=?,post_title =?,post_user=?,post_date=now(),post_image=?,post_content=?,post_tags=?, post_comment_count=?,post_status=? post_attachment=? WHERE post_id=?");
                                mysqli_stmt_bind_param($stmt2, "isssssissi", $post_category,$post_title,$post_user,$post_image,$post_content,$post_tags,$post_comment_count,$post_status,$post_attachment,$post_id);
                                mysqli_stmt_execute($stmt2);
                                if($stmt2){
                                    echo "<div class='alert alert-success' role='alert'>
                                      Post Updated Successfully <a href='../post.php?id={$post_id}'>View post</a> or <a href='posts.php'>Edit more post</a>
                                    </div>";
                                }else{
                            die('QUERY FAILED'. mysqli_error($connect));
                        }

                               
                        }

                         //*************post update end here*************

                        ?>
                          <form action="" method="post" enctype="multipart/form-data">
                         <div class="form-group">
                                <input type="hidden" class="form-control"  value="<?php echo escape($post_id); ?>" name="post_id">
                            </div>
                            <div class="form-group">
                                <label for="post_title" class="control-label">Post Title</label>
                                <input type="text" class="form-control" id="post_title" value="<?php echo escape($post_title); ?>" name="post_title">
                            </div>
                                <div class="form-group">
                                    <label for="post_category" class="control-label">Post Categoey 
                                    </label>
                                    <select name="post_category" id="post_category" class="form-control">
                                        <?php
                                        //*************all categories starts here**********

                                            $stmt2="SELECT * FROM category";
                                            $category=mysqli_query($connect,$stmt2);
                                            if(!$category){
                                                die('QUERY FAILED'. mysqli_error($connect));
                                            }
                                            while ($cat_row=mysqli_fetch_assoc($category)):  
                                                  $cat_id= $cat_row['cat_id'];     
                                                  $cat_title= $cat_row['cat_title'];     
                                       
                                            ?><?php if($cat_id == $post_category_id): ?>
                                            <option selected value="<?php echo $cat_id; ?>"><?php echo $cat_title; ?></option>
                                            <?php else: ?>
                                             <option value="<?php echo $cat_id; ?>"><?php echo $cat_title; ?></option>
                                            <?php endif; ?>
                                            <?php
                                             endwhile;

                                         //*************all categories end here**********
                                        
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                <label for="users" class="control-label">Users</label>
                                <select name="post_user" id="users" class="form-control">
                                    <option value="<?php echo escape($post_user); ?>"><?php echo escape($post_user); ?></option>
                                    <?php
                                    //************ users starts here*********
                                    $stmt3="SELECT * FROM users";
                                    $users=mysqli_query($connect,$stmt3);
                                        if(!$users){
                                            die('QUERY FAILED'. mysqli_error($connect));
                                        }
                                        while ($user_row=mysqli_stmt_fetch($users)):
                                            $username=$user_row['username'];
                                    ?>
                                    <option value="<?php echo escape($username); ?>"><?php echo escape($username); ?></option>
                                    <?php
                                    endwhile;
                                    //************ users end here*********
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="post_status" class="control-label">Post Status</label>
                                <select name="post_status" id="post_status">
                                    <option value="<?php echo escape($post_status); ?>"><?php echo escape($post_status); ?></option>
                                        <?php
                                        if($post_status=='published'){
                                        echo "<option value='draft'>draft</option>";
                                        }else{
                                        echo "<option value='published'>published</option>";
                                         }
                                         ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <img width="100" src="../images/<?php echo escape($post_image) ; ?>" alt="">
                                <input type="file" id="post_image" name="post_image">
                            </div>
                             <div class="form-group">
                                <label for="post_attachment" class="control-label">Post Attachment</label>
                                <br>
                                <p><?php echo $post_attachment; ?></p>
                                <input type="file" id="post_attachment" name="post_attachment" value="<?php echo escape($post_attachment); ?>">
                            </div>
                            <div class="form-group">
                                <label for="post_tags" class="control-label">Post Tags</label>
                                <input type="text" class="form-control" id="post_tags" value="<?php echo escape($post_tags); ?>" name="post_tags">
                            </div>
                            <div class="form-group">
                                <label for="post_comment_count" class="control-label">Post Comment Count</label>
                                <input type="text" class="form-control" id="post_comment_count" value="<?php echo escape($post_comment_count); ?>" name="post_comment_count">
                            </div>
                            <div class="form-group">
                                <label for="post_content" class="control-label">Post Details</label>
                                <textarea rows="10" cols="10" class="form-control" id="body" name="post_content"><?php echo escape($post_content); ?></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
                            </div>
                        </form>
                        <?php
                         endwhile;
                         }
                         //***************post edit end here*************
                        ?>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
            <!-- /#page-wrapper -->
        <?php include_once'includes/admin-footer.php';?>
