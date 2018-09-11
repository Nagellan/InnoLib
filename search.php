<?php // search 
    include "bd.php"; // making a connection with the database
    if (!empty($_POST['query'])){ 
        $result = search($_POST['query']); // using a function of a search
        echo '<div class="inside1" style="padding: 20px; overflow: auto;">';
        
        if (!empty($_POST['query']))
            if (strlen($_POST['query']) < 3)
                echo 'Too short'; // writing a message about too short request
            else if (strlen($_POST['query']) > 128)
                echo 'Too long'; // writing a message about too big request
            else {
               
                if (mysql_affected_rows() > 0) {
                    echo '<table class="table">';
                    while($row = mysql_fetch_array($result)){ // making a table with results
                        echo '<tr style="font-weight: 400; ">
                                 <td style="padding: 10px;"><form action="save_book_cookie.php" method="post"><input type="submit" name="name" value="'.$row['name'].'"></form></td>
                                 <td>'.$row['author'].'</td>
                                 <td>'.$row['publisher'].'</td>
                                 <td>'.$row['copies'].' copies</td>
                              </tr>'; 
                    }
                    echo '</table>';
                } else         // writing a message that nothing is found otherwise
                    echo 'Nothing found';
                $who = mysql_fetch_array(mysql_query("SELECT name FROM users WHERE login = '".$_COOKIE['userName']."'"))[0];
                // writing about searching to the log table
                if ($who != "")    // if user is logged in
                    mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$who',' searched \"','$query\"','".time()."')");
            }
        else
            echo 'Empty request'; // writing a message about empty request
        echo '</div>';
    
        
    }    

    function search ($query) // function of a search
    { 
        $query = trim($query); 
        $query = mysql_real_escape_string($query);
        $query = htmlspecialchars($query);
        
         mysql_query("ALTER TABLE files ADD FULLTEXT(name, author, publisher, tags)");
        $result =  mysql_query("SELECT *  FROM `files` WHERE MATCH (name, author, publisher, tags) AGAINST ('$query')"); // taking data from the database
        return $result;
    
        
    }
?>