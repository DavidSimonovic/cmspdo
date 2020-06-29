<?php
    if(isset($_POST['checkBoxArray'])) {
        foreach($_POST['checkBoxArray'] as $postValueId ){
            $bulk_options = $_POST['bulk_options'];
            
            switch($bulk_options) {
                    
                case 'published':
                    $update_to_published_status = $pdo->prepare("UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = ? ");
                    
                    $update_to_published_status->execute([$postValueId]);     

                    confirmQuery($update_to_published_status);

                    break;
                    
                case 'draft':
                    $update_to_draft_status = $pdo->prepare("UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}  ");
                    
                    $update_to_draft_status->execute([$postValueId]);

                    confirmQuery($update_to_draft_status);

                    break;

                case 'delete':
                    $update_to_delete_status = $pdo->prepare("DELETE FROM posts WHERE post_id = ?  ");

                    $update_to_delete_status->execute([$postValueId]);

                    confirmQuery($update_to_delete_status);
                    break;
                case 'clone':
                    $select_post_query = $pdo->prepare("SELECT * FROM posts WHERE post_id = '{$postValueId}'  ");

                    $select_post_query->execute([$postValueId]);


                    while ($row = $select_post_query->fetch()) {
                    
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_date = $row['post_date'];
                        $post_author = $row['post_author'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_content = $row['post_content'];     
                    }
                    
                    $copy_query = $pdo->prepare("INSERT INTO posts(post_category_id, post_title, post_author, post_date,post_image,post_content,post_tags,post_status) VALUES ( ? , ? , ? ,now(),  ? , ? , ? , ? ) "); 
                    $copy_query->execute([$post_category_id, $post_title, $post_author , $post_image, $post_content, $post_tags, $post_status]);
                    if (!$copy_query) {
                        die("QUERY FAILED" . mysqli_error($pdo));
                    }
                    break;
                    
            }
        }
    }


?>

<form action="" method="post">

    <table class="table table-bordered table-hover">
       
       <div id="bulkOptionContainer" class="col-xs-4">
           
           <select class="form-control" name="bulk_options" id="" >
               
               <option value="" >Select Options</option>
               <option value="published" >Publish</option>
               <option value="draft" >Draft</option>
               <option value="delete" >Delete</option>
               <option value="clone" >Clone</option>
               
           </select>
           
           
       </div>
       <div class="col-xs-4">
           <input type="submit" name="submit" class="btn btn-success" value="Apply">
           <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
       </div>
       
  
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>

           <?php

                $select_posts = $pdo->prepare("SELECT * FROM posts ORDER BY post_id DESC");

                $select_posts->execute();

                while($row = $select_posts->fetch()) {

                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];
                    $post_views_count = $row['post_views_count'];
                    

                    echo "<tr>";
            ?>
                 <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>  
            <?php
                    
                    
                    echo "<td>{$post_id}</td>";
                    echo "<td>{$post_author}</td>";
                    echo "<td>{$post_title}</td>";


                    $select_categories_id = $pdo->prepare("SELECT * FROM categories WHERE cat_id = ? ");
                    $select_categories_id->execute([$post_category_id]);

                    while($row = $select_categories_id->fetch()) {

                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];

                    echo "<td>{$cat_title}</td>";

                    }

                    echo "<td>{$post_status}</td>";
                    echo "<td><img width='100' src='../images/$post_image' alt='images'></td>";
                    echo "<td>{$post_tags}</td>";
                    echo "<td>{$post_comment_count}</td>";
                    echo "<td>{$post_date}</td>";
                    echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
                    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                    echo "<td><a onClick=\"javascript: return confirm('Da li si siguran da zelis da obrises');\" href='posts.php?delete={$post_id}'>Delete</a></td>";
                    echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";            
                    echo "</tr>";            
                } 
            ?>

        </tbody>
    </table>
</form> 

<?php

    if(isset($_GET['delete'])) {
        $the_post_id = $_GET['delete'];
       
        $delete_query = $pdo->prepare("DELETE FROM posts WHERE post_id = ? ");

        $delete_query->execute([$the_post_id]);

        header("Location: posts.php");
        
        confirmQuery($delete_query);
    }

    if(isset($_GET['reset'])) {
        $the_post_id = mysqli_real_escape_string($pdo, $_GET['reset']);
       
        $reset_query = $pdo->prepare("UPDATE posts SET post_views_count = 0 WHERE post_id = ? ");
        $reset_query->execute([$the_post_id]);
        header("Location: posts.php");
        
        confirmQuery($reset_query);
    }

?>