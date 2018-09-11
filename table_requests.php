<?php // showing requests on files to a librerian
    if ($_COOKIE["status"] != NULL and ($_COOKIE["status"] == "Librarian-1" or $_COOKIE["status"] == "Librarian-2" or $_COOKIE["status"] == "Librarian-3" or $_COOKIE["status"] == "Admin")){
        include ("bd.php"); // making a connection with the database
        
          // queue list
          
        $result = mysql_query('SELECT * FROM `queue`'); // request for a sample
        echo'<table class="users" id="intro-dm-queue">
            <tr>
                <td hidden>Id</td>
                <td>UserName</td>
                <td>Email</td>
                <td>Status</td>
                <td hidden>BookId</td>
                <td>BookName</td>
            </tr>';

          $st_array = []; $in_array = []; $ta_array = []; $vp_array = []; $pr_array = []; $lib_array = []; $ad_array = [];

          while($row = mysql_fetch_array($result))
               if ($row['status'] == "Student")
                    $st_array[] = $row;
               else if ($row['status'] == "Instructor")
                    $in_array[] = $row;
               else if ($row['status'] == "Teaching Assistant")
                    $ta_array[] = $row;
               else if ($row['status'] == "Visiting Professor")
                    $vp_array[] = $row;
               else if ($row['status'] == "Professor")
                    $pr_array[] = $row;
               else if ($row['status'] == "Librarian-1" or $row['status'] == "Librarian-2" or $row['status'] == "Librarian-3")
                   $lib_array[] = $row;
               else if ($row['status'] == "Admin")
                   $ad_array[] = $row;

          $everyone = [$st_array, $in_array, $ta_array, $vp_array, $pr_array, $lib_array, $ad_array];

          $count = 0;
          foreach ($everyone as $key => $value) {
               $status = $value;
               foreach ($status as $key2 => $row) {
                    $count = $count + 1;
                    $result = mysql_query("SELECT copies FROM `files` WHERE id = '".$row['book_id']."'");
                    $copies = mysql_fetch_array($result);
                    if ($copies['copies'] > 0){
                        mysql_query("UPDATE `files` SET copies = '".$copies['copies']."' - 1 WHERE id = '".$row['book_id']."'"); // taking data from the database
                        mysql_query("INSERT INTO `requests` (user_id, book_id, user_name, email, status, book_name) 
                            VALUES ('".$row['user_id']."', '".$row['book_id']."', '".$row['user_name']."',
                                '".$row['email']."','".$row['status']."', '".$row['book_name']."')"); 
                        mysql_query("DELETE FROM `queue` WHERE id = '".$row['id']."'");        
                    } else
                    echo '<tr>
                         <td hidden><input size="5" class="inactive" readonly type="text" name = "id'.$count.'" value = "'.$row['id'].'"></td>
                         <td hidden><input size="5" class="inactive" readonly type="text" name = "user_id'.$count.'" value = "'.$row['user_id'].'"></td>
                         <td style="padding: 10px 0;">'.$row['user_name'].'</td>
                         <td>'.$row['email'].'</td>
                         <td>'.$row['status'].'</td>
                         <td hidden><input size="5" class="inactive" readonly type="text" name = "book_id'.$count.'" value = "'.$row['book_id'].'"></td>
                         <td>'.$row['book_name'].'
                             <div class="right-buttons buttons">
                                 <button class="reject" name="reject_queue" value = "'.$count.'"><img width="20px" height="20px" src="/img/reject.png"></button>
                             </div>
                         </td>';
               }
               unset($row);
          }
          echo '</tr></table>';
        
        // requests list
        
        $result = mysql_query('SELECT * FROM `requests`'); // request for a sample
        echo '<table class="users" id="intro-dm-requests">
                <tr>
                   <td hidden>Id</td>
                   <td hidden>UserId</td>
                   <td>UserName</td>
                   <td>Email</td>
                   <td>Status</td>
                   <td hidden>BookId</td>
                   <td>BookName</td>
                </tr>';
        $count = 0;
        while($row = mysql_fetch_array($result))
        {
            $count = $count + 1;
            echo   '<tr>
                    <td hidden><input size="5" class="inactive" readonly type="text" name = "id'.$count.'" value = "'.$row['id'].'"></td>
                    <td hidden><input size="5" class="inactive" readonly type="text" name = "user_id'.$count.'" value = "'.$row['user_id'].'"></td>
                    <td style="padding: 10px 0;">'.$row['user_name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['status'].'</td>
                    <td hidden><input size="5" class="inactive" readonly type="text" name = "book_id'.$count.'" value = "'.$row['book_id'].'"></td>
                    <td>'.$row['book_name'].'
                        <div class="right-buttons buttons">
                            <button class="accept" name="accept" value = "'.$count.'"><img width="20px" height="20px" src="/img/accept.png"></button>
                            <button class="reject" name="reject" value = "'.$count.'"><img width="20px" height="20px" src="/img/reject.png"></button>
                        </div>
                    </td>';
        }
        echo '</tr></table>';
        
                  // return list
        $result = mysql_query('SELECT * FROM `returns`'); // request for a sample
        echo '<table class="users" id="intro-dm-returns">
                <tr>
                   <td hidden>Id</td>
                   <td hidden>UserId</td>
                   <td>UserName</td>
                   <td>Email</td>
                   <td>Status</td>
                   <td hidden>BookId</td>
                   <td>BookName</td>
                   <td>Fine</td>
                   <td>Overdue</td>
                </tr>';
        $count = 0;
        while($row = mysql_fetch_array($result))
        {
            $count = $count + 1;
            echo   '<tr>
                    <td hidden><input size="5" class="inactive" readonly type="text" name = "id'.$count.'" value = "'.$row['id'].'"></td>
                    <td hidden><input size="5" class="inactive" readonly type="text" name = "user_id'.$count.'" value = "'.$row['user_id'].'"></td>
                    <td style="padding: 10px 0;">'.$row['user_name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['status'].'</td>
                    <td hidden><input size="5" class="inactive" readonly type="text" name = "book_id'.$count.'" value = "'.$row['book_id'].'"></td>
                    <td>'.$row['book_name'].'</td>
                    <td>'.$row['fine']. '</td>
                    <td>'.$row['overdue'].'
                        <div class="right-buttons buttons">
                            <button class="accept" name="accept_return" value = "'.$count.'"><img width="20px" height="20px" src="/img/accept.png"></button>
                            
                        </div>
                    </td>';
        }
        echo '</tr></table>';
        
        
        // log
        if ($_COOKIE['status'] == "Admin"){
            $result = mysql_query('SELECT * FROM `log` ORDER BY id DESC'); // request for a sample
            echo '<div id="intro-dm-log" class="container">
                       <div id="log-anchor" class="anchor"></div>
                       <h2>Log</h2>
                           <div class="inside"><table class="users">';
            $i = 0;
            while($row = mysql_fetch_array($result) and !($i >= 30))
            {
                $i = $i + 1;
                $time = date('D, d M o, H:i:s', $row['time']);
                echo   '<tr><td><span>'.$row['name'].'</span>'.$row['action'].'<span>'.$row['target'].'</span>'.$row['action2'].'<span>'.$row['target2'].'</span> at <span>'.$time.'</span></td></tr>';
            }
            echo '</table></div></div>';
        }

    } else {
        // saying that the person don't have an access to this page if it's not a librerian
        echo "<script> alert('You have no access to this page! Go away!');window.location.replace(\"index.html\");</script>"; 
    }
?>