<?php
    include("../login_user.php");
    include("../check_out.php");
    include("../return.php");
    
    $email_1 = "s.afonso@innopolis.ru";
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_1'"))[0];

    $book = "Null References: The Billion Dollar Mistake";
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];
    renew($id, time());
    
   
        
        
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
        
    
    
    $message = $message.'Waiting list: \n';

    
    $result = mysql_query("SELECT * FROM `queue` WHERE book_id = '$book_id'");
    //$message = "";
    while($row = mysql_fetch_array($result)){
        $name = $row['user_name'];
        $message = $message.$name.'\n';
    }
    
    
    echo '<script>
            alert("Test9 has been successully completed!");
            alert("'.$message.'");
            window.location.replace("test.php");
          </script>';
    
    
    echo '<script>alert( document.cookie );alert("Test9 has been completed!");window.location.replace("test.php");</script>';
?>