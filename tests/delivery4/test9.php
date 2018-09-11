<?php
    include("../../bd.php");
    $result = mysql_query("SELECT * FROM `log`");
    $message="";
    while($row = mysql_fetch_array($result)){
        $time = date('D, d M o, H:i:s', $row['time']);
        $message = $message.$row['name']." ".$row['action']." ".$row['target']." ".$time.'\n';

    }    
    
        echo "<script> 
        alert('$message');
        alert('Test8 has been successfully completed!'); window.location.replace(\"test.php\");</script>";
    
?>