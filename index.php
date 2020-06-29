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

                // UBACITI BROJ STRANICA!!!






                // PDO 
                if(isset($_GET['source'])){

                    $source = $_GET['source'];


                    // all posts with specific post_id

                    $all_posts = $pdo->prepare('SELECT * FROM posts WHERE post_category_id = ?');

                    $all_posts->execute([$source]);
                    
                   
                }
                
                else
                
                {
                
                // all posts

                $all_posts = $pdo->prepare("SELECT * FROM posts");
                
                $all_posts->execute(); 
                
                }
                
                while ($row = $all_posts->fetch()) {
                    
                // variables for easier use
                   
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'], 0, 150);
                        $post_status = $row['post_status'];
                        
                if($post_status == 'published') {
                            
                        
                ?>

                    <div class="jumbotron">
                       
                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>

                        <!-- First Blog Post -->
                       
                        <p class="lead">
                        
                        <!-- Authore name -->
                            by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                        </p>
                        <p>
                        
                        <!-- Date -->
                        <span class="glyphicon glyphicon-time"></span><?php echo ' '.$post_date; ?></p>
                        <hr>
                        
                        <!-- Image -->
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""></a>
                        <hr>
                        <p> 
                        
                        <!-- Content -->
                        <?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>
                    </div>


                        <!-- closting the while loop anad the if statment-->
                <?php }    } ?>  
                        
                 </div>

            <!-- Blog Sidebar Widgets Column -->
          
              <?php include 'includes/sidebar.php'; ?>

            </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
<?php include 'includes/footer.php'; ?>
 