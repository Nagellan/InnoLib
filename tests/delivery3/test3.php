<?php
    include("../login_user.php");
    include("../check_out.php");
    include("../request_accept_decline.php");
    include("../return.php");
    
    $email_1 = "s.afonso@innopolis.ru";
    $email_2 = "a.velo@innopolis.ru";
    $email_3 = "v.rama@innopolis.ru";
    
    $password = "password";
    
    $book_1 = "Introduction to Algorithms, Third edition";
    $book_2 = "Design Patterns: Elements of Reusable Object-Oriented Software, First edition";
    
    log_in_check_out_renew($email_1, $password, $book_1);
    log_in_check_out_renew($email_2, $password, $book_2);
    log_in_check_out_renew($email_3, $password, $book_2);
    
    function log_in_check_out_renew($email, $password, $book){
        login_user($email, $password);
        check_out($email, $book);
        
        $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
        $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email'"))[0];
        
        $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
        accept($id, 1522306800);
        
        $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];
        renew($id, 1522652400);
    }
    
    $emails = array($email_1, $email_2, $email_3);
    $message = "";
    
    $everything_is_ok = true;
    
    foreach($emails as $key => $value){
        $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE login ='$value'"));
        $message = $message.'\n'.$user['name'].'\n';
        $user_id = $user['id'];
        $result = mysql_query("SELECT * FROM `files-users` WHERE user_id = '$user_id'");
        while ($books = mysql_fetch_array($result)){
            $book = $books['book_id'];
            $book = mysql_fetch_array(mysql_query("SELECT name FROM `files` WHERE id ='$book'"))[0];
            $due_date = date('F jS', $books['due_date']);
            $message = $message."*  ".$book." - ".$due_date.'\n';
        }
        if ($value == $email_1)
            if (!($book == $book_1 and $due_date == "April 30th"))
                $everything_is_ok = false;
        else if ($value == $email_2)
            if (!($book == $book_2 and $due_date == "April 16th"))
                $everything_is_ok = false;
        else if ($value == $email_3)
            if (!($book == $book_2 and $due_date == "April 9th"))
                    $everything_is_ok = false;
    }
    
    if ($everything_is_ok)
        echo '<script>alert("Test3 has successully completed!");</script>';
    else
        echo '<script>alert("Test3 has failed!");</script>';
    
    echo '<script>
                alert("'.$message.'");
                window.location.replace("test.php");
          </script>';
?>