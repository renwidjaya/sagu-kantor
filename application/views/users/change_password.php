<div class="row">
    <?php
        if( ($group_id==1)||($hak_akses['change_password']==1) ){
    ?>
    <div class="col-md-5 col-sm-12">           
        <form class="eventInsForm" method="post" target="_self" name="formku" id="formku">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span id="message">&nbsp;</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 col-sm-12">Old Password <font color="#f00">*</font></div>
                <div class="col-md-7 col-sm-12">
                    <input type="password" id="old_password" name="old_password" 
                           class="form-control" style="margin-bottom:5px" maxlength="25" value="">
                </div>
            </div> 
            <div class="row">
                <div class="col-md-5 col-sm-12">New Password <font color="#f00">*</font></div>
                <div class="col-md-7 col-sm-12">
                    <input type="password" id="new_password" name="new_password" 
                           class="form-control" style="margin-bottom:5px" maxlength="25" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 col-sm-12">Confirm Password <font color="#f00">*</font></div>
                <div class="col-md-7 col-sm-12">
                    <input type="password" id="confirm_password" name="confirm_password" 
                           class="form-control" style="margin-bottom:5px" maxlength="25" value="">
                </div>
            </div> 
            <div class="row">
                <div class="col-md-5 col-sm-12">&nbsp;</div>
                <div class="col-md-7 col-sm-12">
                    &nbsp;<br>
                    <input type="button" onClick="simpandata();" name="btnSave" 
                        value="Save" class="btn btn-primary" id="btnSave">
                    <br>&nbsp;</td>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">                  
                    <div id="progress-bar">
                        <progress class="progress progress-striped progress-success" value="0" max="100">
                            <div class="progress">
                                <span class="progress-bar" style="width: 0%;">0%</span>
                            </div>
                        </progress>
                        <div class="progress-info">&nbsp;</div>
                    </div>


                </div>
            </div>
        </form>        
    </div>
    <?php
        }else{
    ?>
    <div class="col-md-12">
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span id="message">You are not authorized to access that location!</span>
        </div>
    </div>
    <?php
        }
    ?>
</div>                        

<script>
function simpandata(){		
    if($.trim($("#old_password").val()) == ""){
        $("#message").html("Old password can`t be blank!");  
        $('.alert-danger').show(); 
    }else if($.trim($("#new_password").val()) == ""){
        $("#message").html("New password can`t be blank!");
        $('.alert-danger').show(); 
    }else if($.trim($("#confirm_password").val()) == ""){
        $("#message").html("Confirm_password can`t be blank!");
        $('.alert-danger').show(); 
    }else if($("#confirm_password").val() != $("#new_password").val()){
        $("#message").html("Password does not match confirmation!");
        $('.alert-danger').show();
    }else{                  
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/Users/update_password'); ?>',
            data:"data="+$("#old_password").val()+"^"+$("#new_password").val(),
            success:function(result){
                console.log(result);
                if(result=="SALAH"){
                    $('#message').html("Old password is wrong!");
                    $('.alert-danger').show(); 
                }else{
                    $('#message').html("");
                    $('.alert-danger').hide(); 
                    $('#btnSave').attr("disabled", true);
                    
                    var progressBarContainer = $('#progress-bar');
                    var progressBar = {
                        chain: [],
                        progress: progressBarContainer.children('progress'),
                        progressBar: progressBarContainer.find('.progress-bar'),
                        progressInfo: progressBarContainer.children('.progress-info'),
                        set: function(value, info, noPush) {
                            if(!noPush) {
                                this.chain.push(value);
                            }
                            if(this.chain[0] == value) {
                                this.go(value, info);
                            }
                            else {
                                var self = this;
                                setTimeout(function() {
                                    self.set(value, info, true)
                                }, 100);
                            }
                        },
                        go: function(value, info) {
                            this.progressInfo.text(info);
                            var self = this;
                            var interval = setInterval(function() {
                                var curr = self.progress.attr('value');
                                if(curr >= value) {
                                    clearInterval(interval);
                                    self.progress.attr('value', value);
                                    self.progressBar.css('width', value + '%');
                                    self.chain.shift();
                                    window.location.href = "<?php echo base_url(); ?>index.php/Login/logout"; 
                                }
                                else {
                                    self.progress.attr('value', ++curr);
                                    self.progressBar.css('width', curr + '%');
                                }
                            }, 10)
                        }
                    };


                    progressBar.set(5, 'Request data to server');
                    progressBar.set(12, 'Validate your username and password');
                    progressBar.set(62, 'Update your password');
                    progressBar.set(86, 'Refresh database');
                    progressBar.set(100, 'Complete');                                      
                }
            }
        });    
    };
};
</script>

<style>
    #progress-bar {
        width: 100%;
    }
    .progress {
        height: 25px;
        width: 100%;
    }
    .progress-info {
        color: #000;
        text-align: center;
        font-weight: bold;
    }
</style>