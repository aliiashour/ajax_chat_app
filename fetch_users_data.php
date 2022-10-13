<?php
    session_start() ; 
    include "connect_data_base.php" ; 
    $q = "SELECT * FROM login WHERE login_user_id != :user_id" ;
    $stmt = $con->prepare($q) ; 
    $stmt->execute(array(
        ':user_id' => $_SESSION['login_user_id']
    )) ; 
    $output = '' ; 




    if($stmt->rowCount()){
        foreach ($stmt->fetchAll() as $row) {
            $current_time = strtotime(date('Y-m-d H:i:s')."-10 second") ;//unix
            $current_time = date('Y-m-d H:i:s', $current_time) ; //str
            $last_active_time = get_last_active_time($row['login_user_id'], $con) ; 
            $status = '<span class="btn btn-primary">Online</span>' ; 
            if($last_active_time < $current_time){
                $status = '<span class="btn btn-danger">Offline</span>' ; 
            }
            $output .= '<tr>
                            <td>
                                '.$row['login_user_name'].'
                            </td>
                            <td>
                                '.$status.'
                            </td>
                            <td>
                                <button class="btn btn-info start_chat" data-to_user_name="'.$row['login_user_name'].' " data-to_user_id="'.$row['login_user_id'].'">start Chat</button>
                            </td>
                        </t>' ; 
        }
    }else{
        $output ='<tr><td>there is no users</td></tr>' ; 
    }
    echo $output ; 
?>