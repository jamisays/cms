<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
    <?php 
        // the message
        $msg = "First line of text\nSecond line of text";

        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg,70);

        // send email
        // mail("jamisays@gmail.com","My subject",$msg);
        
        if(isset($_POST['submit'])) {
            $to    = "jamisays@gmail.com";
            $email = $_POST['email'];
            $body  = $_POST['body'];
            
            
        }
    ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                        <h5 class="text-center bg-warning"><?php if(isset($message)) {echo $message;} ?></h5>
                        <div class="form-group">
                            <label for="subject" class="sr-only">subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your Subject">
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email">
                        </div>
                         <div class="form-group">
                            <textarea class="form-control" name="body" id="body" placeholder="Your Content Here" cols="30" rows="4"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
