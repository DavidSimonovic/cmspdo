<?php
    if(isset($_POST['create_user'])) {

        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        
      
    
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];


        $select_randsalt_query = $pdo->prepare("SELECT randSalt FROM users");
        $select_randsalt_query->execute();

        if (!$select_randsalt_query) {

            die("Query failed". mysqli_error($pdo));
        
        }

        $row = $select_randsalt_query->fetch();

        $salt = $row['randSalt'];

        $hashed_password = crypt($user_password, $salt);
  
        // Making a query with the given info to insert in to the database
        $create_user_query = $pdo->prepare("INSERT INTO users (user_firstname, user_lastname, user_image, user_role,username,user_email,user_password) VALUES ( ? , ? , 'img', ? , ? , ? ,?)");
        $create_user_query->execute([$user_firstname , $user_lastname, $user_role, $username, $user_email, $hashed_password ]); 
        
        // Function we made to check if connection is working
        confirmQuery($create_user_query);
        
        echo "<p class='bg-success'>User created. <a href='users.php'>View users</a></p>";
    }


?>
  
<form action="" method="post" enctype="multipart/form-data">        
    
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    
    <div class="form-group">
        <select name="user_role" id="user_role">
          
                <option value='subscriber'>Select Options</option>
                <option value='admin'>Admin</option>
                <option value='subscriber'>Subscriber</option>
         
      </select>
    </div>

   
    <div class="form-group">
       <label for="username">Username</label>
       <input type="text" class="form-control" name="username">
    </div>
   
    <div class="form-group">
       <label for="user_email">Email</label>
       <input type="email" class="form-control" name="user_email">
    </div>
    
    <div class="form-group">
       <label for="user_password">Password</label>
       <input type="password" class="form-control" name="user_password">
    </div>
    
   

    <div class="form-group">
       <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>
</form>
  
  