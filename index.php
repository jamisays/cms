<?php 
    include "admin/functions.php";
    include "includes/db.php";
    include "includes/header.php";
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
                    
                    $per_page = 3;
                    
                    if(isset($_GET['page'])) {
                        $page = $_GET['page'];
                    }
                    else {
                        $page = "";
                        $black = 1;
                    }
                    if($page == "" || $page == 1) {
                        $page_1 = 0;
                        $page = 1;
                    }
                    else {
                        $page_1 = ($page * $per_page) - $per_page;
                    }
                    
                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
                        $count_query = "SELECT * FROM posts";
                    
                    }
                    else {
                        $count_query = "SELECT * FROM posts WHERE post_status = 'published'";
                    }
                
                    $count_query_exe = mysqli_query($connection, $count_query);
                    $count = mysqli_num_rows($count_query_exe);
                
                if($count < 1) {
                    echo "<h3 class='text-center'>No Posts</h3>";
                }
                else {

                    $page_count = ceil($count / $per_page);
                
                    $query = "SELECT * FROM posts LIMIT {$page_1}, {$per_page}";
                    $select_all_posts = mysqli_query($connection,$query);
                       
                    while($row = mysqli_fetch_assoc($select_all_posts)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_status = $row['post_status'];
                        $post_content = substr($row['post_content'], 0, 100);
                        
                ?>
                
                        <!-- First Blog Post -->
                <h2>
                    <a href="post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <a href="post/<?php echo $post_id; ?>">
                    <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
                    
                
                <?php   }  } ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>
        
        <ul class="pager">
            <?php 
                if(isset($page_count)) {
                    for($i = 1; $i <= $page_count; $i++) {
                        if($i == $page) {
                            echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                        }
                        else {
                            echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                        }
                    }
                }
                
            ?>
        </ul>

<?php 
    include "includes/footer.php";
?>

