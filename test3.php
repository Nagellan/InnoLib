<?php
    include("bd.php");
    include("variables.php");
    include("login_user.php");
    include("save_book.php");

    login_user($l1['login'], $l1['password']);
    
    $error1 = save_book($d1['name'], $d1['author'], $d1['best'], $d1['type'], $d1['publisher'], $d1['description'], 3, $d1['price'], $d1['tags'], $l1['status']);
    $error2 = save_book($d2['name'], $d2['author'], $d2['best'], $d2['type'], $d2['publisher'], $d2['description'], 3, $d2['price'], $d2['tags'], $l1['status']);
    $error3 = save_book($d3['name'], $d3['author'], $d3['best'], $d3['type'], $d3['publisher'], $d3['description'], 3, $d3['price'], $d3['tags'], $l1['status']);
    
    $condition1 = mysql_num_rows(mysql_query("SELECT * FROM `files` WHERE name = '".$d1['name']."' AND copies = 3"));
    $condition2 = mysql_num_rows(mysql_query("SELECT * FROM `files` WHERE name ='".$d2['name']."' AND copies = 3"));
    $condition3 = mysql_num_rows(mysql_query("SELECT * FROM `files` WHERE name = '".$d3['name']."' AND copies = 3"));

     if ($error1 == "no-access" and $error2 == "no-access" and $error3 == "no-access") {
         echo '<script>
                alert("Librarian-1 do not have an opportunity to create new books!");
              </script>';
    }
    
    if ($condition1 == 0 && $condition2 == 0 && $condition3 == 0)
        echo "<script> alert('Test3 has been successfully completed!'); window.location.replace(\"test.php\");</script>";
    else
        echo "<script> alert('Test3 has been failed!'); window.location.replace(\"test.php\");</script>";
        
?>