<?php 
    
    function checkConnection($result) {
        global $connection;
        
        if(!$result) {
            die("Connection error!! " . mysqli_error($connection));
        }
    }

    function redirect($location) {
        header("Location: " . $location);
        exit;
    }

    function query($query) {
        global $connection;
        return mysqli_query($connection, $query);
    }

    function loggedInUserId() {
        global $connection;
        if(isLoggedIn()) {
            $resultt = mysqli_query($connection,"SELECT * FROM users WHERE username='" . $_SESSION['username'] ."'");
            checkConnection($resultt);
            $userr = mysqli_fetch_array($resultt);
            return mysqli_num_rows($resultt) >= 1 ? $userr['user_id'] : false;
        }
    }

    function getPostlikes($post_id){

        $result = query("SELECT * FROM likes WHERE post_id=$post_id");
        checkConnection($result);
        echo mysqli_num_rows($result);

    }

    function userLikedThisPost($post_id='') {
        global $connection;
        $result = mysqli_query($connection,"SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " AND post_id={$post_id}");
        checkConnection($result);
        $user = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? true : false;
    }

    function imagePlaceholder($image='') {
        if(!$image) {
            return 'prd.jpg';
        }
        else {
            return $image;
        }
    }

    function currentUser() {
        if(isset($_SESSION['username'])) {
            return $_SESSION['username'];
        }
        return false;
    }

    function ifItIsMethod($method=null) {
        if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
            return true;
        }
        else {
            return false;
        }
    }

    function isLoggedIn() {
        if(isset($_SESSION['user_role'])) {
            return true;
        }
        return false;
    }

    function checkIfUserLoggedInAndRedirect ($redirectLocation=null) {
        if(isLoggedIn()){
            redirect($redirectLocation);
        }
    }

    function escape($string) {
        global $connection;
        return mysqli_real_escape_string($connection,trim($string));
    }
    

    function users_online() {
        global $connection;
        
        $session = session_id();
        $time = time();
        $timeout_in_seconds = 30;
        $timeout = $time - $timeout_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

            if($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('{$session}','{$time}')");
            }
            else {
                mysqli_query($connection, "UPDATE users_online SET time = '{$time}' WHERE session = '{$session}'");
            }
        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '{$timeout}'");
        return mysqli_num_rows($users_online_query);    
    }
    
    function insert_categories() {
        global $connection;
        if(isset($_POST['submit'])) {
            $cat_title = $_POST['cat_title'];
            if($cat_title == "" || empty($cat_title)) {
                echo "Should not empty!";
            }
        else {
            $stmt = mysqli_prepare($connection, "INSERT INTO category(cat_title) VALUE(?) ");

            mysqli_stmt_bind_param($stmt, 's', $cat_title);
            
            mysqli_stmt_execute($stmt);
            
            if(!$stmt) {
                die("Error in query!" . mysqli_error($connection));
            }
            mysqli_stmt_close($stmt);
        }

        }
    }

    function findAllCategories() {
        global $connection;
            $query = "SELECT * FROM category";
            $select_categories = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<tr>";
                echo "<td>{$cat_id}</td>";
                echo "<td>{$cat_title}</td>";
                if(isAdmin(currentUser())) {
                    echo "<td><a class='btn btn-warning' href='categories.php?update={$cat_id}'>Edit</a></td>";
                    echo "<td><a class='btn btn-danger' href='categories.php?delete={$cat_id}'>Delete</a></td>";
                }
                else {
                    echo "<td><a class='btn btn-warning disabled' href='categories.php?update={$cat_id}'>Edit</a></td>";
                    echo "<td><a class='btn btn-danger disabled' href='categories.php?delete={$cat_id}'>Delete</a></td>";
                }
                echo "</tr>";
            }
    }

    function recordCount($tName) {
        global $connection;
        $query = "SELECT * FROM " . $tName;
        $count_post_query = mysqli_query($connection, $query);
        
        $result = mysqli_num_rows($count_post_query);
        checkConnection($result);
        return $result;
    }

    function deleteCategories() {
        global $connection;
        if(isset($_GET['delete'])) {
            $the_cat_id = $_GET['delete'];
            $query = "DELETE FROM category WHERE cat_id = {$the_cat_id} ";
            mysqli_query($connection, $query);
            header("Location: categories.php");
        }
    }

    function checkStatus($tName,$rName,$sName) {
        global $connection;
        $query = "SELECT * FROM $tName WHERE $rName = '$sName' ";
        $result = mysqli_query($connection, $query);
        return mysqli_num_rows($result);
    }

    function checkUserRole($tName,$rName,$sName) {
        global $connection;
        $query = "SELECT * FROM $tName WHERE $rName = '$sName' ";
        $result = mysqli_query($connection, $query);
        return mysqli_num_rows($result);
    }

    function isAdmin($uName) {
        global $connection;
        if(isLoggedIn()) {
            $query = "SELECT user_role FROM users WHERE username = '$uName' ";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            if($row['user_role'] == 'Admin') {
                return true;
            }
            else {
                return false;
            }
        }
        return false;
    }

    function isUniqueUser($username) {
        global $connection;
        $query = "SELECT username FROM users WHERE username = '$username' ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_num_rows($result);
        if($row) {
            return false;
        }
        else {
            return true;
        }
    }

    function isUniqueEmail($email) {
        global $connection;
        $query = "SELECT user_email FROM users WHERE user_email = '$email' ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_num_rows($result);
        if($row) {
            return false;
        }
        else {
            return true;
        }
    }

    function register_user($username, $email, $password) {
        
        global $connection;
        
        $username = mysqli_real_escape_string($connection, $username);
        $email    = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        $query = "INSERT INTO users (username, user_email, user_password, user_role) VALUES('{$username}','{$email}','{$password}','Subscriber')";
        $register_query = mysqli_query($connection, $query);

        checkConnection($register_query);
        echo "<p class='bg-success text-center'>Registered Successfully! <a href='index.php'> Login</a> </p>";

    }

    function login_user($uName, $uPassword) {
        global $connection;
        
        $username = trim($uName);
        $password = trim($uPassword);
        
        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);
        
        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $select_user_query = mysqli_query($connection, $query);
        checkConnection($select_user_query);
        
        while($row = mysqli_fetch_array($select_user_query)) {
            $db_user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];
        }
        
//        $password = crypt($password, $db_user_password);
        
        if(isset($db_user_password) && password_verify($password,$db_user_password)) {
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['user_firstname'] = $db_user_firstname;
            $_SESSION['user_lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
            
//            header("Location: ../admin");
            // if(basename($_SERVER['PHP_SELF']) == 'login.php' || basename($_SERVER['PHP_SELF']) == 'login') {
            //     redirect("/cms/admin");
            // }
            // else {
                redirect("/cms/admin");
            // }
        } 
        else {
//            header("Location: ../index.php");
            // redirect("index.php");
            return false;
            // redirect('/cms/login.php');
        }
    }

?>