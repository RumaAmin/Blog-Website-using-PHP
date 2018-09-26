<?php ob_start();
include_once 'db.php';
$path="/Udmey/12_Section_CMS_Project _Blogging_System_Front_End_and_First_Steps/cms_project/";

?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index">Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                //************all category*********
                $sql="SELECT * FROM category";
                $results=mysqli_query($connect,$sql);
                while ($rows=mysqli_fetch_assoc($results)):
                    $catId=$rows['cat_id'];
                    $category_active='';
                    $registration_class='';
                    $login_class='';
                    $contact_class='';
                    $pageName=basename($_SERVER['PHP_SELF']);
                    $registration='registration';
                    $contact='contact';
                    $login='login';
                    if(isset($_GET['cat_id']) && $_GET['cat_id'] == $catId){
                        $category_active="active";
                    }elseif($pageName == $registration){
                        $registration_class="active";
                    }elseif($pageName == $contact){
                        $contact_class="active";
                    }elseif($pageName == $login){
                        $login_class="active";
                    }
                ?>
                <li class="<?php echo $category_active; ?>">
                    <a href="category.php?cat_id=<?php echo $catId; ?>"><?php echo $rows['cat_title']; ?></a>
                </li>
                <?php
                endwhile; 
                
                   ?>
                <?php if(isset($_SESSION['user_role'])): ?>
                <li>
                    <a href="admin">Admin</a>
                </li>
                <li>
                    <a href="includes/logout.php">Logout</a>
                </li>
                 <?php else: ?>
                <li class="<?php echo $login_class; ?>">
                    <a href="<?php echo $path; ?>login.php">Login</a>
                </li>
                 <?php endif; ?>
                <li class="<?php echo $registration_class; ?>">
                    <a href="<?php echo $path; ?>registration">Registration</a>
                </li>
                <li class="<?php echo $contact_class; ?>">
                    <a href="<?php echo $path; ?>contact">Contact</a>
                </li>
                
                <?php

                if(isset($_SESSION['user_role'])){
                    if(isset($_GET['id'])){
                        $id=$_GET['id'];
                        echo "<li><a href='{$path}admin/edit-post.php?edit={$id}'>Edit Post</a></li>";
                    }
                }
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
