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
                            <small><?php echo escape($_SESSION['username']); ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <?php
                                        //**********all posts*******
                                        $post_count=recordCount('posts');
                                        ?>
                                        <div class='huge'><?php echo escape($post_count); ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                         <?php
                                         //********all comment******
                                        $comments_count=recordCount('comment');

                                        ?>
                                        <div class='huge'><?php echo $comments_count; ?></div>
                                      <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php

                                        //*****************all users*********
                                        $users_count=recordCount('users');;

                                        ?>
                                        <div class='huge'><?php echo $users_count; ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php

                                        //***************all category***********
                                        $categories_count=recordCount('category');

                                        ?>
                                        <div class='huge'><?php echo escape($categories_count); ?></div>
                                         <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                //******active post******
              
                $active_posts_count=checKStatus('posts','post_status','published');

                //******draft post***
                
                $draft_posts_count=checKStatus('posts','post_status','draft');

                //*****unapprove comment*****

                $unapprove_comment_count=checKStatus('comment','comment_status','unapproved');

                //*****subscriber count******

                $subscribers_count=checKUserRole('users','user_role','subscriber');

                 //*****admin count*******

                $admin_count=checKUserRole('users','user_role','admin');
                ?>
             

                <!-- google chart starts here -->

                <div class="row">
                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['bar']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Data','Count'],

                          <?php 

                        $element_text=['All posts','Active posts','Draft posts','Categories','Users','Subscribers','admin','Comments','Pending comments'];
                        $element_count=[$post_count,$active_posts_count,$draft_posts_count,$categories_count,$users_count,$subscribers_count,$admin_count,$comments_count,$unapprove_comment_count];

                        for($i=0;$i<9;$i++){
                            echo"['$element_text[$i]'" . "," . "$element_count[$i]],";
                        }

                           ?>
                        ]);

                        var options = {
                          chart: {
                            title: '',
                            subtitle: '',
                          }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                      }
                    </script>
                 <div id="columnchart_material" style="width: auto; height: 500px;"></div>
                </div>
                <!-- google charts ends here -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    <?php include_once'includes/admin-footer.php';?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>

    <script>
        
        $(document).ready(function(){

            var pusher = new Pusher('db4adb7cfcf2580a78a4', {
              cluster: 'mt1',
              forceTLS: true
            });
           var notificationChannel=pusher.subscribe('notifications');

           notificationChannel.bind('new_user',function(notification){
            var message = notification.message;

            toastr.success(`${message} just registered`);

           });
        });
    </script>
