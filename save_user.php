<?php // adding a new user to the database
    include ("bd.php"); // making a connection with the database
    $who = mysql_fetch_array(mysql_query("SELECT name FROM users WHERE login = '".$_COOKIE['userName']."'"))[0];
    $password = $_POST['password']; $name = $_POST['name']; $address = $_POST['address']; $phone = $_POST['phone']; $login = $_POST['login']; $status = $_POST['status'];
    
    if (isset($_POST['img-btn'])){ // changing an image of user
        $url = $_POST['img-url'];
        if (!empty($url) and get_headers($url, 1)){
            mysql_query("UPDATE `users` SET `img_link` = '$url' WHERE `login` = '".$_COOKIE['userName']."'");
            // writing about changing an account image to the log table
            mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$who',' changed its account image','','".time()."')");
            echo "<script> alert('Account image has been successfully changed'); window.location.replace(\"profile.html\");</script>"; // writing a message about successful changing of an image
        } else echo "<script> alert('The url-address is incorrect or empty.'); window.location.replace(\"profile.html\");</script>"; // writing a message about incorrect or empty url-address
    } else if (isset($_POST['password-btn'])){ // changing a password of a user
        $password = $_POST['password'];
        if (!empty($password)){
            mysql_query("UPDATE `users` SET `password` = '$password' WHERE `login` = '".$_COOKIE['userName']."'");
            // writing about changing a password to the log table
            mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$who',' changed its account password','','".time()."')");
            echo "<script> alert('Password has been successfully changed'); window.location.replace(\"profile.html\");</script>"; // writing a message about successful changing of a password
        } else echo "<script> alert('The field is empty!'); window.location.replace(\"profile.html\");</script>"; // writing a message if the field is empty
    } else if (isset($_POST['button'])){
        $password = substr(md5(uniqid(rand(),true)), 0, 8);
        $title = 'Welcome to InnoLib!';
        $body = '<p><b>Your password:</b> '.$password.'</p><p>Now you can go <a href="http://y98722gq.beget.tech/signUp.html">here</a> to log in and start using InnoLib!</p>';
        include("send_email.php");
        send_email($login, $title, $body); // sending an email to a user
        $output = create_user($login, $password, $name, $address, $phone, $status, true);
        if ($output == "already-registered")
            echo "<script>alert('Sorry, this login has been already registered. Enter another login.'); window.location.replace(\"search_users.html\");</script>";
        else if ($output == "success")
            echo "<script>alert('You have successfully registered a user!'); window.location.replace(\"search_users.html\");</script>";
        else if ($output == "fill-completely")
            echo "<script> alert('Fill the form completely!'); window.location.replace(\"search_users.html\");</script>";
        else if ($output == "admin-exists")
            echo "<script> alert('Library cannot have more than 1 admin!'); window.location.replace(\"search_users.html\");</script>";
    } else if (isset($_POST['input'])){
        $output = create_user($login, $password, $name, $address, $phone, $status, false);
        if ($output == "already-registered")
            echo "<script>alert('Sorry, this login has been already registered. Enter another login.');window.location.replace(\"signUp.html\");</script>";
        else if ($output == "success")
            echo "<script> alert('You have been successfully registered!'); window.location.replace(\"profile.html\");</script>";
        else if ($output == "fill-completely")
            echo "<script> alert('Fill the form completely!'); window.location.replace(\"signUp.html\");</script>";
        else if ($output == "admin-exists")
            echo "<script> alert('Library cannot have more than 1 admin!'); window.location.replace(\"signUp.html\");</script>";
    }
        
    function create_user($login, $password, $name, $address, $phone, $status, $is_registered){
        if (empty($login) or empty($password) or empty($name) or empty($address) or empty($phone) or empty($status)) // if the user didn't enter a username or password, we issue an error and stop the script
            return "fill-completely";
        else {
            // checking for the existence of a user with the same login
            $admin_nums = mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE status = 'Admin'"));
            if ($status == "Admin" and $admin_nums > 0)
                return "admin-exists";
            $user_id = mysql_fetch_array(mysql_query("SELECT id FROM users WHERE login='$login'"))[0];
            if (!empty($user_id))
                return "already-registered";
            else {        // if there is no such, then saving the data
                mysql_query ("INSERT INTO users (login,password, name, address, phone, status) VALUES('$login','$password','$name','$address','$phone', '$status')");
                if ($is_registered){        // writing that someone created an account for a user to the log table
                    global $who;
                    mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$who',' created an account for ','$name','".time()."')");
                } else {
                    setcookie("userName", $login);
                    setcookie('status', $status);
                    // writing about registration a new user to the log table
                    mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$name',' created an account','','".time()."')");  
                }
                return "success";
            }
        }
    }
?>