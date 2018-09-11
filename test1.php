<?php
    include("bd.php");
    include("variables.php");
    include("login_user.php");
    include("save_user.php");
    
    login_user($admin['login'], $admin['password']);
    
    $error = create_user($admin1['login'], $admin1['password'], $admin1['name'], $admin1['address'], $admin1['phone'], "Admin", true);
    
    $condition = mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE status = 'Admin'"));
    if ($error == "admin-exists") {
         echo '<script>
                alert("Library cannot have more than 1 admin!");
              </script>';
    }
    
    if ($condition == 1)
        echo "<script> alert('Test1 has been successfully completed!'); window.location.replace(\"test.php\");</script>";
    else
        echo "<script> alert('Test1 has been failed!'); window.location.replace(\"test.php\");</script>";
    
?>