<?php
    include_once 'includes/db.php';
    include_once 'includes/header.php';
    ?>


    <?php


	echo loggedInId();

	if(userLinkedThisPost(97)){
		echo "like it";
	}else{
		echo "did not like it";
	}




    ?>


    <?php


     if(userLinkedThisPost(97)): 

                    ?>

                <div class="row">
                    <p class="pull-right"><a class="unlike" href="#"><span class="glyphicon glyphicon-thumbs-down"></span>Unlike</a></p>
                </div>
                <?php
                else:
                ?>
                <div class="row">
                    <p class="pull-right"><a class="like" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>Like</a></p>
                </div>

                <?php
                endif;
                ?>
