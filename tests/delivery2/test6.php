<?php
    include("../bd.php");
    $time = time();
    $row = mysql_query("SELECT * FROM users WHERE name = 'Sergey Afonso'");
    $p1 = mysql_fetch_array($row);
    $row = mysql_query("SELECT * FROM files WHERE name = 'Introduction to Algorithms, Third edition'");
    $b1 = mysql_fetch_array($row);
    $row = mysql_query("SELECT * FROM users WHERE name = 'Elvira Espindola'");
    $p3 = mysql_fetch_array($row);
    $row = mysql_query("SELECT * FROM files WHERE name = 'Design Patterns: Elements of Reusable Object-Oriented Software, First edition'");
    $b2 = mysql_fetch_array($row);
    if ($b1['copies'] > 0 and $p1['id'] > 0){
        mysql_query ("INSERT INTO `files-users` (user_id, book_id, check_out_date) VALUES ('".$p1['id']."','".$b1['id']."','".$time."')");
    }
    if ($b1['copies'] > 1 and $p3['id'] > 0){
        mysql_query ("INSERT INTO `files-users` (user_id, book_id, check_out_date) VALUES ('".$p3['id']."','".$b1['id']."','".$time."')");
    }
    if ($b2['copies'] > 0 and $p1['id'] > 0){
        mysql_query ("INSERT INTO `files-users` (user_id, book_id, check_out_date) VALUES ('".$p1['id']."','".$b2['id']."','".$time."')");
    }



    echo "<script> alert('Test6 succesfully completed!'); window.location.replace(\"../search_users.html\");</script>";
?>