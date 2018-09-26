<?php ob_start(); 
include'includes/db.php'; ?>
<?php  include "includes/header.php"; ?>
    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
    <?php 
    include_once 'vendor/autoload.php';
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();

    $pusher = new Pusher\Pusher( getenv('APP_KEY'),getenv('APP_SECRET'),getenv('APP_ID'),array('cluster' => 'mt1', 'useTLS' => true ));

    //************Registration processing for new user********

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username=trim($_POST['username']);
        $email=trim($_POST['email']);
        $password=trim($_POST['password']);
        $error=[

            'username'=>'',
            'email'=>'',
            'password'=>''
        ];
        
        //*******User information validation**********

        if(strlen($username)<4){
            $error['username']="Username needs too longer";
        }

        if($username == ""){
            $error['username']="Username can not be empty";
        }

         if(user_exits($username)){
            $error['username']="User name is exist";
        }

        if($email == ""){
            $error['email']="Email can not be empty";
        }

         if(user_email_exits($email)){
            $error['email']="Email address is exist,<a href='index.php'>Please login?</a>";
        }

        if($password == ""){
            $error['password']="Password can not be empty";
        }

       foreach ($error as $key => $value) {
          if(empty($value)){

            unset($error[$key]);
          }
       }

        if(empty($error)){

            register_user($username,$email,$password);
            $data['message'] = $username;
            $pusher->trigger('notifications','new_user',$data);
        }

    }

    ?>
    
    <!-- Page Content -->
    <div class="container">
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                        <h1>Register</h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="on">
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($username) ? $username :'' ?>">
                                    <p><?php echo isset($error['username']) ? $error['username'] :'' ?></p>
                                </div>
                                 <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($email) ? $email :'' ?>">
                                    <p><?php echo isset($error['email']) ? $error['email'] :'' ?></p>
                                </div>
                                 <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                    <p><?php echo isset($error['password']) ? $error['password'] :'' ?></p>
                                </div>
                                <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                            </form>
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>
        <hr>
    <?php include "includes/footer.php";?>
