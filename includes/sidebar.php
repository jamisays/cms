<?php 
    if(ifItIsMethod('post')) {
        if(isset($_POST['login'])) {
            if(isset($_POST['username']) && isset($_POST['password'])) {
            login_user($_POST['username'], $_POST['password']);
            }
            else {
                redirect('index');
            }
        }
    }
 ?>

            <div class="col-md-4">
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <!-- search form -->
                    <form action="/cms/search.php" method="post">
                        <div class="input-group">
                            <input name="search" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button name="submit" class="btn btn-primary" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                            </button>
                            </span>
                        </div>
                    </form> 
                    <!-- /.input-group -->
                </div>
                
                
                <!-- Login -->
                <div class="well">
                   <?php if(isset($_SESSION['user_role'])): ?>
                       <h3>You are logged in as: <?php echo $_SESSION['username']; ?></h3>
                       <br>
                       <div>
                           <a class="btn btn-danger" href="/cms/includes/logout.php">Logout</a>
                       </div>
                   <?php else: ?>
                       <h4 class="text-center">Login</h4>
                        <!-- search form -->
                        <form method="post">
                            <div class="form-group">
                                <input name="username" placeholder="username" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <input name="password" placeholder="password" type="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <a href="/cms/forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
                            </div>
                            <button class="btn btn-primary form-control" name="login" type="submit">Submit</button>
                        </form> 
                   <?php endif; ?>
                   
                   
                    
                    <!-- /.input-group -->
                </div>
                
                

                <!-- Blog Categories Well -->
                <div class="well">
                   
                   <?php 
                        $query = "SELECT * FROM category";
                        $select_categories = mysqli_query($connection,$query);
                    ?>
                   
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                               <?php 
                                    while($row = mysqli_fetch_assoc($select_categories)) {
                                    $cat_title = $row['cat_title'];
                                    $cat_id = $row['cat_id'];

                                    echo "<li><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                                    }
                                ?>
                            </ul>
                        </div>

                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>
                
                
                

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Don’t Miss These Latest Articles!</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>