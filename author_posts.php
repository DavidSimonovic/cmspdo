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
                    $the_post_id =  $_GET['p_id'];
                    $the_post_author =  $_GET['author'];
                }
                // NEW PDO WAY

                $author_posts = $pdo->prepare("SELECT * FROM posts WHERE post_author = ?");
                
                $author_posts->execute([$the_post_author]); 

                while ($row = $author_posts->fetch()){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                     
                        ?>
                     
                        <!-- Showing all posts by author-->
                    
                        <h2>
                           <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>
                        
                        <p class="lead">
                        
                            All posts by <?php echo $post_author; ?>
                        </p>
                        <p>
                        
                        <span class="glyphicon glyphicon-time"></span><?php echo ' '.$post_date; ?></p>
                        <hr>
                        
                        <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                        <hr>
                        <p> 
                        
                        <?php echo $post_content; ?>
                    
                        </p>
                 

                        <hr>

                        <br>
                        
                        <!-- closing the while loop -->
                    <?php } ?>  
                      
                      
                       
                <!-- Blog Comments -->
                    <?php
                    
                        if(isset($_POST['create_comment'])) {
                            
                            $the_post_id =  $_GET['p_id'];
                            $comment_author = $_POST['comment_author'];
                            $comment_email = $_POST['comment_email'];
                            $comment_content= $_POST['comment_content'];
                            
                            if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                                //pdo 

                                $create_comment_query = $pdo->prepare("INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ?,?,?,?,, 'unapproved', now()");
                
                                $create_comment_query->execute([$the_post_id,$comment_author, $comment_email, $comment_content]); 


                                if(!$create_comment_query) {
                                    die("QUERY FAILS" . mysqli_error($pdo));
                                }
                                

                                $update_comment_count = $pdo->prepare("UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = ? ");
                                
                                $update_comment_count->execute([$the_post_id]); 

                                if(!$update_comment_count) {

                                    die("QUERY FAILS" . mysqli_error($pdo));
                                
                                }
                                
                                echo "<p class='bg-success'>Commentar Created!";
                            }  

                            else 
                            
                            {
                                echo "<script>alert('Fields cannot be empty')</script>";
                            }
                        }
                
                
                    ?>
                
                
                
                

                <!-- Comments Form -->
   

                    <!-- Posted Comments -->
             
                    <!-- Comment -->
                 
   
            </div>

            <!-- Blog Sidebar Widgets Column -->
          
              <?php include 'includes/sidebar.php'; ?>

          
        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
<?php include 'includes/footer.php'; ?>
