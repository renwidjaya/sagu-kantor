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
} );
</script>
<div class="row">                            
    <div class="col-md-12">         
        <?php
            if(($group_id==1)||($hak_akses['pembayaran_nota_gelondongan']==1)){
        ?>
        <form accept-charset="utf-8" action="<?php echo base_url().'index.php/Kas/pembayaran_nota_gelondongan'; ?>" 
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
                    <div class="col-md-3 col-xs-12">
                        <input type="submit" class="btn green" id="btnSubmit" 
                            name="btnSubmit" value=" Filter "> &nbsp;

                        <a href="<?php echo base_url().'index.php/Kas/pembayaran_nota_gelondongan'; ?>" class="btn default">
                            <i class="fa fa-times"></i> Reset </a>
                    </div>
                    <div class="col-md-3" style="text-align:right">
                        &nbsp;
                    </div>
                </div>
            </fieldset>
        </form>
        <hr>
        
        <form class="eventInsForm" method="post" target="_self" name="formku" 
            id="formku" action="<?php echo base_url('index.php/Kas/save_nota_gelondongan'); ?>">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span id="msg_error">&nbsp;</span>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-5">Tanggal pembayaran <font color="#f00">*</font></div>
                    <div class="col-md-7">
                        <input type="text" id="tanggal" name="tanggal" 
                            class="form-control myline input-small" 
                            style="margin-bottom:5px;float:left" value="<?php echo date('d-m-Y'); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">Transaksi diterima <font color="#f00">*</font></div>
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
        
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>Pembayaran Nota Gelondongan
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="check_all" name="check_all" onclick="checkAll()" class="form-control">
                    </th>
                    <th>No</th>
                    <th>Tanggal</th>   
                    <th>No Referensi</th> 
                    <th>Agen</th>
                    <th>Oleh</th> 
                    <th>Uraian</th>  
                    <th>Jumlah (Rp)</th> 
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0;
                        foreach ($list_data as $data){
                            $no++;
                    ?>
                    <tr>
                        <td>                                                    
                            <input type="checkbox" value="1" id="check_<?php echo $no; ?>" name="mydata[<?php echo $no; ?>][check]" 
                                onclick="check();" class="form-control"> 
                            
                            <input type="hidden" name="mydata[<?php echo $no; ?>][nota_id]" value="<?php echo $data->id; ?>">
                            <input type="hidden" id="jumlah_<?php echo $no; ?>" name="mydata[<?php echo $no; ?>][jumlah]" 
                                   value="<?php echo $data->total_harga; ?>">
                            <input type="hidden" id="no_nota_<?php echo $no; ?>" name="mydata[<?php echo $no; ?>][no_nota]" 
                                   value="<?php echo $data->no_nota; ?>">
                            
                            <input type="hidden" id="agen_<?php echo $no; ?>" name="mydata[<?php echo $no; ?>][m_agen_id]" 
                                   value="<?php echo $data->m_agen_id; ?>">
                        </td>
                        <td style="text-align:center"><?php echo $no; ?></td>                        
                        <td><?php echo date('d/m/Y', strtotime($data->tanggal)); ?></td>
                        <td><?php echo $data->no_nota; ?></td>
                        <td><?php echo $data->nama_agen.((!empty($data_jenis_agen))? " (".$data->jenis_agen.")": ""); ?></td>
                        <td><?php echo $data->realname; ?></td>
                        <td><?php echo $data->uraian; ?></td>
                        <td style="text-align:right;color:blue"><?php echo number_format($data->total_harga,0,',','.'); ?></td>
                                              
                    </tr>
                    <?php
                        }
                    ?>                                                                                    
                </tbody>
                </table>
            </div>
        </div>
            
        <div class="portlet box red-intense" id="box_kasbon" style="display:none">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>Kasbon
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>   
                    <th>No Referensi</th> 
                    <th>Agen</th>
                    <th>Supir</th>
                    <th>Uraian</th>  
                    <th>Jumlah (Rp)</th> 
                </tr>
                </thead>
                <tbody id="tbl_kasbon">
                                                                                                       
                </tbody>
                </table>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-7">&nbsp;</div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-5">Jumlah transaksi yang dibayar (Rp)<font color="#f00">*</font></div>
                    <div class="col-md-7">
                        <input type="text" id="total_bayar" name="total_bayar" class="form-control myline" 
                            readonly="readonly">
                    </div>
                </div>
                <!--div class="row">
                    <div class="col-md-5">Jumlah kasbon (Rp)<font color="#f00">*</font></div>
                    <div class="col-md-4">
                        <input type="text" id="total_kasbon" name="total_kasbon" class="form-control myline" 
                               readonly="readonly" style="margin-bottom:3px">
                    </div>
                    <div class="col-md-3" style="text-align:right">
                        <a href="javascript:;" class="btn red-intense" onclick="cekKasbon();" style="margin-right:0">
                            <i class="fa fa-book"></i> Cek</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">Sisa yang harus dibayar (Rp)<font color="#f00">*</font></div>
                    <div class="col-md-7">
                        <input type="text" id="sisa_bayar" name="sisa_bayar" class="form-control myline" 
                            readonly="readonly">
                    </div>
                </div-->
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-12">
                &nbsp;<br>
                <input type="button" onClick="simpandata();" name="btnSave" 
                    value="Bayar" class="btn btn-primary" id="btnSave">
                <a href="<?php echo base_url(); ?>" class="btn btn-default">
                    Batal</a>
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
function checkAll(){
    if ($('#check_all').prop("checked")) {  
        $('input').each(function(i){
            $('#uniform-check_'+i+' span').attr('class', 'checked');
            $('#check_'+i).attr('checked', true);
        });
    }else{
        $('input').each(function(i){
            $('#uniform-check_'+i+' span').attr('class', '');
            $('#check_'+i).attr('checked', false);
        });
    }   
    hitung_bayar();
}

function check(){
    $('#uniform-check_all span').attr('class', '');
    $('#check_all').attr('checked', false);    
    hitung_bayar();
}

function hitung_bayar(){
    var bayar = 0;
    $('input').each(function(i){
        if($('#check_'+i).prop("checked")){
            bayar = bayar + Number($('#jumlah_'+i).val());                
        }
    });

    total_bayar = bayar.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $('#total_bayar').val(total_bayar);
}
    
function simpandata(){	    
    if($.trim($("#tanggal").val()) == ""){
        $('#msg_error').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();  
    }else if($.trim($("#tempat_transaksi").val()) == ""){
        $('#msg_error').html("Silahkan pilih tempat transaksi!");
        $('.alert-danger').show();  
    }else if($.trim($("#total_bayar").val()) == ""){
        $('#msg_error').html("Total harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();  
    }else if($.trim($("#total_kasbon").val()) == ""){
        $('#msg_error').html("Cek dulu kasbon!");
        $('.alert-danger').show(); 
    }else if($.trim($("#sisa_bayar").val()) == ""){
        $('#msg_error').html("Sisa bayar harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
    }else{
        $('#msg_error').html("");
        $('.alert-danger').hide();
        $('#btnSave').attr("disabled", true);     
        $('#formku').submit();
    };
};

function cekKasbon(){
    var cek = 0;
    $('input').each(function(i){
        if($('#check_'+i).prop("checked")){
            cek += 1;
            agen = $('#agen_'+i).val();
        }
    });
    
    if(cek==0){
        $('#msg_error').html("Pilih dulu nota-nota yang akan dibayar!"); 
        $('.alert-danger').show(); 
    }else{
        $('#msg_error').html("");
        $('.alert-danger').hide();
        
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/Kas/cek_kasbon'); ?>',
            data:"agen="+agen,
            success:function(result){
                //console.log(result);
                if(result['status']=="ADA"){
                    $('#box_kasbon').show(200);
                    $('#total_kasbon').val(result['kasbon']);
                    $('#tbl_kasbon').html(result['konten']);
                    
                    hitungSisa();
                }else if(result['status']=="TIDAK"){
                    $('#box_kasbon').hide(200);
                    $('#tbl_kasbon').html('');
                    $('#total_kasbon').val('0');
                    hitungSisa();
                }
            }
        });
    }
}

function hitungSisa(){
    total_bayar = $('#total_bayar').val().toString().replace(/\./g, "");
    total_kasbon = $('#total_kasbon').val().toString().replace(/\./g, "");
    
    sisa = Number(total_bayar)- Number(total_kasbon);
    $('#sisa_bayar').val(sisa.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    
}
</script>