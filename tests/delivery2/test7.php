<?php
    include("../bd.php");
    $time = time();
    $row = mysql_query("SELECT * FROM users WHERE name ='Sergey Afonso'");
    $p1 = mysql_fetch_array($row);
    $row = mysql_query("SELECT * FROM users WHERE name = 'Nadia Teixeira'");
    $p2 = mysql_fetch_array($row);
    $row = mysql_query("SELECT * FROM files WHERE name = 'Introduction to Algorithms, Third edition'");
    $b1 = mysql_fetch_array($row);
    $row = mysql_query("SELECT * FROM files WHERE name = 'Design Patterns: Elements of Reusable Object-Oriented Software, First edition'");
    $b2 = mysql_fetch_array($row);
    $row = mysql_query("SELECT * FROM files WHERE name = 'The Mythical Man-month, Second edition'");
    $b3 = mysql_fetch_array($row);
    $row = mysql_query("SELECT * FROM files WHERE name = 'Null References: The Billion Dollar Mistake'");
    $av1 = mysql_fetch_array($row);
    $row = mysql_query("SELECT * FROM files WHERE name = 'Information Entropy'");
    $av2 = mysql_fetch_array($row);
    if ($b1['copies'] > 0 and $p1['id'] > 0){
        mysql_query ("INSERT INTO `files-users` (user_id, book_id, check_out_date) VALUES ('".$p1['id']."','".$b1['id']."','".$time."')");
    }
    if ($b2['copies'] > 0  and $p1['id'] > 0){
        mysql_query ("INSERT INTO `files-users` (user_id, book_id, check_out_date) VALUES ('".$p1['id']."','".$b2['id']."','".$time."')");
    }
    if ($b3['copies'] > 0  and $p1['id'] > 0){
        mysql_query ("INSERT INTO `files-users` (user_id, book_id, check_out_date) VALUES ('".$p1['id']."','".$b3['id']."','".$time."')");
    }
    if ($av1['copies'] > 0  and $p1['id'] > 0){
        mysql_query ("INSERT INTO `files-users` (user_id, book_id, check_out_date) VALUES ('".$p1['id']."','".$av1['id']."','".$time."')");
    }
    if ($b1['copies'] > 0  and $p2['id'] > 0){
        mysql_query ("INSERT INTO `files-users` (user_id, book_id, check_out_date) VALUES ('".$p2['id']."','".$b1['id']."','".$time."')");
    }
    if ($b2['copies'] > 0  and $p2['id'] > 0){
        mysql_query ("INSERT INTO `files-users` (user_id, book_id, check_out_date) VALUES ('".$p2['id']."','".$b2['id']."','".$time."')");
    }
    if ($av2['copies'] > 0  and $p2['id'] > 0){
        mysql_query ("INSERT INTO `files-users` (user_id, book_id, check_out_date) VALUES ('".$p2['id']."','".$av2['id']."','".$time."')");
    }
    echo "<script> alert('Test7 succesfully completed!'); window.location.replace(\"../search_users.html\");</script>";
?>