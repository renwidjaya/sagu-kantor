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
                              id="formku">
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
                                    Group Name <font color="#f00">*</font>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="group_name" name="group_name" 
                                        class="form-control myline" style="margin-bottom:5px" maxlength="25" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                    <input type="hidden" id="id" name="id">
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
                    <i class="fa fa-weixin"></i>Groups
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
                    <th>Group Name</th>   
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
                            <td><?php echo $data->name; ?></td>
                            <td style="text-align:center">
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
                                <a href="<?php echo base_url(); ?>index.php/Groups/delete/<?php echo $data->id; ?>" 
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
    $('#group_name').val('');
    $('#id').val('');

    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Add Group');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#group_name").val()) == ""){
        $("#message").html("Group name can`t be blank!");  
        $('.alert-danger').show(); 
    }else{       
        //$('#btnSave').attr("disabled", true); 
        if(dsState=="Input"){
            $.ajax({
                type:"POST",
                url:'<?php echo base_url('index.php/Groups/cek_code'); ?>',
                data:"data="+$("#group_name").val(),
                success:function(result){
                    //console.log(result);
                    if(result=="ADA"){
                        $('#message').html("Group name already exist!");
                        $('.alert-danger').show();
                    }else{
                        $('#message').html("");
                        $('.alert-danger').hide();
                        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Groups/save");
                        $('#formku').submit();                    
                    }
                }
            });
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Groups/update");
            $('#formku').submit(); 
        }
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/Groups/edit'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
           //console.log(result);
           $('#group_name').val(result['name']);
           $('#id').val(result['id']);
           
           $("#myModal").find('.modal-title').text('Edit Group');
           $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}
</script> 