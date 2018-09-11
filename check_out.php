<?php // checking out a book if a user is logged in
    if (isset($_POST['button'])){
        $book = $_COOKIE["bookName"];
        $user = $_COOKIE["userName"];
        $output = check_out($user, $book);
        if ($output == "have-book")
            echo "<script> alert('You already have this book');  window.location.replace(\"search_books.html\");</script>";
        else if ($output == "request-book")
            echo "<script> alert('You have already requested for this book');  window.location.replace(\"search_books.html\");</script>";
        else if ($output == "success")
            echo "<script> alert('You have booked this book. Now please wait until librarian\'s acceptance.'); window.location.replace(\"search_books.html\");</script>";
        else if ($output == "out-req")
            echo "<script> alert('Not possible. An outstanding request for this book'); window.location.replace(\"search_books.html\");</script>";
        else if ($output == "queue")
            echo "<script> alert('You have been placed into a queue for this book. Be patient!'); window.location.replace(\"search_books.html\");</script>";
        else if ($output == "not-logged")
            echo "<script> alert('You are not logged in!'); window.location.replace(\"signUp.html\");</script>"; // saying that a user haven't been logged in
    }
    
    function check_out($user, $book){
        include ("bd.php"); // making a connection with the database
        $request_b = mysql_fetch_array(mysql_query("SELECT * FROM `files` WHERE name ='$book'"));
        $request_p = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE login ='$user'"));
        
        $n = mysql_num_rows(mysql_query("SELECT * FROM `files-users` WHERE user_id = '".$request_p['id']."' AND book_id = '".$request_b['id']."'"));
        $m = mysql_num_rows(mysql_query("SELECT * FROM `requests` WHERE user_id = '".$request_p['id']."' AND book_id = '".$request_b['id']."'"));
        $k = mysql_num_rows(mysql_query("SELECT * FROM `queue` WHERE user_id = '".$request_p['id']."' AND book_id = '".$request_b['id']."'"));
        
        if ($n > 0 || $k > 0 || $m > 0)
            if ($n > 0)
                return "have-book";
            else
                return "request-book";
        else if ($user != null)
            if ($request_b['copies'] > 0){
                mysql_query("INSERT INTO `requests` (user_id, book_id, user_name, email, status, book_name) 
                                VALUES ('".$request_p['id']."', '".$request_b['id']."', '".$request_p['name']."',
                                    '".$request_p['login']."','".$request_p['status']."', '".$request_b['name']."')"); 
                mysql_query("UPDATE `files` SET copies = '".$request_b['copies']."' - 1 WHERE name = '".$book."'");
                
                // writing about making a request to the log table
                mysql_query ("INSERT INTO log (name, action, target, time) VALUES ('".$request_p['name']."',' has booked the ".$request_b['type']." ','".$request_b['name']."','".time()."')");
                return "success";
            }
            else {
                if ($request_b['out_req'] == 1)
                    return "out-req";
                else    
                    mysql_query("INSERT INTO `queue` (user_id, book_id, user_name, email, status, book_name) 
                                VALUES ('".$request_p['id']."', '".$request_b['id']."', '".$request_p['name']."',
                                    '".$request_p['login']."','".$request_p['status']."', '".$request_b['name']."')");
                                    
                // writing about placing a book into the queue to the log table
                mysql_query ("INSERT INTO log (name, action, target, time) VALUES ('".$request_p['name']."',' has been placed to the queue for ".$request_b['type']." ','".$request_b['name']."','".time()."')");
                return "queue";
            }
        else
            return "not-logged";
    }
?>