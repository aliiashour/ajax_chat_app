<?php
    session_start() ; 
    include "connect_data_base.php" ; 
    $q = "SELECT * FROM login WHERE login_user_id NOT IN(:user_id, 16)" ;
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
            $status = '' ;
 
            
            if($last_active_time >= $current_time){
                $status = '<div class="badge bg-success rounded-pill status" style="padding:6px"></div>' ;
            }
            $c = '' ; 
            if(unseen_message($row['login_user_id'], $con)){//adam id
                $c = '
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger status">
                        '.unseen_message($row['login_user_id'], $con).'
                        <span class="visually-hidden">unread messages</span>
                    </span>' ; 
            }
            $output .= '<tr>
                            <td>
                                '.$status.'
                                '.$row['login_user_name'].'
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary position-relative start_chat" data-to_user_name="'.$row['login_user_name'].' " data-to_user_id="'.$row['login_user_id'].'">
                                    start chat'.$c.'
                                </button>
                            </td>
                        </t>' ; 
        }
    }else{
        $output ='<tr><td>there is no users</td></tr>' ; 
    }
    echo $output ; 
?>