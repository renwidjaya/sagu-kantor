<div class="row">                            
    <div class="col-md-12">    
        <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">&nbsp;</h4>
                    </div>
                    <div class="modal-body">
                        <form class="eventInsForm" method="post" target="_self" name="formku" 
                              id="formku" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger display-hide">
                                        <button class="close" data-close="alert"></button>
                                        <span id="message">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    User Name <font color="#f00">*</font>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="username" name="username" 
                                        class="form-control myline" style="margin-bottom:5px" maxlength="25">
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Employee Name <font color="#f00">*</font>
                                </div>                                
                                <div class="col-md-8">
                                    <select id="m_employee_id" name="m_employee_id" class="form-control select2me myline" 
                                        data-placeholder="Select..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_employee as $value){
                                                echo "<option value='".$value->id."'>".$value->employee_name."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Password <font color="#f00">*</font>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" id="password" name="password" 
                                        class="form-control myline" style="margin-bottom:5px" maxlength="25">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Group Name <font color="#f00">*</font>
                                </div>
                                <div class="col-md-8">
                                    <select id="group_id" name="group_id" class="form-control select2me myline" 
                                        data-placeholder="Select..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_group as $value){
                                                echo "<option value='".$value->id."'>".$value->name."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:5px">
                                <div class="col-md-4">
                                    Active <font color="#f00">*</font>
                                </div>
                                <div class="col-md-8">
                                    <input type="checkbox" checked class="make-switch" data-size="small" 
                                        id="active" name="active">
                                </div>
                            </div>                             
                            <div class="row" id="input_photo" style="display:none;">
                                <div class="col-md-4">
                                    Photo Profile
                                </div>
                                <div class="col-md-8">
                                    <div class="fileinput fileinput-new myline" data-provides="fileinput" style="margin-bottom:5px" > 
                                        <div class="input-group input-small">
                                            <div class="form-control uneditable-input" data-trigger="fileinput">
                                                <i class="fa fa-file fileinput-exists"></i>&nbsp; 
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn default btn-file">
                                            <span class="fileinput-new">
                                            Select file </span>
                                            <span class="fileinput-exists">
                                            Change </span>
                                            <input type="file" name="photo_profile_url" id="photo_profile_url">
                                            </span>
                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                                            Remove </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row" id="edit_photo" style="display:none;">
                                <div class="col-md-4">
                                    Photo Profile
                                </div>
                                <div class="col-md-5">
                                    <input type="text" id="photo_url" name="photo_url" 
                                        class="form-control myline" style="margin-bottom:5px" readonly="true">
                                </div>
                                <div class="col-md-3">
                                    <a href="#" onclick="new_file();" class="btn btn-circle green btn-sm">
                                        <i class="fa fa-pencil-square-o"></i> Change
                                    </a>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-4">
                                    &nbsp;
                                </div>
                                <div class="col-md-8">
                                    <small><i>Recommended 29 x 29 pixels (jpg, png, gif)</i></small> 
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" onClick="simpandata();">Save</button>
                        <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            if( ($group_id==1)||($hak_akses['index']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Users
                </div>
                <div class="tools">                                            
                    <a style="height:28px" class="btn btn-circle btn-sm default" onclick="newData()">
                        <i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>User Name</th> 
                    <th>Real Name/Employee Name</th>
                    <th>Group</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0;
                        foreach ($list_data as $data){
                            $no++;
                    ?>
                    <tr>
                            <td style="width:50px; text-align:center"><?php echo $no; ?></td>
                            <td><?php echo $data->username; ?></td>
                            <td><?php echo $data->employee_name; ?></td>
                            <td><?php echo $data->group_name; ?></td>
                            <td style="text-align:center">
                                <?php
                                    if($data->active==1){
                                ?>
                                    <img src="<?php echo base_url(); ?>img/user_active.png">
                                <?php }else{ ?>
                                    <img src="<?php echo base_url(); ?>img/user_disabled.png">
                                <?php } ?>
                            </td>
                            <td style="width:200px; text-align:center">
                                <?php 
                                    if($data->id == 1){
                                ?>
                                <a href="#" class="btn btn-xs btn-circle green thickbox" 
                                   disabled="disabled" style="margin-bottom:4px">
                                    &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                                <a href="#" class="btn btn-xs btn-circle red" disabled="disabled" 
                                   style="margin-bottom:4px">
                                    <i class="fa fa-times"></i> Delete </a>
                                <?php
                                    }else{
                                        if( ($group_id==1)||($hak_akses['edit']==1) ){
                                ?>
                                <a class="btn btn-circle btn-xs green" onclick="editData(<?php echo $data->id; ?>)" style="margin-bottom:4px">
                                    &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                                <?php 
                                        }
                                        if( ($group_id==1)||($hak_akses['delete']==1) ){
                                ?>
                                <a href="<?php echo base_url(); ?>index.php/Users/delete/<?php echo $data->id; ?>" 
                                   class="btn btn-xs btn-circle red" style="margin-bottom:4px" 
                                   onclick="return confirm('Are you sure want to delete?');">
                                    <i class="fa fa-times"></i> Delete </a>
                                <?php
                                        }
                                    }
                                ?>

                            </td>
                        </tr>
                    <?php
                        }
                    ?>                                                                                    
                </tbody>
                </table>
            </div>
        </div>
        <?php
            }else{
        ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span id="message">You are not authorized to access that location!</span>
        </div>
        <?php
            }
        ?>
    </div>
</div>                        
<script>
var dsState;

function newData(){
    $('#username').val('');
    $('#m_employee_id').val('');
    $('#password').val('');
    $('#group_id').val('');
    $('#id').val('');
    $('#input_photo').show();
    $('#edit_photo').hide();
    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Add User');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#username").val()) == ""){
        $("#message").html("User name can`t be blank!");  
        $('.alert-danger').show(); 
    }else if($.trim($("#m_employee_id").val()) == ""){
        $("#message").html("Please cek real name/ employee name!");
        $('.alert-danger').show(); 
    }else if($.trim($("#password").val()) == ""){
        $("#message").html("Password can`t be blank!");
        $('.alert-danger').show(); 
    }else if($.trim($("#group_id").val()) == ""){
        $("#message").html("Group name can`t be blank!");
        $('.alert-danger').show(); 
    }else{       
        //$('#btnSave').attr("disabled", true); 
        if(dsState=="Input"){
            $.ajax({
                type:"POST",
                url:'<?php echo base_url('index.php/Users/cek_code'); ?>',
                data:"data="+$("#username").val(),
                success:function(result){
                    //console.log(result);
                    if(result=="ADA"){
                        $('#message').html("Username already exist!");
                        $('.alert-danger').show();
                    }else{
                        $('#message').html("");
                        $('.alert-danger').hide();
                        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Users/save");
                        $('#formku').submit();                    
                    }
                }
            });
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Users/update");
            $('#formku').submit(); 
        }
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/Users/edit'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
           console.log(result);
           $('#nik').val(result['nik']);
           $('#username').val(result['username']);
           $('#m_employee_id').select2('val', result['m_employee_id']);           
           $('#password').val(result['password']);
           $('#group_id').select2('val', result['group_id']);
           $("#active").bootstrapSwitch('state', result['active']);
           $('#id').val(result['id']);
           
           $('#photo_url').val(result['photo_profile_url']);
           $('#input_photo').hide();
           $('#edit_photo').show();
           
           $("#myModal").find('.modal-title').text('Edit Employee');
           $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}

function new_file(){
    $('#input_photo').show();
    $('#edit_photo').hide();
}
</script>                         