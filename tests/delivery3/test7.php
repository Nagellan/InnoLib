<?php
    include("../login_user.php");
    include("../check_out.php");
    include("../book_edit_delete.php");
    
    $book = "Null References: The Billion Dollar Mistake";
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    
    $email_1 = "s.afonso@innopolis.ru";
    $email_2 = "n.teixeira@innopolis.ru";
    $email_3 = "a.velo@innopolis.ru";
    $email_4 = "v.rama@innopolis.ru";
    $email_5 = "e.espindola@innopolis.ru";
    
    set_request($book_id, 1522652400);
    
    $result = mysql_query("SELECT * FROM `queue` WHERE book_id = '$book_id'");
    $message = "";
    while($row = mysql_fetch_array($result)){
        $message = $message.$row['user_name'].'\n';
    }
    
    if (empty($message))
        $message = $message."Queue is empty".'\n';
    
    $user_name = mysql_fetch_array(mysql_query("SELECT name FROM `users` WHERE login = '$email_1'"))[0];
    $message = $message.$user_name.' is notified to return the book\n';
    
    $user_name = mysql_fetch_array(mysql_query("SELECT name FROM `users` WHERE login = '$email_2'"))[0];
    $message = $message.$user_name.' is notified to return the book \n';
    
    $user_name = mysql_fetch_array(mysql_query("SELECT name FROM `users` WHERE login = '$email_3'"))[0];
    $message = $message.$user_name.' is notified that book no longer available \n';
    
    $user_name = mysql_fetch_array(mysql_query("SELECT name FROM `users` WHERE login = '$email_4'"))[0];
    $message = $message.$user_name.' is notified that book no longer available \n';
    
    $user_name = mysql_fetch_array(mysql_query("SELECT name FROM `users` WHERE login = '$email_5'"))[0];
    $message = $message.$user_name.' is notified that book no longer available \n';

    
    echo '<script>
                alert("Test7 has been successully completed!");
                alert("'.$message.'");
                window.location.replace("test.php");
          </script>';
?>