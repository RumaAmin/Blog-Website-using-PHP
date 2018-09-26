<?php
include_once 'includes/db.php';
?>
<div class="col-md-4">
    <?php
    //***********search post starts here************
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
            echo"some";
        }
    }
    //***********search post end here************
    ?>
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input type="text" class="form-control" name="search">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>
     <!-- login form-->
    <div class="well">

        <!-- processing login form data starts here-->
     <?php if(isset($_SESSION['user_role'])): ?>
    <h4>Logged in as <?php echo $_SESSION['username']; ?> </h4>
    <a href="includes/logout.php" class="btn btn-primary">Logout</a>
     <?php else: ?>
        <h4>Login to admin panel</h4>

        <?php


        if(isset($_POST['login'])){

        if(isset($_POST['username']) && isset($_POST['password'])){
            login_user($_POST['username'],$_POST['password']);

             // header("location:../admin/index.php");
        }else{
            header("location:index.php");

        }

        }

        ?>
         <!-- processing login form data end here-->
        <form  method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Enter Username">
                
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter Password">
                
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="login" value="Login">
            </div>
            <div class="form-group">
               <a href="forgot_pass.php?forgot=<?php echo uniqid(true);?>">Forgot Password?</a>
            </div>
        </form>
        <!-- /.input-group -->
     <?php endif; ?>
     </div>
    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    //*******all category starts here*******
                    $sql="SELECT * FROM category";
                    $category=mysqli_query($connect,$sql);
                    while ($rows=mysqli_fetch_assoc($category)):
                        $cat_title=$rows['cat_title'];
                        $cat_id=$rows['cat_id'];

                        //*******all category end here*******
                    ?>
                    <li>
                        <a href="category.php?cat_id=<?php echo $cat_id; ?>"><?php echo $cat_title; ?></a>
                    </li>
                        <?php
                    endwhile;
                    ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- Side Widget Well -->
    <?php
    include_once 'widget.php';
    ?>
</div>