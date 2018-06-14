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
    
    $("#tgl_awal").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>img/Kalender.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    });
    
    $("#tgl_akhir").datepicker({
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
        <div class="modal fade bs-modal-lg" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog modal-lg">
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
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5">
                                            Tanggal <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="tanggal" name="tanggal" 
                                                class="form-control myline input-small" style="margin-bottom:5px;float:left">
                                            
                                            <input type="hidden" id="id" name="id">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Dibuat oleh <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="nama_kasir" name="nama_kasir" 
                                                class="form-control myline" style="margin-bottom:5px;" 
                                                readonly="readonly">
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
                                                readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Transaksi diterima <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-7">
                                            <select id="tempat_transaksi" name="tempat_transaksi" class="form-control myline select2me" 
                                                data-placeholder="Pilih tempat..." style="margin-bottom:5px">
                                                <option value="Pabrik">Pabrik</option>
                                                <option value="Kantor" selected="selected">Kantor</option>
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
                                                        readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    Nama Agen
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" id="nama_agen" name="nama_agen" 
                                                        class="form-control myline" style="margin-bottom:5px;" 
                                                        readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    Sopir
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" id="supir" name="supir" 
                                                        class="form-control myline" style="margin-bottom:5px;" 
                                                        readonly="readonly">
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
                                                        readonly="readonly" value="SAGU">
                                                </div>
                                            </div>                                            
                                            <div class="row">
                                                <div class="col-md-5">
                                                    Jumlah (Rp)<font color="#f00">*</font>
                                                </div>
                                                <div class="col-md-7">
                                                    <!--input type="text" id="total_harga" name="total_harga" 
                                                        class="form-control myline" style="margin-bottom:5px;" onkeydown="return myCurrency(event);" 
                                                        onkeyup="getComa(this.value);"-->
                                                    <input type="text" id="total_harga" name="total_harga" 
                                                           class="form-control myline" style="margin-bottom:5px;" readonly="readonly">
                                                </div>
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>
                            </div>                          
                            <div class="row">
                                <div class="col-md-12">
                                    Uraian<br>
                                    <textarea id="uraian" name="uraian" class="form-control myline" 
                                        rows="3" style="margin-bottom:5px"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" onClick="simpandata();">Terima</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if( ($group_id==1)||($hak_akses['list_nota_jual']==1) ){
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
                </div>
            </div>
        </div>
        
        <form accept-charset="utf-8" action="<?php echo base_url().'index.php/Kas/list_nota_jual'; ?>" 
            method="post" id="frm_search">
            <fieldset>
                <legend>Filter Data</legend>
                <div class="row">
                    <div class="col-md-1">
                        Mulai Tanggal
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="tgl_awal" name="tgl_awal" 
                            class="form-control myline" style="margin-bottom:5px;float:left; width:70%" 
                            value="<?php echo date('d-m-Y', strtotime($tgl_awal)); ?>">
                    </div>
                    <div class="col-md-1">
                        Sampai Tanggal
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="tgl_akhir" name="tgl_akhir" 
                            class="form-control myline" style="margin-bottom:5px;float:left; width:70%" 
                            value="<?php echo date('d-m-Y', strtotime($tgl_akhir)); ?>">
                    </div>
                    <div class="col-md-3">
                        <input type="submit" class="btn green" id="btnSubmit" 
                            name="btnSubmit" value=" Filter "> &nbsp;

                        <a href="<?php echo base_url().'index.php/Kas/list_nota_jual'; ?>" class="btn default">
                            <i class="fa fa-times"></i> Reset </a>
                    </div>
                    <div class="col-md-3" style="text-align:right">
                        &nbsp;
                    </div>
                </div>
            </fieldset>
        </form>
        
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>Terima Nota Pembayaran
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>   
                    <th>No Referensi</th> 
                    <th>Customer</th>
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
                        <td><?php echo $data->no_nota; ?></td>
                        <td><?php echo $data->nama_customer; ?></td>
                        <td><?php echo $data->realname; ?></td>
                        <td><?php echo $data->uraian; ?></td>
                        <td style="text-align:right;color:blue"><?php echo number_format($data->total_harga,0,',','.'); ?></td>
                        <td style="text-align:center"> 
                             <?php
                                if($data->flag_bayar==1){
                                    echo "Sudah Dibayar";
                                }else if($data->flag_cancel==1){
                                    echo "Dibatalkan";
                                }else{
                                    if( ($group_id==1)||($hak_akses['terima_nota']==1) ){                            
                                        echo '<a class="btn btn-circle btn-xs green" onclick="terimaNota('.$data->id.')" style="margin-bottom:4px">
                                                &nbsp; <i class="fa fa-edit"></i> Terima &nbsp; </a>';
                                    } 
                                    
                                    /*if( ($group_id==1)||($hak_akses['cancel_transaksi']==1) ){
                                        echo '<a class="btn btn-circle btn-xs red" onclick="cancelTransaksi('.$data->id.')" style="margin-bottom:4px">
                                            &nbsp; <i class="fa fa-rotate-left"></i> Cancel &nbsp; </a>';
                                    }*/
                                }
                            ?>
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
function simpandata(){	    
    if($.trim($("#tempat_transaksi").val()) == ""){
        $('#message').html("Silahkan pilih tempat transaksi!");
        $('.alert-danger').show();  
    }else if($.trim($("#total_harga").val()) == ""){
        $('#message').html("Jumlah harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();  
    }else if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();
    }else if($.trim($("#uraian").val()) == ""){
        $('#message').html("Uraian harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();
    }else{
        $('#message').html("");
        $('.alert-danger').hide();
        $('#btnSave').attr("disabled", true);    
        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Kas/save_terima_nota");   
        $('#formku').submit();
    };
};

function terimaNota(id){
    $.ajax({
        url: "<?php echo base_url('index.php/Kas/terima_nota'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            console.log(result);
            $('#tanggal').val(result['tanggal']);
            $('#nama_kasir').val(result['realname']);
            $('#no_nota').val(result['no_nota']);
            $('#no_kendaraan').val(result['no_kendaraan']);
            $('#nama_agen').val(result['nama_agen']);
            $('#supir').val(result['supir']);
            
            $('#jenis_barang').val(result['jenis_barang']);
            $('#total_harga').val(result['total_harga']);

            $('#uraian').val(result['uraian']);
            $('#id').val(result['id']);
            
            $("#myModal").find('.modal-title').text('Terima Nota '+ result['no_nota']);
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
    $('#total_harga').val(nilai.toString().replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}
</script>