
<?php
    session_start() ; 
    include "connect_data_base.php" ; 
    $q = "UPDATE messages SET status = '0' WHERE message_from_user = :user_id AND message_to_user = :session_user AND status = '1'" ;
    $stmt = $con->prepare($q) ; 
    $stmt->execute(array(
        ':user_id' => $_REQUEST['to_user_id'],
        ':session_user' => $_SESSION['login_user_id']
    )) ;

    
?>