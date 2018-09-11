<?php
    include("../login_user.php");
    include("../check_out.php");
    include("../return.php");
    include("../request_accept_decline.php");
    
    $email_1 = "s.afonso@innopolis.ru";
    $email_2 = "v.rama@innopolis.ru";
    $password = "password";
    $book = "Introduction to Algorithms, Third edition";
    
    login_user($email_1, $password);
    check_out($email_1, $book);
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_1'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    accept($id, 1522047600);
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];

    renew($id, 1522306800);
    
    
    login_user($email_2, $password);
    check_out($email_2, $book);
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_2'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    accept($id, 1522047600);
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];
    renew($id, 1522306800);
    
    
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE login ='$email_1'"));
    $message = $message.'\n'.$user['name'].'\n';
    $user_id = $user['id'];
    $result = mysql_query("SELECT * FROM `files-users` WHERE user_id = '$user_id'");
    while ($books = mysql_fetch_array($result)){
        $book = $books['book_id'];
        $book = mysql_fetch_array(mysql_query("SELECT name FROM `files` WHERE id ='$book'"))[0];
        $due_date = date('F jS', $books['due_date']);
        $message = $message."*  ".$book." - ".$due_date.'\n';
    }   
    
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE login ='$email_2'"));
    $message = $message.'\n'.$user['name'].'\n';
    $user_id = $user['id'];
    $result = mysql_query("SELECT * FROM `files-users` WHERE user_id = '$user_id'");
    while ($books = mysql_fetch_array($result)){
        $book = $books['book_id'];
        $book = mysql_fetch_array(mysql_query("SELECT name FROM `files` WHERE id ='$book'"))[0];
        $due_date = date('F jS', $books['due_date']);
        $message = $message."*  ".$book." - ".$due_date.'\n';
    }    
    
    echo '<script>
            alert("Test 10 has been successully completed!");
            alert("'.$message.'");
            window.location.replace("test.php");
          </script>';
    
    
    
    
?>