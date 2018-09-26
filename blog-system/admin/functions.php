 <?php ob_start();

 include_once('C:\xampp\htdocs\Udmey\12_Section_CMS_Project _Blogging_System_Front_End_and_First_Steps\cms_project\includes\db.php');

 // include_once(__DIR__ .'\includes\db.php');


 function imagePlaceholder($image=''){
    if(!$image){

        echo"case1.jpg";
    }else{

        echo $image;
    }

 }

 function loggedInId(){
    global $connect;
    if(isset($_SESSION['user_role'])){

        $username=$_SESSION['username'];
        $result=mysqli_query($connect,"SELECT * FROM users WHERE username='$username'");
         if(!$result){
             die('QUERY FAILED'. mysqli_error($connect));
          }

        $users=mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result)>=1){

            return $users['user_id'];

        }
    }
return false;

 }

 function userLinkedThisPost($post_id){
    global $connect;
    $user_id=loggedInId();

    $result=mysqli_query($connect,"SELECT * FROM likes WHERE user_id='$user_id' AND post_id='$post_id'");
     if(!$result){
           die('QUERY FAILED'. mysqli_error($connect));
       }

    return mysqli_num_rows($result)>=1 ? true : false;

 }

 function getPostLikes($post_id){
    global $connect;
     $result=mysqli_query($connect,"SELECT * FROM likes WHERE  post_id='$post_id'");
      if(!$result){
           die('QUERY FAILED'. mysqli_error($connect));
       }
       return mysqli_num_rows($result);
 }



 function escape($string){
    global $connect;
    return mysqli_real_escape_string($connect,trim($string));

     }

 //************* insert_category starts here**********
function insert_category(){
	global $connect;
	 if(isset($_POST['submit'])){
        $cat_title=$_POST['cat_title'];
        if($cat_title == "" || empty($cat_title)){
            echo "this field should not be empty";
        }else{
            $stmt1=mysqli_prepare($connect,"INSERT INTO `category`(`cat_title`) VALUES (?);");
            mysqli_stmt_bind_param($stmt1, "s", $cat_title);
            mysqli_stmt_execute($stmt1);
            
            if(!$stmt1){
                die('QUERY FAILED'. mysqli_error($connect));
            }

            mysqli_stmt_close($stmt1);
        }
    }
}

 //************* insert_category end here**********


function update_category(){
    global $connect;
    if(isset($_POST['update_category'])){
         $cat_title=$_POST['cat_title'];
         $edit_id=$_POST['cat_id'];
        $stmt2=mysqli_prepare($connect,"UPDATE category SET cat_title=? WHERE cat_id=?");
        mysqli_stmt_bind_param($stmt2, "si", $cat_title,$edit_id);
        mysqli_stmt_execute($stmt2);
        redirect("categories.php");
        if(!$stmt2){
            die('QUERY FAILED'. mysqli_error($connect));
        }

        mysqli_stmt_close($stmt2);

      }
}


 //************* deleteCategory start here**********


function deleteCategory(){
	global $connect;
    if(isset($_GET['delete'])){

    $the_cat_id=$_GET['delete'];
    $query="DELETE FROM category WHERE cat_id='$the_cat_id'";
    $delete=mysqli_query($connect,$query);
    header("location:categories.php");
    if(!$delete){
        die('QUERY FAILED'. mysqli_error($connect));
    }

  }
}

 //************* deleteCategory end here**********


 //************* userOnline starts here**********


 function userOnline()
{
    if(isset($_GET['onlineUsers'])){

    global $connect;
    if($connect){
        session_start();
        $session=session_id();
        $time=time();
        $time_out_in_sec=05;
        $time_out=$time-$time_out_in_sec;

        $query="SELECT * FROM users_online WHERE session='$session'";
        $send_query=mysqli_query($connect,$query);
        $count=mysqli_num_rows($send_query);

        if($count == null){
          mysqli_query($connect,"INSERT INTO users_online(session, time) VALUES ('$session','$time')");
        }else{
         mysqli_query($connect,"UPDATE users_online SET time='$time' WHERE session='$session'");

        }

        $user_online=mysqli_query($connect,"SELECT * FROM users_online WHERE time>'$time_out'");
        echo $count_users=mysqli_num_rows($user_online);

        }
    
}

}
userOnline();

 //************* userOnline end here**********


 //************* insert_users starts here**********


