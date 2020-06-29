 <div class="col-md-4 sidebar"  style="position:-webkit-sticky;position:sticky;top: 80px;">
                
               
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Search</h4>

                        <form action="search.php" method="post">

                            <div class="input-group">
                                <input name="search" type="text" class="form-control">
                                <span class="input-group-btn">
                                    <button name="submit" class="btn btn-default" type="submit">
                                        <span class="glyphicon glyphicon-search"></span>
                                </button>
                                </span>
                            </div>
                            <!-- /.input-group -->
                        </form> 

                </div>
                
                  <!-- Login -->
                <div class="well">
                    <h4>Login</h4>

                        <form action="includes/login.php" method="post">

                            <div class="form-group">
                                <input name="username" type="text" class="form-control" placeholder="Enter username">
                            </div>
                            
                             <div class="input-group">
                                <input name="password" type="password" class="form-control" placeholder="Enter password">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" name="login" type="submit">Submit</button>
                                </span>
                            </div>
                            
                        </form> 
                        <!-- end  Login form -->

                </div>
  
                <!-- Blog Categories Well -->
                <div class="well" >
                   
                   <?php
                    // New pdo way 

                    $category_sidebar = $pdo->query("SELECT * FROM categories");
                
                    $category_sidebar->execute();
                    ?>
                                    
                    <h4>Blog Categories</h4>
                    <div class="row card" >

                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php 
                                
                                // Showing every category title we have with a while loop


                                while ($row = $category_sidebar->fetch()) {
                                         
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                        
                                    // sidebar categories

                                        echo "<li><a href='category.php?category={$cat_id}'>{$cat_title}</a></li>"; 
                                    }

                                ?>
                            
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->

                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                  <?php include "widget.php";  ?>
      
            </div>
