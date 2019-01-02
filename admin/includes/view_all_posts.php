
   <?php 

//    include("delete_modal.php");
    if(isset($_POST['checkBoxArray'])) {
        foreach($_POST['checkBoxArray'] as $postValueId) {
            $bulkOptions = $_POST['bulkOptions'];
            switch($bulkOptions) {
                case 'published':
                    $query = "UPDATE posts SET post_status = '{$bulkOptions}' WHERE post_id = {$postValueId}";
                    $update = mysqli_query($connection, $query);
                    break;
                case 'draft':
                    $query = "UPDATE posts SET post_status = '{$bulkOptions}' WHERE post_id = {$postValueId}";
                    $update = mysqli_query($connection, $query);
                    break;
                case 'clone':
                    $query = "SELECT * FROM posts where post_id = '{$postValueId}'";
                    $clone_query = mysqli_query($connection, $query);
                    
                    while($row = mysqli_fetch_array($clone_query)) {
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_author = $row['post_author'];
                        $post_category_id = $row['post_category_id'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_content = $row['post_content'];
                    }

                    $query = "INSERT INTO posts(post_category_id,post_title,post_user,post_date,post_image,post_content,post_tags,post_status) ";

                    $query .= "VALUES({$post_category_id},'{$post_title}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";

                    $create_post_query = mysqli_query($connection, $query);

                    checkConnection($create_post_query);
                    break;
                case 'delete':
                    $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                    $update = mysqli_query($connection, $query);
                    break;
                
            }   
        }
    }
?>
   
<form action="" method="post">
    <table class="table table-bordered table-hover">
       <div id="bulkOptionContainer" class="col-xs-4">
           <select name="bulkOptions" id="" class="form-control">
               <option value="">Select Options</option>
               <option value="published">Publish</option>
               <option value="draft">Draft</option>
               <option value="clone">Clone</option>
               <option value="delete">Delete</option>
           </select>
       </div>
       <div class="col-xs-4">
           <input type="submit" name="submit" class="btn btn-success" value="Apply">
           <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
       </div>
        <thead>
            <th><input type="checkbox" id="selectAllBoxes"></th>
            <th>ID</th>
            <th>User</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Views</th>
        </thead>
        <tbody>
           <?php

           $ussr = currentUser();

           if($ussr == 'Jami') {
                $query = "SELECT posts.post_id,posts.post_author,posts.post_user,posts.post_title,posts.post_category_id,posts.post_status,posts.post_image,posts.post_tags,posts.post_comment_count,posts.post_date,posts.post_views_count,category.cat_id,category.cat_title FROM posts LEFT JOIN category ON posts.post_category_id = category.cat_id ORDER BY posts.post_id DESC";
           }
           else {
                $query = "SELECT posts.post_id,posts.post_author,posts.post_user,posts.post_title,posts.post_category_id,posts.post_status,posts.post_image,posts.post_tags,posts.post_comment_count,posts.post_date,posts.post_views_count,category.cat_id,category.cat_title FROM posts LEFT JOIN category ON posts.post_category_id = category.cat_id WHERE posts.post_user = '$ussr' ORDER BY posts.post_id DESC";
           }
            
            
            
            $select_posts = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_posts)) {
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_user = $row['post_user'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_date = $row['post_date'];
                $post_views_count = $row['post_views_count'];
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                
                echo "<tr>";
            ?>
                
            <td><input type="checkbox" class="checkBoxes" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
            
            <?php
                
                echo "<td>$post_id</td>";
                if(!empty($post_author)){
                    echo "<td>$post_author</td>";
                } 
                elseif(!empty($post_user)) {
                    echo "<td>$post_user</td>";
                }
                
                
                echo "<td>$post_title</td>";

                    // displaying the post category from category table
//                    $query = "SELECT * FROM category WHERE cat_id = {$post_category_id} ";
//                    $select_categories_id = mysqli_query($connection, $query);
//
//                    while($row = mysqli_fetch_assoc($select_categories_id)) {
//                        $cat_id = $row['cat_id'];
//                        $cat_title = $row['cat_title']; 
                
                        echo "<td>$cat_title</td>";
                   // }


                echo "<td>$post_status</td>";
                echo "<td><img width='80' src='../images/$post_image'</td>";
                echo "<td>$post_tags</td>";
                
                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $comment_count_query = mysqli_query($connection, $query);
                $row = mysqli_fetch_array($comment_count_query);
                $comment_id = $row['comment_id'];
                $count_comment = mysqli_num_rows($comment_count_query);
                
                echo "<td><a href='post_comments.php?id={$post_id}'>$count_comment</a></td>";
                
                echo "<td>$post_date</td>";
                echo "<td><a class='btn btn-primary' href='../post/{$post_id}'>View Post</a></td>";
                echo "<td><a class='btn btn-warning' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                
                ?>
                
                <form action="" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <?php 
                        if(isAdmin($_SESSION['username'])) {
                            echo "<td><a onClick=\"javascript: return confirm('Are you sure?'); \" ><input class='btn btn-danger delete_link' type='submit' name='delete' value='Delete'</a></td>";
                        }
                        else {
                            echo "<td><a onClick=\"javascript: return confirm('Are you sure?'); \" ><input class='btn btn-danger delete_link disabled' type='submit' name='delete' value='Delete'</a></td>";
                        }
                    ?>
                    
                </form>
                
                <?php 
                
                
//                echo "<td><a rel='$post_id' class='delete_link'>Delete</a></td>";
                
//                echo "<td><a onClick=\"javascript: return confirm('Are you sure?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
                echo "<td>{$post_views_count} <a href='posts.php?reset={$post_id}'>reset</a> </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</form>
   
<?php 
    if(isset($_GET['reset'])) {
        $reset_post_id = $_GET['reset'];
        
        $zero = 0;
        
        $query = "UPDATE posts SET post_views_count = {$zero} WHERE post_id = {$reset_post_id} ";
        
        $reset_post_count = mysqli_query($connection, $query);
        header("Location: posts.php");
        
        checkConnection($reset_post_count);
    }
?>

<?php 
    if(isset($_POST['delete'])) {
        $delete_post_id = $_POST['post_id'];
        
        $query = "DELETE FROM posts WHERE post_id = {$delete_post_id} ";
        
        $delete_post = mysqli_query($connection, $query);
        header("Location: posts.php");
        
        checkConnection($delete_post);
    }
?>

<script>
    $(document).ready(function() {
        $(".delete_link").on('click', function(){
           var id = $(this).attr("rel");
           var delete_url = "posts.php?delete="+ id +" "; 
           $(".modal_delete_link").attr("href", delete_url);
           $("#myModal").modal('show');
        });
    });
</script>






