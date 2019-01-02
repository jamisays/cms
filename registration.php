<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>

<?php require 'vendor/autoload.php'; 

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

    $options = array(
        'cluster' => 'ap2',
        'useTLS' => true
      );
    $pusher = new Pusher\Pusher(getenv('APP_KEY'),getenv('APP_SECRET'),getenv('APP_ID'),$options);
?>
    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
    <?php 
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = trim($_POST['username']);
            $email    = trim($_POST['email']);
            $password = trim($_POST['password']);
            
            $error = [
                'username' => '',
                'email' => '',
                'password' => ''
            ];
            
                if(strlen($username) < 4) {
                    $error['username'] = "Username too short!";
                }
                if(strlen($username) == 0) {
                    $error['username'] = "Username cannot be empty!";
                }
                if(!isUniqueUser($username)) {
                    $error['username'] = "Username already taken! Please pick another!";
                }
                if(strlen($email) == 0) {
                    $error['email'] = "Email cannot be empty!";
                }
                if(!isUniqueEmail($email)) {
                    $error['email'] = "Email already exists! <a href='index.php'>Login</a>";
                }
                if(strlen($password) == 0) {
                    $error['password'] = "Password cannot be empty!";
                }

            foreach($error as $key => $value) {
                if(empty($value)) {
                    unset($error[$key]);
                }
            }
            
            if(empty($error)) {
                register_user($username, $email, $password);
                $data['message'] = $username;
                $pusher->trigger('notifications', 'new-user', $data);
                login_user($username, $password);
            }
            
        } 
    ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
<!--                        <h5 class="text-center bg-warning"><?php if($message) {echo $message;} ?></h5>-->
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input autocomplete="on" type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            <p><?php echo isset($error['username']) ? $error['username'] : "" ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input autocomplete="on" type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            <p><?php echo isset($error['email']) ? $error['email'] : "" ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <p><?php echo isset($error['password']) ? $error['password'] : "" ?></p>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
