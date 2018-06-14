<div class="row">                            
    <div class="col-md-12">   
        <?php
            if( ($group_id==1)||($hak_akses['beli_cangkang_timbang_kedua']==1) ){
        ?>
        <form class="eventInsForm" method="post" target="_self" name="formku" 
            id="formku" action="<?php echo base_url('index.php/Pembelian/save_beli_cangkang_timbang_kedua'); ?>">
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-car"></i>BELI CANGKANG - Proses Timbang 2
                </div>                
            </div>
            <div class="portlet-body">                
                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend> Info Kendaraan </legend>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama Agen
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_agen" name="nama_agen" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $data_otorisasi['nama_agen']; ?>">
                                    <input type="hidden" id="otorisasi_id" name="otorisasi_id" 
                                        value="<?php echo $data_otorisasi['id']; ?>">
                                    <input type="hidden" id="timbang_id" name="timbang_id" 
                                        value="<?php echo $timbang1['id']; ?>">
                                    
                                    <input type="hidden" id="m_agen_id" name="m_agen_id" 
                                        value="<?php echo $data_otorisasi['m_agen_id']; ?>">
                                    <input type="hidden" id="m_kendaraan_id" name="m_kendaraan_id" 
                                        value="<?php echo $data_otorisasi['m_kendaraan_id']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Jenis Agen
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jenis_agen" name="jenis_agen" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $data_otorisasi['jenis_agen']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Kendaraan (No Polisi)
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_kendaraan" name="no_kendaraan" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $data_otorisasi['no_kendaraan']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Type Kendaraan
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="type_kendaraan" name="type_kendaraan" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $data_otorisasi['type_kendaraan']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                   Nama Supir
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="supir" name="supir" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo $data_otorisasi['supir']; ?>">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend> Data Timbangan </legend>
                            <div class="row">
                                <div class="col-md-5">
                                   Berat #1 (Kg)<font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="berat_timbang1" name="berat_timbang1" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo number_format($timbang1['berat1'],0,',','.');?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                   Berat #2 (Kg)<font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="berat_timbang2" name="berat_timbang2" class="form-control myline" 
                                        style="margin-bottom:5px" onkeydown="return myCurrency(event);" onkeyup="hitungBruto(this.value);">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                   Bruto (Kg)<font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="berat_kotor" name="berat_kotor" class="form-control myline" 
                                        style="margin-bottom:5px" readonly="readonly">
                                    
                                    <input type="hidden" id="berat_bersih" name="berat_bersih">
                                </div>
                            </div>
                        </fieldset>
                        
                    </div>
                    <div class="col-md-6">
                        <fieldset>
                            <legend> Transaksi </legend>
                            <div class="row">
                                <div class="col-md-5">
                                    Muatan
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_muatan" name="nama_muatan" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo $data_otorisasi['nama_muatan']; ?>">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Jenis Transaksi
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jenis_transaksi" name="jenis_transaksi" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo $data_otorisasi['jenis_transaksi']; ?>">
                                </div>
                            </div> 
                        </fieldset>
                        
                        <fieldset>
                            <legend> Perhitungan Harga </legend>                                                     
                            <div class="row">
                                <div class="col-md-5">
                                    Harga Cangkang (Rp/ Kg) <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="harga" name="harga" class="form-control myline" 
                                        style="margin-bottom:5px" onkeydown="return myCurrency(event);" 
                                        onkeyup="hitungTotalHarga();" readonly="readonly"
                                        value="<?php echo number_format($harga_cangkang,0,',', '.'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Total Harga (Rp) <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="total_harga" name="total_harga" class="form-control myline" 
                                        style="margin-bottom:5px" readonly="readonly">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">Keterangan</div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea id="keterangan" name="keterangan" class="form-control myline" 
                                        rows="5" onkeyup="this.value = this.value.toUpperCase()"></textarea>
                                </div>
                            </div>
                        </fieldset>
                        
                    </div>
                </div>                
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span id="message">&nbsp;</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                &nbsp;<br>
                <input type="button" onClick="simpandata();" name="btnSave" 
                    value="Simpan" class="btn btn-primary" id="btnSave">
                <a href="<?php echo base_url('index.php/Pembelian/index/CANGKANG/Beli'); ?>" class="btn btn-default">
                    Kembali</a>
            </div>
        </div>
        </form>
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
function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function simpandata(){    
    $('#btnSave').attr("disabled", true); 
    if($.trim($("#berat_timbang2").val()) == ""){
        $('#message').html("Berat timbang 2 harus diisi!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    }else if($.trim($("#berat_kotor").val()) == ""){
        $('#message').html("Berat kotor harus diisi!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    
    }else if($.trim($("#harga").val()) == ""){
        $('#message').html("Harga harus diisi!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    }else if($.trim($("#total_harga").val()) == ""){
        $('#message').html("Total harga harus diisi!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    }else{        
        $('#message').html("");
        $('.alert-danger').hide();
        $('#formku').submit();                    
    };
};

function hitungBruto(berat2){
    var berat1 = $('#berat_timbang1').val().toString().replace(/\./g, "");
    bruto = Number(berat1)- Number(berat2);
    $('#berat_kotor').val(bruto);
    $('#berat_bersih').val(bruto);
    hitungTotalHarga();
}

function hitungTotalHarga(){
    var netto  = $('#berat_bersih').val();
    var harga  = $('#harga').val().toString().replace(/\./g, "");
    totalHarga = Number(harga)* Number(netto);
    
    $('#total_harga').val(totalHarga.toString().replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}

</script>