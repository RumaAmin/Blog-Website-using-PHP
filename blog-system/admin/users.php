<?php include_once'includes/admin-header.php';?>
    <div id="wrapper">
        <!-- Navigation -->
       <?php include_once'includes/admin-navigation.php';?>
       <?php include_once'includes/delete-modal.php';?>
        <div id="page-wrapper">
            <?php
                if(!is_Admin($_SESSION['username'])){

                    header("location:../index.php");
                }
            ?>
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
                                 bluk_options("users","user_role","user_id",$bluk_option,"subscriber","admin","delete");

                                }
                            ?>
                            <form action="" method="post">
                                <div class="row">
                                    <div id="posts" class="col-xs-4">
                                        <div class="form-group">
                                            <select name="bluk_option" id="" class="form-control">
                                            <option value="">Select Options</option>
                                            <option value="subscriber">Subscriber</option>
                                            <option value="admin">Admin</option>
                                            <option value="delete">Delete</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-success" name="submit" value="Apply">
                                        <a class='btn btn-primary' href='add_users.php'>Add New</a>
                                    </div>    
                                </div>
                                <table class="table table-bordered table-hover"> 
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkboxes"></th>
                                            <th>Id</th>
                                            <th>Username</th>
                                            <th>User Firstname</th>
                                            <th>User Lastname</th>
                                            <th>User Email</th>
                                            <th>User Role</th>
                                            <th>Admin</th>
                                            <th>Subscriber</th>
                                            <th>Delete</th>
                                            <th>Edit</th>
                                        </tr> 
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql="SELECT * FROM users";
                                        $users=mysqli_query($connect,$sql);

                                        $user_row=mysqli_num_rows($users);
                                        if($user_row == 0){
                                            $_SESSION['username']=null;
                                            $_SESSION['user_firstname']=null;
                                            $_SESSION['user_lastname']=null;
                                            $_SESSION['user_role']=null;
                                            header("location:index.php");
                                        }
                                        while ($rows=mysqli_fetch_assoc($users)){
                                            $user_id=escape($rows['user_id']);
                                            $username=escape($rows['username']);
                                            $user_firstname=escape($rows['user_firstname']);
                                            $user_lastname=escape($rows['user_lastname']);
                                            $user_email=escape($rows['user_email']);
                                            $user_role=escape($rows['user_role']);

                                            ?>
                                            <tr>
                                                <td><input type="checkbox" class="checkboxes" value="<?php echo $user_id; ?>" name="allChechBox[]"></td>
                                                <td><?php echo $user_id; ?></td>
                                                <td><?php echo $username; ?></td>                                       
                                                <td><?php echo $user_firstname; ?></td>
                                                <td><?php echo $user_lastname; ?></td>
                                                <td><?php echo $user_email; ?></td> 
                                                <td><?php echo $user_role; ?></td> 
                                                <td><a class='btn btn-success' href='users.php?change_to_admin=<?php echo $user_id;?>'>Admin</a></td>
                                                <td><a class='btn btn-warning' href='users.php?change_to_sub=<?php echo $user_id;?>'>Subscriber</a></td>
                                                <td><a rel="<?php echo $user_id; ?>" class='btn btn-danger delete_link' href='javascript:void(0)'>Delete</a></td>
                                                <td><a class='btn btn-primary' href='edit_users.php?edit=<?php echo $user_id;?>'>Edit</a></td>                                        
                                            </tr>
                                            <?php
                                           
                                                }

                                            //*********User role change to admin*********

                                            if(isset($_GET['change_to_admin'])){
                                                $user_id=escape($_GET['change_to_admin']);
                                                user_role_change_to_admin($user_id);
                                            }


                                            //***********User role change to subscriber*****
                                           if(isset($_GET['change_to_sub'])){
                                                $user_id_sub=escape($_GET['change_to_sub']);
                                                user_role_change_to_subscriber($user_id_sub);
                                            }

                                           //**************delete user************

                                            if(isset($_GET['delete'])){
                                                $del_user_id=escape($_GET['delete']);
                                                user_delete($del_user_id);

                                            } 
                                    ?>

                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $(".delete_link").on('click',function(){
                                                    var id=$(this).attr("rel");
                                                    var delete_url="users.php?delete="+ id +" ";
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
