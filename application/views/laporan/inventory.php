<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$(function(){  
    window.setTimeout(function() { $(".alert-success").hide(); }, 4000);
    
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
                                    Tanggal <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="tanggal" name="tanggal" 
                                        class="form-control myline input-small" style="margin-bottom:5px;float:left" 
                                        value="<?php echo date('d-m-Y'); ?>">
                                </div>
                            </div>    
                            <div class="row">                                
                                <div class="col-md-5">
                                    Nama CV <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="adjustment_cv" name="adjustment_cv" class="form-control myline select2me" 
                                        data-placeholder="Pilih nama CV..." style="margin-bottom:5px">
                                        <option value="" selected="selected">Pabrik</option>
                                        <?php
                                            foreach ($list_cv as $row){
                                                echo '<option value="'.$row->id.'">'.$row->nama_cv.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-5">
                                    Nama Barang/ Produk <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="nama_produk" name="nama_produk" class="form-control myline select2me" 
                                        data-placeholder="Pilih nama CV..." style="margin-bottom:5px">
                                        <?php
                                            foreach ($list_produk as $row){
                                                echo '<option value="'.$row->nama_produk.'">'.$row->nama_produk.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-5">
                                    Sak
                                </div>
                                <div class="col-md-7">
                                    <select id="sak" name="sak" class="form-control myline select2me" 
                                        data-placeholder="Pilih sak..." style="margin-bottom:5px">
                                        <option value="25" selected="selected">25 Kg</option>
                                        <option value="50">50 Kg</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-5">
                                    Type Adjustment <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="type_adjustment" name="type_adjustment" class="form-control myline select2me" 
                                        data-placeholder="Pilih type adjustment..." style="margin-bottom:5px">
                                        <option value="minus" selected="selected">Mengurangi stok</option>
                                        <option value="plus">Menambah stok</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-5">
                                    Jumlah Adjustment <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jumlah" name="jumlah" class="form-control myline" 
                                        style="margin-bottom:5px" onkeydown="return myCurrency(event);" onkeyup="getComa(this.value);">
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-5">
                                    Catatan <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <textarea id="catatan" name="catatan" class="form-control myline" 
                                        style="margin-bottom:5px" rows="3" onkeyup="this.value = this.value.toUpperCase()"></textarea>
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
            if( ($group_id==1)||($hak_akses['inventory']==1) ){
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <form accept-charset="utf-8" action="<?php echo base_url().'index.php/Laporan/inventory'; ?>" 
                    method="post" id="frm_search">
                <fieldset>
                    <legend>Filter Data</legend>
                    <div class="row">
                        <div class="col-md-1">
                            Nama CV
                        </div>
                        <div class="col-md-3">                            
                            <select id="m_cv_id" name="m_cv_id" class="form-control myline select2me" 
                                data-placeholder="Pilih nama CV..." style="margin-bottom:5px">
                                <option value=""></option>
                                <?php
                                    foreach ($list_cv as $row){
                                        if($parameter==$row->id){
                                            echo '<option value="'.$row->id.'" selected="selected">'.$row->nama_cv.'</option>';
                                        }else{
                                            echo '<option value="'.$row->id.'">'.$row->nama_cv.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="btn green" id="btnSubmit" 
                                name="btnSubmit" value=" Search "> &nbsp;

                            <a href="<?php echo base_url().'index.php/Laporan/inventory'; ?>" class="btn default">
                                <i class="fa fa-times"></i> Reset </a>
                        </div>
                        
                        <div class="col-md-5" style="text-align:right;">
                            <?php
                                if( ($group_id==1)||($hak_akses['print_inventory']==1) ){
                                    echo '<a href="'.base_url().'index.php/Laporan/print_inventory/'.$parameter.'" 
                                        class="btn green" style="margin-right:0">
                                            <i class="fa fa-print"></i> Export to Excel </a>';
                                }
                            ?>
                            
                            <a href="javascript:;" class="btn red-flamingo" onclick="editStok();">
                                <i class="fa fa-edit"></i> Adjustment Stok </a>
                        </div>
                    </div>
                    
                </fieldset>
                </form>    
            </div>            
        </div>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>List Inventory
                </div>
            </div>
            <div class="portlet-body">
                <?php echo $myTable; ?>
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
function editStok(){  
    $("#jumlah").val('');
    $("#catatan").val('');
    
    $("#myModal").find('.modal-title').text('Adjustment Stok');
    $("#myModal").modal('show',{backdrop: 'true'}); 
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

function simpandata(){    
    if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else if($.trim($("#adjustment_cv").val()) == ""){
        $('#message').html("Pilih dulu nama CV!");
        $('.alert-danger').show();    
    }else if($.trim($("#nama_produk").val()) == ""){
        $('#message').html("Pilih dulu produk!");
        $('.alert-danger').show();  
    }else if($.trim($("#jumlah").val()) == ""){
        $('#message').html("Jumlah harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();  
    }else if($.trim($("#catatan").val()) == ""){
        $('#message').html("Catatan harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();
    }else{   
        $('#message').html("");
        $('.alert-danger').hide();
        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Laporan/save_adjustment_stok");
        $('#formku').submit();
    };
};
</script>