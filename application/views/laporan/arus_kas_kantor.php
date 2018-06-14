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
                                    Uraian <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <textarea id="uraian" name="uraian" class="form-control myline" 
                                        style="margin-bottom:5px;" rows="4" onkeyup="this.value = this.value.toUpperCase()"></textarea>
                                </div>
                            </div>                            
                            <div class="row">                                
                                <div class="col-md-5">
                                    D/K <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="dk" name="dk" class="form-control myline select2me" 
                                        data-placeholder="Pilih..." style="margin-bottom:5px">
                                        <option value="D" selected="selected">Debet</option>
                                        <option value="K">Kredit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-5">
                                    Jumlah Adjustment <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jumlah" name="jumlah" class="form-control myline" 
                                        style="margin-bottom:5px" onkeydown="return myCurrency(event);" 
                                        onkeyup="getComa(this.value);">
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-5">
                                    No. Referensi<br>
                                    <small><i>Masukkan no. referensi jika ada</i></small>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_referensi" name="no_referensi" class="form-control myline" 
                                        style="margin-bottom:5px" onkeyup="this.value = this.value.toUpperCase()">
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
            if( ($group_id==1)||($hak_akses['arus_kas']==1) ){
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
                <div class="row" style="margin-bottom:5px">
                    <div class="col-md-6">
                        <?php
                            if( ($group_id==1)||($hak_akses['print_arus_kas_kantor']==1) ){
                                echo '<a href="'.base_url().'index.php/Laporan/print_arus_kas_kantor" class="btn green">
                                        <i class="fa fa-print"></i> Export to Excel </a> &nbsp;';
                            }
                            
                            if( ($group_id==1)||($hak_akses['adjustment_kas']==1) ){
                                echo '<a href="javascript:;" class="btn red-flamingo" onclick="editKas();">
                                    <i class="fa fa-edit"></i> Adjustment Kas </a>';
                            }
                        ?>                        
                    </div>
                    <div class="col-md-6" style="text-align:right">
                        <strong>Saldo Awal : Rp. <?php echo number_format($saldo,0,',','.'); ?></strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>Laporan Arus Kas - Kantor
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th> 
                    <th>Uraian</th>
                    <th>D/K</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                    <th>No Referensi</th> 
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0;
                        foreach ($list_data as $data){
                            $no++;
                    ?>
                    <tr>
                        <td style="text-align:center"><?php echo $no; ?></td>                        
                        <td><?php echo date('d/m/Y', strtotime($data->tanggal)); ?></td>
                        <td><?php echo $data->uraian; ?></td>
                        <td style="text-align:center"><?php echo $data->dk; ?></td>                        
                        <td style="text-align:right;color:blue"><?php echo number_format($data->debet,0,',','.'); ?></td>
                        <td style="text-align:right;color:red"><?php echo number_format($data->kredit,0,',','.'); ?></td>
                        <td style="text-align:right;color:blue"><?php echo number_format($data->saldo,0,',','.'); ?></td>
                        <td><?php echo $data->no_referensi; ?></td>                                                
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
function editKas(){  
    $("#jumlah").val('');
    $("#uraian").val('');
    $("#no_referensi").val('');
    
    $("#myModal").find('.modal-title').text('Adjustment Kas - Kantor');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){    
    if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else if($.trim($("#uraian").val()) == ""){
        $('#message').html("Uraian harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();    
    }else if($.trim($("#jumlah").val()) == ""){
        $('#message').html("Jumlah harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();      
    }else{   
        $('#message').html("");
        $('.alert-danger').hide();
        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Laporan/save_adjustment_kas_kantor");
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
    $('#jumlah').val(nilai.toString().replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}
</script>