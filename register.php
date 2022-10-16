<?php
    $page_title = "register user" ; 
    include_once "init.php" ; 
    $response = '' ; 
    if(isset($_POST['submit']) && $_POST['submit']='submit'){
        if($_REQUEST['user_uname']){
            $q = 'SELECT * FROM login WHERE login_user_name = :user_name' ; 
            $stmt = $con->prepare($q) ; 
            $stmt->execute(array(
                ':user_name' => $_REQUEST['user_uname']
            )) ; 
            $count = $stmt->rowCount() ; 
            if(!$count){
                $res = $stmt->fetch() ; 
                // password_verify($_REQUEST['user_password'], $res['login_user_password']))
                if (strlen($_REQUEST['user_password']) > 4){
                    $q = 'INSERT INTO login(login_user_name, login_user_password) VALUES(:user_id, :user_password)' ; 
                    $stmt = $con->prepare($q) ; 
                    $stmt->execute(array(
                        ':user_id' => $_REQUEST['user_uname'],
                        ':user_password' => sha1($_REQUEST['user_password'])
                    )) ; 
                    header('location:index.php') ; 
                }else{
                    $response = '<div class="alert alert-danger">Short <strong>password < 5</strong> </div>' ;     
                }

            }else{
                $response = '<div class="alert alert-danger">this <strong>username</strong> is duplicate</div>' ; 
            }

        }else{
            $response = '<div class="alert alert-danger"><strong>username</strong> is empty</div>' ; 
        }
    }
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8  register_form_container">
            <span id="response"><?php echo $response?></span>
            <form method="POST" id="user_register_form">
                <div class="mb-3">
                    <label for="user_uname" class="form-label">User Name</label>
                    <input type="text" class="form-control" name = "user_uname" id="user_uname">
                    <div id="user_uname_help" class="form-text">Your user name should be unique one.</div>
                </div>
                <div class="mb-3">
                    <label for="user_password" class="form-label">Password</label>
                    <input type="password" class="form-control" name = "user_password" id="user_password">
                </div>
                <div class="mb-3 form-check text-center">
                    <span>you already have an account?<a href="./login.php">signIN</a></span>
                </div>
                <button type="submit" name ="submit" class="btn btn-primary" id="submit_button">SignUp</button>
            </form>
        </div>
    </div>
</div>



<?php

    include_once "./include/footer.php" ; 
?>
    <script>

    </script>
</body>
</html>
