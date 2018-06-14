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
                                    
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama Customer <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="m_customer_id" name="m_customer_id" class="form-control select2me myline" 
                                        data-placeholder="Pilih customer..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_customer as $value){
                                                echo "<option value='".$value->id."'>".$value->nama_customer."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama CV <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="m_cv_id" name="m_cv_id" class="form-control select2me myline" 
                                        data-placeholder="Pilih CV..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_cv as $value){
                                                echo "<option value='".$value->id."'>".$value->nama_cv."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Jenis Tagihan <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="payment_method" name="payment_method" class="form-control myline" 
                                        style="margin-bottom:5px" >
                                        <option value="SAGU" selected="selected">SAGU</option>
                                        <option value="ONGGOK">ONGGOK</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Metode Pembayaran <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="payment_method" name="payment_method" class="form-control select2me myline" 
                                            data-placeholder="Silahkan pilih..." style="margin-bottom:5px" onclick="cekMethod(this.value);">
                                        <option value=""></option>
                                        <option value="Cash">Cash/Tunai</option>
                                        <option value="Bank">Bank</option>
                                    </select>
                                </div>
                            </div> 
                            <div class="row bank" style="display:none">
                                <div class="col-md-5">
                                    Nama Bank <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_bank" name="nama_bank" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row bank" style="display:none">
                                <div class="col-md-5">
                                    No. Rekening <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_rekening" name="no_rekening" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Jumlah <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="amount" name="amount" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeydown="return myCurrency(event);" onkeyup="getComa(this.value);">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    No. Referensi
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_referensi" name="no_referensi" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Keterangan
                                </div>
                                <div class="col-md-7">
                                    <textarea id="keterangan" name="keterangan"  rows="3"
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()"></textarea>
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
            if( ($group_id==1)||($hak_akses['pembayaran']==1) ){
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
                    <i class="fa fa-user"></i>List Pembayaran Customer
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
                    <th>Tanggal</th>   
                    <th>Customer</th> 
                    <th>Nama CV</th>
                    <th>Jenis Tagihan</th>
                    <th>Medode <br>Pembayaran</th>
                    <th>Nama Bank</th> 
                    <th>Nomor <br>Rekening</th>
                    <th>Jumlah (Rp)</th> 
                    <th>Status</th>
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
                        <td><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>
                        <td><?php echo $data->nama_customer; ?></td>
                        <td><?php echo $data->nama_cv; ?></td> 
                        <td><?php echo $data->jenis_tagihan; ?></td> 
                        <td><?php echo $data->payment_method; ?></td> 
                        <td><?php echo $data->nama_bank; ?></td> 
                        <td><?php echo $data->no_rekening; ?></td> 
                        <td style="text-align:right"><?php echo number_format($data->amount,2,',','.'); ?></td> 
                        <td style="text-align:center">
                            <?php 
                            if($data->flag_bayar==1){
                                echo '<div style="background-color:green;color:white;padding:2px">Sudah diseatle</div>';
                            }else{
                                echo '<div style="background-color:yellow;padding:2px">Pending</div>';
                            } 
                            ?>
                        </td> 
                        <td style="text-align:center"> 
                            <?php
                                #if( ($group_id==1)||($hak_akses['edit_pembayaran']==1) ){
                            ?>
                            <!--a class="btn btn-circle btn-xs green" onclick="editData(<?php echo $data->id; ?>)" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a-->
                            <?php 
                                #}
                                if( ($group_id==1)||($hak_akses['delete_pembayaran']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/Piutang/delete_pembayaran/<?php echo $data->id; ?>" 
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
function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function getComa(nilai){
    myNilai = nilai.toString().replace(/\./g, "");
    $('#amount').val(myNilai.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}

function cekMethod(prm){
    if(prm=="Cash"){
        $('.bank').hide();        
    }else{
        $('.bank').show();   
    }
}

var dsState;

function newData(){    
    $('#m_customer_id').select2('val', '');
    $('#m_cv_id').select2('val', '');
    $('#payment_method').select2('val', '');
    $('#nama_bank').val('');
    $('#no_rekening').val('');
    $('#amount').val('');
    $('#no_referensi').val('');
    $('#keterangan').val('');
    $('#id').val('');
    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Terima Cash/Bank');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#m_customer_id").val()) == ""){
        $('#message').html("Silahkan pilih customer!");
        $('.alert-danger').show();
    }else if($.trim($("#m_cv_id").val()) == ""){
        $('#message').html("Silahkan pilih CV!");
        $('.alert-danger').show();
    }else if($.trim($("#payment_method").val()) == ""){
        $('#message').html("Silahkan pilih metode pembayaran!");
        $('.alert-danger').show();
    }else if($.trim($("#amount").val()) == ""){
        $('#message').html("Jumlah harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#nama_bank").val()) == "" && $("#payment_method").val()=="Bank"){
        $('#message').html("Nama bank harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#no_rekening").val()) == "" && $("#payment_method").val()=="Bank"){
        $('#message').html("Nomor rekening harus diisi!");
        $('.alert-danger').show();
    }else{      
        if(dsState=="Input"){
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Piutang/save_pembayaran");
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Piutang/update_pembayaran");            
        }
        $('#formku').submit(); 
    };
};

</script>         