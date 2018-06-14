<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$(function(){    
    for(i=1;i<10;i++){
        j = i+1;
      if($.trim($('#item_'+j).val())==""){
           $('#row_muatan'+j).hide();
        }else{
           $('#row_muatan'+j).show();
        }
    }
});
</script>
<div class="row">                            
    <div class="col-md-12">
        <?php
            if( ($group_id==1)||($hak_akses['edit_masuk']==1) ){
        ?>        
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-car"></i>Edit Otorisasi Kendaraan - Masuk
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
                                    <option value="<?php echo $mydata['jenis_transaksi']; ?>" selected="selected">
                                        <?php echo $mydata['jenis_transaksi']; ?>
                                    </option> 
                                    <option value="Jual">Jual</option> 
                                    <option value="Beli">Beli</option>
                                    <option value="Beli">Pakai</option>
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
                                    <option value="<?php echo $mydata['m_agen_id']; ?>" selected="selected">
                                        <?php echo $mydata['nama_agen']; ?></option>
                                    <?php
                                        foreach ($agen_list as $row){
                                            echo '<option value="'.$row->id.'">'.$row->nama_agen.'</option>';
                                        }
                                    ?>
                                </select>
                                <input type="hidden" id="id" name="id" value="<?php echo $mydata['id']; ?>">
                            </div>
                        </div>
                        <div class="row" id="box_jenis_agen">
                            <div class="col-md-4">Jenis Agen</div>
                            <div class="col-md-8">
                                <input type="text" id="type_agen" name="type_agen" class="form-control myline" 
                                       style="margin-bottom:5px" readonly="readonly" value="<?php echo $mydata['jenis_agen']; ?>">
                            </div>
                        </div>                        
                                                
                        <div class="row">
                            <div class="col-md-4">Kendaraan (No Polisi) <font color="#f00">*</font></div>
                            <div class="col-md-8">
                                <select id="m_kendaraan_id" name="m_kendaraan_id" class="form-control myline select2me" 
                                    data-placeholder="Pilih Kendaraan..." style="margin-bottom:5px">
                                    <option value="<?php echo $mydata['m_kendaraan_id']; ?>" selected="selected">
                                        <?php echo $mydata['no_kendaraan']; ?></option>
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
                                       style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()" 
                                       value="<?php echo $mydata['supir']; ?>">
                            </div>
                        </div>
                        
                        <div class="row" id="box_muatan" <?php echo ($mydata['jenis_transaksi']=='Jual')? 'style="display:none"': '';?>>
                            <div class="col-md-4">Muatan</div>
                            <div class="col-md-8">
                                <select id="m_muatan_id" name="m_muatan_id" class="form-control myline select2me" 
                                    data-placeholder="Pilih Muatan..." style="margin-bottom:5px" onclick="cek_muatan(this.value);">
                                    <option value="<?php echo $mydata['m_muatan_id']; ?>" selected="selected">
                                        <?php echo $mydata['nama_muatan']; ?></option>
                                    <?php
                                        foreach ($muatan_list as $row){
                                            echo '<option value="'.$row->id.'">'.$row->nama_muatan.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" id="box_deskripsi" <?php echo ($mydata['m_muatan_id']<10)? 'style="display:none"': '';?>>
                            <div class="col-md-4">Dekripsi muatan <font color="#f00">*</font></div>
                            <div class="col-md-8">
                                <textarea id="deskripsi" name="deskripsi" class="form-control myline" rows="2"> 
                                <?php echo $mydata['deskripsi']; ?>
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
                                <a href="<?php echo base_url('index.php/TOtorisasi/otorisasi_masuk'); ?>" class="btn btn-default">
                                    Batal</a>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-8" id="box_penjualan" <?php echo ($mydata['jenis_transaksi']=='Beli')? 'style="display:none"': '';?>>
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
                                        <?php
                                            if(isset($myproduk[$i]->item)&& !empty($myproduk[$i]->item)){
                                                echo "<option value='".$myproduk[$i]->item."' selected='selected'>".$myproduk[$i]->item."</option>";
                                            }else{
                                                echo "<option value=''></option>";
                                            }
                                        ?>
                                            <option value="SAGU">SAGU</option>
                                            <option value="ONGGOK">ONGGOK</option>
                                        </select>
                                        <input type="hidden" name="mymuatan[<?php echo $j; ?>][id]" 
                                            value="<?php echo (isset($myproduk[$i]->id))? $myproduk[$i]->id: '';?>">
                                    </div>
                                    <div class="col-md-3">
                                        <select id="type_<?php echo $j; ?>" name="mymuatan[<?php echo $j; ?>][type]" 
                                            class="form-control myline select2me" 
                                            data-placeholder="Pilih type..." style="margin-bottom:5px">
                                        <?php
                                            if(isset($myproduk[$i]->type_produk)&& !empty($myproduk[$i]->type_produk)){
                                                echo "<option value='".$myproduk[$i]->type_produk."' selected='selected'>".$myproduk[$i]->type_produk."</option>";
                                            }else{
                                                echo "<option value=''></option>";
                                            }
                                        ?>
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
                                        <?php
                                            if(isset($myproduk[$i]->sak)&& !empty($myproduk[$i]->sak)){
                                                echo "<option value='".$myproduk[$i]->sak."' selected='selected'>".$myproduk[$i]->sak."</option>";
                                            }else{
                                                echo "<option value=''></option>";
                                            }
                                        ?>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" id="jumlah_<?php echo $j; ?>" name="mymuatan[<?php echo  $j; ?>][jumlah]" 
                                            class="form-control myline" onkeydown="return myCurrency(event);" maxlength="3" 
                                            value="<?php echo (isset($myproduk[$i]->jumlah)&& !empty($myproduk[$i]->jumlah))? $myproduk[$i]->jumlah: ""; ?>">
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
            $('#msg_main').html("");
            $('.alert-danger').hide();
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/TOtorisasi/update_masuk");
            $('#formku').submit();             
        }
    };
};

function get_type_agen(id){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('index.php/TOtorisasi/get_type_agen'); ?>",
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