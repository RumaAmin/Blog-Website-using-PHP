<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<!-- Page Content -->


<?php


require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


 if($_SERVER['REQUEST_METHOD'] !== 'GET' && !isset($_GET['forgot'])){

header("location:index.php");

 }

 if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['email'])){
        $email=$_POST['email'];
        $length=50;
        $token=bin2hex(openssl_random_pseudo_bytes($length));

        if(user_email_exits($email)){
        if($stmt1=mysqli_prepare($connect,"UPDATE users SET token='$token' WHERE user_email=?")){
            mysqli_stmt_bind_param($stmt1, "s",$email);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_close($stmt1);

     

        //*****************phpmailer starts here**************
            $mail = new PHPMailer(true);                              
        try {
            //Server settings
            // $mail->SMTPDebug = 2;                                 
            $mail->isSMTP();
            $mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true ));                                   
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;                              
            $mail->Username = 'rumacse61@gmail.com';                
            $mail->Password = 'Rum@@1996';                          
            $mail->SMTPSecure = 'tls';                            
            $mail->Port = 587;                                    

            //Recipients
            $mail->setFrom('rumacse61@gmail.com','Ruma Akter');
            $mail->addAddress($email);     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->CharSet='UTF-8';                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = '<p>Please click here to Reset Password</p><a href="http://localhost/Udmey/12_Section_CMS_Project%20_Blogging_System_Front_End_and_First_Steps/cms_project/reset.php?email='.$email.'&token='.$token.'">Click Here</a>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            
         }
         catch (Exception $e) {
            // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
        //*****************phpmailer end here**************

    }else{

       die("QUERY FAILED" . mysqli_error($connect));
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
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">
                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>
                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>
                            </div><!-- Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <?php include "includes/footer.php";?>
</div> <!-- /.container -->

