<?php // showing a list of books
    include ("bd.php"); // making a connection with the database
   
    if ($_COOKIE["status"] != 'Librarian-1' && $_COOKIE["status"] != 'Librarian-2' && $_COOKIE["status"] != 'Librarian-3' && $_COOKIE["status"] != 'Admin'){
        
        $result = mysql_query('SELECT * FROM `files` WHERE type = "Book" '); // taking data of books from the database
        print_table_patron("intro-dm-books", $result); // printing a table of books
    
        $result = mysql_query('SELECT * FROM `files` WHERE type = "Article" '); // taking data of articles from the database
        print_table_patron("intro-dm-articles", $result); // printing a table of articled
        
        $result = mysql_query('SELECT * FROM `files` WHERE type = "AV-file" '); // taking data of AV-files from the database
        print_table_patron("intro-dm-avfiles", $result); // printing a table of AV-files
        
    } else {        //==================================================================
    if ($_COOKIE['status'] != 'Librarian-1')
        echo '
            <div class="container" id="intro-dm-add-book">
                <h2>Add book</h2>
                <div class="inside">
                    <form id="intro-dm-add-book" action="save_book.php" method="post">
                        <table class="books">
                            <tr class="add-book">
                                <td><input type="text" name="name" class="field" placeholder="Name"></td>
                                <td><input type="text" name="author" class="field" placeholder="Author"></td>
                                <td class="radio" colspan="2">Bestseller:<label><input type="radio" name="best" class="field" value="Yes">Yes</label><label><input checked type="radio" name="best" class="field" value="No">No</label></td>
                                <td>
                                    <select name="type" required size="1">
                                        <option>Book</option>
                                        <option>Article</option>
                                        <option>AV-file</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="add-book">
                                <td class="description"><textarea name="description" class="field" placeholder="Description"></textarea></td>
                                <td><input type="text" name="publisher" class="field" placeholder="Publisher"></td>
                                <td><input type="url" name="img" class="field" placeholder="Image URL"></td>
                                <td class="price"><input type="number" name="price" class="field" placeholder="Price"></td>
                                <td class="copies"><input type="number" name="copies" class="field" placeholder="Copies"></td>
                            </tr>
                        </table>
                        <button type="submit" class="button" name = "button" value="add-user">Add</button>
                    </form>
                </div>
            </div>';
        
        $result = mysql_query('SELECT * FROM `files` WHERE type = "Book" '); // taking data of books from the database
        print_table_librarian("intro-dm-books", $result); // printing a table of books
    
        $result = mysql_query('SELECT * FROM `files` WHERE type = "Article" '); // taking data of articles from the database
        print_table_librarian("intro-dm-articles", $result); // printing a table of articled
        
        $result = mysql_query('SELECT * FROM `files` WHERE type = "AV-file" '); // taking data of AV-files from the database
        print_table_librarian("intro-dm-avfiles", $result); // printing a table of AV-files
    }  
    
    function print_table_librarian($id, $result){ // function of printing a table for librarians
        echo '<table class="books" id="'.$id.'">
                <tr>
                   <td>Name</td>
                   <td>Author</td>
                   <td>Publisher</td>
                   <td>Best-<br>seller</td>
                   <td>Type</td>
                   <td>Description</td>
                   <td>Image URL</td>
                   <td>Price</td>
                   <td>Copies</td>
                </tr>';
        $count = 0;
        while($row = mysql_fetch_array($result))
        {
                $count = $count + 1;
                
                $check1 = ""; $check2 = "";
                if ($row['best'] == "Yes")
                    $check1 = "selected";
                else
                    $check2 = "selected";
                    
                $select1 = ""; $select2 = ""; $select3 = "";
                if ($row['type'] == "Book")
                    $select1 = "selected";
                else if ($row['type'] == "Article")
                    $select2 = "selected";
                else
                    $select3 = "selected";
            
                echo   '<tr class="edit-delete-books">
                            <td><div class="anchor" id="book'.$row['id'].'"></div><div class="left-buttons buttons"><form action="save_book_cookie.php" method="post"><button name="name" value="'.$row['name'].'"><img width="20px" height="20px" src="/img/link.png"></button></form></div>
                                <input type="hidden" name = "id'.$count.'" value = "'.$row['id'].'"><input type="text" name="name'.$count.'" class="field" value="'.$row['name'].'"></td>
                            <td><input type="text" name="author'.$count.'" class="field" value="'.$row['author'].'"></td>
                            <td><input type="text" name="publisher'.$count.'" class="field" value="'.$row['publisher'].'"></td>
                            <td class="type">
                                <select name="best'.$count.'">
                                    <option value="Yes" '.$check1.'>Yes</option>
                                    <option value="No" '.$check2.'>No</option>
                                </select>
                            </td>
                            <td class="type">
                                <select name="type'.$count.'" required size="1">
                                    <option '.$select1.' value = "Book">Book</option>
                                    <option '.$select2.' value = "Article">Article</option>
                                    <option '.$select3.' value = "AV-file">AV-file</option>
                                </select>
                            </td>
                            <td class="description"><textarea name="description'.$count.'" class="field">'.$row['description'].'</textarea></td>
                            <td><input type="url" name="img_link'.$count.'" class="field" value="'.$row['img_link'].'"></td>
                            <td><input type="number" name="price'.$count.'" class="field" value="'.$row['price'].'">
                            <td class="copies"><input type="number" name="copies'.$count.'" class="field" value="'.$row['copies'].'">
                                <div class="right-buttons buttons">
                                     <button name="edit" value = "'.$count.'"><img width="20px" height="20px" src="/img/save.png"></button>
                                     <button name="clear" value = "'.$count.'"><img width="20px" height="20px" src="/img/clear.png"></button>';
                                     if ($_COOKIE['status'] != 'Librarian-1' && $_COOKIE['status'] != 'Librarian-2')
                                        echo  '<button name="delete" value = "'.$count.'"><img width="20px" height="20px" src="/img/delete.png"></button>
                                 </div>
                            </td>
                        </tr>'; // output the data
        }
        echo '</table>';
    }
    function print_table_patron($id, $result){ // function of printing a table for patrons
        echo '<table id="'.$id.'">
                <tr>
                   <td>Name</td>
                   <td>Author</td>
                   <td>Publisher</td>
                   <td>SBestseller</td>
                   <td>Copies</td>
                </tr>';
        while($row = mysql_fetch_array($result)){
            echo '<tr>
                     <td><div class="anchor" id="book'.$row['id'].'"></div><form action="save_book_cookie.php" method="post"><input type="submit" name="name" value="'.$row['name'].'"></form></td>
                     <td>'.$row['author'].'</td>
                     <td>'.$row['publisher'].'</td>
                     <td>'.$row['best'].'</td>
                     <td>'.$row['copies'].'</td>
                  </tr>'; // output the data
        }
        echo '</table>';
    }
?>