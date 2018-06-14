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
                                    Nama Muatan <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_muatan" name="nama_muatan" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                    <input type="hidden" id="id" name="id">
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
        
        <div class="modal fade" id="myKategori" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Judul</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger display-hide" id="box_error_kategori">
                                    <button class="close" data-close="alert"></button>
                                    <span id="msg_error_kategori">&nbsp;</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                List type/kategori untuk muatan
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="nama_muatan_kategori" name="nama_muatan" 
                                    class="form-control myline" style="margin-bottom:5px" 
                                    readonly="readonly">

                                <input type="hidden" id="m_muatan_id" name="m_muatan_id">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover table-bordered table-hover">
                                    <thead>
                                        <th>No</th>
                                        <th>Type/Kategori</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody id="tblKategori">
                                        
                                    </tbody>
                                </table>
                            </div>

                        </div>     
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            if( ($group_id==1)||($hak_akses['index']==1) ){
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
                </div>
            </div>
        </div>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-car"></i>Master Muatan
                </div>
                <div class="tools">    
                    <a style="height:28px" class="btn btn-circle btn-sm default" onclick="newData()">
                        <i class="fa fa-plus"></i> Tambah</a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Muatan</th>   
                    <th>Keterangan</th> 
                    <th>Type/ Kategori</th>
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
                        <td><?php echo $data->nama_muatan; ?></td>
                        <td><?php echo $data->keterangan; ?></td> 
                        <td style="text-align:center">
                            <a class="btn btn-circle btn-xs blue-hoki" onclick="showDetail(<?php echo $data->id; ?>,'<?php echo $data->nama_muatan; ?>')" style="margin-bottom:4px">
                                &nbsp; <i class="fa  fa-bars"></i> Add Type/ Kategori &nbsp; </a>
                        </td> 
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
                            <a href="<?php echo base_url(); ?>index.php/MMuatan/delete/<?php echo $data->id; ?>" 
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
<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
var dsState;

function newData(){
    $('#nama_muatan').val('');
    $('#keterangan').val('');
    $('#id').val('');
    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Tambah Muatan');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function showDetail(id, nama_muatan){
    $('#nama_muatan_kategori').val(nama_muatan);
    $('#m_muatan_id').val(id);
    
    loadKategori(id);
    
    $("#myKategori").find('.modal-title').text('Input Type/Kategori');
    $("#myKategori").modal('show',{backdrop: 'true'});
}

function loadKategori(id){
    $.ajax({
        type:"POST",
        url:'<?php echo base_url('index.php/MMuatan/generate_kategori'); ?>',
        data:"id="+id,
        success:function(result){
            $('#tblKategori').html(result);
        }
    });
}

function saveKategori(){
    if($.trim($("#muatan_type").val()) == ""){
        $('#msg_error_kategori').html("Type/ kategori harus diisi!");
        $('#box_error_kategori').show();       
    }else{               
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/MMuatan/save_kategori'); ?>',
            data:{muatan_type:$("#muatan_type").val(),m_muatan_id:$('#m_muatan_id').val()},
            success:function(result){
                if(result=="sukses"){
                    $('#msg_error_kategori').html("");
                    $('#box_error_kategori').hide();
                    loadKategori($('#m_muatan_id').val());
                }else{
                    $('#msg_error_kategori').html("Error while saved data!");
                    $('#box_error_kategori').show();                 
                }
            }
        });
    }        
}

function hapusKategori(id){
    var r = confirm('Anda yakin menghapus data ini?');
    if (r==true){
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/MMuatan/delete_kategori'); ?>',
            data:"id="+id,
            success:function(result){
                if(result=="sukses"){
                    $('#msg_error_kategori').html("");
                    $('#box_error_kategori').hide();
                    loadKategori($('#m_muatan_id').val());
                }else{
                    $('#msg_error_kategori').html("Error while deleted data!");
                    $('#box_error_kategori').show();                 
                }
            }
        });
    }
}

function simpandata(){
    if($.trim($("#nama_muatan").val()) == ""){
        $('#message').html("Nama muatan harus diisi!");
        $('.alert-danger').show();       
    }else{      
        //$('#btnSave').attr("disabled", true); 
        if(dsState=="Input"){
            $.ajax({
                type:"POST",
                url:'<?php echo base_url('index.php/MMuatan/cek_code'); ?>',
                data:"data="+$("#nama_muatan").val(),
                success:function(result){
                    //console.log(result);
                    if(result=="ADA"){
                        $('#message').html("Nama muatan sudah ada, silahkan ganti dengan nama lain!");
                        $('.alert-danger').show();
                    }else{
                        $('#message').html("");
                        $('.alert-danger').hide();
                        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MMuatan/save");
                        $('#formku').submit();                    
                    }
                }
            });
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MMuatan/update");
            $('#formku').submit(); 
        }
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/MMuatan/edit'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            console.log(result);
            $('#nama_muatan').val(result['nama_muatan']);
            $('#keterangan').val(result['keterangan']);
            $('#id').val(result['id']);
            
            $("#myModal").find('.modal-title').text('Edit Muatan');
            $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}

$(function(){    
    window.setTimeout(function() { $(".alert-success").hide(); }, 4000);
});
</script>         