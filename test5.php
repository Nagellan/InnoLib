<?php
    include("bd.php");
    include("variables.php");
    include("login_user.php");
    include("save_user.php");
    include("book_edit_delete.php");
    
    login_user($l2['login'], $l2['password']);
    
    
    $book = mysql_fetch_array(mysql_query("SELECT id FROM `files` WHERE name = '".$d1['name']."' "))[0];
    edit($book, $d1['name'], $d1['author'], $d1['publisher'], $d1['best'], $d1['type'], $d1['description'], "", $d1['price'], 2, $d1['tags']);
    
    $condition1 = mysql_fetch_array(mysql_query("SELECT copies FROM `files` WHERE name = '".$d1['name']."'"))[0];
    
    if ($condition1 == 2 ) {
         echo '<script>
                alert("1 copy of d1 has been successfully deleted!!");
              </script>';
    }
    
    if ($condition1 == 2)
        echo "<script> alert('Test5 has been successfully completed!'); window.location.replace(\"test.php\");</script>";
    else
        echo "<script> alert('Test5 has been failed!'); window.location.replace(\"test.php\");</script>";
?>