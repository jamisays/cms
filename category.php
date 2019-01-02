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
                    Posts
                </h1>
                
                <?php 
                
                    if(isset($_GET['category'])) {
                        $post_category_id = $_GET['category']; 
                    
                    if(isset($_SESSION['username']) && isAdmin($_SESSION['username'])) {
                        $stmt1 = mysqli_prepare($connection,"SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");
                    }
                        
                    else {
                        $stmt2 = mysqli_prepare($connection,"SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");
                        $published = 'published';
                    }
                        
                    if(isset($stmt1)) {
                        mysqli_stmt_bind_param($stmt1, "i", $post_category_id);
                        mysqli_stmt_execute($stmt1);
                        mysqli_stmt_store_result($stmt1);
                        mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
                        $stmt = $stmt1;
                    }
                    else {
                        mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);
                        mysqli_stmt_execute($stmt2);
                        mysqli_stmt_store_result($stmt2);
                        mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
                        $stmt = $stmt2;
                    } 
                        
                    if(mysqli_stmt_num_rows($stmt) === 0) {
                        // echo mysqli_stmt_num_rows($stmt);
                        echo "<h3 class='text-center'>No Post</h3>";
                    }
                       
                    while(mysqli_stmt_fetch($stmt)):
                        
                        ?>
                                <!-- First Blog Post -->
                        <h2>
                            <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="../author_posts.php?author=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                        <hr>
                        <a href="/cms/post/<?php echo $post_id; ?>">
                            <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                        </a>
                        <hr>
                        <?php $post_content = substr($post_content, 0, 100); ?>
                        <p><?php echo $post_content ?></p>

                        <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>
                    
                
                <?php   endwhile;  mysqli_stmt_close($stmt); } else {
                        
                        header("Location: index.php");
                        
                    }?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php 
    include "includes/footer.php";
?>