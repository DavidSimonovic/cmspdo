<form action="" method="post">

    <div class="form-group">

        <label for="cat_title">Edit Category</label>

            <?php
                if(isset($_GET['edit'])){
                    $cat_id = $_GET['edit'];

                    $select_categories_id = $pdo->prepere("SELECT * FROM categories WHERE cat_id = ? ");

                    $select_categories_id->execute([$cat_id]);

                    while($row = $select_categories_id->fetch()) {

                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];

                    ?>


                    <input value="<?php if(isset($cat_title)) { echo $cat_title; } ?>" class="form-control" type="text" name="cat_title" >  


                     <?php } }  ?>

                     <?php

                        if(isset($_POST['update_category'])) {
                            $the_cat_title = $_POST['cat_title'];

                            $update_query = $pdo->prepere("UPDATE categories SET cat_title = ? WHERE  cat_id = ? ");

                            $update_query->execute([$the_cat_title, $cat_id]);

                             if(!$update_query) {

                                die('Conneciton failed: ' . mysqli_error($connection));
                            }
                        }

        ?>

    </div>

     <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>



</form>