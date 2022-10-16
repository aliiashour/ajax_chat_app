<?php 
    session_start() ; 
    $page_title = "login" ; 
    include_once "init.php" ; 
    $response = '' ;  
    if(isset($_SESSION['login_user_id'])){
        header("location:index.php") ; 
    }
    if(isset($_POST['login']) && $_POST['login']='login'){
        if($_REQUEST['user_uname']){
            $q = 'SELECT * FROM login WHERE login_user_name = :user_name' ; 
            $stmt = $con->prepare($q) ; 
            $stmt->execute(array(
                ':user_name' => $_REQUEST['user_uname']
            )) ; 
            $count = $stmt->rowCount() ; 
            if($count){
                $res = $stmt->fetch() ; 
                // password_verify($_REQUEST['user_password'], $res['login_user_password']))
                if (sha1($_REQUEST['user_password']) == $res['login_user_password']){
                    //found, start sessions
                    $_SESSION['login_user_id'] = $res['login_user_id'] ; 
                    $_SESSION['login_user_name'] = $res['login_user_name'] ; 
                    //now insert user id into logindetails table
                    $q = 'INSERT INTO login_details(login_detail_user_id) VALUES(:user_id)' ; 
                    $stmt = $con->prepare($q) ; 
                    $stmt->execute(array(
                        ':user_id' => $_SESSION['login_user_id']
                    )) ; 
                    $_SESSION['login_details_id'] = $con->lastInsertId() ; 
                    header('location:index.php') ; 
                }else{
                    $response = '<div class="alert alert-danger"><strong>password</strong> is Wrong</div>' ;     
                }

            }else{
                $response = '<div class="alert alert-danger"><strong>username</strong> is Wrong</div>' ; 
            }

        }else{
            $response = '<div class="alert alert-danger"><strong>username</strong> is empty</div>' ; 
        }
    }



?>


<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-10 col-md-8 mt-5">
            <div id="response"><?php echo $response ; ?></div>
            <form method="POST">
                <div class="mb-3">
                    <label for="user_uname" class="form-label">User Name</label>
                    <input type="text" class="form-control" name="user_uname" required>
                    <div id="user_name_help" class="form-text">Your user name should be unique one.</div>
                </div>
                <div class="mb-3">
                    <label for="user_password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="user_password" required>
                </div>
                <div class="mb-3 form-check text-center">
                    <span>you already have an account?<a href="./register.php">signUp</a></span>
                </div>
                <!-- <button type="submit" class="btn btn-primary" id="login_button">LogIN</button> -->
                
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" name="login" value="logIN">
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
    include_once "./include/footer.php" ; 
?>


