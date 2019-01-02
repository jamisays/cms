            <table class="table table-bordered table-hover">
                <thead>
                    <th>ID</th>
                    <th>Author</th>
                    <th>Comment</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>In Response to</th>
                    <th>Date</th>
                    <th>Approve</th>
                    <th>Unapprove</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                   <?php
                    $query = "SELECT * FROM comments";
                    $select_comments = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($select_comments)) {
                        $comment_id = $row['comment_id'];
                        $comment_post_id = $row['comment_post_id'];
                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];
                        $comment_email = $row['comment_email'];
                        $comment_status = $row['comment_status'];
                        $comment_date = $row['comment_date'];

                        echo "<tr>";
                        echo "<td>$comment_id</td>";
                        echo "<td>$comment_author</td>";
                        echo "<td>$comment_content</td>";
                        echo "<td>$comment_email</td>";
                        echo "<td>$comment_status</td>";

                            // displaying the post title from post table
                            $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id} ";
                            $select_post_id_query = mysqli_query($connection, $query);

                            while($row = mysqli_fetch_assoc($select_post_id_query)) {
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];    
                                echo "<td><a href='../post/$post_id'>$post_title</a></td>";
                            }


                        
                        //echo "<td>Some Title</td>";
                        echo "<td>$comment_date</td>";
                        if(isAdmin(currentUser())) {
                            echo "<td><a class='btn btn-success' href='comments.php?approve=$comment_id'>Approve</a></td>";
                            echo "<td><a class='btn btn-warning' href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                            echo "<td><a class='btn btn-danger' href='comments.php?delete=$comment_id'>Delete</a></td>";
                        }
                        else {
                            echo "<td><a class='btn btn-success disabled' href='comments.php?approve=$comment_id'>Approve</a></td>";
                            echo "<td><a class='btn btn-warning disabled' href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                            echo "<td><a class='btn btn-danger disabled' href='comments.php?delete=$comment_id'>Delete</a></td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

<?php 

    if(isset($_GET['approve'])) {
        $approve_comment_id = $_GET['approve'];
        
        $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = {$approve_comment_id} ";
        
        $approve_comment = mysqli_query($connection, $query);
        header("Location: comments.php");
        
        checkConnection($approve_comment);
    }

    if(isset($_GET['unapprove'])) {
        $unapprove_comment_id = $_GET['unapprove'];
        
        $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = {$unapprove_comment_id} ";
        
        $unapprove_comment = mysqli_query($connection, $query);
        header("Location: comments.php");
        
        checkConnection($unapprove_comment);
    }

    if(isset($_GET['delete'])) {
        $delete_comment_id = $_GET['delete'];
        
        $query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id} ";
        
        $delete_comment = mysqli_query($connection, $query);
        header("Location: comments.php");
        
        checkConnection($delete_comment);
    }
?>






