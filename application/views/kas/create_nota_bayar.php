<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$(function(){ 
    $("#tanggal").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>img/Kalender.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    });     
    
});
</script>
<div class="row">                            
    <div class="col-md-12"> 
        <form class="eventInsForm" method="post" target="_self" name="formku" 
            id="formku" action="<?php echo base_url('index.php/Kas/save_bayar_nota'); ?>">
         <div class="portlet box red">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-calculator"></i>Bayar Nota
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                Tanggal <font color="#f00">*</font>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="tanggal" name="tanggal" 
                                    class="form-control myline input-small" style="margin-bottom:5px; float:left" 
                                    value="<?php echo date('d-m-Y'); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                Dibuat oleh <font color="#f00">*</font>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="nama_kasir" name="nama_kasir" 
                                    class="form-control myline" style="margin-bottom:5px;" 
                                    value="<?php echo $mydata['realname']; ?>" readonly="readonly">
                            </div>
                        </div>
                    </div>                    
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                Nomor Nota <font color="#f00">*</font>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="no_nota" name="no_nota" 
                                    class="form-control myline" style="margin-bottom:5px;" 
                                    value="Auto generate by system" readonly="readonly">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                Transaksi di terima <font color="#f00">*</font>
                            </div>
                            <div class="col-md-7">
                                <select id="tempat_transaksi" name="tempat_transaksi" class="form-control myline select2me" 
                                    data-placeholder="Pilih tempat..." style="margin-bottom:5px">
                                    <option value=""></option>
                                    <option value="Pabrik">Pabrik</option>
                                    <option value="Kantor">Kantor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="portlet box blue-chambray">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-car"></i>Data Kendaraan
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        No Polisi
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="no_kendaraan" name="no_kendaraan" 
                                            class="form-control myline" style="margin-bottom:5px;" 
                                            value="<?php echo $mydata['no_kendaraan']; ?>" readonly="readonly">
                                        
                                        <input type="hidden" id="m_kendaraan_id" name="m_kendaraan_id" 
                                            value="<?php echo $mydata['m_kendaraan_id']; ?>">
                                        <input type="hidden" id="m_agen_id" name="m_agen_id" 
                                            value="<?php echo $mydata['m_agen_id']; ?>">
                                        <input type="hidden" id="id" name="id" 
                                            value="<?php echo $mydata['id']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        Nama Agen
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="nama_agen" name="nama_agen" 
                                            class="form-control myline" style="margin-bottom:5px;" 
                                            value="<?php echo $mydata['nama_agen']; ?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        Sopir
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="supir" name="supir" 
                                            class="form-control myline" style="margin-bottom:5px;" 
                                            value="<?php echo $mydata['supir']; ?>" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="portlet box blue-chambray">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-file-archive-o"></i>Data Pembayaran
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        Jenis Barang
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="jenis_barang" name="jenis_barang" 
                                            class="form-control myline" style="margin-bottom:5px;" 
                                            value="<?php echo $mydata['nama_muatan']; ?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        Netto (Kg)
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="berat_bersih" name="berat_bersih" 
                                            class="form-control myline" style="margin-bottom:5px;" 
                                            value="<?php echo number_format($mydata['berat_bersih'],0,',','.'); ?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        Harga <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="harga" name="harga" 
                                            class="form-control myline" style="margin-bottom:5px;" 
                                            value="<?php echo number_format($mydata['harga'],0,',','.'); ?>"
                                            maxlength="15" onkeydown="return myCurrency(event);" 
                                            onkeyup="getComa(this.value);">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        Total Harga <font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="total_harga" name="total_harga" 
                                            class="form-control myline" style="margin-bottom:5px;" readonly="readonly"
                                            value="<?php echo number_format($mydata['total_harga'],0,',','.'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        Catatan<br>
                        <textarea id="catatan" name="catatan" class="form-control myline" rows="3"></textarea>
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
                <input type="button" onClick="simpandata();" name="btnSave" 
                    value="Simpan" class="btn btn-primary" id="btnSave">
                <a href="<?php echo base_url('index.php/TBayar/create_pembayaran'); ?>" class="btn btn-default">
                    Batal</a>
            </div>                
        </div>
        </form>
    </div>
</div>  

<script>    
function simpandata(){	    
    if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();   
    }else if($.trim($("#tempat_transaksi").val()) == ""){
        $('#message').html("Silahkan pilih tempat transaksi!");
        $('.alert-danger').show();  
    }else if($.trim($("#harga").val()) == ""){
        $('#message').html("Harga harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();  
    }else{
        $('#btnSave').attr("disabled", true);        
        $('#formku').submit();
    };
};

function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function getComa(nilai){
    $('#harga').val(nilai.toString().replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}
</script>
        