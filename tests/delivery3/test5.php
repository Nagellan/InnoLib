<?php
    include("../login_user.php");
    include("../check_out.php");
    include("../request_accept_decline.php");

    
    $email_1 = "s.afonso@innopolis.ru";
    $email_2 = "a.velo@innopolis.ru";
    $email_3 = "v.rama@innopolis.ru";
    $password = "password";
    $book = "Null References: The Billion Dollar Mistake";
    
    login_user($email_1, $password);
    check_out($email_1, $book);
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email'"))[0];
    
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    accept($id, 1522306800);
    
    
    login_user($email_2, $password);
    check_out($email_2, $book);
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    accept($id, 1522306800);
    
    
    login_user($email_3, $password);
    check_out($email_3, $book);
    
    $result = mysql_query("SELECT * FROM `queue` WHERE book_id = '$book_id'");
    $message = "";
    while($row = mysql_fetch_array($result)){
        $name = $row['user_name'];
        $message = $message.$name.'\n';
    }
    
    if ($name == "Veronika Rama")
        echo '<script>alert("Test5 has successully completed!");</script>';
    else
        echo '<script>alert("Test5 has failed!");</script>';
        
    echo '<script>
                alert("'.$message.'");
                window.location.replace("test.php");
          </script>';
?>