function insert_users(){
    global $connect;
    if(isset($_POST['submit'])){

        $user_firstname=escape($_POST['user_firstname']);                            
        $user_lastname=escape($_POST['user_lastname']);                            
        $user_role=escape($_POST['user_role']);
        $username=escape($_POST['username']);
        $email=escape($_POST['email']);
        $password=escape($_POST['password']);
        //$user_password=escape(password_hash($password,PASSWORD_BCRYPT, array('cost'=>8)));
        $user_password=escape(md5($password));
       
        $query="INSERT INTO `users` (`username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`,`user_role`) VALUES ('$username', '$user_password', '$user_firstname', '$user_lastname', '$email', '$user_role');";
        $create_new_user=mysqli_query($connect,$query);
        if($create_new_user){
            echo "<div class='alert alert-success' role='alert'>
              User Created Successfully
            </div>";
        }else{
            die('QUERY FAILED'. mysqli_error($connect));
        }
        }

        
 //************* insert_users end here**********
   

}


function update_user(){
    global $connect;
    if(isset($_POST['update_user'])){
        $user_id=escape($_POST['user_id']);
        $user_firstname=escape($_POST['user_firstname']);                            
        $user_lastname=escape($_POST['user_lastname']);                            
        $user_role=escape($_POST['user_role']);
        $username=escape($_POST['username']);
        $email=escape($_POST['email']);
        $password=escape($_POST['password']);
           if(!empty($password)){
            $query_password="SELECT user_password FROM users WHERE user_id='$user_id'";
            $password_query=mysqli_query($connect,$query_password);
            if(!$password_query){
                die('QUERY FAILED'.mysqli_error($connect)); 
            }
            $row=mysqli_fetch_assoc($password_query);
            $user_password=escape($row['user_password']);
           
           if($user_password != $password){
            //$hash_password=escape(password_hash($user_password,PASSWORD_BCRYPT,array('cost'=>8)));
            $hash_password=escape(md5($user_password));
           }
             $query="UPDATE users 
             SET username='$username',
             user_password='$hash_password',
             user_firstname='$user_firstname',
             user_lastname='$user_lastname',
             user_email='$email',
             user_role='$user_role' 
             WHERE user_id='$user_id'";

            $update_user=mysqli_query($connect,$query);
            if($update_user){
                echo "<div class='alert alert-success' role='alert'>
                  User Updated Successfully
                </div>";
            }else{
        die('QUERY FAILED'. mysqli_error($connect));
        }
      } 

  }


}

function update_user_profile($data){
    global $connect;
    
        $user_id=escape($data['user_id']);
        $user_firstname=escape($data['user_firstname']);                            
        $user_lastname=escape($data['user_lastname']);                            
        $user_role=escape($data['user_role']);
        $username=escape($data['username']);
        $email=escape($data['email']);
        $password=escape($data['password']);
    
         $query="UPDATE users SET username='$username',user_password ='$password',user_firstname='$user_firstname',user_lastname='$user_lastname',user_email='$email',user_role='$user_role' WHERE username='$username'";
            $update_user=mysqli_query($connect,$query);
            if(!$update_user){
                die('QUERY FAILED'. mysqli_error($connect));
            }

     }
  

 //************* recordCount start here**********
function recordCount($table){
    global $connect;
    $query="SELECT * FROM ".$table;
    $result=mysqli_query($connect,$query);
    if(!$result){
        die('QUERY FAILED'. mysqli_error($connect));
    }
    $count=mysqli_num_rows($result);
    return $count;

}
 //************* recordCount end here**********



 //************* checKStatus starts here**********

function checKStatus($table,$column,$status){
    global $connect;
    $query="SELECT * FROM $table WHERE $column='$status'";
    $result=mysqli_query($connect,$query);
    if(!$result){
        die('QUERY FAILED'. mysqli_error($connect));
    }
    return mysqli_num_rows($result);
}

 //************* checKStatus end here**********


 //************* checKUserRole starts here**********

function checKUserRole($table,$column,$role){
    global $connect;
    $query="SELECT * FROM $table WHERE $column='$role'";
    $result=mysqli_query($connect,$query);
    if(!$result){
        die('QUERY FAILED'. mysqli_error($connect));
    }
    return mysqli_num_rows($result);
}


 //************* checKUserRole end here**********

 //************* is_Admin starts here**********


function is_Admin($username=''){

    global $connect;
    $sql="SELECT user_role FROM users WHERE username='$username'";
    $result=mysqli_query($connect,$sql);
    if(!$result){
        die('QUERY FAILED'. mysqli_error($connect));
    }
    $row=mysqli_fetch_assoc($result);
    if($row['user_role'] == 'admin'){
        return true;
    }else{
        return false;
    }
}

 //************* is_Admin end here**********


 //************* user_exits starts here**********

function user_exits($username){
    global $connect;
    $sql="SELECT username FROM users WHERE username='$username'";
    $result=mysqli_query($connect,$sql);
    if(!$result){
        die('QUERY FAILED'. mysqli_error($connect));
    }
    
    if(mysqli_num_rows($result)>0){
        return true;
    }else{
        return false;
    }
}

 //************* user_exits end here**********

 //************* user_email_exits starts here**********

