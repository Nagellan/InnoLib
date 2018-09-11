<?php
    include("../bd.php");
    mysql_query ("UPDATE files SET copies = '1' WHERE name = 'Introduction to Algorithms, Third edition'");
    mysql_query ("UPDATE files SET copies = '0' WHERE name = 'The Mythical Man-month, Second edition'");
    mysql_query ("DELETE FROM users WHERE name = 'Nadia Teixeira'");
    echo "<script> alert('Test2 succesfully completed!'); window.location.replace(\"../search_books.html\");</script>";
?>