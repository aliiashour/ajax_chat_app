<?php
    session_start() ; 
    require_once "connect_data_base.php" ; 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // here i shoud insert data to data base
        $q = "INSERT INTO messages(message_from_user, message_to_user,message_content) VALUES(?, ?, ?)" ; 
        $stmt = $con->prepare($q) ; 
        $stmt->execute(array($_SESSION['login_user_id'],$_REQUEST['to_user_id'], $_REQUEST['message_content'] )) ; 
        echo "done" ; 
    }else{
        echo "you are not allowed to be here" ; 
    }