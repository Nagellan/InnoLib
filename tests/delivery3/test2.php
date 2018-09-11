<?php
    include("../login_user.php");
    include("../check_out.php");
    include("../request_accept_decline.php");
    include("../return.php");
    
    $email_1 = "s.afonso@innopolis.ru";
    $email_2 = "a.velo@innopolis.ru";
    $email_3 = "v.rama@innopolis.ru";
    $password = "password";
    $book_name_1 = "Introduction to Algorithms, Third edition";
    $book_name_2 = "Design Patterns: Elements of Reusable Object-Oriented Software, First edition";
    
    $emails = array($email_1, $email_2, $email_3);
    
    foreach ($emails as $key => $email){
        login_user($email, $password);
        $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email'"))[0];
        
        check_out($email, $book_name_1);
        $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_name = '$book_name_1' AND email = '$email'"))[0];
        accept($id, 1520431200);
    
        check_out($email, $book_name_2);
        $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_name = '$book_name_2' AND email = '$email'"))[0];
        accept($id, 1520431200);
        
        $id = mysql_fetch_array(mysql_query("SELECT id FROM `returns` WHERE user_name ='$email' AND book_name = '$book_name_2'"))[0];
        update_fine_overdue($id);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
/*    login_user($email_1, $password);
    
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_1'"))[0];
    
    check_out($email_1, $book_name_1);
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_name = '$book_name_1' AND email = '$email_1'"))[0];
    accept($id, 1520431200);

    check_out($email_1, $book_name_2);
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_name = '$book_name_2' AND email = '$email_1'"))[0];
    accept($id, 1520431200);
    
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `returns` WHERE user_name ='$email_1' AND book_name = '$book_name_2'"))[0];
    update_fine_overdue($id);
   
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book_name_2'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];
    return_book($id);
    
    
    login_user($email_2, $password);
    
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_2'"))[0];
    
    check_out($email_2, $book_name_1);
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_name = '$book_name_1' AND email = '$email_2'"))[0];
    accept($id, 1520431200);

    check_out($email_2, $book_name_2);
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_name = '$book_name_2' AND email = '$email_2'"))[0];
    accept($id, 1520431200);
    
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `returns` WHERE user_name ='$email_2' AND book_name = '$book_name_2'"))[0];
    update_fine_overdue($id);
   
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book_name_2'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];
    return_book($id);
    
    
    login_user($email_3, $password);
    
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_3'"))[0];
    
    check_out($email_3, $book_name_1);
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_name = '$book_name_1' AND email = '$email_3'"))[0];
    accept($id, 1520431200);

    check_out($email_3, $book_name_2);
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_name = '$book_name_2' AND email = '$email_3'"))[0];
    accept($id, 1520431200);
    
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `returns` WHERE user_name ='$email_3' AND book_name = '$book_name_2'"))[0];
    update_fine_overdue($id);
   
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book_name_2'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];
    return_book($id);
    
    */
    
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
            
            if ($value == $email_1 and $book == $book_name_1)
                {$overdue = 0; $fine = 0;}
            if ($value == $email_1 and $book == $book_name_2)
                {$overdue = 0; $fine = 0;}
            if ($value == $email_2 and $book == $book_name_1)
                {$overdue = 7; $fine = 700;}
            if ($value == $email_2 and $book == $book_name_2)
                {$overdue = 14; $fine = 1400;}
            if ($value == $email_3 and $book == $book_name_1)
                {$overdue = 21; $fine = 2100;}
            if ($value == $email_3 and $book == $book_name_2)
                {$overdue = 21; $fine = 1700;}
            $message = $message."*  ".$book." [fine: ".$fine.", overdue: ".$overdue.']\n';
        }
    }
    
    if ($everything_is_ok)
        echo '<script>alert("Test2 has successully completed!");</script>';
    else
        echo '<script>alert("Test2 has failed!");</script>';
          
    echo '<script>
            alert("'.$message.'");
            window.location.replace("test.php");
          </script>';   
?>