function user_email_exits($user_email){
    global $connect;
    $sql="SELECT user_email FROM users WHERE user_email='$user_email'";
    $result=mysqli_query($connect,$sql);
    if(!$result){
        die('QUERY FAILED'. mysqli_error($connect));
    }
    
    if(mysqli_num_rows($result)>0){
        return true;
    }else{
        return false;
    }
}

 //************* user_email_exits end here**********


function user_role_change_to_admin($user_id){
    global $connect;
    $query="UPDATE users SET user_role='admin' WHERE user_id='$user_id'";
    $admin=mysqli_query($connect,$query);
    if(!$admin){
        die('QUERY FAILED' . mysqli_error($connect));
    }
    header("location:users.php");
}


function user_role_change_to_subscriber($user_id_sub){
    global $connect;
    $query="UPDATE users SET user_role='subscriber' WHERE user_id='$user_id_sub'";
    $subscriber=mysqli_query($connect,$query);
    if(!$subscriber){
        die('QUERY FAILED' . mysqli_error($connect));
    }
    header("location:users.php");
}

function user_delete($del_user_id){
    global $connect;
    $query="DELETE FROM users WHERE user_id='$del_user_id'";
    $delete_user=mysqli_query($connect,$query);
    if(!$delete_user){
        die('QUERY FAILED' . mysqli_error($connect));
    }
    header("location:users.php");
}



 //************* redirect starts here**********

function redirect($location){

     header("location:".$location);
     exit;
}

 //************* redirect end here**********


 //************* register_user starts here**********


function register_user($username,$email,$password){

    global $connect;
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $username=mysqli_real_escape_string($connect, $username);
    $email=mysqli_real_escape_string($connect, $email);
    $password=mysqli_real_escape_string($connect, $password);
    //$password=password_hash($password, PASSWORD_BCRYPT,array('cost'=>8));
    $password=md5($password);
    $query="INSERT INTO `users` (`username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`,`user_role`) VALUES ('$username', '$password', '', '', '$email', '');";

    $create_new_user=mysqli_query($connect,$query);

    }
 //************* register_user end here**********


 //************* login_user starts here**********
    

