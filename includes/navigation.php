<nav class="navbar navbar-inverse navbar-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms">CMS Front</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                   
                   <?php 
                       $query = "SELECT * FROM category";
                       $nav_select_connection = mysqli_query($connection,$query);
                       
                       while($row = mysqli_fetch_assoc($nav_select_connection)) {
                           $cat_title = $row['cat_title'];
                           $cat_id = $row['cat_id'];
                           
                           $cat_class = "";
                           $reg_class = "";
                           $reg = basename($_SERVER['PHP_SELF']);
                           $name = "registration.php";
                           
                           if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
                               $cat_class = 'active';
                           }
                           else if($reg == $name) {
                               $reg_class = 'active';
                           }
                           
                           
                           echo "<li class='$cat_class'><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
                       }
                   ?>

                    <?php if(isLoggedIn()): ?>
                    <li>
                        <a href="/cms/admin">Admin</a>
                    </li>
                    <li>
                        <a href="/cms/includes/logout.php">Logout</a>
                    </li>
                    <?php else: ?>
                    <li>
                        <a href="/cms/login">Login</a>
                    </li>
                    <li class="<?php echo $reg_class; ?>">
                        <a href="/cms/registration">Register</a>
                    </li>
                    
                  <?php endif; ?>

                    <li>
                        <a href="/cms/contact">Contact</a>
                    </li>

                   <?php 
                        if(isset($_SESSION['username'])) {
                            if(isset($_GET['p_id'])) {
                                $edit_post_id = $_GET['p_id'];
                                echo "<li><a href='/cms/admin/posts.php?source=edit_post&p_id={$edit_post_id}'>Edit Post</a></li>";
                            }
                        }
                    ?>
               
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
</nav>