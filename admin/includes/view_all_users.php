<table  class="table table-bordered table-hover">
   <thead>
       <tr>
           <th>Id</th>
           <th>Username</th>
           <th>Firstname</th>
           <th>Lastname</th>
           <th>Email</th>
           <th>Role</th>
          
       </tr>
   </thead>
   <tbody>
      <?php 

        $select_users = $pdo->prepare("SELECT * FROM users");
        $select_users->execute();

        while($row = $select_users->fetch()) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];

            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_firstname}</td>";         
            echo "<td>{$user_lastname}</td>";
            echo "<td>{$user_email}</td>";
            echo "<td>{$user_role}</td>";
            
         
                                                           
            echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
                echo "<td><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>";
                echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
                echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
                echo "</tr>"; 
        }                        
       ?>  
                         
   </tbody>
</table>


<?php
    if(isset($_GET['change_to_admin'])) {
        $the_user_id = $_GET['change_to_admin'];
       
        $change_to_admin_query = $pdo->prepare("UPDATE users SET user_role = 'admin' WHERE user_id =  ? ");

        $change_to_admin_query->execute([$the_user_id]);

        header("Location: users.php");
        
        confirmQuery($change_to_admin_query);
    }

    if(isset($_GET['change_to_sub'])) {
        $the_user_id = $_GET['change_to_sub'];
       
        $change_to_sub_query = $pdo->prepare("UPDATE users SET user_role = 'subscriber' WHERE user_id = ? ");

        $change_to_sub_query->execute([$the_user_id]);

        header("Location: users.php");
        
        confirmQuery($change_to_sub_query);
    }

    if(isset($_GET['delete'])) {
        $the_user_id = $_GET['delete'];
       
        $delete_user_query = $pdo->prepare("DELETE FROM users WHERE user_id = ? ");

        $delete_user_query->execute([$the_user_id]);

        header("Location: users.php");
        
        confirmQuery($delete_user_query);
    }
?>