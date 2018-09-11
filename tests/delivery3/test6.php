<?php
    include("../login_user.php");
    include("../check_out.php");
    include("../request_accept_decline.php");

    
    $email_1 = "s.afonso@innopolis.ru";
    $email_2 = "n.teixeira@innopolis.ru";
    $email_3 = "a.velo@innopolis.ru";
    $email_4 = "v.rama@innopolis.ru";
    $email_5 = "e.espindola@innopolis.ru";
    $password = "password";
    $book = "Null References: The Billion Dollar Mistake";
    
    login_user($email_1, $password);
    check_out($email_1, $book);
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_1'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    accept($id, 1522306800);
    
    
    login_user($email_2, $password);
    check_out($email_2, $book);
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_2'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    accept($id, 1522306800);
    
    
    login_user($email_3, $password);
    check_out($email_3, $book);
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_3'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    //accept($id, 1522306800);
    
    
    login_user($email_4, $password);
    check_out($email_4, $book);
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_4'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    //accept($id, 1522306800);
    
    
    login_user($email_5, $password);
    check_out($email_5, $book);
    $book_id = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name ='$book'"))[0];
    $user_id = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE login = '$email_5'"))[0];
    $id = mysql_fetch_array(mysql_query("SELECT id FROM `requests` WHERE book_id = '$book_id' AND user_id = '$user_id'"))[0];
    //accept($id, 1522306800);
    
$result = mysql_query("SELECT * FROM `queue` WHERE book_id = '$book_id'");
    $message = "";
    while($row = mysql_fetch_array($result)){
        $message = $message.$row['user_name'].'\n';
    }
    
    echo '<script>
                alert("Test6 has been successully completed!");
                alert("'.$message.'");
                window.location.replace("test.php");
          </script>';?>