<?php
    include("bd.php");
    include("variables.php");
    include("login_user.php");
    include("search.php");
    
    login_user($v['login'], $v['password']);
    $result = search("Introduction");
    $message="";
    while($row = mysql_fetch_array($result)){
        
        $message = $message.$row['name'].'\n';

    }    
    
        echo "<script> 
        alert('$message');
        alert('Test10 has been successfully completed!'); window.location.replace(\"test.php\");</script>";
?>    