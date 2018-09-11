<?php // showing information about book from the database
    include ("bd.php"); // making a connection with the database
    $book = $_COOKIE["bookName"];
    $row = mysql_fetch_array(mysql_query("SELECT * FROM `files` WHERE name='$book'")); // taking information about book from the database and making a table with it
        echo   '<div id="intro"> 
                    <h1>'.$row['name'].'</h1>
                    <hr>
                    <table>
                        <tr><td>Description:</td></tr>
                        <tr><td>'.$row['description'].'</td></tr>
                        
                        <tr><td>Author:</td></tr>
                        <tr><td>'.$row['author'].'</td></tr>
    
                        <tr><td>Publisher:</td></tr>
                        <tr><td>'.$row['publisher'].'</td></tr>
    
                        <tr><td>Type:</td></tr>
                        <tr><td>'.$row['type'].'</td></tr>
    
                        <tr><td>Bestseller:</td></tr>
                        <tr><td>'.$row['best'].'</td></tr>
    
                        <tr><td>Copies:</td></tr>
                        <tr><td>'.$row['copies'].'</td></tr>
                    </table>
                </div>
            <div id="intro-dm-img">      
                <img src = "'.$row['img_link'].'"  width="100%">
            </div>';           
?>