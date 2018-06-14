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
                                    Jenis Transaksi <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jenis_transaksi" name="jenis_transaksi" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama Biaya <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_biaya" name="nama_biaya" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Kategori <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="kategori" name="kategori" class="form-control myline select2me" 
                                        data-placeholder="Pilih type..." style="margin-bottom:5px">
                                        <option value="Harga Item">Harga Item</option>
                                        <option value="Ongkos">Ongkos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Parameter
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="parameter" name="parameter" 
                                        class="form-control myline" style="margin-bottom:5px">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Keterangan
                                </div>
                                <div class="col-md-7">
                                    <textarea id="keterangan" name="keterangan" 
                                        class="form-control myline" style="margin-bottom:5px" rows="3" 
                                        onkeyup="this.value = this.value.toUpperCase()"></textarea>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-5">
                                    Type <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="type_biaya" name="type_biaya" class="form-control myline select2me" 
                                        data-placeholder="Pilih type..." style="margin-bottom:5px">
                                        <option value="Qty">Qty</option>
                                        <option value="Flat">Flat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Satuan
                                </div>
                                <div class="col-md-7">
                                    <select id="satuan" name="satuan" class="form-control myline select2me" 
                                        data-placeholder="Pilih satuan..." style="margin-bottom:5px">
                                        <option value="Kg">Kg</option>
                                        <option value="Sak">Sak</option>
                                        <option value="Sak">Hari</option>
                                        <option value="Orang">Orang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Jumlah (Rp) <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jumlah" name="jumlah" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeydown="return myCurrency(event);" onkeyup="getComa(this.value)">
                                    
                                    <input type="hidden" id="old_jumlah" name="old_jumlah">
                                    <input type="hidden" id="old_parameter" name="old_parameter">
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
                    <i class="fa fa-pied-piper"></i>Master Biaya
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
                    <th>Jenis Transaksi</th>
                    <th>Nama Biaya</th>  
                    <th>Kategori</th>
                    <th>Parameter</th>
                    <th>Keterangan</th>
                    <th>Type</th> 
                    <th>Satuan</th>
                    <th>Jumlah (Rp)</th>
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
                        <td><?php echo $data->jenis_transaksi; ?></td>
                        <td><?php echo $data->nama_biaya; ?></td>
                        <td><?php echo $data->kategori; ?></td>
                        <td><?php echo $data->parameter; ?></td>
                        <td><?php echo $data->keterangan; ?></td>
                        <td><?php echo $data->satuan; ?></td>
                        <td><?php echo $data->type_biaya; ?></td>   
                        <td style="text-align:right"><?php echo number_format($data->jumlah,0,',','.'); ?></td> 
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
                            <a href="<?php echo base_url(); ?>index.php/MBiaya/delete/<?php echo $data->id; ?>" 
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
    $('#jenis_transaksi').val('');
    $('#nama_biaya').val('');
    $('#kategori').select2('val', '');
    $('#parameter').val('');
    $('#keterangan').val('');
    $('#type_biaya').select2('val', '');
    $('#satuan').select2('val', '');
    $('#jumlah').val('');
    $('#id').val('');
    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Tambah Biaya');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#jenis_transaksi").val()) == ""){
        $('#message').html("Jenis transaksi harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#nama_biaya").val()) == ""){
        $('#message').html("Nama biaya harus diisi!");
        $('.alert-danger').show();
     }else if($.trim($("#kategori").val()) == ""){
        $('#message').html("Kategori harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#type_biaya").val()) == ""){
        $('#message').html("Type biaya harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#jumlah").val()) == ""){
        $('#message').html("Jumlah harus diisi!");
        $('.alert-danger').show();
    }else{      
        //$('#btnSave').attr("disabled", true); 
        $('#message').html("");
        $('.alert-danger').hide();
        if(dsState=="Input"){            
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MBiaya/save");        
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MBiaya/update");
        }
        $('#formku').submit();
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/MBiaya/edit'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            console.log(result);
            $('#jenis_transaksi').val(result['jenis_transaksi']);
            $('#nama_biaya').val(result['nama_biaya']);
            $('#kategori').select2('val',result['kategori']);
            $('#parameter').val(result['parameter']);
            $('#keterangan').val(result['keterangan']);
            $('#type_biaya').select2('val',result['type_biaya']);
            $('#satuan').select2('val',result['satuan']);
            $('#jumlah').val(result['jumlah']);
            
            $('#old_jumlah').val(result['jumlah']);
            $('#old_parameter').val(result['parameter']);
            $('#id').val(result['id']);
            
            $("#myModal").find('.modal-title').text('Edit Biaya');
            $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}

function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function getComa(nilai){
    $('#jumlah').val(nilai.toString().replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}
</script>         