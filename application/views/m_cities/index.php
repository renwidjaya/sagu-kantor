<div class="row">                            
    <div class="col-md-12"> 
        <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Add City</h4>
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
                                <div class="col-md-5">
                                    Kode Kota <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="city_code" name="city_code" 
                                        class="form-control myline" style="margin-bottom:5px" maxlength="15" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama Kota <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="city_name" name="city_name" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Provinsi <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="m_province_id" name="m_province_id" class="form-control myline select2me" 
                                        data-placeholder="Silahkan pilih...">
                                        <option value=""></option>
                                        <?php
                                            foreach ($province_list as $row){
                                                echo '<option value="'.$row->id.'">'.$row->province_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>                            
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" onClick="simpandata();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
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
                    <i class="fa fa-globe"></i>Master Kota
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
                    <th>Kode Kota</th>   
                    <th>Nama Kota</th> 
                    <th>Provinsi</th> 
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
                        <td><?php echo $data->city_code; ?></td>
                        <td><?php echo $data->city_name; ?></td>
                        <td><?php echo $data->province_name; ?></td>
                        <td style="width:200px; text-align:center"> 
                            <?php
                                if( ($group_id==1)||($hak_akses['edit']==1) ){
                            ?>
                            <a class="btn btn-circle btn-xs green" onclick="editData(<?php echo $data->id; ?>)" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                            <?php 
                                }
                                if( ($group_id==1)||($hak_akses['delete']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/MCities/delete/<?php echo $data->id; ?>" 
                               class="btn btn-xs btn-circle red" style="margin-bottom:4px" onclick="return confirm('Anda yakin menghapus data ini?');">
                                <i class="fa fa-trash-o"></i> Hapus </a>
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
    $('#city_code').val('');
    $('#city_name').val('');
    $('#m_province_id').val('');
    $('#id').val('');
    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Tambah Data Kota');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#city_code").val()) == ""){
        $('#message').html("Kode kota tidak boleh kosong!");
        $('.alert-danger').show();       
    }else if($.trim($("#city_name").val()) == ""){
        $('#message').html("Nama kota tidak boleh kosong!");
        $('.alert-danger').show();
    }else if($.trim($("#m_province_id").val()) == ""){
        $('#message').html("Silahkan pilih provinsi!");
        $('.alert-danger').show();
    }else{    
        //$('#btnSave').attr("disabled", true); 
        if(dsState=="Input"){
            $.ajax({
                type:"POST",
                url:'<?php echo base_url('index.php/MCities/cek_code'); ?>',
                data:"data="+$("#city_code").val(),
                success:function(result){
                    //console.log(result);
                    if(result=="ADA"){
                        $('#message').html("Kode kota sudah digunakan, silahkan ganti dengan kode lain!");
                        $('.alert-danger').show();
                    }else{
                        $('#message').html("");
                        $('.alert-danger').hide();
                        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MCities/save");
                        $('#formku').submit();                    
                    }
                }
            });
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MCities/update");
            $('#formku').submit(); 
        }
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/MCities/edit'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
           console.log(result);
           $('#city_code').val(result['city_code']);
           $('#city_name').val(result['city_name']);
           $('#m_province_id').select2('val', result['m_province_id']);
           $('#id').val(result['id']);
           
           $("#myModal").find('.modal-title').text('Edit Kota');
           $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}

</script>        