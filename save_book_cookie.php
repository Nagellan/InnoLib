<?php // saving book cookie
    if (isset($_POST['name'])){
        set_cookie($_POST['name']);
        header('Location: book.html');
    }
    
    function set_cookie($name){ // function of setting cookie
        setcookie('bookName', $name);
    }
?>