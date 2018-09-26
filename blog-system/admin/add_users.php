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
                        <small><?php echo escape($_SESSION['username']); ?></small>
                    </h1>
                        <!-- create user -->

                        <?php  insert_users(); ?>
                   
                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="user_firstname" class="control-label">User Firstname</label>
                            <input type="text" class="form-control" id="user_firstname" name="user_firstname">
                        </div>
                        <div class="form-group">
                            <label for="user_lastname" class="control-label">User Lastname</label>
                            <input type="text" class="form-control" id="user_lastname" name="user_lastname">
                        </div>
                        <div class="form-group">
                            <label for="user_role" class="control-label">User role
                        </label>
                            <select name="user_role" id="user_role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="subscriber">Subscriber</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="submit" value="Add user">
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







