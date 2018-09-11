<?php // connects with the database and shows an information about user in a table
    if ($_COOKIE["userName"] != NULL){
        include ("bd.php"); // making a connection with the database
        $user = $_COOKIE["userName"];
        $user = stripslashes($user);
        $user = htmlspecialchars($user);
        $user = trim($user);
        $result = mysql_query("SELECT * FROM `users` WHERE login='".$user."'"); // request for a sample
        $row = mysql_fetch_array($result);
                  
            echo '<div id="intro-dm">
                       <h1>'.$row['name'].'</h1>
                       <hr>
                       <table>
                           <tr>
                                 <td>
                                      Status:
                                 </td>
                            </tr>
        
                            <tr>
                                 <td>'
                                      .$row['status'].
                                 '</td>
                            </tr>
                            
                            <tr>
                                 <td>
                                      Email:
                                 </td>
                            </tr>
        
                            <tr>
                                 <td>'
                                      .$row['login'].
                                 '</td>
                            </tr>
                       
                            <tr>
                                 <td>Address</td>
                            </tr>
        
                            <tr>
                                 <td>'
                                      .$row['address'].
                                 '</td>
                            </tr>
        
                            <tr>
                                 <td>
                                      Phone:
                                 </td>
                            </tr>
        
                            <tr>
                                 <td>'
                                      .$row['phone'].
                                 '</td>
                            </tr>
        
                       </table>
                       <form action="save_user.php" method="post">
                           <div class="change-password">
                               <div class="field"><input type="text" name="password" placeholder="Change password"></div>
                               <div class="btn"><button name="password-btn">save</button></div>
                           </div>
                       </form>
                   </div>';
                   
            echo '<div id="intro-dm-img">  
                     <form action="save_user.php" method="post">
                         <div class="image" style = "background-image: url('.$row['img_link'].');">
                             <div class="change-img">
                                 <div class="label">Change the picture</div>
                                 <div class="field"><input type="text" name="img-url" placeholder="URL"></div>
                                 <div class="btn"><button name="img-btn">save</button></div>
                             </div>
                         </div>
                     </form>
                  </div>';
                
            $list_of_books = mysql_query("SELECT * FROM `files-users` WHERE user_id='".$row['id']."'"); 
            
            echo '<table id = "intro-dm-books" >   ';
            $count = 0;
            while($row_books = mysql_fetch_array($list_of_books)){
                $count = $count + 1;
                $book_name = mysql_query("SELECT * FROM `files` WHERE id='".$row_books['book_id']."'"); // taking data from the database
                $row_name = mysql_fetch_array($book_name); 
                
                
                
                $time_left = round(($row_books['due_date'] - time()) / 86400);
                if ($time_left == -0)
                    $time_left = 0;
                echo '
                    <tr>
                        <td> '.$row_name['name'].'</td>
                        <td hidden><input type = "hidden" name = "id'.$count.'" value = "'.$row_books['id'].'"></td>
                        <td hidden><input type = "hidden" name = "renewed'.$count.'" value = "'.$row_books['renewed'].'"></td>
                        <td hidden><input type = "hidden" name = "user_id'.$count.'" value = "'.$row_books['user_id'].'"></td>
                        <td hidden><input type = "hidden" name = "book_id'.$count.'" value = "'.$row_books['book_id'].'"></td>
                        <td hidden><input type = "hidden" name = "check_out_date'.$count.'" value = "'.$row_books['check_out_date'].'"></td>
                    </tr>';
                    if($time_left < 0) {
                        $fine = -100 * $time_left;
                        if ($fine > $row_name['price']){
                            $fine = $row_name['price'];
                        }    
                        echo'<td><span> Overdue: '.$fine.' ₽';
                    }    
                    else echo '<td><span> Days left: '.$time_left.'</span><button style="margin-left: 10px;" class="button" name = "renew" value = "'.$count.'"> renew </button>';
                         echo '<button class="button" name = "return" value = "'.$count.'"> return </button>
                               </td></tr>';
            }
            
            $list_of_books = mysql_query("SELECT * FROM `requests` WHERE user_id='".$row['id']."'"); // taking data from the database
            while($row_books = mysql_fetch_array($list_of_books)){
                $count = $count + 1;
                $book_name = mysql_query("SELECT * FROM `files` WHERE id='".$row_books['book_id']."'");
                $row_name = mysql_fetch_array($book_name); 
                
                echo '<tr>
                        <td><input type = "hidden" name = "id'.$count.'" value = "'.$row_books['id'].'">' .$row_name['name']. '</td>
                    </tr>';
                echo '<td><span>Waiting for acceptance</span><button class="button" name = "cancel" value = "'.$count.'"> cancel </button></td></tr>';
            }
            
            $list_of_books = mysql_query("SELECT * FROM `queue` WHERE user_id='".$row['id']."'"); // taking data from the database
            while($row_books = mysql_fetch_array($list_of_books)){
                $count = $count + 1;
                $book_name = mysql_query("SELECT * FROM `files` WHERE id='".$row_books['book_id']."'");
                $row_name = mysql_fetch_array($book_name); 
                
                echo '<tr>
                        <td><input type = "hidden" name = "id'.$count.'" value = "'.$row_books['id'].'">' .$row_name['name']. '</td>
                    </tr>';
                echo '<td><span>You\'re in a queue</span><button class="button" name = "leave" value = "'.$count.'"> leave </button></td></tr>';
            } 
    } else {
        echo "<script> alert('You are not logged in!');window.location.replace(\"signUp.html\");</script>"; // 
    }     
?>