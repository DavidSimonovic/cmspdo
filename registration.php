<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php

if(isset($_POST['submit'])){
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];


    if($repassword === $password){


    if(!empty($username) && !empty($email) && !empty($password)) {
        
    
        $select_randsalt_query = $pdo->query("SELECT randSalt FROM users");
                
        $select_randsalt_query->execute(); 
                

        

        if (!$select_randsalt_query) {

            die("Query failed". mysqli_error($pdo));
        }

        $row = $select_randsalt_query->fetch();

        $salt = $row['randSalt'];

        $password = crypt($password, $salt);

        // PDO



        $register_user_query = $pdo->prepare("INSERT INTO users (username, user_email, user_firstname, user_lastname, user_password, user_image, user_role) VALUES ( ?, ? , ? , ? , ? , 'img' , 'subscriber' )");
                
        $register_user_query->execute([$username, $email, $name, $lastname , $password ]); 



        if (!$register_user_query) {

            die("Query failed ". mysqli_error($pdo) . ' ' . mysqli_errno($pdo));
        }
        
            $message = "Your registration has been submitted!";
   
        } else {
        
            $message = "Fields cannot be empty!";
        
        }
        
        }
        else
        {
            $message = "Passwords do not match";
        }
    
        } else {

            $message = "";
        
        }

?>

<!-- Navigation -->
    
<?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                       
                       <h6 class="text-center"><?php echo $message; ?></h6>
                       
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="name" class="sr-only">Name</label>
                            <input type="text" name="name" id="username" class="form-control" placeholder="Name">
                        </div>
                         <div class="form-group">
                            <label for="lastname" class="sr-only">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                         <div class="form-group">
                            <label for="repassword" class="sr-only">Repeat Password</label>
                            <input type="password" name="repassword" id="key" class="form-control" placeholder="Repeat Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<br>

<?php include "includes/footer.php";?>
