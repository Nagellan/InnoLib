<?php // returning a book
    include("bd.php"); // making a connection with the database
    
    if (isset($_POST['return'])) { // returning a book
        $index = $_POST['return'];
        $id = $_POST["id".$index];
        return_book($id); // using a function of returning a book
        echo "<script>alert('Book has been returned.');window.location.replace(\"profile.html\");</script>"; // writing a message about successful returning a book
    }
    else if (isset($_POST['cancel'])) { // canceling a request
        $index = $_POST['cancel'];
        $id = $_POST["id".$index];
        cancel($id); // using a function of canceling a request
        echo "<script>alert('Your requests has been canceled');window.location.replace(\"profile.html\");</script>"; // writing a message about canceling a request
    }
    else if (isset($_POST['leave'])) { // leaving a queue
        $index = $_POST['leave'];
        $id = $_POST["id".$index];
        leave($id); // using a function of leaving the queue of requests
        echo "<script>alert('You have left the queue.');window.location.replace(\"profile.html\");</script>"; // writing a message about leaving the queue
    }
    else if (isset($_POST['renew'])) { // making a renew on a book 
        $index = $_POST['renew'];
        $id = $_POST["id".$index];
        renew($id, time());
    }
    
    function return_book($id){ // function of returning a book
        $files_users = mysql_fetch_array(mysql_query("SELECT * FROM `files-users` WHERE id = '$id'")); // taking data of a user files from the database
        $user_info = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE id = '".$files_users['user_id']."'")); // taking data of a user from the database
        $book_info = mysql_fetch_array(mysql_query("SELECT * FROM `files` WHERE id = '".$files_users['book_id']."'")); // // taking data of a book from the database
        
        $overdue = -1 * ceil(($files_users['due_date'] - time()) / 86400); // counting overdue
        if ($overdue < 0)
            $overdue = 0;
        
        $fine = 100 * $overdue; // counting a fine
        if ($fine > $book_info['price'])
            $fine = $book_info['price'];
            
        mysql_query("INSERT INTO `returns` (user_id, book_id, user_name, email, status, book_name, fine, overdue) 
                     VALUES ('".$user_info['id']."', '".$book_info['id']."', '".$user_info['name']."', '".$user_info['login']."', '".$user_info['status']."', '".$book_info['name']."', '$fine', '$overdue')");
        // deleting a book from the user files in the database
        mysql_query("DELETE FROM `files-users` WHERE id = '$id'");
        // writing about returning a book to the log table
        mysql_query ("INSERT INTO log (name, action, target, time) VALUES('".$user_info['name']."',' returned the book ','".$book_info['name']."','".time()."')");
    }
    
    function cancel($id){ // function of canceling a request
        $requests = mysql_fetch_array(mysql_query("SELECT * FROM `requests` WHERE id = '$id'"));
        $copies = mysql_fetch_array(mysql_query("SELECT `copies` FROM `files` WHERE id ='".$requests['book_id']."'"))[0];
        mysql_query("DELETE FROM `requests` WHERE id = '$id'"); // deleting a book from the requests
        mysql_query("UPDATE `files` SET copies = '$copies' + 1 WHERE id = '".$requests['book_id']."'"); // increasing amounnt of copies of a book
        // writing about canceling a request to the log table
        mysql_query ("INSERT INTO log (name, action, target, time) VALUES('".$requests['user_name']."',' canceled his request for the book ','".$requests['book_name']."','".time()."')");
    }
    
    function leave($id){ // function of leaving a queue
        $row = mysql_fetch_array(mysql_query("SELECT * FROM `queue` WHERE id ='$id'"));
        // writing about leaving a queue to the log table
        mysql_query ("INSERT INTO log (name, action, target, time) VALUES('".$row['user_name']."',' left the queue for the book ','".$row['book_name']."','".time()."')");
        // deleting a book from a queue of requests
        mysql_query("DELETE FROM `queue` WHERE id = '$id'");
    }
    
    function renew($id, $cur_time){ // function of renew on a book
        $row = mysql_fetch_array(mysql_query("SELECT * FROM `files-users` WHERE id ='$id'")); // taking data of a user files from the database
        
        if ($out == 0 && ($row['renewed'] == 0 || $status == 'Visiting Professor')){
            mysql_query("UPDATE `files-users` SET check_out_date = '$cur_time' WHERE id = '$id'");
            mysql_query("UPDATE `files-users` SET renewed = 1 WHERE id = '$id'");
            
            $file = mysql_fetch_array(mysql_query("SELECT * FROM `files` WHERE id = '".$row['book_id']."'"));
            $status = mysql_fetch_array(mysql_query("SELECT status FROM `users` WHERE id = '".$row['user_id']."'"))[0];
            
            $due_date = $cur_time; // counting a due date
            if($status == 'Professor' or $status == 'Teaching Assistant' or $status == 'Instructor') // due date for Professors, Teaching Assistants and Instructors
                $due_date = $due_date + 28*86400;
            else if($status == 'Visiting Professor') // due date for Visiting Professors
                $due_date = $due_date + 7*86400;
            else if($file['type'] == 'AV-file' or $file['type'] == 'Article') // due date on AV-files and articles
                $due_date = $due_date + 14*86400;
            else if($file['best'] == 'Yes') // due date on bestsellers
                $due_date = $due_date + 14*86400;
            else // due date otherwise
                $due_date = $due_date + 21*86400; 
            mysql_query("UPDATE `files-users` SET due_date = '$due_date' WHERE id = '$id'");
            $user_name = mysql_fetch_array(mysql_query("SELECT name FROM users WHERE id = '".$row['user_id']."'"))[0]; // taking data of a user from the database
            $book_name = mysql_fetch_array(mysql_query("SELECT name FROM files WHERE id = '".$row['book_id']."'"))[0]; // taking data of a book from the database
            mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$user_name',' renewed the book ','$book_name','".time()."')");
            echo "<script>alert('File has been renewed.');window.location.replace(\"profile.html\");</script>";
        }
        else 
            echo "<script>alert('It is not possible to renew this file.');window.location.replace(\"profile.html\");</script>"; // writing a message that it's not possible to renew a file
    }
?>