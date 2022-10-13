<?php
    session_start() ; 
    include "connect_data_base.php" ; 
    $q = "UPDATE login_details SET login_detail_user_last_activity = now() WHERE login_detail_user_id = ?" ; 
    $stmt = $con->prepare($q) ; 
    $stmt->execute(array($_SESSION['login_user_id'])) ; 
    
?>