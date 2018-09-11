<?php // deleting or editting a user 
    include("bd.php"); // making a connection with the database
    $who = $_COOKIE['userName'];
    $who = mysql_fetch_array(mysql_query("SELECT name FROM users WHERE login = '$who'"))[0];
    
    if (isset($_POST['delete'])) { // deleting a user
        $index = $_POST['delete'];
        $login = $_POST["email".$index];
        mysql_query("DELETE FROM `users` WHERE `users`.`login` = '$login'");
        mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$who',' deleted the user ','".$_POST["name".$index]."','".time()."')");
        echo "<script>alert('User has been removed');window.location.replace(\"search_users.html\");</script>";
    }
    else if (isset($_POST['edit'])) { // editting a user
        $index = $_POST['edit'];
        $login = $_POST["email".$index];
        $name = $_POST["name".$index];
        $address = $_POST["address".$index];
        $phone = $_POST["phone".$index];
        $status = $_POST["status".$index];
        $id = $_POST["id".$index];
        
        mysql_query("UPDATE `users` SET `name` = '".$name."' WHERE `users`.`id` = '".$id."'");
        mysql_query("UPDATE `users` SET `address` = '".$address."' WHERE `users`.`id` = '".$id."'");
        mysql_query("UPDATE `users` SET `phone` = '".$phone."' WHERE `users`.`id` = '".$id."'");
        mysql_query("UPDATE `users` SET `login` = '".$login."' WHERE `users`.`id` = '".$id."'");
        mysql_query("UPDATE `users` SET `status` = '".$status."' WHERE `users`.`id` = '".$id."'");
        
        // writing about editing the user to the log table
        mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$who',' edited the user ','$name','".time()."')");
        echo "<script>alert('The user\'s information has been edited');window.location.replace(\"search_users.html\");</script>";
    }
    
?>