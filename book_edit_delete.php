<?php // deleting or editting a file 
    include("bd.php"); // making a connection with the database
    $who = mysql_fetch_array(mysql_query("SELECT name FROM users WHERE login = '".$_COOKIE['userName']."'"))[0]; // taking data of a user from the database
    
    if (isset($_POST['delete'])) { // deleting a file
        $index = $_POST['delete'];
        $id = $_POST["id".$index];
        delete($id);
        echo "<script>alert('File has been removed'); window.location.replace(\"search_books.html\");</script>"; // writing a message about successful deliting
    }
    else if (isset($_POST['edit'])) { // editting a file
        $index = $_POST['edit'];
        $id = $_POST["id".$index];
        edit($id, $_POST["name".$index], $_POST["author".$index], $_POST["publisher".$index], $_POST["best".$index], $_POST["type".$index], $_POST["description".$index], $_POST["img_link".$index], $_POST["price".$index], $_POST["copies".$index], '');
        echo "<script>alert('The file information has been edited');window.location.replace(\"search_books.html\");</script>"; // writing a message about successful editing
    }
    else if (isset($_POST['clear'])) { // if nothing has been changed
        $index = $_POST['clear'];
        $id = $_POST["id".$index];
        set_request($id, time(), $_COOKIE['status']);
        echo "<script> window.location.replace(\"search_books.html\");</script>";
    }
    
    function edit($id, $name, $author, $publisher, $best, $type, $description, $img_link, $price, $copies, $tags){
        global $who;
        mysql_query("UPDATE `files` SET name = '$name', author = '$author', publisher = '$publisher', best = '$best', type = '$type', description = '$description', img_link = '$img_link', price = '$price', copies = '$copies', tags = '$tags'  WHERE `id` = '$id'");
        mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$who',' edited the $type ','$name','".time()."')"); 
    }
    
    function delete($id){
        global $who;
        mysql_query("DELETE FROM `files` WHERE `id` = '$id'"); // deleting a file from the database
        mysql_query ("INSERT INTO log (name, action, target, time) VALUES ('$who',' deleted the book ','".$_POST["name".$index]."','".time()."')"); // writing about deletion to the log table
    }

    function set_request($id, $cur_time, $status){ // making a request on a book
        if($status == "Librarian-2" || $status == "Librarian-3" || $status == "Admin"){
            global $who;
            $book_name = mysql_fetch_array(mysql_query("SELECT name FROM `files` WHERE id = '$id'"))[0];
            $is_requested = mysql_fetch_array(mysql_query("SELECT out_req FROM files WHERE id = '$id'"))[0];
            if($is_requested == 1){
                mysql_query("UPDATE `files` SET `out_req` = 0 WHERE `id` = '$id'");
                // writing about removing a request to the log table
                mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$who',' removed an outstanding request for ','$book_name','".time()."')");
                // writing a message about successful removing a book from a request
                echo "<script>alert('You have removed an outstanding request for this book.'); window.location.replace(\"search_books.html\");</script>";  
            }
            else{
                mysql_query("UPDATE `files` SET `out_req` = 1 WHERE `id` = '$id'");
                include("send_email.php");
                $title = 'InnoLib Important!';
                
                $body = '<h1>Attention!</h1><p>The book <b>'.$book_name.'</b> has been set to an Outstanding request!</p><p>That is why you have been removed from a queue on this book.</p><p>Sorry for all disturbances.</p>';
                $users_in_queue = mysql_query("SELECT * FROM `queue` WHERE book_id = '$id'");
                while ($row = mysql_fetch_array($users_in_queue))
                    send_email($row['email'], $title, $body);
                mysql_query("DELETE FROM `queue` WHERE book_id = '$id'");
                
                $body = '<h1>Attention!</h1><p>The book <b>'.$book_name.'</b> has been set to an Outstanding request!</p><p>That is why you have been removed from a requests list on this book.</p><p>Sorry for all disturbances.</p>';
                $users_in_requests = mysql_query("SELECT * FROM `requests` WHERE book_id = '$id'");
                while ($row = mysql_fetch_array($users_in_requests))
                    send_email($row['email'], $title, $body);
                $copies = mysql_fetch_array(mysql_query("SELECT copies FROM `files` WHERE id = '$id'"))[0];
                $copies_updated = $copies + mysql_num_rows($users_in_requests);
                mysql_query("UPDATE `files` SET copies = '$copies_updated' WHERE id = '$id'"); // taking data from the database
                mysql_query("DELETE FROM `requests` WHERE book_id = '$id'");
                
                $body = '<h1>Attention!</h1><p>The book <b>'.$book_name.'</b> has been set to an Outstanding request!</p><p>Please, return the book as fast as possible, otherwise you can be fined. You can do it <a href="http://y98722gq.beget.tech/profile.html">here</a>.</p><p>Sorry for all disturbances.</p>';
                $users_with_book = mysql_query("SELECT * FROM `files-users` WHERE book_id = '$id'");
                while ($row = mysql_fetch_array($users_with_book)){
                    $user_id = $row['user_id'];
                    $login = mysql_fetch_array(mysql_query("SELECT login FROM `users` WHERE id = '$user_id'"))[0];
                    send_email($login, $title, $body);
                }
                mysql_query("UPDATE `files-users` SET `due_date` = '$cur_time' WHERE book_id = '$id'");
                
                // writing about making a request to the log table
                mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$who',' created an outstanding request for ','$book_name','".time()."')");
                // writing a message about successful making of a request
                echo "<script>alert('You have created an outstanding request for this book.');</script>"; 
            }
        }
        else echo "<script>alert('You cannot put an outstanding request.');</script>";
            
    }
?>