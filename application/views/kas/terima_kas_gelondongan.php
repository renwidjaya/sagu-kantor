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
} );
</script>
<div class="row">                            
    <div class="col-md-12">         
        <?php
            if(($group_id==1)||($hak_akses['terima_kas_gelondongan']==1)){
        ?>
        <form class="eventInsForm" method="post" target="_self" name="formku" 
            id="formku" action="<?php echo base_url('index.php/Kas/save_kas_gelondongan'); ?>">
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
                <div class="row">
                    <div class="col-md-5">Nama Customer <font color="#f00">*</font></div>
                    <div class="col-md-7">
                        <select id="m_customer_id" name="m_customer_id" class="form-control myline select2me" 
                            data-placeholder="Pilih customer..." style="margin-bottom:5px" onclick="filterData();">
                            <option value=""></option>
                            <?php
                                foreach ($customer_list as $row){
                                    echo '<option value="'.$row->id.'">'.$row->nama_customer.'</option>';
                                }
                            ?>
                        </select>
                        <input type="hidden" id="nama_customer" name="nama_customer">
                    </div>                    
                </div>
            </div>
            <div class="col-md-2">&nbsp;</div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-5">Jumlah Bayar (Rp)<font color="#f00">*</font></div>
                    <div class="col-md-7">
                        <input type="text" id="jumlah_bayar" name="jumlah_bayar" 
                            class="form-control myline" onkeydown="return myCurrency(event);" 
                            onkeyup="getComa(this.value);" style="margin-bottom:3px">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">Sisa Piutang sebelumnya (Rp) <font color="#f00">*</font></div>
                    <div class="col-md-4">
                        <input type="text" id="piutang_lama" name="piutang_lama" 
                               class="form-control myline" readonly="readonly" style="margin-bottom:3px">
                    </div>
                    <div class="col-md-3" style="text-align:right">
                        <a href="javascript:;" class="btn red-intense" onclick="cekPiutang();" style="margin-right:0">
                            <i class="fa fa-book"></i> Cek</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">Total Bayar (Rp)<font color="#f00">*</font></div>
                    <div class="col-md-7">
                        <input type="text" id="total_kas" name="total_kas" 
                            class="form-control myline" readonly="readonly" style="margin-bottom:3px">
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
                    <th>Customer</th>
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
                            
                            <input type="hidden" id="customer_<?php echo $no; ?>" name="mydata[<?php echo $no; ?>][m_customer_id]" 
                                   value="<?php echo $data->m_agen_id; ?>">
                        </td>
                        <td style="text-align:center"><?php echo $no; ?></td>                        
                        <td><?php echo date('d/m/Y', strtotime($data->tanggal)); ?></td>
                        <td><?php echo $data->no_nota; ?></td>
                        <td><?php echo $data->nama_customer; ?></td>
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
                <div class="row">
                    <div class="col-md-5">Sisa piutang setelah pembayaran (Rp)<font color="#f00">*</font></div>
                    <div class="col-md-7">
                        <input type="text" id="sisa_bayar" name="sisa_bayar" class="form-control myline" 
                            readonly="readonly">
                    </div>
                </div>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-12">
                &nbsp;<br>
                <input type="button" onClick="simpandata();" name="btnSave" 
                    value="Terima" class="btn btn-primary" id="btnSave">
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
function filterData(){
    data = $('#m_customer_id').select2('data');
    oTable = $('#sample_6').DataTable();
    oTable.search(data.text).draw() ;
    $('#nama_customer').val(data.text);
}

function getComa(nilai){
    $('#jumlah_bayar').val(nilai.toString().replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}

function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
    
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
    var piutang = $('#total_kas').val().toString().replace(/\./g, "");
    
    $('input').each(function(i){
        if($('#check_'+i).prop("checked")){
            bayar = bayar + Number($('#jumlah_'+i).val());                
        }
    });

    total_bayar = bayar.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $('#total_bayar').val(total_bayar);
    
    piutang_new = Math.abs(Number(bayar)- Number(piutang));
    $('#sisa_bayar').val(piutang_new.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}
    
function simpandata(){	    
    if($.trim($("#tanggal").val()) == ""){
        $('#msg_error').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();  
    }else if($.trim($("#tempat_transaksi").val()) == ""){
        $('#msg_error').html("Silahkan pilih tempat transaksi!");
        $('.alert-danger').show();
    }else if($.trim($("#m_customer_id").val()) == ""){
        $('#msg_error').html("Silahkan pilih nama customer!");
        $('.alert-danger').show();
    }else if($.trim($("#jumlah_bayar").val()) == ""){
        $('#msg_error').html("Jumlah bayar harus diisi, tisdak boleh kosong!");
        $('.alert-danger').show();
    }else if($.trim($("#piutang_lama").val()) == ""){
        $('#msg_error').html("Jumlah piutang sebelumnya harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#total_kas").val()) == ""){
        $('#msg_error').html("Total bayar harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();
    }else if($.trim($("#total_bayar").val()) == ""){
        $('#msg_error').html("Jumlah transaksi yang dibayar harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();  
    }else if($.trim($("#sisa_bayar").val()) == ""){
        $('#msg_error').html("Sisa piutang harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();  
    }else{
        hutang = $('#total_bayar').val().toString().replace(/\./g, "");
        kas    = $('#total_kas').val().toString().replace(/\./g, "");
        if(Number(hutang)> Number(kas)){
            $('#msg_error').html("Jumlah bayar tidak cukup!, silahkan uncheck salah satu item dan periksa lagi perhitungan kas anda.");
            $('.alert-danger').show();  
        }else{        
            $('#msg_error').html("");
            $('.alert-danger').hide();
            $('#btnSave').attr("disabled", true);     
            $('#formku').submit();
        }
    };
};

function cekPiutang(){
    customer = $('#m_customer_id').val();
    $.ajax({
        type:"POST",
        url:'<?php echo base_url('index.php/Kas/cek_piutang'); ?>',
        data:"customer="+customer,
        success:function(result){
            //console.log(result);
            if(result['status']=="ADA"){
                $('#piutang_lama').val(result['piutang']);                    
                hitungKas();
            }else if(result['status']=="TIDAK"){
                $('#piutang_lama').val('0');
                hitungKas();
            }
        }
    });
}

function hitungKas(){
    jumlah_bayar = $('#jumlah_bayar').val().toString().replace(/\./g, "");
    piutang = $('#piutang_lama').val().toString().replace(/\./g, "");
    
    kas = Number(jumlah_bayar)+ Number(piutang);
    $('#total_kas').val(kas.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    
}
</script>