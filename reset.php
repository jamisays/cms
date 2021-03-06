<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>

<!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>

<?php 
    if(!isset($_GET['email']) && !isset($_GET['token'])) {
        redirect('index');
    }
    
    // $email = 'jamisays@gmail.com';
    // $token = "469092d191a07c9ef5b6c073313ca87d7689252f74a330fe68f9fc167c70991c3a085c61af49a158332b08bd9e6d0d04bd84";
    
    if($stmt = mysqli_prepare($connection, "SELECT username, user_email, token FROM users WHERE token = ?")) {
        mysqli_stmt_bind_param($stmt, 's', $_GET['token']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    if(isset($_POST['password']) && isset($_POST['confirmPassword'])) {
        if($_POST['password'] === $_POST['confirmPassword']) {
            $password = $_POST['password'];
            $hashed_password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
            $stmt = mysqli_prepare($connection, "UPDATE users SET token = '', user_password = '{$hashed_password}' WHERE user_email = ?");
            mysqli_stmt_bind_param($stmt, 's', $_GET['email']);
            mysqli_stmt_execute($stmt);
            if(mysqli_stmt_affected_rows($stmt) >= 1) {
                mysqli_stmt_close();
                redirect('login.php');
            }

        }
    }
    

 ?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                                <input id="password" name="password" placeholder="password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                                <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                                <!-- <h2>Please check your email</h2> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

