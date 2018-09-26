<?php include_once'includes/admin-header.php';?>
    <div id="wrapper">
        <!-- Navigation -->
       <?php include_once'includes/admin-navigation.php';?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>
                         <?php

                            //**********Fetching user profile information starts here*********

                            if(isset($_SESSION['username'])) {
                                $username = escape($_SESSION['username']);
                                $query = "SELECT * FROM users WHERE username='$username'";
                                $select_user_profile_query = mysqli_query($connect, $query);
                                if (!$select_user_profile_query) {
                                    die('QUERY FAILED' . mysqli_error($connect));
                                }
                                while ($rows = mysqli_fetch_assoc($select_user_profile_query)) {
                                    $user_id = escape($rows['user_id']);
                                    $username = escape($rows['username']);
                                    $user_password = escape($rows['user_password']);
                                    $user_firstname = escape($rows['user_firstname']);
                                    $user_lastname = escape($rows['user_lastname']);
                                    $user_email = escape($rows['user_email']);
                                    ?>
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" value="<?php echo $user_id; ?>"
                                                   name="user_id">
                                        </div>
                                        <div class="form-group">
                                            <label for="user_firstname" class="control-label">User Firstname</label>
                                            <input type="text" class="form-control" id="user_firstname"
                                                   name="user_firstname" value="<?php echo $user_firstname; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="user_lastname" class="control-label">User Lastname</label>
                                            <input type="text" class="form-control" id="user_lastname"
                                                   name="user_lastname" value="<?php echo $user_lastname; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="username" class="control-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                   value="<?php echo $username; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="control-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   value="<?php echo $user_email; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="control-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                   autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" name="update_profile"
                                                   value="Update Profile">
                                        </div>
                                    </form>
                                    <?php
                                }
                            }
                            
                            //**********Fetching user profile information end here*********

                            //*****update profile********
                            if(isset($_POST['update_profile'])){
                            update_user_profile($_POST);
                             }

                        ?>
                    </div>
                </div>
            </div>
                <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
        <!-- /#page-wrapper -->
    <?php include_once'includes/admin-footer.php';?>
