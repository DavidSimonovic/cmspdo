<?php include "db.php"; ?>
<?php session_start(); ?>


<?php 

    if(isset($_POST['login'])){

        // 
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        
        $select_user_query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $select_user_query->execute([$username]);
        
        if(!$select_user_query) {

            die("QUERY FAILS" . mysqli_error($pdo));
        }
        
        while ($row = $select_user_query->fetch()){

            $db_user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];       
        
        }

        $password = crypt($password, $db_user_password);
        
        if($username === $db_username && $password === $db_user_password){

            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
            
            header("Location: ../admin");
        } 
        else 
        {
           //header("Location: ../index.php");
           header("Location: ../admin");
        }  
        
    }
?>