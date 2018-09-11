<?php
    include("../login_user.php");
    include("../check_out.php");
    include("../return.php");
    include("../request_accept_decline.php");
    include("../book_edit_delete.php");
    
    $email_1 = "s.afonso@innopolis.ru";
    $email_2 = "a.velo@innopolis.ru";
    $email_3 = "v.rama@innopolis.ru";
    $password = "password";
    $book_1 = "Introduction to Algorithms, Third edition";
    $book_2 = "Design Patterns: Elements of Reusable Object-Oriented Software, First edition";
    
    login_user($email_1, $password);
    check_out($email_1, $book_1);
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book_1'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_1'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    accept($id, 1522306800);
    mysql_query("UPDATE `files-users` SET check_out_date = 1522306800 WHERE book_id = '$book_id' AND  user_id = '$user_id'");

    $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];
    renew($id, 1522652400);

    login_user($email_2, $password);
    check_out($email_2, $book_2);
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book_2'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_2'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    accept($id, 1522306800);
    mysql_query("UPDATE `files-users` SET check_out_date = 1522306800 WHERE book_id = '$book_id' AND  user_id = '$user_id'");

    set_request($book_id, 1522652400);
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];
    renew($id, 1522652400);

    
    login_user($email_3, $password);
    check_out($email_3, $book_2);
    
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book_2'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_3'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    accept($id, 1522306800);
    mysql_query("UPDATE `files-users` SET check_out_date = 1522306800 WHERE book_id = '$book_id' AND  user_id = '$user_id'");
    
    set_request($book_id, 1522652400);
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];
    renew($id, 1522652400);

    $everything_is_ok = true;

    $emails = array($email_1, $email_2, $email_3);
    $message = "";
    foreach($emails as $key => $value){
        $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE login ='$value'"));
        $message = $message.'\n'.$user['name'].'\n';
        $user_id = $user['id'];
        $result = mysql_query("SELECT * FROM `files-users` WHERE user_id = '$user_id'");
        while ($books = mysql_fetch_array($result)){
            $book = $books['book_id'];
            $book = mysql_fetch_array(mysql_query("SELECT name FROM `files` WHERE id ='$book'"))[0];
            $check = $books['due_date'];
            $due_date = date('F jS', $books['due_date']);
            $message = $message."*  ".$book." - ".$due_date.'\n';
        }
        if ($value == $email_1)
            if (!($book == $book_1 and $due_date == "April 30th"))
                $everything_is_ok = false;
        else if ($value == $email_2)
            if (!($book == $book_2 and $due_date == "April 2nd"))
                $everything_is_ok = false;
        else if ($value == $email_3)
            if (!($book == $book_2 and $due_date == "April 2nd"))
                    $everything_is_ok = false;
    }
    
    if ($everything_is_ok)
        echo '<script>alert("Test4 has successully completed!");</script>';
    else
        echo '<script>alert("Test4 has failed!");</script>';
    
    echo '<script>
        alert("'.$message.'");
        window.location.replace("test.php");
    </script>';
?>