<?php

    if(isset($_GET['p_id'])) {
        
    // Variable to show wich post is selected
        $the_post_id = $_GET['p_id'];
    }
    
    // Selecting the post from the database
    $select_posts_by_id = $pdo->prepare("SELECT * FROM posts WHERE post_id = ? ");
    $select_posts_by_id->execute([$the_post_id]);

    confirmQuery($select_posts_by_id);
    
    // Showing the posts info
    while($row = $select_posts_by_id->fetch()) {

        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_content = $row['post_content'];
    
    }

    if(isset($_POST['update_post'])) {

        $post_author = $_POST['post_author'];
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category'];   
        $post_status = $_POST['post_status'];
        
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        
        $post_content = $_POST['post_content'];
        $post_tags = $_POST['post_tags'];
        
        move_uploaded_file($post_image_temp, "../images/$post_image");
        
        if(empty($post_image)) {
            $select_image = $pdo->prepare("SELECT * FROM posts WHERE post_id = ? ");

            $select_image->execute([$the_post_id]);
            
            while($row =  $select_image->fetch()) {

                $post_image = $row['post_image'];

            }
        }
        
        $update_post = $pdo->prepare("UPDATE posts SET post_title  = ? , post_category_id = ? , post_date  =  now(), post_author = ? , post_status = ? , post_tags   = ? , post_content = ? , post_image  = ? WHERE post_id = ? ");
        
        $update_post->execute([$post_title, $post_category_id , $post_author, $post_status, $post_tags, $post_content, $post_image, $the_post_id ]);
        
        confirmQuery('$update_post');
        
        echo "<p class='bg-success'>Post updated <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>Edit more Posts</a> ";
        
        
        
    }

?>

<form action="" method="post" enctype="multipart/form-data">        
    
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
    </div>

    
    
    <div class="form-group">
     
      <select name="post_category" id="post_category">
          <?php
            $select_categories = $pdo->prepare("SELECT * FROM categories");
            $select_categories->execute();

            confirmQuery($select_categories);

            while($row = $select_categories->fetch()) {
                
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='{$cat_id}'>{$cat_title}</option>";
            }
          ?>
      </select>
      
    </div>
    
    
    <div class="form-group">
       <label for="post_author">Author</label>
       <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="post_author">
    </div>
    
    <div class="form-group">
      <select name="post_status" id="post_status">
         
           <option value=""><?php echo $post_status; ?></option>
           
           <?php
                if($post_status == 'published') {
                    echo "<option value='draft'>Draft</option>";
                } else {
                     echo "<option value='published'>Published</option>";
                }
          
          
           ?>
                
      </select>
    </div>
    
   
<!--
    <div class="form-group">
       <label for="post_status">Post Status</label>
       <input value="<?php echo $post_status; ?>" type="text" class="form-control" name="post_status">
    </div>
-->
     
     <div class="form-group">
       <label for="image">Post Image</label>
       <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
       <input type="file" name="image">
    </div>
    
    <div class="form-group">
       <label for="post_tags">Post Tags</label>
       <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>
    
    <div class="form-group">
       <label for="post_content">Post Content</label>
       <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content;  ?>
       </textarea>
    </div>

    <div class="form-group">
       <input type="submit" class="btn btn-primary" name="update_post" value="Publish Post">
    </div>
</form>
  
  