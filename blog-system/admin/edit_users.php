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
                        //*************edit users starts here************
                            if(isset($_GET['edit'])){
                                $edit_id=escape($_GET['edit']);
                                $query="SELECT * FROM users WHERE user_id='$edit_id'";
                                $edit_user=mysqli_query($connect,$query);
                                if(!$edit_user){
                                    die('QUERY FAILED'. mysqli_error($connect));
                                }
                                while ($rows=mysqli_fetch_assoc($edit_user)):
                                $user_role=escape($rows['user_role']);
                                $user_id=escape($rows['user_id']);
                                $user_firstname=escape($rows['user_firstname']);
                                $user_lastname=escape($rows['user_lastname']);
                                $username=escape($rows['username']);
                                $user_email=escape($rows['user_email']);
                                $user_role=escape($rows['user_role']);
                        ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="hidden" class="form-control"  value="<?php echo escape($user_id); ?>" name="user_id">
                            </div>
                            <div class="form-group">
                                <label for="user_firstname" class="control-label">User Firstname</label>
                                <input type="text" class="form-control" id="user_firstname" name="user_firstname" value="<?php echo escape($user_firstname); ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_lastname" class="control-label">User Lastname</label>
                                <input type="text" class="form-control" id="user_lastname" name="user_lastname" value="<?php echo escape($user_lastname); ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_role" class="control-label">User role
                                </label>
                                <select name="user_role" id="user_role" class="form-control">
                                     <option value="<?php echo escape($user_role); ?>"><?php echo escape($user_role); ?></option>
                                    <?php
                                     
                                       if($user_role == 'admin'){
                                        echo "<option value='subscriber'>Subscriber</option>";
                                       }else{
                                        echo "<option value='admin'>Admin</option>";

                                       }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="username" class="control-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo escape($username); ?>">
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo escape($user_email); ?>">
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="update_user" value="Update user">
                            </div>
                        </form>
                        <?php
                         endwhile;
                    //*************update users starts here************

                         update_user();

                    //*************update users end here************
                         }else{
                         header("location:index.php");
                        }

                        //*************edit users end here************
                        ?>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

        </div>
            <!-- /#page-wrapper -->

        <?php include_once'includes/admin-footer.php';?>
