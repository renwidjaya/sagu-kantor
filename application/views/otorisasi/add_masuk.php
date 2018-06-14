<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$(function(){    
    for(i=2;i<10;i++){
      $('#row_muatan'+i).hide();
    }
});
</script>
<div class="row">                            
    <div class="col-md-12">
        <!-- Pop Up Modal untuk inputan Agen Baru -->
        <div class="modal fade" id="mdlAgen" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Judul</h4>
                    </div>
                    <div class="modal-body">
                        <form class="eventInsForm" method="post" target="_self" name="frm_agen" 
                              id="frm_agen">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger display-hide">
                                        <button class="close" data-close="alert"></button>
                                        <span id="msg_agen">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama Agen <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_agen" name="nama_agen" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Alamat
                                </div>
                                <div class="col-md-7">
                                    <textarea id="alamat" name="alamat" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Penanggung Jawab (PIC)
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="pic" name="pic" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nomor Telepon
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="telepon" name="telepon" 
                                        class="form-control myline" style="margin-bottom:5px">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Jenis Agen <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="jenis_agen" name="jenis_agen" class="form-control myline select2me" 
                                        data-placeholder="Select..." style="margin-bottom:5px">
                                        <option value="Lokal">Lokal</option>
                                        <option value="Luar">Luar</option>
                                    </select>
                                </div>
                            </div>                                                                                                               
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" onClick="simpanAgen();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir Pop Up Modal untuk inputan Agen Baru -->
        
        <!-- Pop Up Modal untuk inputan Kendaraan Baru -->
        <div class="modal fade" id="mdlKendaraan" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Judul</h4>
                    </div>
                    <div class="modal-body">
                        <form class="eventInsForm" method="post" target="_self" name="frm_kendaraan" 
                              id="frm_kendaraan">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger display-hide">
                                        <button class="close" data-close="alert"></button>
                                        <span id="msg_kendaraan">&nbsp;</span>
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
                        <button type="button" class="btn blue" onClick="simpanKendaraan();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir Pop Up Modal untuk inputan Kendaraan baru -->
        
        <?php
            if( ($group_id==1)||($hak_akses['add_masuk']==1) ){
        ?>
        <div class="row">
            <div class="col-md-12">
                <a class="btn green" onclick="newAgen()">
                    <i class="fa fa-plus"></i> Daftar Agen</a>
                <a class="btn green" onclick="newKendaraan()">
                    <i class="fa fa-plus"></i> Daftar Kendaraan</a>
            </div>
            <br>&nbsp;
        </div>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-car"></i>Otorisasi Kendaraan - Masuk
                </div>
            </div>
            <div class="portlet-body">
                <form class="eventInsForm" method="post" target="_self" name="formku" 
                    id="formku">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <span id="msg_main">&nbsp;</span>
                        </div>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">Jenis Transaksi<font color="#f00">*</font></div>
                            <div class="col-md-8">
                                <select id="jenis_transaksi" name="jenis_transaksi" class="form-control myline select2me" 
                                        data-placeholder="Pilih Jenis Transaksi..." style="margin-bottom:5px" onclick="cekTransaksi(this.value);">
                                    <option value=""></option> 
                                    <option value="Jual">Jual</option> 
                                    <option value="Beli">Beli</option>
                                    <option value="Pakai">Pakai</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-8">
                                <small class="color:green"><i>BELI untuk singkong, cangkang <br>JUAL untuk sagu, onggok</i></small>
                            </div>
                        </div>                                               
                        
                        <div class="row" id="box_nama_agen">
                            <div class="col-md-4">Nama Agen <font color="#f00">*</font></div>
                            <div class="col-md-8">
                                <select id="m_agen_id" name="m_agen_id" class="form-control myline select2me" 
                                    data-placeholder="Pilih Agen..." style="margin-bottom:5px" 
                                    onclick="get_type_agen(this.value);">
                                    <option value=""></option>
                                    <?php
                                        foreach ($agen_list as $row){
                                            echo '<option value="'.$row->id.'">'.$row->nama_agen.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" id="box_jenis_agen">
                            <div class="col-md-4">Jenis Agen</div>
                            <div class="col-md-8">
                                <input type="text" id="type_agen" name="type_agen" class="form-control myline" 
                                       style="margin-bottom:5px" readonly="readonly">
                            </div>
                        </div>                        
                        
                        
                        <div class="row">
                            <div class="col-md-4">Kendaraan (No Polisi) <font color="#f00">*</font></div>
                            <div class="col-md-8">
                                <select id="m_kendaraan_id" name="m_kendaraan_id" class="form-control myline select2me" 
                                    data-placeholder="Pilih Kendaraan..." style="margin-bottom:5px">
                                    <option value=""></option>
                                    <?php
                                        foreach ($kendaraan_list as $row){
                                            echo '<option value="'.$row->id.'">'.$row->no_kendaraan.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Supir <font color="#f00">*</font></div>
                            <div class="col-md-8">
                                <input type="text" id="supir" name="supir" class="form-control myline" 
                                    style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">
                            </div>
                        </div>
                        
                        <div class="row" id="box_muatan" style="display:none">
                            <div class="col-md-4">Muatan</div>
                            <div class="col-md-8">
                                <select id="m_muatan_id" name="m_muatan_id" class="form-control myline select2me" 
                                        data-placeholder="Pilih Muatan..." style="margin-bottom:5px" onclick="cek_muatan(this.value);">
                                    <option value=""></option>
                                    <?php
                                        foreach ($muatan_list as $row){
                                            echo '<option value="'.$row->id.'">'.$row->nama_muatan.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div> 
                        <div class="row" id="box_deskripsi" style="display:none">
                            <div class="col-md-4">Dekripsi muatan <font color="#f00">*</font></div>
                            <div class="col-md-8">
                                <textarea id="deskripsi" name="deskripsi" class="form-control myline" 
                                          rows="2" onkeyup="this.value = this.value.toUpperCase()">                                    
                                </textarea>
                                <small><i>Jelaskan muatan secara lebih rinci</i></small>
                            </div>
                        </div>

                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-4">&nbsp;</div>
                            <div class="col-md-8">
                                <input type="button" onClick="simpandata();" name="btnSave" 
                                    value="Simpan" class="btn btn-primary" id="btnSave">
                                <a href="<?php echo base_url('index.php/Otorisasi/otorisasi_masuk'); ?>" class="btn btn-default">
                                    Batal</a>
                            </div>
                        </div>
                    </div>   
                    
                    <div class="col-md-8" id="box_penjualan" style="display:none">
                        <div class="portlet box blue-chambray">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-truck"></i>Rincian produk yang dibeli
                                </div>
                            </div>
                            <div class="portlet-body">
                                
                                <div class="row">
                                    <div class="col-md-3">Item</div>
                                    <div class="col-md-3">Type</div>
                                    <div class="col-md-2">Sak (Kg)</div>
                                    <div class="col-md-2">Jumlah</div>
                                    <div class="col-md-2">&nbsp;</div>
                                </div>
                                <?php
                                    for($i=0;$i<9; $i++){
                                        $j=$i+1;
                                ?>
                            
                                <div class="row" id="row_muatan<?php echo $j; ?>">
                                    <div class="col-md-3">
                                        <select id="item_<?php echo $j; ?>" name="mymuatan[<?php echo $j; ?>][item]" 
                                            class="form-control myline select2me" 
                                            data-placeholder="Pilih item..." style="margin-bottom:5px">
                                            <option value=""></option>
                                            <option value="SAGU">SAGU</option>
                                            <option value="ONGGOK">ONGGOK</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="type_<?php echo $j; ?>" name="mymuatan[<?php echo $j; ?>][type]" 
                                            class="form-control myline select2me" 
                                            data-placeholder="Pilih type..." style="margin-bottom:5px">
                                            <option value=""></option>
                                            <option value="PULAU">PULAU</option>
                                            <option value="KWR">KWR</option>
                                            <option value="PH">PH</option>
                                            <option value="POLOS">POLOS</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select id="sak_<?php echo $j; ?>" name="mymuatan[<?php echo $j; ?>][sak]" 
                                            class="form-control myline select2me" 
                                            data-placeholder="Pilih sak..." style="margin-bottom:5px">
                                            <option value=""></option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" id="jumlah_<?php echo $j; ?>" name="mymuatan[<?php echo  $j; ?>][jumlah]" 
                                               class="form-control myline" onkeydown="return myCurrency(event);" maxlength="3">
                                    </div>
                                    <div class="col-md-2">
                                    <?php
                                        if($i>0){
                                    ?>
                                        <a href="javascript:;" class="btn red" onclick="remove_row(<?php echo $j; ?>);">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    <?php
                                        }
                                        if($j<9){
                                    ?>
                                        <a href="javascript:;" class="btn green" onclick="add_row(<?php echo $j; ?>);" id="btnAdd<?php echo $j; ?>">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    <?php } ?>    
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                </form>   
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
function simpandata(){
    $('#btnSave').attr("disabled", true); 
    var jns_transaksi = $('#jenis_transaksi').val();
    console.log(jns_transaksi);
    if($.trim($("#jenis_transaksi").val()) == ""){
        $('#msg_main').html("Pilih dulu jenis transaksi!");
        $('.alert-danger').show();
        $('#btnSave').attr("disabled", false);    
    }else if($.trim($("#m_kendaraan_id").val()) == ""){
        $('#msg_main').html("Kendaraan (no polisi) harus diisi!");
        $('.alert-danger').show();
        $('#btnSave').attr("disabled", false);
    }else if($.trim($("#supir").val()) == ""){
        $('#msg_main').html("Nama supir harus diisi!");
        $('.alert-danger').show();
        $('#btnSave').attr("disabled", false);
        
    }else if($.trim($("#m_agen_id").val()) == ""){
        $('#msg_main').html("Nama agen harus diisi!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);

        
    }else{ 
        if((jns_transaksi=="Beli")&&($.trim($("#m_muatan_id").val()) == "")){
            $('#msg_main').html("Silahkan pilih muatan!");
            $('.alert-danger').show();
            $('#btnSave').attr("disabled", false);
        }else{
            //Validasi nomor kendaraan, cek apakah nomor kendaraan ada di dalam
            $.ajax({
                type:"POST",
                url:'<?php echo base_url('index.php/Otorisasi/cek_kendaraan_masuk'); ?>',
                data:"data="+$("#m_kendaraan_id").val(),
                success:function(result){
                    //console.log(result);
                    if(result=="ADA"){                        
                        $('#msg_main').html("Cek kembali nomor kendaraan yang anda input!<br>\n\
                            Nomor tersebut masih tercatat di system dan belum melakukan otorisasi keluar.");
                        $('.alert-danger').show();
                        $('#btnSave').attr("disabled", false);
                    }else{
                        $('#msg_main').html("");
                        $('.alert-danger').hide();
                        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Otorisasi/save_masuk");
                        
                        //Validasi untuk pembelian singkong, hanya boleh ada 2 truck di dalam, tp bisa overwrite jika 
                        //ada kendaraan mogok di dalam
                        if((jns_transaksi=="Beli")&&($.trim($("#m_muatan_id").val()) == "1")){
                            $.ajax({
                                type:"POST",
                                url:'<?php echo base_url('index.php/Otorisasi/cek_kendaraan_masuk'); ?>',
                                data:"data="+$("#m_kendaraan_id").val(),
                                success:function(result){
                                    //console.log(result);
                                    if(result=="ADA"){                        
                                        if(confirm('Maaf, dalam kondisi NORMAL untuk transaksi pembelian SINGKONG hanya boleh 2 \n\
                                            kendaraan yang masuk. Kecuali jika ada kondisi tertentu yang memungkinkan override kendaraan. \n\
                                            Apakah anda ingin melakukan proses override?'))
                                        {
                                            $('#formku').submit();
                                        }else{
                                            return false;
                                        }
                                    }else{
                                        $('#formku').submit();                  
                                    }
                                }
                            }); 
                        }else{
                            $('#formku').submit();
                        }  
                    }
                }
            });               
        }
    };
};

function newAgen(){
    $('#nama_agen').val('');
    $('#alamat').val('');
    $('#pic').val('');
    $('#telepon').val('');
    
    $("#mdlAgen").find('.modal-title').text('Tambah Agen');
    $("#mdlAgen").modal('show',{backdrop: 'true'}); 
}

function simpanAgen(){
    if($.trim($("#nama_agen").val()) == ""){
        $('#msg_agen').html("Nama agen harus diisi!");
        $('.alert-danger').show();
    }else{      
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/MAgen/cek_code'); ?>',
            data:"data="+$("#nama_agen").val(),
            success:function(result){
                //console.log(result);
                if(result=="ADA"){
                    $('#msg_agen').html("Nama agen sudah ada, silahkan ganti dengan nama lain!");
                    $('.alert-danger').show();
                }else{
                    $('#msg_agen').html("");
                    $('.alert-danger').hide();
                    $('#frm_agen').attr("action", "<?php echo base_url(); ?>index.php/Otorisasi/save_agen");
                    $('#frm_agen').submit();                    
                }
            }
        });
    };
};

function newKendaraan(){
    $('#no_kendaraan').val('');
    $('#m_type_kendaraan_id').select2('val','');
    $('#keterangan').val('');
    
    $("#mdlKendaraan").find('.modal-title').text('Tambah Kendaraan');
    $("#mdlKendaraan").modal('show',{backdrop: 'true'}); 
}

function simpanKendaraan(){
    if($.trim($("#no_kendaraan").val()) == ""){
        $('#msg_kendaraan').html("No Polisi harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#m_type_kendaraan_id").val()) == ""){
        $('#msg_kendaraan').html("Silahkan pilih type kendaraan!");
        $('.alert-danger').show();
    }else{      
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/MKendaraan/cek_code'); ?>',
            data:"data="+$("#no_kendaraan").val(),
            success:function(result){
                //console.log(result);
                if(result=="ADA"){
                    $('#msg_kendaraan').html("Nomor polisi sudah dipakai kendaraan lain, silahkan ganti!");
                    $('.alert-danger').show();
                }else{
                    $('#msg_kendaraan').html("");
                    $('.alert-danger').hide();
                    $('#frm_kendaraan').attr("action", "<?php echo base_url(); ?>index.php/Otorisasi/save_kendaraan");
                    $('#frm_kendaraan').submit();                    
                }
            }
        });
    };
};

function get_type_agen(id){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('index.php/Otorisasi/get_type_agen'); ?>",
        data: {id: id},
        cache: false,
        success: function(result) {
            $("#type_agen").val(result['jenis_agen']);
        } 
    });
}

function cekTransaksi(type){
    if(type=="Beli"){        
        $('#box_muatan').show(200);
        $('#box_penjualan').hide(200);
    }else if(type=="Pakai"){        
        $('#box_muatan').show(200);
        $('#box_penjualan').hide(200);
        $('#box_deskripsi').hide(200);
    }else{        
        $('#box_muatan').hide(200);
        $('#box_penjualan').show(200);
        $('#box_deskripsi').hide(200);
    }
}

function cek_muatan(id){
    if(id=="10"){
        $('#box_deskripsi').show(200);
    }else{
        $('#box_deskripsi').hide(200);
    }
}

function remove_row(id){    
    $('#row_muatan'+id).hide();
    var ta = Number(id)-1;
    $('#btnAdd'+ta).show();
}

function add_row(id){
    $('#btnAdd'+id).hide();
    var ta = Number(id)+1;
    $('#row_muatan'+ta).show();
}

function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>