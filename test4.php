<?php
    include("bd.php");
    include("variables.php");
    include("login_user.php");
    include("save_user.php");
    include("save_book.php");
    
    login_user($l2['login'], $l2['password']);
?>

<?php
    $who = $l2['name'];
    $error1 = save_book($d1['name'], $d1['author'], $d1['best'], $d1['type'], $d1['publisher'], $d1['description'], 3, $d1['price'], $d1['tags'], $l2['status']);
    $error2 = save_book($d2['name'], $d2['author'], $d2['best'], $d2['type'], $d2['publisher'], $d2['description'], 3, $d2['price'], $d2['tags'], $l2['status']);
    $error3 = save_book($d3['name'], $d3['author'], $d3['best'], $d3['type'], $d3['publisher'], $d3['description'], 3, $d3['price'], $d3['tags'], $l2['status']);
    
    $error4 = create_user($s['login'], $s['password'], $s['name'], $s['address'], $s['phone'], $s['status'], true);
    $error5 = create_user($p1['login'], $p1['password'], $p1['name'], $p1['address'], $p1['phone'], $p1['status'], true);
    $error6 = create_user($p2['login'], $p2['password'], $p2['name'], $p2['address'], $p2['phone'], $p2['status'], true);
    $error7 = create_user($p3['login'], $p3['password'], $p3['name'], $p3['address'], $p3['phone'], $p3['status'], true);
    $error8 = create_user($v['login'], $v['password'], $v['name'], $v['address'], $v['phone'], $v['status'], true);
    
    $condition1 = mysql_num_rows(mysql_query("SELECT * FROM `files` WHERE name = '".$d1['name']."' AND copies = 3"));
    $condition2 = mysql_num_rows(mysql_query("SELECT * FROM `files` WHERE name = '".$d2['name']."' AND copies = 3"));
    $condition3 = mysql_num_rows(mysql_query("SELECT * FROM `files` WHERE name = '".$d3['name']."' AND copies = 3"));
    
    $condition4 = mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE name = '".$s['name']."'"));
    $condition5 = mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE name = '".$p1['name']."'"));
    $condition6 = mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE name = '".$p2['name']."'"));
    $condition7 = mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE name = '".$p3['name']."'"));
    $condition8 = mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE name = '".$v['name']."'"));
    
    if ($error1 == "success" and $error2 == "success" and $error3 == "success"  and $error4 == "success"  and 
        $error5 == "success"  and $error6 == "success"  and $error7 == "success"  and $error8 == "success") {
         echo '<script>
                alert("d1, d2 and d3 has been successfully added! s, p1, p2, p3 and v has been successfully created!");
              </script>';
    }
    
    if ($condition1 == 1 and $condition2 == 1 and $condition3 == 1 and $condition4 == 1 and $condition5 == 1 and $condition6 == 1 and $condition7 == 1 and $condition8 == 1)
        echo "<script> alert('Test4 has been successfully completed!'); window.location.replace(\"test.php\");</script>";
    else
        echo "<script> alert('Test4 has been failed!'); window.location.replace(\"test.php\");</script>";
        
?>