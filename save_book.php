<?php // saving a book
    $who = mysql_fetch_array(mysql_query("SELECT name FROM users WHERE login = '".$_COOKIE['userName']."'"))[0];

    if(isset($_POST['button'])){
        $name = $_POST['name']; $author = $_POST['author']; $best = $_POST['best']; $type = $_POST['type']; // taking data of a book from the database
        $publisher = $_POST['publisher']; $description = $_POST['description']; $copies = $_POST['copies']; $price = $_POST['price'];
        $output = save_book($name, $author, $best, $type, $publisher, $description, $copies, $price, "", $_COOKIE['status']);
        if ($output == "fill-completely")
            echo "<script> alert('Fill the form completely!'); window.location.replace(\"search_books.html\");</script>"; // writing a message to fill the form completely if some fields are empty
        else if ($output == "no-access")
            echo "<script> alert('You are not allowed to do it!'); window.location.replace(\"search_books.html\");</script>";
        else if ($output == "success")
            echo "<script> alert('You added a book!'); window.location.replace(\"search_books.html\");</script>";
        
    }
    function save_book($name, $author, $best, $type, $publisher, $description, $copies, $price, $tags, $status){
        //echo "<script> alert('".$status."');</script>";
        if (empty($name) or empty($author) or empty($best) or empty($type) or empty($publisher) 
             or empty($description) or empty($copies) or empty($price))
                return "fill-completely";
        else if(!($status == 'Librarian-2' or $status == 'Librarian-3' or $status == 'Admin')) 
            return "no-access";
        else {
            include ("bd.php"); // making a connection with the database
            // saving book to the database
            mysql_query ("INSERT INTO files (name, author, best, type, publisher, description, copies, price, tags) VALUES('$name','$author','$best','$type','$publisher','$description','$copies', '$price', '$tags')");
            global $who;
            mysql_query ("INSERT INTO log (name, action, target, time) VALUES('$who',' added book ','$name','".time()."')"); // writing about saving a book to the log table
            return "success";
        }
    }
?>