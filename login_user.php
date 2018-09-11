<?php // login user
    if (isset($_POST['login-btn'])){
        $output = login_user($_POST['login'], $_POST['password']);
        if ($output == "fill-completely")
            echo "<script> alert('Fill the form completely!'); window.location.replace(\"signUp.html\");</script>";
        else if ($output == "success")
            echo "<script>alert('You have successfully logged in!'); window.location.replace(\"profile.html\");</script>"; // writing a message about successful logging
        else if ($output == "fail")
            echo "<script>alert('Sorry, written login or password is incorrect!'); window.location.replace(\"signUp.html\");</script>";
    }
    
    function login_user($login, $password){
        if (empty($login) or empty($password)) // if the user didn't enter a username or password, issuing an error and stopping the script
            return "fill-completely";
            
        $login = stripslashes($login);            // if login and password are entered, then processing them so that
        $login = htmlspecialchars($login);        // tags and scripts don't work (we don't know what people can enter)
        $password = stripslashes($password);
        $password = htmlspecialchars($password);
        $login = trim($login);                    // remove extra spaces
        $password = trim($password);
        
        include ("bd.php"); // making a connection with the database
        
        $myrow = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='$login'")); // extract from the database all data about the user with the entered login
        
        if ($myrow['password'] == $password) {    // if the login exists and the passwords match, then start the user session!
                setcookie('userName', $login);
                setcookie('status', $myrow['status']);
                $name = mysql_fetch_array(mysql_query("SELECT name FROM users WHERE login = '$login'"))[0];
                
                mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$name',' logged in','','".time()."')"); // writing about logging to the log table
                return "success";
            } 
        else         // if the user with the entered login doesn't exist
            return "fail";
        
    }
?>