<?php // allows a librarian to accept or decline a request on a book
    include("bd.php"); // making a connection with the database
    $who = mysql_fetch_array(mysql_query("SELECT name FROM users WHERE login = '".$_COOKIE['userName']."'"))[0]; // taking information about user from the database
    
    if (isset($_POST['reject'])){ // declining a request
        $index = $_POST['reject'];
        $id = $_POST["id".$index];
        $book_id = $_POST["book_id".$index];
        reject_request($id, $book_id); // using a function of rejecting a request
        echo "<script>alert('Request has been declined');window.location.replace(\"requests.html\");</script>"; // writing a message about successful declining a request
    }    
    else if (isset($_POST['accept'])){ // accepting a request
        $index = $_POST['accept'];
        $id = $_POST["id".$index];
        $user_id = $_POST["user_id".$index];
        $book_id = $_POST["book_id".$index];
        accept_request($id, time()); // using a function of accepting a request
        echo "<script>alert('Request has been accepted');window.location.replace(\"requests.html\");</script>"; // writing a message about successful accepting a request
    }
    else if (isset($_POST['accept_return'])){ // accepting of a returning a book
        $index = $_POST['accept_return'];
        $id = $_POST["id".$index];
        $book_id = $_POST["book_id".$index];
        accept_return($id, $book_id); // using a function of accepting a return
        echo "<script>window.location.replace(\"requests.html\");</script>"; 
    }
    else if (isset($_POST['reject_queue'])){ // rejecting a request from a queue
        $index = $_POST['reject_queue'];
        $id = $_POST["id".$index];
        reject_queue($id); // using a function of rejecting a request from a queue
        echo "<script>window.location.replace(\"requests.html\");</script>";
    }
    
    function reject_request($id, $book_id){ // function of a declining a request
        $copies = mysql_fetch_array(mysql_query("SELECT `copies` FROM `files` WHERE id ='$book_id'"))[0];
        mysql_query("UPDATE `files` SET copies = '$copies' + 1 WHERE id = '$book_id'"); 
        $row = mysql_fetch_array(mysql_query("SELECT * FROM `requests` WHERE id = '$id'"));
        mysql_query("DELETE FROM `requests` WHERE `id` = '$id'"); // deleting a book from requests in the database
        global $who;
        // writing about declining a request to the log table
        mysql_query("INSERT INTO log (name, action, target, action2, target2, time) VALUES('$who',' rejected the request of ','".$row['user_name']."',' for checking out the book ','".$row['book_name']."','".time()."')");
    }
    
    function accept_request($id, $cur_time){ // function of accepting a request
        $row = mysql_fetch_array(mysql_query("SELECT * FROM `requests` WHERE id = '$id'"));
        
        $due_date = $cur_time; // counting a due date
        if ($row['status'] == 'Professor' or $row['status'] == 'Teaching Assistant' or $row['status'] == 'Instructor') // due date for Professors, Teaching Assistants and Instructors
            $due_date = $due_date + 28*86400;
        else if ($row['status'] == 'Visiting Professor') // due date for Visiting Professors
            $due_date = $due_date + 7*86400;
        else if ($row_name['type'] == 'AV-file' or $row_name['type'] == 'Article') // due date on AV-files and articles
            $due_date = $due_date + 14*86400;
        else if ($row_name['best'] == 'Yes') // due date on bestsellers
            $due_date = $due_date + 14*86400;
        else // due date otherwise
            $due_date = $due_date + 21*86400; 
        
        mysql_query("INSERT INTO `files-users` (user_id, book_id, check_out_date, due_date) VALUES ('".$row['user_id']."', '".$row['book_id']."', '$cur_time', '$due_date')");
        mysql_query("DELETE FROM `requests` WHERE `id` = '$id'");
        global $who;
        // writing about accepting a request to the log table
        mysql_query("INSERT INTO log (name, action, target, action2, target2, time) VALUES('$who',' accepted the request of ','".$row['user_name']."',' for checking out the book ','".$row['book_name']."','".time()."')");
    }
    
    function accept_return($id, $book_id){ // function of accepting of a returning a book
        $copies = mysql_fetch_array(mysql_query("SELECT `copies` FROM `files` WHERE id ='$book_id'"))[0];
        mysql_query("UPDATE `files` SET copies = '$copies' + 1 WHERE id = '$book_id'"); // increasing amount of copies of a book in the database
        $row = mysql_fetch_array(mysql_query("SELECT * FROM `returns` WHERE id = '$id'"));
        mysql_query("DELETE FROM `returns` WHERE `id` = '$id'");
        global $who;
        // writing about accepting a returning of a book to the log table
        mysql_query("INSERT INTO log (name, action, target, action2, target2, time) VALUES('$who',' accepted the return for ','".$row['user_name']."',' of the book ','".$row['book_name']."','".time()."')");
    }
    
    function reject_queue($id){ // function of rejecting a request from a queue 
        $row = mysql_fetch_array(mysql_query("SELECT * FROM `queue` WHERE id = '$id'"));
        mysql_query("DELETE FROM `queue` WHERE `id` = '$id'");
        global $who;
        // writing about rejecting a requst from a queue to the log table
        mysql_query("INSERT INTO log (name, action, target, action2, target2, time) VALUES('$who',' rejected the queue of ','".$row['user_name']."',' for the book ','".$row['book_name']."','".time()."')");
    }
?>