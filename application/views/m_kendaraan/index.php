<div class="row">                            
    <div class="col-md-12"> 
        <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Judul</h4>
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
                                    Type Kendaraan <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="m_type_kendaraan_id" name="m_type_kendaraan_id" class="form-control myline select2me" 
                                        data-placeholder="Silahkan pilih..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($mtk_list as $row){
                                                echo '<option value="'.$row->id.'">'.$row->type_kendaraan.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    No Polisi <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_kendaraan" name="no_kendaraan" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()" maxlength="11">
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-5">
                                    Keterangan
                                </div>
                                <div class="col-md-7">
                                    <textarea id="keterangan" name="keterangan" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()" rows="3"></textarea>
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
                    <i class="fa fa-taxi"></i>Daftar Kendaraan
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
                    <th>No Polisi</th>   
                    <th>Type Kendaraan</th> 
                    <th>Keterangan</th> 
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
                        <td><?php echo $data->no_kendaraan; ?></td>
                        <td><?php echo $data->type_kendaraan; ?></td> 
                        <td><?php echo $data->keterangan; ?></td> 
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
                            <a href="<?php echo base_url(); ?>index.php/MKendaraan/delete/<?php echo $data->id; ?>" 
                               class="btn btn-circle btn-xs red" style="margin-bottom:4px" onclick="return confirm('Anda yakin menghapus data ini?');">
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
    $('#no_kendaraan').val('');
    $('#m_type_kendaraan_id').select2('val','');
    $('#keterangan').val('');
    $('#id').val('');
    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Tambah Kendaraan');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#no_kendaraan").val()) == ""){
        $('#message').html("No Polisi harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#m_type_kendaraan_id").val()) == ""){
        $('#message').html("Silahkan pilih type kendaraan!");
        $('.alert-danger').show();
    }else{      
        //$('#btnSave').attr("disabled", true); 
        if(dsState=="Input"){
            $.ajax({
                type:"POST",
                url:'<?php echo base_url('index.php/MKendaraan/cek_code'); ?>',
                data:"data="+$("#no_kendaraan").val(),
                success:function(result){
                    //console.log(result);
                    if(result=="ADA"){
                        $('#message').html("Nomor polisi sudah dipakai kendaraan lain, silahkan ganti!");
                        $('.alert-danger').show();
                    }else{
                        $('#message').html("");
                        $('.alert-danger').hide();
                        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MKendaraan/save");
                        $('#formku').submit();                    
                    }
                }
            });
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MKendaraan/update");
            $('#formku').submit(); 
        }
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/MKendaraan/edit'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            console.log(result);
            $('#no_kendaraan').val(result['no_kendaraan']);
            $('#keterangan').val(result['keterangan']);
            $('#m_type_kendaraan_id').select2('val',result['m_type_kendaraan_id']);
            $('#id').val(result['id']);
            
            $("#myModal").find('.modal-title').text('Edit Kendaraan');
            $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}
</script>         