function login_user($username,$password){

    global $connect;
    $username=trim($username);
    $password=trim($password);
    $username=mysqli_real_escape_string($connect,$username);
    $password=mysqli_real_escape_string($connect,$password);
    $sql="SELECT * FROM users WHERE username='$username'";
    $users=mysqli_query($connect,$sql);
    if(!$users){
    die('QUERY FAILED'. mysqli_error($connect));
    }

    while ($rows=mysqli_fetch_assoc($users)){
         $db_id=$rows['user_id'];
         $db_username=$rows['username'];
         $db_user_password=$rows['user_password'];
         $db_user_firstname=$rows['user_firstname'];
         $db_user_lastname=$rows['user_lastname'];
         $db_user_role=$rows['user_role'];


       if(password_verify($password, $db_user_password)){
        $_SESSION['username']=$db_username;
        $_SESSION['user_firstname']=$db_user_firstname;
        $_SESSION['user_lastname']=$db_user_lastname;
        $_SESSION['user_role']=$db_user_role;

        header("location:admin/index.php");

    }

    }

   
}


 //************* login_user end here**********

 //************* bluk_options starts here**********


 function bluk_options($table,$column1,$column2,$bluk_option,$case1,$case2,$case3){
    global $connect;
    foreach ($_POST['allChechBox'] as $ValueId) {
      switch ($bluk_option) {
          case $case1:
              $stmt1=mysqli_prepare($connect,"UPDATE $table SET $column1=? WHERE $column2=?");
                mysqli_stmt_bind_param($stmt1, "si", $bluk_option,$ValueId);
                mysqli_stmt_execute($stmt1);
                if(!$stmt1){
                    die('QUERY FAILED'. mysqli_error($connect));
                }

              break;
          case $case2:
              $stmt1=mysqli_prepare($connect,"UPDATE $table SET $column1=? WHERE $column2=?");
                mysqli_stmt_bind_param($stmt1, "si", $bluk_option,$ValueId);
                mysqli_stmt_execute($stmt1);
                if(!$stmt1){
                    die('QUERY FAILED'. mysqli_error($connect));
                }

              break;
          case $case3:
              $stmt1=mysqli_prepare($connect,"DELETE FROM $table WHERE $column2=?");
                mysqli_stmt_bind_param($stmt1, "i",$ValueId);
                mysqli_stmt_execute($stmt1);
                if(!$stmt1){
                    die('QUERY FAILED'. mysqli_error($connect));
                }

         }
     }
 }

  //************* bluk_options end here**********

 //************* post_bluk_options starts here**********
 function  post_bluk_options($table,$column1,$column2,$bluk_option){
    global $connect;
    foreach ($_POST['allChechBox'] as $postValueId) {
        switch ($bluk_option) {
        case 'published':
            $stmt1=mysqli_prepare($connect,"UPDATE $table SET $column1=? WHERE $column2=?");
            mysqli_stmt_bind_param($stmt1,"si", $bluk_option,$postValueId);
            mysqli_stmt_execute($stmt1);
            if(!$stmt1){          
            die('QUERY FAILED'. mysqli_error($connect));
            }
            break;
        case 'draft':
            $stmt1=mysqli_prepare($connect,"UPDATE $table SET $column1=? WHERE $column2=?");
            mysqli_stmt_bind_param($stmt1,"si",$bluk_option,$postValueId);
            mysqli_stmt_execute($stmt1);
            if(!$stmt1){
            die('QUERY FAILED'. mysqli_error($connect));
            }
            break;
        case 'clone':
             $stmt1=mysqli_prepare($connect,"SELECT post_id,post_user,post_title,post_category_id,post_status,post_image,post_date,post_tags,post_content,post_comment_count FROM $table WHERE $column2=?");
            mysqli_stmt_bind_param($stmt1,"i",$postValueId);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_bind_result($stmt1,$post_id,$post_user,$post_title,$post_category_id,$post_status,$post_image,$post_date,$post_tags,$post_content,$post_comment_count);
            while ($rows=mysqli_stmt_fetch($stmt1)){
               
            }

            $stmt2=mysqli_prepare($connect,"INSERT INTO `posts`(`post_title`,`post_category_id`,`post_user`,`post_date`,`post_image`,`post_content`,`post_tags`,`post_comment_count`,`post_status`) 
                VALUES (?,?,?,now(),?,?,?,'',?);");
             mysqli_stmt_bind_param($stmt2, "sisssss",$post_title,$post_category_id,$post_user,$post_image,$post_content,$post_tags,$post_status);
            mysqli_stmt_execute($stmt2);       
            if(!$stmt2){
            die('QUERY FAILED'. mysqli_error($connect));
            }
            break;
        case 'delete':
            $stmt1=mysqli_prepare($connect,"DELETE FROM $table WHERE $column2=?");
            mysqli_stmt_bind_param($stmt1, "i",$postValueId);
            mysqli_stmt_execute($stmt1);
            if(!$stmt1){
            die('QUERY FAILED'. mysqli_error($connect));
            }   
        }
        }

 }

  //************* post_bluk_options end here*********

  //************* comment_approve starts here**********

 function comment_approve($approve_id){
   global $connect;
    $stmt1=mysqli_prepare($connect,"UPDATE comment SET comment_status='approved' WHERE comment_id=?");
    mysqli_stmt_bind_param($stmt1, "i", $approve_id);
    mysqli_stmt_execute($stmt1);
    if(!$stmt1){
        die('QUERY FAILED' . mysqli_error($connect));
    }
   

 }

  //************* comment_approve end here**********


  //************* comment_unapprove starts here**********


  function comment_unapprove($unapprove_id){

    global $connect;
    $stmt1=mysqli_prepare($connect,"UPDATE comment SET comment_status='unapproved' WHERE comment_id=?");
    mysqli_stmt_bind_param($stmt1, "i", $unapprove_id);
    mysqli_stmt_execute($stmt1);
    if(!$stmt1){
        die('QUERY FAILED' . mysqli_error($connect));
    }
    header("location:comments.php");

  }

  //************* comment_unapprove end here**********

  function insert_comment(){
    global $connect;
    if(isset($_POST['submit_comment'])){
        $comment_post_id=$_GET['id'];
        $comment_author=$_POST['comment_author'];
        $comment_email=$_POST['comment_email'];
        $comment=$_POST['comment'];
        if(!empty($comment_author) && !empty($comment_email) && !empty($comment)){
        $query="INSERT INTO `comment`(`comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`,`comment_date`) 
            VALUES ('$comment_post_id', '$comment_author', '$comment_email', 
                    '$comment', 'unapprove',now());";

        $create_comment=mysqli_query($connect,$query);
        if(!$create_comment){
         die('QUERY FAILED'. mysqli_error($connect));
          }

        }else{
            echo "<script>alert('Field can not be empty')</script>";
        }
    }
  }


  //************* comment_delete starts here**********

   function comment_delete($del_comment_id){

    global $connect;
    $stmt1=mysqli_prepare($connect,"DELETE FROM comment WHERE comment_id=?");
    mysqli_stmt_bind_param($stmt1, "i", $del_comment_id);
    mysqli_stmt_execute($stmt1);
    if(!$stmt1){
        die('QUERY FAILED' . mysqli_error($connect));
    }
    header("location:comments.php");

  }

//************* comment_delete end here**********



