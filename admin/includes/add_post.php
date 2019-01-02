<?php 
    if(isset($_POST['create_post'])) {
        $post_title = escape($_POST['post_title']);
        $post_user = escape($_POST['post_user']);
        $post_category_id = escape($_POST['post_category']);
        $post_status = escape($_POST['post_status']);

        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];

        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);
        $post_date = date('d-m-y');
//        $post_comment_count = 4;
        
        move_uploaded_file($post_image_temp, "../images/$post_image");
        
        $query = "INSERT INTO posts(post_category_id,post_title,post_user,post_date,post_image,post_content,post_tags,post_status) ";
        
        $query .= "VALUES({$post_category_id},'{$post_title}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
        
        $create_post_query = mysqli_query($connection, $query);
        
        checkConnection($create_post_query);
        
        $create_post_id = mysqli_insert_id($connection);
        
        echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$create_post_id}'>View Post</a> or <a href='posts.php?source=add_post'>Add More Posts</a>  </p>";
    }
?>
   

   
<form action="" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
    </div>
    
    <div class="form-group">
       <label for="post_category">Category</label>
        <select name="post_category" id="">
            <?php 
                $query = "SELECT * FROM category";
                $select_categories = mysqli_query($connection, $query);
            
                checkConnection($select_categories);

                while($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            ?>
        </select>
    </div>
    
    <div class="form-group">
       <label for="post_user">User</label>
        <select name="post_user" id="">
            <?php 
                $query = "SELECT * FROM users";
                $select_users = mysqli_query($connection, $query);
            
                checkConnection($select_users);

                while($row = mysqli_fetch_assoc($select_users)) {
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                    
                    echo "<option value='{$username}'>{$username}</option>";
                }
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="">
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="body" type="text" class="form-control" name="post_content" cols="30" rows="10"></textarea>
    </div>
    
    <div class="form-group">
        <input class="btn btn-primary" type="submit" class="form-control" name="create_post" value="Publish Post">
    </div>
    
</form>