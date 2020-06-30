<?php

if(isset($_GET['edit_user'])) {
    $the_user_id = $_GET['edit_user'];
    
     $select_users_query = $pdo->prepare("SELECT * FROM users WHERE user_id = ? ");
    
    $select_users_query->execute([$the_user_id]);

    while($row = $select_users_query->fetch()) {

        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    
    }
    
    
    
}

    if(isset($_POST['edit_user'])) {

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
        
        
        $edit_user_query = $pdo->prepare("UPDATE users SET user_firstname  = ? , user_lastname = ? , user_role   =  ? , username = ? , user_email = ? , user_password   = ? WHERE user_id = ? ");
        
        $edit_user_query->execute([$user_firstname, $user_lastname, $user_role, $username, $user_email, $hashed_password , $the_user_id]);
        
        confirmQuery($edit_user_query);
    }


?>
<div class='container'>
  <div class='row'>
<form action="" method="post" enctype="multipart/form-data">        
    
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" value="<?php echo $user_lastname; ?>"  class="form-control" name="user_lastname">
    </div>
    
    <div class="form-group">
        <select name="user_role" id="user_role">
         
             <option value='<?php echo $user_role; ?>'><?php echo $user_role; ?></option>
             <?php
                if($user_role == 'admin') {
                    echo "<option value='subscriber'>Subscriber</option>";
                } else {
                    echo "<option value='admin'>Admin</option>";
                }  
            
            ?>

         
      </select>
    </div>
 
    
    <div class="form-group">
       <label for="username">Username</label>
       <input type="text" value="<?php echo $username; ?>"  class="form-control" name="username">
    </div>
   
    <div class="form-group">
       <label for="user_email">Email</label>
       <input type="email" value="<?php echo $user_email; ?>"  class="form-control" name="user_email">
    </div>
     
    
    <div class="form-group">
       <label for="user_password">Password</label>
       <input type="password" value="<?php echo $user_password; ?>"  class="form-control" name="user_password">
    </div>
    
   

    <div class="form-group">
       <input type="submit" class="btn btn-primary" name="edit_user" value="Edit User">
    </div>
</form>
  
  </div>
</div>