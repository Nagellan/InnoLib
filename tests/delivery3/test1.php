<?php
    include("../login_user.php");
    include("../check_out.php");
    include("../request_accept_decline.php");
    include("../return.php");
    
    $email = "s.afonso@innopolis.ru";
    $password = "password";
    $book_name_1 = "Introduction to Algorithms, Third edition";
    $book_name_2 = "Design Patterns: Elements of Reusable Object-Oriented Software, First edition";
    
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
   
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book_name_2'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];
    return_book($id);
    
    $everything_is_ok = false;
    
    $message = "";
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE login ='$email'"));
    $message = $message.'\n'.$user['name'].'\n';
    $result = mysql_query("SELECT * FROM `files-users` WHERE user_id = '$user_id'");
    while ($books = mysql_fetch_array($result)){
        $book = $books['book_id'];
        $book = mysql_fetch_array(mysql_query("SELECT name FROM `files` WHERE id ='$book'"))[0];
        $fine = mysql_fetch_array(mysql_query("SELECT fine FROM `returns` WHERE user_id = '$user_id'"))[0];
        $overdue = mysql_fetch_array(mysql_query("SELECT overdue FROM `returns` WHERE user_id = '$user_id'"))[0];
        $message = $message."*  ".$book." [fine: ".$fine.", overdue: ".$overdue.']\n';
        if ($book == $book_name_1 and $fine == 0 and $overdue == 0)
            $everything_is_ok = true;
    }
    
    if ($everything_is_ok)
        echo '<script>alert("Test1 has successully completed!");</script>';
    else
        echo '<script>alert("Test1 has failed!");</script>';
          
    echo '<script>
            alert("'.$message.'");
            window.location.replace("test.php");
          </script>';
?>