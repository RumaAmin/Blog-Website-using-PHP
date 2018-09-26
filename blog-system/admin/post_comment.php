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
                            //**********dropdown list******
                            if(isset($_POST['allChechBox'])){
                                 $bluk_option=escape($_POST['bluk_option']);
                                 bluk_options("comment","comment_status","comment_id",$bluk_option,"approved","unapproved","delete");
                                }
                            ?>
                            <form action="" method="post">
                                <div class="row">
                                    <div id="posts" class="col-xs-4">
                                        <div class="form-group">
                                            <select name="bluk_option" id="" class="form-control">
                                                <option value="">Select Options</option>
                                                <option value="approved">Approve</option>
                                                <option value="unapproved">Unapprove</option>
                                                <option value="delete">Delete</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-success" name="submit" value="Apply">
                                    </div>    
                                </div>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkboxes"></th>
                                            <th>Id</th>
                                            <th>Author</th>
                                            <th>Comment</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Post Title</th>
                                            <th>In Response to</th>
                                            <th>Approve</th>
                                            <th>Unapprove</th>
                                            <th>Delete</th>
                                        </tr> 
                                    </thead>
                                    <tbody>
                                        <?php
                                        //*************all post comment************
                                        $id=$_GET['id'];
                                        $stmt2=mysqli_prepare($connect,"SELECT comment.comment_id,comment.comment_post_id,comment.comment_author,comment.comment_email,comment.comment_content,comment.comment_status,comment.comment_date,posts.post_id,posts.post_title FROM comment LEFT JOIN posts ON comment.comment_post_id=posts.post_id WHERE comment_post_id=?");
                                        mysqli_stmt_bind_param($stmt2, "i",$id);
                                        mysqli_stmt_execute($stmt2);
                                        mysqli_stmt_bind_result($stmt2,$comment_id,$comment_post_id,$comment_author,$comment_email,$comment_content,$comment_status,$comment_date,$post_id,$post_title);

                                        while ($rows=mysqli_stmt_fetch($stmt2)){
                                            
                                            ?>
                                            <tr>
                                            <td><input type="checkbox" class="checkboxes" value="<?php echo $comment_id; ?>" name="allChechBox[]"></td> 
                                            <td><?php echo $comment_id; ?></td>
                                            <td><?php echo $comment_author; ?></td>
                                            <td><?php echo $comment_content; ?></td>
                                            <td><?php echo $comment_email; ?></td>
                                            <td><?php echo $comment_status; ?></td>
                                            <td><a href='../post.php?id=<?php echo $post_id;?>'><?php echo $post_title; ?></a></td>
                                            <td><?php echo $comment_date ;?></td> 
                                            <td><a class='btn btn-success' href="post_comment.php?approve=<?php echo $comment_id ;?>&id=<?php echo $_GET['id'];?>">Approve</a></td>
                                            <td><a class='btn btn-warning' href="post_comment.php?unapprove=<?php echo $comment_id ;?>&id=<?php echo $_GET['id'];?>">Unapprove</a></td>
                                            <td><a rel="<?php echo $comment_id; ?>" id="<?php echo $_GET['id']; ?>" class='btn btn-danger delete_link' href='javascript:void(0)'>Delete</a></td>
                                            </tr>
                                            <?php
                                             }
                                        
                                        //*******approve comment*********

                                        if(isset($_GET['approve'])){
                                        $approve_id=escape($_GET['approve']);
                                        comment_approve($approve_id);                                
                                         header("location:post_comment.php?id=".$_GET['id']."");
                                        }

                                        //********unapprove comment******
                                       if(isset($_GET['unapprove'])){
                                        $unapprove_id=escape($_GET['unapprove']);
                                        comment_unapprove($unapprove_id);
                                        header("location:post_comment.php?id=".$_GET['id']."");
                                         }

                                       //*********delete comment*******

                                        if(isset($_GET['delete'])){
                                        $del_comment_id=escape($_GET['delete']);
                                        comment_delete($del_comment_id);
                                         header("location:post_comment.php?id=".$_GET['id']."");
                                        } 
                                        ?>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $(".delete_link").on('click',function(){
                                                    var id=$(this).attr("rel");
                                                    var post_id=$(this).attr("id");
                                                    var delete_url="post_comment.php?delete="+ id +"&id="+post_id+"";
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
