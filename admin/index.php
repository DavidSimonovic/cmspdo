<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">
        
        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                  
                    </div>
                </div><!-- /.row -->
                
                <div class="row">
                   
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                       
                                        <?php

                                            // all posts
                                            $select_all_post = $pdo->prepare("SELECT * FROM posts");
                                            
                                            $select_all_post->execute();

                                            $post_count = $select_all_post->fetchColumn();

                                            echo "<div class='huge'>{$post_count}</div>";
                                        
                                        ?>

                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <?php 
                                        
                                            // all comments
                                            $select_all_comments = $pdo->prepare("SELECT * FROM comments");
                                            $select_all_comments->execute();

                                            $comment_count = $select_all_comments->fetchColumn();
                                            echo "<div class='huge'>{$comment_count}</div>";
                                        
                                        ?>

                                      <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                      <?php 

                                            // all users
                                            $select_all_users = $pdo->prepare("SELECT * FROM users");
                                            $select_all_users->execute();

                                            $user_count = $select_all_users->fetchColumn();

                                            echo "<div class='huge'>{$user_count}</div>";
                                        
                                        ?>

                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                         <?php 

                                            // all categories
                                            $select_all_categories = $pdo->prepare("SELECT * FROM categories");

                                            $select_all_categories->execute();

                                            $category_count = $select_all_categories->fetchColumn();

                                            echo "<div class='huge'>{$category_count}</div>";
                                        
                                        ?>

                                         <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                
                <?php 

                    // all published posts
                    $select_all_published_posts = $pdo->prepare("SELECT * FROM posts WHERE post_status = ? ");

                    $select_all_published_posts->execute(['published']);

                    $post_published_count = $select_all_published_posts->fetchColumn();
                

                    // all drafts
                    $select_all_draft_posts = $pdo->prepare("SELECT * FROM posts WHERE post_status = ? ");

                    $select_all_draft_posts->execute(['draft']);

                    $post_draft_count = $select_all_draft_posts->fetchColumn();
                    
                    // all unapproved
                    $unapproved_comment_query = $pdo->prepare("SELECT * FROM comments WHERE comment_status = ? ");

                    $unapproved_comment_query->execute(['unapproved']);

                    $unapproved_comment_count = $unapproved_comment_query->fetchColumn();
                
                    // all subscribers
                    $select_all_subscribers = $pdo->prepare("SELECT * FROM users WHERE user_role = ? ");
                    
                    $select_all_subscribers->execute(['subscriber']);

                    $subscriber_count = $select_all_subscribers->fetchColumn();
                                                
                                                
                ?>
            
                <div class="row">
                    <script type="text/javascript">

                      google.charts.load('current', {'packages':['bar']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Data', 'Count'],
                            
                            
                            
                            <?php
                                
                                $element_text = ['All posts', 'Active Posts', 'Draft Posts', 'Comments', 'Panding comments', 'Users', 'Subscribers', 'Categories'];
                                $element_count = [$post_count, $post_published_count, $post_draft_count, $comment_count, $unapproved_comment_count, $user_count, $subscriber_count, $category_count];
                                
                                for($i = 0; $i < 8; $i++) {
                                    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                                }
                                                
                            ?>
                            
                            
                            
                 //       ['Posts', 500],
           
                        ]);

                        var options = {
                          chart: {
                            title: '',
                            subtitle: '',
                          }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                      }
                    </script>
                    
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                    
                    
                </div>
                
                
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include "includes/admin_footer.php"; ?>