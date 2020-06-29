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
                
                
                if(isset($_GET['category'])){

                    
                    $post_category_id =  $_GET['category'];
                
                }
                
                // pdo 

                $all_posts = $pdo->prepare("SELECT * FROM posts WHERE post_category_id = ?");
                
                $all_posts->execute([$post_category_id]); 

                while ($row = $all_posts->fetch())
                 {

                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 150);
                 
                    ?>

                        <h1 class="page-header">

                        
                             <?php echo $post_title; ?>
                        
                        </h1>

                        <!-- First Blog Post -->
                    
                        
                        <p class="lead">
                        
                        <!-- using the variable we made to show every author we have -->
                            by <a href="index.php"><?php echo $post_author; ?></a>
                        </p>
                        <p>
                        
                        <!-- using the variable we made to show every date we have -->
                        <span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                        <hr>
                        
                        <!-- using the variable we made to show every image we have -->
                <a href="post.php?p_id=<?php echo $post_category_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""></a>
                        <hr>
                        <p> 
                        
                        <!-- using the variable we made to show every content we have -->
                        <?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>
                        
                        <!-- closting the while loop -->
                    <?php
                     } 
                    ?>  
                        
             

            </div>

            <!-- Blog Sidebar Widgets Column -->
          
              <?php include 'includes/sidebar.php'; ?>

          
        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
<?php include 'includes/footer.php'; ?>
