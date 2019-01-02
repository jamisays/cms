<?php 

    if(isset($_GET['edit_user'])) {
        $the_user_id = $_GET['edit_user'];
        
        $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
        $update_user_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($update_user_query)) {
            $username = $row['username'];
            $bd_user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
//            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
        }
    }

    if(isset($_POST['update_user'])) {

        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];

//        $post_image = $_FILES['post_image']['name'];
//        $post_image_temp = $_FILES['post_image']['tmp_name'];

        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        
        
        if(!empty($user_password)) {
            $query = "SELECT user_password FROM users WHERE user_id = $the_user_id";  
            $update_query = mysqli_query($connection, $query);
            checkConnection($update_query);
            
            $row = mysqli_fetch_array($update_query);
            $db_user_password = $_POST['user_password'];
            
            if($db_user_password != $user_password) {
                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
            }
            else {
                $hashed_password = password_hash($db_user_password, PASSWORD_BCRYPT, array('cost' => 12));
            }
        }
        else {
            $hashed_password = $bd_user_password;
        }
        
        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$hashed_password}' ";
        $query .= "WHERE user_id = $the_user_id ";
        
        $update_user_query = mysqli_query($connection, $query);
        
        checkConnection($update_user_query);
        
        echo "User Updated!" . "<a href='users.php'>View Users</a>";
    }
?>
   

   
<form action="" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="post_author">Firstname</label>
        <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname">
    </div>
    
    <div class="form-group">
        <label for="post_status">Lastname</label>
        <input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname">
    </div>
    
    <div class="form-group">
        <select name="user_role" id="">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php 
                if($user_role == 'admin' || $user_role == 'Admin') {
                    echo "<option value='subscriber'>subscriber</option>";
                }
                else {
                    echo "<option value='admin'>admin</option>";
                }
            ?>
        </select>
    </div>
    
<!--
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
-->
    
    <div class="form-group">
        <label for="post_tags">Username</label>
        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
    </div>
    
    <div class="form-group">
        <label for="post_content">Email</label>
        <input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email">
    </div>
    
    <div class="form-group">
        <label for="post_content">Password</label>
        <input autocomplete="off" type="password" value="" class="form-control" name="user_password">
    </div>
    
    <div class="form-group">
        <input class="btn btn-primary" type="submit" class="form-control" name="update_user" value="Edit User">
    </div>
    
</form>