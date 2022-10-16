<?php
    session_start() ; 
    $page_title = "ChatMe" ; 
    include_once "init.php" ;

    if(!isset($_SESSION['login_user_id'])){
        header("location:login.php") ; 
    }
    //if admin send message to all 
    
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
        <div class="col-12 col-sm-12 col-md-12 mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="users_data">
                </tbody>
                
            </table>
        </div>
        <div id="user_details">
            <div id="user_model_details"></div>
        </div>
    </div>
</div>

<?php
    include_once "./include/footer.php" ; 
?>
<script>
    $(document).ready(function(){
        
        setInterval(function(){  
            update_last_activity() ;    
            fetch_users_data() ; 
            
        },500);

        //get all user data
        function fetch_users_data(){
            $.ajax({
                url:"fetch_users_data.php",
                success:function(data){
                    $("#users_data").html(data) ; 
                }
            });
        }
        
        function update_last_activity(){
            $.ajax({
                url:"update_last_activity.php",
                success:function(data){
                    // $("#users_data").html(data) ; 
                }
            });
        }


        function make_chat_box(to_user_id, to_user_name){
            var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="Chating '+to_user_name+'">';
            modal_content += '<div style="height:400px; border:1px solid #CCC; overflow-y:scroll; margin-bottom:24px;padding:16px;" class="chat_history" data-to_user_id="'+to_user_id+'" id="chat_history_'+to_user_id+'">' ;
            modal_content += '<div class="container">'+load_chat_history(to_user_id)+'</div>'; 
            modal_content += '</div>' ; 
            modal_content +='<div class="form-group">' ;
            modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>' ; 
            modal_content += '</div><div class="form-group" align="right">' ; 
            modal_content +='<button type="button" name="send_chat" data-id="'+to_user_id+'" id="send_button_'+to_user_id+'" class="btn btn-primary send_button" disabled>Send</button></div></div>' ; 
            $('#user_model_details').html(modal_content) ; 
        }


        function load_chat_history(to_user_id){
            $.ajax({
                url:"fetch_message.php",
                data:{to_user_id:to_user_id},
                method:"POST",
                success:function(data){
                    $("#chat_history_"+to_user_id+ " .container").html(data) ; 
                }
            });
        }
        
        function update_message_status(from_user_id){
            $.ajax({
                url:"update_message_status.php",
                data:{to_user_id:from_user_id},
                method:"POST",
                success:function(data){
                }
            });
        }
        $(document).on('click', '.start_chat', function(){
            var to_user_id = $(this).data('to_user_id') ; 
            var to_user_name = $(this).data('to_user_name') ; 
            make_chat_box(to_user_id, to_user_name) ; 
            $("#user_dialog_"+to_user_id).dialog({
                autoOpen:false,
                width:400,
            });
            $("#user_dialog_"+to_user_id).dialog('open') ; 
            // load_chat_history(to_user_id) ; //////////////////
            setInterval(function(){
                if($("#chat_message_"+to_user_id).val() == ''){
                    $("#send_button_"+to_user_id).attr('disabled', 'disabled') ; 
                }else{
                    $("#send_button_"+to_user_id).attr('disabled',false) ; 
                }
            }, 500);
            //do here query to update status from this particular user to set to 0 not 1
            update_message_status(to_user_id) ; 

        });
        
        $(document).on('click', '.send_button', function(){
            
            // var from_user_id = $_SESSION['login_use_id'] ; 
            var to_user_id = $(this).data("id") ; 
            var message_content = $("#chat_message_"+to_user_id).val() ; 
            $.ajax({
                url:"send_message.php",
                data:{to_user_id:to_user_id, message_content:message_content},
                method:"POST",
                beforeSend:function(){
                    $("#send_button_"+to_user_id).attr('disabled', 'disabled') ; 
                    $("#send_button_"+to_user_id).html('sending..') ; 
                },
                success:function(data){
                    $("#send_button_"+to_user_id).attr('disabled', false) ; 
                    $("#send_button_"+to_user_id).html('send') ; 
                    $("#chat_message_"+to_user_id).val('') ; 
                    setInterval(function(){
                        load_chat_history(to_user_id) ;
                    }, 500); 

                }
            });
        });

    })
</script>

    </tbody>
</html>