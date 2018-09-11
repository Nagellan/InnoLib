<?php
    include("bd.php");
    include("variables.php");
    include("login_user.php");
    include("check_out.php");
    include("book_edit_delete.php");


    check_out($p1['login'], $d3['name']);

    check_out($p2['login'], $d3['name']);

    check_out($s['login'], $d3['name']);

    check_out($v['login'], $d3['name']);

    check_out($p3['login'], $d3['name']);
    
    login_user($l3['login'], $l3['password']);
    $who = $l3['name'];
    
    $id = mysql_fetch_array(mysql_query("SELECT id from `files` WHERE name = '".$d3['name']."'"))[0];
    set_request($id, time(), $l3['status']);
    
    
    
    
    if (mysql_fetch_array(mysql_query("SELECT out_req from `files` WHERE name = '".$d3['name']."'"))[0] == 1){
        $message = '1. Waiting list for document d3 is empty. \n 2. s, p1 and p2 are notified to return the respective books. \n 3. v and p3 are notified that document d3 is not longer available and that they have been removed from the waiting list.';
        
        echo "<script>alert('".$message."');  alert('Test7 has been successfully completed!'); window.location.replace(\"test.php\");</script>";
        
    }
    else
        echo "<script> alert('Test7 has failed!'); window.location.replace(\"test.php\");</script>";

?>