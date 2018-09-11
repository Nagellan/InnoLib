<?php
    include("../login_user.php");
    include("../check_out.php");
    include("../return.php");
    
    
    $email_2 = "n.teixeira@innopolis.ru";
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_2'"))[0];

    $book = "Null References: The Billion Dollar Mistake";
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `files-users` WHERE user_id ='$user_id' AND book_id = '$book_id'"))[0];
    return_book($id);
    
    $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE login ='$email_2'"));
    $message = $message.'\n'.$user['name'].'\n';
    $result = mysql_query("SELECT * FROM `returns` WHERE user_id = '$user_id'");
    while ($books = mysql_fetch_array($result)){
        $book = $books['book_id'];
        $book = mysql_fetch_array(mysql_query("SELECT name FROM `files` WHERE id ='$book'"))[0];
        $fine = mysql_fetch_array(mysql_query("SELECT fine FROM `returns` WHERE user_id = '$user_id' "))[0];
        $overdue = mysql_fetch_array(mysql_query("SELECT overdue FROM `returns` WHERE user_id = '$user_id' AND book_name = '$book'"))[0];
        $message = $message."*  ".$book." [fine: ".$fine.", overdue: ".$overdue.']\n';
        
    }
    
    $message = $message.' Andrey Velo is notified that book is available \n';
    $message = $message.' Waiting list: \n';

    
    $result = mysql_query("SELECT * FROM `queue` WHERE book_id = '$book_id'");
    //$message = "";
    while($row = mysql_fetch_array($result)){
        $name = $row['user_name'];
        $message = $message.$name.'\n';
    }
    
    
    echo '<script>
            alert("Test 8 has been successully completed!");
            alert("'.$message.'");
            window.location.replace("test.php");
          </script>';
?>