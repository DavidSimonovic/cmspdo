<table  class="table table-bordered table-hover">
   <thead>
       <tr>
           <th>Id</th>
           <th>Author</th>
           <th>Comments</th>
           <th>Email</th>
           <th>Status</th>
           <th>In Response to</th>
           <th>Date</th>
           <th>Approve</th>
           <th>Unapprove</th>
           <th>Delete</th>
       </tr>
   </thead>
   <tbody>
     
      <?php 

        // All comments
        
        $select_comments = $pdo->prepare("SELECT * FROM comments");
        $select_comments->execute();

        while($row = $select_comments->fetch()) {

            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_email = $row['comment_email'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            echo "<tr>";
            echo "<td>{$comment_id}</td>";
            echo "<td>{$comment_author}</td>";
            echo "<td>{$comment_content}</td>";         
            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_status}</td>";
            
            $select_post_id_query = $pdo->prepare("SELECT * FROM posts WHERE post_id = ? ");
            $select_post_id_query->execute([$comment_post_id]);
            
            while($row = $select_post_id_query->fetch()){

                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                
                echo "<td><a href='../post.php?p_id={$post_id}' >{$post_title}</a></td>";
                
            }

            echo "<td>{$comment_date}</td>";                                                
            echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";                                                
            echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";                                                                                              
            echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";                                                
        }                        
       ?>  
                         
   </tbody>
</table>


<?php
    if(isset($_GET['approve'])) {
        
        $the_comment_id = $_GET['approve'];
        
        $approved_comment_query = $pdo->prepare("UPDATE comments SET comment_status = 'approved' WHERE comment_id = ? ");

        $approved_comment_query->execute([$the_comment_id]);

        header("Location: comments.php");
        
        confirmQuery($approved_comment_query);
    }

    if(isset($_GET['unapprove'])) {

        $the_comment_id = $_GET['unapprove'];
        
        $unapproved_comment_query = $pdo->prepare("UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = ? ");

        $unapproved_comment_query->execute([$the_comment_id]);

        header("Location: comments.php");
        
        confirmQuery($unapproved_comment_query);
    }






    if(isset($_GET['delete'])) {
        $the_comment_id = $_GET['delete'];
        
        $delete_query = $pdo->prepare("DELETE FROM comments WHERE comment_id = ? ");

        $delete_query->execute([$the_comment_id]);

        header("Location: comments.php");
        
        confirmQuery($delete_query);
    }


?>