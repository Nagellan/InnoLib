<?php
    include("../../bd.php");
    include("variables.php");
    include("../../login_user.php");
    include("../../save_user.php");
    include("../../book_edit_delete.php");
    
    login_user($l2['login'], $l2['password']);
    
    
    
    $condition1 = mysql_num_rows(mysql_query("SELECT * FROM `files` WHERE name = $d1['names'] AND copies = 2"));
    
    if ($condition1 == 1)
        echo "<script> alert('Test12 has been successfully completed!'); window.location.replace(\"test.php\");</script>";
    else
        echo "<script> alert('Test12 has been failed!'); window.location.replace(\"test.php\");</script>";
?>