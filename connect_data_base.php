<?php
    $dsn = "mysql:host=localhost;dbname=ajax_chat_app" ; 
    $user = "root" ; 
    $pass = "" ; 
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );
    try{
        $con    = new PDO($dsn, $user, $pass, $option);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        function get_last_active_time($user_id, $co){
            $q = "SELECT login_detail_user_last_activity FROM login_details WHERE login_detail_user_id = :user_id ORDER BY login_detail_user_last_activity DESC LIMIT 1" ;
            $stmt = $co->prepare($q) ; 
            $stmt->execute(array(
                ':user_id' => $user_id
            )) ; 
            $row = $stmt->fetch() ; 
            return $row['login_detail_user_last_activity'] ; 

        }
        function unseen_message($to_user_id, $con){//not sessioned users
            //get all unseended message from this particular id
            $q = "SELECT COUNT(*) as count FROM messages WHERE message_from_user = :user_id AND message_to_user = :user_session AND status = '1'" ;
            $stmt = $con->prepare($q) ; 
            $stmt->execute(array(
                ':user_id' => $to_user_id,
                ':user_session' => $_SESSION['login_user_id']
            )) ; 
            $row = $stmt->fetch() ; 
            return $row['count'] ; 

        }
        
    }
    catch (PDOException $e){
        echo $e ->getMessage() ; 
    }
    
    
?>