  <?php
//***********edit category starts here**********
    if(isset($_GET['edit'])){
        $edit_category=$_GET['edit'];
        $stmt1=mysqli_prepare($connect,"SELECT * FROM category WHERE cat_id=?");
        mysqli_stmt_bind_param($stmt1, "i", $edit_category);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_bind_result($stmt1, $cat_id,$cat_title);
        if(!$stmt1){
            die('QUERY FAILED'. mysqli_error($connect));
        }

        while ($rows=mysqli_stmt_fetch($stmt1)):
   
    ?>

     <form action="" method="post">
        <div class="form-group">
            <label for="id" class="control-label">id</label>
            <input type="text" value="<?php echo $cat_id; ?>" class="form-control" id="cat_id" name="cat_id">
        </div>
        <div class="form-group">
            <label for="cat_title" class="control-label">Edit Category name</label>
            <input type="text" value="<?php echo $cat_title; ?>" class="form-control" id="cat_title" name="cat_title">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" name="update_category" value="Update category">
        </div>
    </form>
    <?php

endwhile;

update_category();

     }

     //***********edit category end here**********
    ?>