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
            if( ($group_id==1)||($hak_akses['index']==1) ){
        ?>
        <h3>Proses Giling</h3>
        <form class="eventInsForm" method="post" target="_self" name="formku" 
            id="formku" action="<?php echo base_url('index.php/Giling/save_giling'); ?>">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span id="msg_giling">&nbsp;</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    Tanggal Giling <font color="#f00">*</font>
                </div>
                <div class="col-md-6">
                    <input type="text" id="tanggal" name="tanggal" 
                        class="form-control myline input-small" style="margin-bottom:5px; float:left" 
                        value="<?php echo date('d-m-Y'); ?>">
                    <input type="button" onClick="simpandata();" name="btnSave" 
                        value="Proses" class="btn btn-primary" id="btnSave">
                </div>
            </div>
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cog"></i>Pilih Stok Singkong
                    </div>                
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="check_all" name="check_all" onclick="checkAll()" class="form-control">
                            </th>
                            <th>No</th>
                            <th>Tanggal Pembelian</th>  
                            <th>Jam Masuk</th>
                            <th>Nama Agen</th>   
                            <th>Nomor Polisi</th> 
                            <th>Nama Supir</th>
                            <th>Berat (Kg)</th>
                            <th>Pasir</th>
                            <th>Tanah</th>
                            <th>Kadar Aci</th>
                            <th>Ukuran</th>
                            <th>Bonggol</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 0;
                                if(sizeof($list_data)>0){
                                    foreach ($list_data as $data){ 
                                        $no++;
                            ?>
                            <tr> 
                                <td>                                                    
                                    <input type="checkbox" value="1" id="check_<?php echo $no; ?>" name="mydata[<?php echo $no; ?>][check]" 
                                        onclick="check();" class="form-control"> 
                                    <input type="hidden" name="mydata[<?php echo $no; ?>][timbang_id]" value="<?php echo $data->id; ?>">
                                    <input type="hidden" id="berat_<?php echo $no; ?>" name="mydata[<?php echo $no; ?>][berat_bersih]" 
                                           value="<?php echo $data->berat_bersih; ?>">
                                </td>
                                <td style="width:50px; text-align:center"><?php echo $no; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($data->time_in)); ?></td>  
                                <td style="text-align:center"><?php echo date('h:m', strtotime($data->time_in)); ?></td> 
                                <td><?php echo $data->nama_agen; ?></td>  
                                <td><?php echo $data->no_kendaraan; ?></td> 
                                <td><?php echo $data->supir; ?></td>
                                <td style="text-align:right; background-color: #ccccff"><?php echo number_format($data->berat_bersih,0,',','.'); ?></td> 
                                <td><?php echo $data->qc01; ?></td>
                                <td><?php echo $data->qc02; ?></td>
                                <td><?php echo $data->qc03; ?></td>
                                <td><?php echo $data->qc04; ?></td>
                                <td><?php echo $data->qc05; ?></td>                        
                            </tr>                            
                            <?php                                
                                }
                            ?>
                            <tr><td colspan="7"><strong>Total stock SINGKONG yang akan digiling : </strong></td>
                                <td style="text-align:right; background-color:#faf8b4">
                                    <strong><div id="berat_total_show">&nbsp;</div></strong>
                                    <input type="hidden" id="berat_total" name="berat_total">
                                </td>
                                <td colspan="5">&nbsp;</td>
                            </tr>
                            <?php
                            }else{
                                echo "<tr><td colspan='12' style='color:red'>Tidak ada data singkong yang bisa di proses giling...</td></tr>";
                            }
                            ?>                                                                                    
                        </tbody>
                        </table>
                    </div>
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
    hitung_berat();
}

function check(){
    $('#uniform-check_all span').attr('class', '');
    $('#check_all').attr('checked', false);    
    hitung_berat();
}

function hitung_berat(){
    var berat = 0;
    $('input').each(function(i){
        if($('#check_'+i).prop("checked")){
            berat = berat + Number($('#berat_'+i).val());                
        }
    });
    $('#berat_total').val(berat);
    berat_show = berat.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $('#berat_total_show').html(berat_show);
}

function simpandata(){
    var item_check = 0;
    $('input').each(function(i){
        if($('#check_'+i).prop("checked")){
            item_check += 1;                    
        }
    });
    
    $('#btnSave').attr("disabled", true); 
    if($.trim($("#tanggal").val()) == ""){
        $('#msg_giling').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    }else{   
        if(item_check==0){
            $('#msg_giling').html("Silahkan pilih singkong yang akan digiling!"); 
            $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
        }else{
            $('#msg_giling').html("");
            $('.alert-danger').hide();
            $('#formku').submit();
        }
    };
};

</script>