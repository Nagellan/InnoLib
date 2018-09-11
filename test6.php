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
    
    login_user($l1['login'], $l1['password']);
    $who = $l1['name'];
    
    $id = mysql_fetch_array(mysql_query("SELECT id from `files` WHERE name = '".$d3['name']."'"))[0];
    set_request($id, time(), $l1['status']);
    if (mysql_fetch_array(mysql_query("SELECT out_req from `files` WHERE name = '".$d3['name']."'"))[0] == 0)
        echo "<script> alert('Test6 has been successfully completed!'); window.location.replace(\"test.php\");</script>";
    else
        echo "<script> alert('Test6 has been failed!'); window.location.replace(\"test.php\");</script>";
?>