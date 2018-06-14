<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$( function() {    
    $("#tanggal").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>img/Kalender.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    });       
} );
</script>
<div class="row">                            
    <div class="col-md-12"> 
        <div class="modal fade" id="myApproveModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Judul</h4>
                    </div>
                    <div class="modal-body">
                        <form class="eventInsForm" method="post" target="_self" name="frm_approve" 
                              id="frm_approve">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger display-hide" id="box_error_approve">
                                        <button class="close" data-close="alert"></button>
                                        <span id="msg_error_approve">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            Tanggal <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="tanggal" name="tanggal" 
                                                class="form-control myline input-small" style="margin-bottom:5px;float:left">
                                            
                                            <input type="hidden" id="id" name="id">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Nomor Nota <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="no_nota" name="no_nota" 
                                                class="form-control myline" style="margin-bottom:5px;" 
                                                readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Dibuat oleh <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="nama_kasir" name="nama_kasir" 
                                                class="form-control myline" style="margin-bottom:5px;" 
                                                readonly="readonly">
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            Transaksi diterima <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
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
                            <div class="row">                                
                                <div class="col-md-12">                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            Uraian  <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea id="uraian" name="uraian" class="form-control myline" 
                                                rows="5" style="margin-bottom:5px;" ></textarea>
                                        </div>
                                    </div>                                            
                                    <div class="row">
                                        <div class="col-md-4">
                                            Jumlah (Rp)<font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="jumlah" name="jumlah" 
                                                class="form-control myline" style="margin-bottom:5px;"                                                         
                                                maxlength="15" onkeydown="return myCurrency(event);" 
                                                onkeyup="getComa(this.value);">
                                        </div>
                                    </div>                                          
                                        
                                </div>
                            </div>                            
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" onClick="saveApproveBiaya();">Approve</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="myCancelModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Judul</h4>
                    </div>
                    <div class="modal-body">
                        <form class="eventInsForm" method="post" target="_self" name="frm_cancel" 
                              id="frm_cancel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger display-hide" id="box_error_cancel">
                                        <button class="close" data-close="alert"></button>
                                        <span id="msg_error_cancel">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            Tanggal <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="tanggal_cancel" name="tanggal" 
                                                class="form-control myline" style="margin-bottom:5px;" readonly="readonly">
                                            
                                            <input type="hidden" id="header_id" name="id">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Nomor Nota <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="no_nota_cancel" name="no_nota" 
                                                class="form-control myline" style="margin-bottom:5px;" 
                                                readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Dibuat oleh <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="nama_kasir_cancel" name="nama_kasir" 
                                                class="form-control myline" style="margin-bottom:5px;" 
                                                readonly="readonly">
                                        </div>
                                    </div>                                                                     
                                </div>                                 
                            </div>
                            <div class="row">                                
                                <div class="col-md-12">                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            Uraian  <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea id="uraian_cancel" name="uraian" class="form-control myline" 
                                                      rows="5" style="margin-bottom:5px;" readonly="readonly"></textarea>
                                        </div>
                                    </div>                                            
                                    <div class="row">
                                        <div class="col-md-4">
                                            Jumlah (Rp)<font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="jumlah_cancel" name="jumlah" 
                                                class="form-control myline" style="margin-bottom:5px;"                                                         
                                                readonly="">
                                        </div>
                                    </div>                                          
                                    <div class="row">
                                        <div class="col-md-4">
                                            Alasan Pembatalan  <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea id="alasan_cancel" name="alasan_cancel" class="form-control myline" 
                                                rows="5" style="margin-bottom:5px;"></textarea>
                                        </div>
                                    </div>     
                                </div>
                            </div>                            
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" onClick="saveCancelBiaya();">Batalkan Biaya</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if( ($group_id==1)||($hak_akses['list_nota_bayar']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>Pengakuan Biaya
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>   
                    <th>No Referensi</th> 
                    <th>Oleh</th> 
                    <th>Uraian</th>  
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
                        <td style="text-align:center"><?php echo $no; ?></td>                        
                        <td><?php echo date('d/m/Y', strtotime($data->tanggal)); ?></td>
                        <td><?php echo $data->no_referensi; ?></td>
                        <td><?php echo $data->realname; ?></td>
                        <td><?php echo $data->uraian; ?></td>
                        <td style="text-align:right;color:blue"><?php echo number_format($data->jumlah,0,',','.'); ?></td>
                        <td style="text-align:center"> 
                            <?php
                                if( ($group_id==1)||($hak_akses['approve_biaya']==1) ){
                            ?>
                            <a class="btn btn-circle btn-xs green" onclick="approveBiaya(<?php echo $data->id; ?>)" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Approve &nbsp; </a>
                            <?php } 
                                if( ($group_id==1)||($hak_akses['cancel_biaya']==1) ){
                            ?>
                            <a class="btn btn-circle btn-xs red" onclick="cancelBiaya(<?php echo $data->id; ?>)" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-trash"></i> Batalkan &nbsp; </a>
                            <?php } ?>    
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
function saveApproveBiaya(){	    
    if($.trim($("#tempat_transaksi").val()) == ""){
        $('#msg_error_approve').html("Silahkan pilih tempat transaksi!");
        $('#box_error_approve').show();  
    }else if($.trim($("#uraian").val()) == ""){
        $('#msg_error_approve').html("Harga harus diisi, tidak boleh kosong!");
        $('#box_error_approve').show();  
    }else if($.trim($("#jumlah").val()) == ""){
        $('#msg_error_approve').html("Jumlah harus diisi, tidak boleh kosong!");
        $('#box_error_approve').show();
    }else{
        $('#msg_error_approve').html("");
        $('#box_error_approve').hide();   
        $('#frm_approve').attr("action", "<?php echo base_url(); ?>index.php/Kas/save_approve_biaya");   
        $('#frm_approve').submit();
    };
};

function approveBiaya(id){
    $.ajax({
        url: "<?php echo base_url('index.php/Kas/approve_biaya'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            console.log(result);
            $('#tanggal').val(result['tanggal']);
            $('#nama_kasir').val(result['realname']);
            $('#no_nota').val(result['no_referensi']);
            $('#jumlah').val(result['jumlah']);
            $('#uraian').val(result['uraian']);
            $('#id').val(result['id']);
            
            $("#myApproveModal").find('.modal-title').text('Approve Biaya '+ result['no_referensi']);
            $("#myApproveModal").modal('show',{backdrop: 'true'});           
        }
    });
}

function cancelBiaya(id){
    $.ajax({
        url: "<?php echo base_url('index.php/Kas/approve_biaya'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            console.log(result);
            $('#tanggal_cancel').val(result['tanggal']);
            $('#nama_kasir_cancel').val(result['realname']);
            $('#no_nota_cancel').val(result['no_referensi']);
            $('#jumlah_cancel').val(result['jumlah']);
            $('#uraian_cancel').val(result['uraian']);
            $('#header_id').val(result['id']);
            
            $("#myCancelModal").find('.modal-title').text('Cancel Biaya '+ result['no_referensi']);
            $("#myCancelModal").modal('show',{backdrop: 'true'});           
        }
    });
}

function saveCancelBiaya(){	    
    if($.trim($("#alasan_cancel").val()) == ""){
        $('#msg_error_cancel').html("Alasan pembatalan harus diisi!");
        $('#box_error_cancel').show();  
    }else{
        $('#msg_error_cancel').html("");
        $('#box_error_cancel').hide();   
        $('#frm_cancel').attr("action", "<?php echo base_url(); ?>index.php/Kas/save_cancel_biaya");   
        $('#frm_cancel').submit();
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