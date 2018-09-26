<?php include_once'includes/admin-header.php';?>
<div id="wrapper">
<!-- Navigation -->
<?php include_once'includes/admin-navigation.php';?>
<?php include_once'includes/delete-modal.php';?>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to Admin
                    <small><?php echo escape($_SESSION['username']); ?></small>
                </h1>
                <div class="col-xs-6">
                    <!-- Add category -->
                    <?php

                   insert_category();
                    ?>
                <!-- add categpry -->
                <form action="" method="post">
                    <div class="form-group">
                        <label for="cat_title" class="control-label">Category name</label>
                        <input type="text" class="form-control" id="cat_title" name="cat_title">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="submit" value="Add category">
                    </div>
                </form>
                    <!-- update category -->
                <?php 
                    if(isset($_GET['edit'])){
                        $edit_cat_id=escape($_GET['edit']);
                        include_once "includes/update.php";
                    }
                ?>
                </div>
                <div class="col-xs-6">
                    <table class="table table-bordered table-hover">
                        <colgroup>
                            <col class="col-xs-1"> <col class="col-xs-7">
                        </colgroup> 
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Category name</th>
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr> 
                        </thead>
                        <tbody>
                             <?php
                             // find all category
                          
                                $sql="SELECT * FROM category";
                                $category=mysqli_query($connect,$sql);

                                while ($rows=mysqli_fetch_assoc($category)):
                              ?>
                            <tr> 
                                <th scope="row"> <code><?php echo escape($rows['cat_id']); ?></code> </th>
                                <td><?php echo escape($rows['cat_title']); ?></td>
                                <td><a rel="<?php echo $rows['cat_id']; ?>" class='btn btn-danger delete_link' href='javascript:void(0)'>Delete</a></td>
                                <td><a class=" btn btn-success" href="categories.php?edit=<?php echo escape($rows['cat_id']); ?>">Edit</a></td>
                            </tr>
                              <?php
                                endwhile;
                              ?>
                              <?php
                              //delete query
                              deleteCategory();
                              ?>
                              <!-- delete confirm message script -->
                            <script type="text/javascript"> 
                                $(document).ready(function(){
                                    $(".delete_link").on('click',function(){
                                        var id=$(this).attr("rel");
                                        var delete_url="categories.php?delete="+ id +" ";

                                        $(".modal_delete_link").attr("href",delete_url);
                                        $("#myModal").modal("show");
                                    });
                                    });
                            </script>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php include_once'includes/admin-footer.php';?>
