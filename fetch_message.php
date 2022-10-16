<?php
    session_start() ; 
    require_once "connect_data_base.php" ; 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // here i shoud insert data to data base
        $q = '(SELECT * FROM messages WHERE message_from_user = ? AND message_to_user=?)
                UNION
                (SELECT * FROM messages WHERE message_from_user = ? AND message_to_user=?) ORDER BY message_data ASC ' ; 
        $stmt = $con->prepare($q) ; 
        $stmt->execute(array($_SESSION['login_user_id'], $_REQUEST['to_user_id'], $_REQUEST['to_user_id'], $_SESSION['login_user_id'])) ; 
        $count = $stmt->rowCount() ; 
        $output = '' ; 
        if ($count){
            $ress = $stmt->fetchAll() ; 
            foreach($ress as $res){
                if($res['message_from_user'] == $_SESSION['login_user_id']){
                    //right align        
                    $output .= '<div class="row justify-content-end"><div class="col-8 iSend">'.$res['message_content'].'</div></div>' ;   
                }else{
                    $output .= '<div class="row justify-content-start"><div class="col-8 iRecev">'.$res['message_content'].'</div></div>' ;
                }
            }
            // update_message_status($_REQUEST['to_user_id'], $con) ; //
        }else{
            $output = '<class ="row"><div class="col-12 text-center alert alert-danger">there is no message yet.</div></div>' ;
        }
        echo $output ; 
        
    }else{
        echo "you are not allowed to be here" ; 
    }