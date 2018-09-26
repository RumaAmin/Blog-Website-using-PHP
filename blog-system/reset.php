<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<!-- Page Content -->



<?php

if(!isset($_GET['email']) && !isset($_GET['token'])){

    header("location:index.php");
}

$varified=false;

$email='rumacse61@gmail.com';
$token='0e14be59ec5d3052f560a12ad000d1fdfaf88273a6e8cabf4713e09bb6aee31cf70b16da68a5c3e8c3adef56d50def21b175';
if($stmt1=mysqli_prepare($connect,"SELECT username,user_email,token FROM users WHERE token=?")){

    mysqli_stmt_bind_param($stmt1, "s",$_GET['token']);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_bind_result($stmt1,$username,$user_email,$token);
    mysqli_stmt_fetch($stmt1);
    mysqli_stmt_close($stmt1);
    echo $username;


    // if($_GET['email']!== $user_email || $_GET['token'] !== $token){

    // header("location:index.php");
    // }

    if(isset($_POST['password']) && isset($_POST['confirm_password'])){

       if($_POST['password'] === $_POST['confirm_password']){

        $password=$_POST['password'];
        $password_hash=password_hash($password,PASSWORD_BCRYPT, array('cost'=>8));

        if($stmt2=mysqli_prepare($connect,"UPDATE users SET token='',user_password='$password_hash' WHERE user_email=?")){
            mysqli_stmt_bind_param($stmt2, "s", $email);
            mysqli_stmt_execute($stmt2);
            if(mysqli_stmt_affected_rows($stmt2)>=1){

                  header("location:login.php"); 
            }
            mysqli_stmt_close($stmt2);
            $varified=true;

        }

        }
    }

}


?>
<div class="container">
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">
                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="password" class="form-control"  type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-check color-blue"></i></span>
                                            <input id="password" name="confirm_password" placeholder="confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>
                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>
                            </div><!-- Body-->
                            <!-- <h2>Please check your email</h2> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

