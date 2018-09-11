<?php
    include("../../bd.php");
    include("variables.php");
    include("../../login_user.php");
    include("../../save_user.php");
    
    login_user($admin['login'], $admin['password']);
    
    $error1 = create_user($l1['login'], $l1['password'], $l1['name'], $l1['address'], $l1['phone'], $l1['status'], true);
    $error2 = create_user($l2['login'], $l2['password'], $l2['name'], $l2['address'], $l2['phone'], $l2['status'], true);
    $error3 = create_user($l3['login'], $l3['password'], $l3['name'], $l3['address'], $l3['phone'], $l3['status'], true);
    
    $condition1 = mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE status = 'Librarian-1'"));
    $condition2 = mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE status = 'Librarian-2'"));
    $condition3 = mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE status = 'Librarian-3'"));
    
    if ($error1 == "success" and $error2 == "success" and $error3 == "success") {
         echo '<script>
                alert("Librarian-1, Librarian-2 and Librarian-3 has been successfully created!");
              </script>';
    }
    
    if ($condition1 == 1 and $condition2 == 1 and $condition3 == 1)
        echo "<script> alert('Test2 has been successfully completed!'); window.location.replace(\"test.php\");</script>";
    else
        echo "<script> alert('Test2 has been failed!'); window.location.replace(\"test.php\");</script>";

?>