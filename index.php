<?php
    session_start() ; 
    $page_title = "ChatMe" ; 
    include_once "init.php" ;

    if(!isset($_SESSION['login_user_id'])){
        header("location:login.php") ; 
    }
    
?>
<div class="container">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="row">
                <div class="col-8 text-first">
                    REAL TIME APPLICATION
                </div>
                <div class="col-4 text-end">
                    <div class="row">
                        <div class="col-6 text-start">
                            <?php echo "Welcome ". strtoupper($_SESSION['login_user_name']) ; ?>
                        </div>
                        <div class="col-6 text-start">
                            <a href="./logout.php">logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-12 col-sm-8 col-md-8 mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                        $q = 'SELECT * FROM login WHERE login_user_id != :user_id' ; 
                        $stmt = $con->prepare($q) ; 
                        $stmt->execute(array(
                            ':user_id' => $_SESSION['login_user_id']
                        )) ; 
                        $count = $stmt->rowCount() ;
                        $output = '' ; 
                        while ($count-- > 0) {
                            $res = $stmt->fetch() ; 
                            $output .='<tr>
                                            <td>
                                                '.$res['login_user_name'].'
                                            </td>
                                            <td>
                                                <button class="btn btn-info">start chat</button>
                                            </td>
                                        </tr>' ; 
                        }
                        if($output !=''){
                            echo $output ; 
                        }else{
                            echo "Sorry There is no users" ; 
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-12 col-sm-4 col-md-4 mt-5">
            search
            <hr>
            users
        </div>
    </div>
</div>


<script>
    console.log("test") ; 
</script>

<?php
    include_once "./include/footer.php" ; 
?>