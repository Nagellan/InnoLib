<?php
    include("../bd.php");
    mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies) VALUES('Introduction to Algorithms, Third edition','Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest and Clifford Stein','No','Book','MIT Press, 2009','...','3')");
    mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies) VALUES('Design Patterns: Elements of Reusable Object-Oriented Software, First edition','Erich Gamma, Ralph Johnson, John Vlissides, Richard Helm','Yes','Book','Addison-Wesley Professional
, 2003','...','2')");
    mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies) VALUES('The Mythical Man-month, Second edition','Brooks,Jr., Frederick P','No','Book','Addison-Wesley Longman Publishing Co., Inc., 1995','...','1')");
    mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies) VALUES('Null References: The Billion Dollar Mistake','Tony Hoare','No','AV-file','...','...','1')");
    mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies) VALUES('Information Entropy','Claude Shannon','No','AV-file','...','...','1')");
    mysql_query ("INSERT INTO users (id, login, password, name, address, phone, status) VALUES('1010', 'p1@p1.p1', 'password', 'Sergey Afonso', 'Via Margutta, 3', '30001', 'Faculty')");
    mysql_query ("INSERT INTO users (id, login, password, name, address, phone, status) VALUES('1011', 'p2@p2.p2', 'password', 'Nadia Teixeira', 'Via Sacra, 13', '30002', 'Student')");
    mysql_query ("INSERT INTO users (id, login, password, name, address, phone, status) VALUES('1100', 'p3@p3.p3', 'password', 'Elvira Espindola', 'Via del Corso, 22', '30003', 'Student')");
    echo "<script> alert('Test1 succesfully completed!'); window.location.replace(\"../index.html\");</script>";
?>