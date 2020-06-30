<?php 


// Tests if the query was sucessfull

function confirmQuery($result) {
    global $pdo;

    if(!$result) {
            die("QUERY FAILS " . mysqli_error($pdo));
        }
}

// Adding categories

function insert_categories() {
    
    global $pdo;
    
    if(isset($_POST["submit"])){
        $cat_title = $_POST["cat_title"];

        if($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $create_category_query = $pdo->prepare("INSERT INTO categories(cat_title) VALUES = ? ");
            $create_category_query->execute([$cat_title]);


            if(!$create_category_query) {
                die('Connection failed' . mysqli_error($pdo));
            }
        }
    }   
}

// Searching and Showing categories

function findAllCategories() {
    
    global $pdo;

    // All categories

    $select_categories = $pdo->prepare("SELECT * FROM categories");
    $select_categories->execute();

    while ($row = $select_categories->fetch()){
        
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

// Deleting categories 

function deletCategory(){

    global $pdo;
    
    if(isset($_GET['delete'])) {

        $the_cat_id = $_GET['delete'];

        $delete_category = $pdo->prepare("DELETE FROM categories WHERE cat_id = ? ");

        $delete_category->execute([$the_cat_id]);

        header("Location: categories.php");
        

        if(!$delete_category){

            die("Not Deleted" . mysqli_error($pdo));
        }
    }


    
}



?>