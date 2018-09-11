<?php // showing all users to a librerian
    if ($_COOKIE["status"] != NULL && ($_COOKIE["status"] == 'Librarian-1' || $_COOKIE["status"] == 'Librarian-2' || $_COOKIE["status"] == 'Librarian-3' || $_COOKIE["status"] == 'Admin')){

        include ("bd.php"); // making a connection with the database
        if ($_COOKIE['status'] != 'Librarian-1'){
            echo '
                   <div class="container" id = "intro-dm-add-user">
                       <h2>Add user</h2>
                       <div class="inside">
                           <form action="save_user.php" method="post">
                                <table class="users">
                                    <tr class="add-user">
                                       <td><input type="text" name="name" class="field" placeholder="Name"></td>
                                       <td><input type="email" name="login" class="field" placeholder="Email"></td>
                                       <td>
                                           <div class="status"><select name="status" required>
                                              <option selected value="Student">Student</option>
                                              <option value="Professor">Professor</option>
                                              <option value="Teaching Assistant">Teaching Assistant</option>
                                              <option value="Instructor">Instructor</option>
                                              <option value="Visiting Professor">Visiting Professor</option>';
                                              if($_COOKIE['status'] == Admin)
                                                  echo'
                                                  <option value="Librarian-1">Librarian-1</option>
                                                  <option value="Librarian-2">Librarian-2</option>
                                                  <option value="Librarian-3">Librarian-3</option>';
                                            echo '      

                                           </select></div>
                                       </td>
                                       <td><input type="text" name="address" class="field" placeholder="Address"></td>
                                       <td><input type="tel" name="phone" clas+
                                       s="field" placeholder="Phone number"></td>
                                    </tr>
                                </table>
                                <button type="submit" class="button" name = "button" value="add-user">Register</button>
                            </form>
                        </div>
                    </div>
                
            ';
        }
         $result = mysql_query('SELECT * FROM `users`'); // request for a sample
        echo '
        
       
        <table class="users" id="intro-dm">
                <tr>
                   <td>Id</td>
                   <td>Name</td>
                   <td>Email</td>
                   <td>Status</td>
                   <td>Address</td>
                   <td>Phone</td>
                </tr>';
        $count = 0;
        while($row = mysql_fetch_array($result)){
            if((( $row['status'] != 'Librarian-1' && $row['status'] != 'Librarian-2'  && $row['status'] != 'Librarian-3') || $_COOKIE['status'] == 'Admin') && $row['status'] != 'Admin'){
                $select1 = ''; $select2 = ''; $select3 = ''; $select4 = ''; $select5 = ''; $select6 = ''; $select7 = ''; $select8 = ''; $select9 = '';
                if ($row['status'] == "Librarian-1"){
                    $select1 = "selected";                
                } else if ($row['status'] == "Teaching Assistant"){
                    $select2 = "selected";
                } else if ($row['status'] == "Student") {
                    $select3 = "selected";
                } else if ($row['status'] == "Instructor") {
                    $select4 = "selected";
                } else if ($row['status'] == "Professor") {
                    $select5 = "selected";
                } else if ($row['status'] == "Visiting Professor"){
                    $select6 = "selected";
                    
                }else if   ($row['status'] == "Librarian-2"){
                    $select7 = "selected";
                }else if   ($row['status'] == "Librarian-3"){
                    $select8 = "selected";
                }else if   ($row['status'] == "Admin")
                    $select9 = "selected";
                    

                
                $count = $count + 1;
            
                    echo '  <tr>
                                <td>
                                    <div class="link">
                                        <div class="left-buttons buttons">
                                            <button form="">
                                                <img width="20px" height="20px" src="/img/book_list.png">
                                            </button>
                                        </div>';
                                        $list_of_books = mysql_query("SELECT * FROM `files-users` WHERE user_id='".$row['id']."'"); 
                                        $count1 = 0;
                                        if (mysql_num_rows($list_of_books) > 0){
                    echo '              <div class="list-books">
                                            <table>';
                                                while($row_books = mysql_fetch_array($list_of_books)){
                                                    $count1 = $count1 + 1;
                                                    $book_name = mysql_query("SELECT * FROM `files` WHERE id='".$row_books['book_id']."'"); // taking data from the database
                                                    $row_name = mysql_fetch_array($book_name); 
                                                    
                                                    // counting available time
                                                    if($row['status'] == 'Professor' or $row['status'] == 'Teaching Assistant' or $row['status'] == 'Instructor'){
                                                        $time_available = 28;
                                                    }
                                                    else if($row['status'] == 'Visiting Professor'){
                                                        $time_available = 7;
                                                    }
                                                    else if($row_name['type'] == 'AV-file' or $row_name['type'] == 'Article'){
                                                        $time_available = 14;
                                                    }
                                                    else if($row_name['best'] == 'Yes'){
                                                        $time_available = 14;
                                                    }
                                                    else{
                                                        $time_available = 21;
                                                    }    
                                                    
                                                    // counting left time
                                                    $time_left = ceil($time_available - (time() - $row_books['check_out_date']) / 86400);
                                                    echo '<tr><td hidden><input type = "hidden" name = "id'.$count1.'" value = "'.$row_books['id'].'"></td>
                                                          <td style="padding: 10px;">'.$row_name['name'].'</td></tr>';
                                                        if ($time_left < 0){ 
                                                            $fine = -100 * $time_left;
                                                            if ($fine > $row_name['price']){
                                                                $fine = $row_name['price'];
                                                            }
                                                        echo'
                                                            <tr><td><span>Overdue: '.$fine.' ₽ 
                                                            </span></td></tr>';
                                                        }    
                                                        else echo'<tr><td><span> Days left: '.$time_left.'</span></td></tr>';
                                                }
                    echo '                  </table>
                                        </div>
                                    </div>';
            }
                            echo '<input size="5" class="inactive" readonly type="text" name = "id'.$count.'" value = "'.$row['id'].'"></td>
                            <td><input type="text" name = "name'.$count.'" value="'.$row['name'].'"></td>
                            <td><input type="email" name = "email'.$count.'" value="'.$row['login'].'"></td>
                            <td>
                                <select name="status'.$count.'">';
                                if($_COOKIE['status'] == Admin)
                                                  echo'
                                                  
                                    <option '.$select1.' value="Librarian-1">Librarian-1</option>
                                    <option '.$select8.' value="Librarian-3">Librarian-3</option>
                                    <option '.$select7.' value="Librarian-2">Librarian-2</option>';
                                    echo '
                                    <option '.$select6.' value="Visiting Professor">Visiting Professor</option>
                                    <option '.$select5.' value="Professor">Professor</option>
                                    <option '.$select4.' value="Instructor">Instructor</option>
                                    <option '.$select3.' value="Student">Student</option>
                                    <option '.$select2.' value="Teaching Assistant">Teaching Assistant</option>
                                    
                                </select>
                            </td>
                            <td><input type="text" name = "address'.$count.'" value="'.$row['address'].'"></td>
                            <td><input type="tel" name = "phone'.$count.'" value="'.$row['phone'].'">
                                <div class="right-buttons buttons">
                                    <button name="edit" value = "'.$count.'"><img width="20px" height="20px" src="/img/save.png"></button>';
                                    if($_COOKIE['status'] != 'Librarian-1' && $_COOKIE['status'] != 'Librarian-2')
                                        echo '
                                        <button name="delete" value = "'.$count.'"><img width="20px" height="20px" src="/img/delete.png"></button>
                                </div>
                            </td>';// output the data
            }
        }
        echo '</tr></table>
         
        ';
    } else {
        // saying that the person don't have an access to this page if it's not a librerian
        echo "<script> alert('You have no access to this page! Go away!');window.location.replace(\"index.html\");</script>"; 
    }
?>