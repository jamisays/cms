<?php 
    include "includes/db.php";
    include "includes/header.php";
    include "admin/functions.php";
?>

    <!-- Navigation -->
    
<?php 
    include "includes/navigation.php";
?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
               
               <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                
                <?php 
                
                    if(isset($_GET['p_id'])) {
                        $the_post_id = $_GET['p_id'];
                        $the_post_author = $_GET['author'];
                    }
                
                    $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}' ";
                    $select_all_posts = mysqli_query($connection,$query);
                       
                    while($row = mysqli_fetch_assoc($select_all_posts)) {
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        
                ?>
                        <!-- First Blog Post -->
                <h2>
                    <a href="post/<?php echo $the_post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    All posts by <?php echo $post_user; ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <hr>
                    
                
                <?php   }   ?>
                
                <!-- Blog Comments -->

                <!-- Comments Form -->
                
                <?php 
                    if(isset($_POST['create_comment'])) {
                        $the_post_id = $_GET['p_id'];
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];
                        
                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                            $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";

                            $insert_comment_query = mysqli_query($connection, $query);
                            checkConnection($insert_comment_query);

                            $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                            $query .= "WHERE post_id = $the_post_id";

                            $update_comment_count = mysqli_query($connection, $query);
                        }
                        else {
                            echo "<script>alert('Fields cannot be enpty!')</script>";
                        }
                    }
                    
                ?>
                
<!--
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" name="comment_author" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <input type="email" name="comment_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Your Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>
-->

                <hr>

                <!-- Posted Comments -->
                
                
                
                

                <!-- Comment -->
                

                <!-- Comment -->
                

            </div>

            <!-- Blog Sidebar Widgets Column -->
            
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php 
    include "includes/footer.php";
?>