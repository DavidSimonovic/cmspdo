<?php
    if(isset($_POST['create_post'])) {
        if(empty($_POST['title']) && empty($_POST['author']) && empty($_POST['post_tags']) && empty($_POST['post_content'])){

            
            echo "This fields should not be empty: ";
        
        
                if(empty($_POST['title'])){

                    echo 'title ';
                }

                if(empty($_POST['author'])){

                    echo 'author ';
                }

                if(empty($_POST['post_tags'])){

                    echo 'post_tags ';
                }

                if(empty($_POST['post_content'])){

                    echo 'post_content ';
                }
    
            }

        else{

        $post_title = $_POST['title'];
        $post_author = $_POST['author'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        
        // Wich file to upload
        $post_image = $_FILES['image']['name'];
        
        // Temporery saved file 
         $post_image_temp = $_FILES['image']['tmp_name'];
    
    
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
        $post_comment_count = 0;
        $post_view_count = 0;
        
        // Moving the uploaded file to the folder 
        move_uploaded_file($post_image_temp, "../images/$post_image");
        
        // Making a query with the given info to inser in to the database
        $create_post_query = $pdo->prepare("INSERT INTO posts (post_category_id, post_title, post_author, post_date,post_image,post_content,post_tags,post_comment_count,post_status,post_views_count) VALUES ( ? , ? , ? , now() , ? , ? , ? , ? , ? , ? ) ");
        $create_post_query->execute([$post_category_id, $post_title, $post_author, $post_image , $post_content, $post_tags , $post_comment_count, $post_status, $post_view_count ]);
       
        // Function we made to check if connection is working
       
        confirmQuery($create_post_query);
        
        $the_post_id = mysqli_insert_id($pdo);
        
        echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>Edit more Posts</a> ";
    }

}
?>
  
<form action="" method="post" enctype="multipart/form-data">        
    
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    
    <div class="form-group">
     
      <select name="post_category" id="post_category">
          <?php

          // Quering the data
            $select_categories = $pdo->prepare("SELECT * FROM categories");
            $select_categories->execute();

            confirmQuery($select_categories);
          
         // Showing it in a Dropdown list/option 
            while ($row = $select_categories->fetch()) {
              
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='{$cat_id}'>{$cat_title}</option>";
            
            }
 
            ?>
      </select>
      
    </div>
    
    <div class="form-group">
       <label for="author">Author</label>
       <input type="text" class="form-control" name="author">
    </div>
   
    <div class="form-group">

    <select name="post_status" id="">
           <option value="draft">Post Status</option>
           <option value="published">Published</option>
           <option value="draft">Draft</option>
       </select>
       
       
    </div>
     
     <div class="form-group">
       <label for="post_image">Post Image</label>
       <input type="file" name="image">
    </div>
    
    <div class="form-group">
       <label for="post_tags">Post Tags</label>
       <input type="text" class="form-control" name="post_tags">
    </div>
    
    <div class="form-group">
       <label for="post_content">Post Content</label>
       <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
       <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>
</form>
  
  