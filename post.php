<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
<?php include 'includes/navigation.php'; ?>
    
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                
                <?php 
                
                if(isset($_GET['p_id'])){

                    $the_post_id = $_GET['p_id'];

                    // pdo one 

                    $update_post_view_count = $pdo->prepare("UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = ?");
                
                    $update_post_view_count->execute([$the_post_id]);

                    
                    if(!$update_post_view_count) {
                       
                        die("QUERY FAILD");
                    
                    }
                
                    // SELECT ALL FORM POSTS
                  
                    $slect_all_posts = $pdo->prepare("SELECT * FROM posts WHERE post_id = ?");
                
                    $slect_all_posts->execute([$the_post_id]); 
                    
                
                while ($row = $slect_all_posts->fetch()) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                     
                        ?>
                     
                        <h1 class="page-header">
                            
                            <?php echo $post_title; ?>
                        
                        </h1>

                        <!-- First Blog Post -->
                    
                        <p class="lead">
                        
                        <!-- using the vasiable we made to sho every author we have -->
                            by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                        
                        </p>
                        <p>
                        
                        <!-- using the vasiable we made to sho every date we have -->
                        <span class="glyphicon glyphicon-time"></span><?php echo ' '.$post_date; ?></p>
                        
                        <hr>
                        
                        <!-- using the vasiable we made to sho every image we have -->
                        <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                        <hr>
                        <p> 
                        
                        <!-- using the vasiable we made to sho every content we have -->
                        <?php echo $post_content; ?></p>
                        
                        <hr>
                        
                        <!-- closting the while loop -->
                    <?php } 
                    } 
                    else 
                    {
                        header("Location: index.php");
                    }
                    ?>  
                      
                      
                       
                <!-- Blog Comments -->
             <?php
            


              if(isset($_POST['create_comment'])) {
                            
                            $the_post_id =  $_GET['p_id'];
                            $comment_author = $_POST['comment_author'];
                            $comment_email = $_POST['comment_email'];
                            $comment_content= $_POST['comment_content'];
                            
                            if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                                
                                // new Pdo 


                                $create_comment_query = $pdo->prepare("INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ?,?,?,?, 'unapproved', now()");
                
                                $create_comment_query->execute([$the_post_id, $comment_author, $comment_email,$comment_content]);


                            

                                if(!$create_comment_query) {
                                    die("QUERY FAILS" . mysqli_error($pdo));
                                }

                                $update_comment_count = $pdo->prepare("UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = ?");

                                $update_comment_count->execute([$the_post_id]);

                                if(!$update_comment_count) {
                                    die("QUERY FAILS" . mysqli_error($pdo));
                                }
                                 echo "<p class='bg-success'>Commentar Created!";
                            }  else {
                                echo "<script>alert('Fields cannot be empty')</script>";
                            }
                        }
                  
                ?>
      
                
                
                

                <!-- Comments Form -->
                    <div class="well">
                        <h4>Leave a Comment:</h4>
                        
                        <form role="form" action="" method="post">
                           
                            <div class="form-group">
                               <label for="comment_author">Author</label>
                               <input type="text" name="comment_author" class="form-control">
                            </div>
                               
                            <div class="form-group">
                                <label for="comment_email">Email</label>
                               <input type="email" name="comment_email" class="form-control">
                            </div> 
                            
                            <div class="form-group">
                               <label for="comment_content">Your comment</label>
                                <textarea name="comment_content" class="form-control" rows="3"></textarea>
                            </div>
                            
                            <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                            
                        </form>
                        
                    </div>

                    <hr>

                    <!-- Posted Comments -->
                    
                    <?php 
                
                        // pdo 
                        $select_comment_query  = $pdo->prepare("SELECT * FROM comments WHERE comment_post_id = ? AND comment_status = 'approved' ORDER BY comment_id DESC ");

                        $select_comment_query->execute([$the_post_id]);

                
                    if(!$select_comment_query) {
                        die('Query Failed' . mysqli_error($pdo));
                    }
                
                    while ($row = $select_comment_query->fetch()) {

                        $comment_date   = $row['comment_date']; 
                        $comment_content= $row['comment_content'];
                        $comment_author = $row['comment_author'];                
                    ?>
                
                    <!-- Comment -->
                    <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="https://api.adorable.io/avatars/64/abott@adorable.png" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                    </div>
                    <?php }  ?>
   
            </div>

            <!-- Blog Sidebar Widgets Column -->
          
              <?php include 'includes/sidebar.php'; ?>

          
        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
<?php include 'includes/footer.php'; ?>
