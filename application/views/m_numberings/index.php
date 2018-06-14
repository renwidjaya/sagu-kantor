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
                                    Prefix <font color="#f00">*</font>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="prefix" name="prefix" 
                                        class="form-control myline" style="margin-bottom:5px" maxlength="10"
                                        onkeyup="this.value = this.value.toUpperCase()">
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Date Info <font color="#f00">*</font>
                                </div>
                                <div class="col-md-8">
                                    <input type="checkbox" checked class="make-switch" data-size="small" 
                                        id="date_info" name="date_info" data-on-text="Yes" data-off-text="No">
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-4">
                                    Padding <font color="#f00">*</font>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="padding" name="padding" 
                                        class="form-control myline" style="margin-bottom:5px;margin-top:5px" maxlength="5" 
                                        onkeydown="return myCurrency(event);">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Prefix Separator
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="prefix_separator" name="prefix_separator" 
                                        class="form-control myline" style="margin-bottom:5px" maxlength="1">
                                </div>
                                <div class="col-md-2">
                                    Date Separator
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="date_separator" name="date_separator" 
                                        class="form-control myline" style="margin-bottom:5px" maxlength="1">
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
                    <i class="fa fa-sort-numeric-asc"></i>Master Numbering
                </div>
                <div class="tools">                                            
                    <?php
                        if( ($group_id==1)||($hak_akses['add']==1) ){
                            echo '<a style="height:28px" class="btn btn-circle btn-sm default" onclick="newData()">
                                <i class="fa fa-plus"></i> Tambah</a>';
                        }
                    ?>  
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Prefix</th> 
                    <th>Date Info</th> 
                    <th>Padding</th>
                    <th>Prefix Separator</th> 
                    <th>Date Separator</th> 
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
                        <td><?php echo $data->prefix; ?></td>
                        <td style="text-align:center"><?php echo ($data->date_info==1)? "Yes": "No"; ?></td>
                        <td style="text-align:center"><?php echo $data->padding; ?></td>
                        <td style="text-align:center"><?php echo $data->prefix_separator; ?></td>
                        <td style="text-align:center"><?php echo $data->date_separator; ?></td>
                        <td style="text-align:center"> 
                            <?php
                                if( ($group_id==1)||($hak_akses['edit']==1) ){
                            ?>
                            <a class="btn btn-circle btn-xs green" onclick="editData(<?php echo $data->id; ?>)" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                            <?php 
                                }
                                if( ($group_id==1)||($hak_akses['delete']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/MNumberings/delete/<?php echo $data->id; ?>" 
                               class="btn btn-xs btn-circle red" style="margin-bottom:4px" 
                               onclick="return confirm('Are you sure want to delete?');">
                                <i class="fa fa-trash-o"></i> Delete </a>
                            <?php }?>
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
            <span id="message">Anda tidak memiliki hak akses ke halaman ini!</span>
        </div>
        <?php
            }
        ?>
    </div>
</div>                        	
<script>
var dsState;

function newData(){
    $('#prefix').val('');
    $('#padding').val('');
    $('#prefix_separator').val('');
    $('#date_separator').val('');
    $('#id').val('');
    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Add Numbering');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#prefix").val()) == ""){
        $('#message').html("Prefix can`t be blank!");
        $('.alert-danger').show();
    }else if($.trim($("#padding").val()) == ""){
        $('#message').html("Padding value can`t be blank!");
        $('.alert-danger').show();
    }else{       
        if(dsState=="Input"){
            $.ajax({
                type:"POST",
                url:'<?php echo base_url('index.php/MNumberings/cek_code'); ?>',
                data:"data="+$("#prefix").val(),
                success:function(result){
                    //console.log(result);
                    if(result=="ADA"){
                        $('#message').html("Prefix type already exist! Please choose other.");
                        $('.alert-danger').show();
                    }else{
                        $('#message').html("");
                        $('.alert-danger').hide();
                        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MNumberings/save");
                        $('#formku').submit();                    
                    }
                }
            });
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MNumberings/update");
            $('#formku').submit(); 
        }
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/MNumberings/edit'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
           console.log(result);
           $('#prefix').val(result['prefix']);
           $("#date_info").bootstrapSwitch('state', result['date_info']);
           $('#padding').val(result['padding']);
           $('#prefix_separator').val(result['prefix_separator']);
           $('#date_separator').val(result['date_separator']);
           $('#id').val(result['id']);
           
           $("#myModal").find('.modal-title').text('Edit Numbering');
           $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}

function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!==190)
        return false;
    return true;
}
</script>