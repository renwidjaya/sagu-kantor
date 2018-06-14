<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$(function(){  
    window.setTimeout(function() { $(".alert-success").hide(); }, 4000);     
});
</script>
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
        <?php
            if( ($group_id==1)||($hak_akses['list_invoice']==1) ){
        ?>
        <form class="eventInsForm" method="post" target="_self" name="formku" 
            id="formku" action="<?php echo base_url('index.php/Piutang/update_invoice'); ?>">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span id="msg_invoice">&nbsp;</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="javascript:;" onClick="simpandata();" class="btn green" id="btnSave" style="margin-bottom:4px">
                        <i class="fa fa-floppy-o"></i> Bayar/ Set Lunas
                    </a>
                </div>
            </div>
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-file-o"></i>List Invoice CV
                    </div>                
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_6">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>
                            <input type="checkbox" id="check_all" name="check_all" onclick="checkAll()" class="form-control">
                        </th>
                        <th>Tanggal</th>
                        <th>Nama CV</th> 
                        <th>Nomor Invoice</th>
                        <th>Customer</th> 
                        <th>PIC</th> 
                        <th>Alamat</th> 
                        <th>Ekspedisi</th> 
                        <th>Total <br>Order (Kg)</th> 
                        <th>Nilai <br>Order (Rp)</th> 
                        <th>No DO Pabrik</th>
                        <th>Status <br>Pembayaran</th>
                        <th>Print</th>
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
                            <td>
                                <?php
                                    if($data->flag_bayar==0){
                                        echo '<input type="checkbox" value="1" id="check_'.$no.'" name="mydata['.$no.'][check]" 
                                            onclick="check();" class="form-control"> 
                                        <input type="hidden" name="mydata['.$no.'][do_id]" value="'.$data->id.'">';
                                    }
                                ?>
                            </td> 
                            <td><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>
                            <td><?php echo $data->nama_cv; ?></td>
                            <td><?php echo $data->no_delivery_order; ?></td>
                            <td><?php echo $data->nama_customer; ?></td>
                            <td><?php echo $data->pic; ?></td>
                            <td><?php echo $data->alamat; ?></td>
                            <td><?php echo $data->nama_ekspedisi; ?></td>
                            <td style="text-align:right;color:blue">
                                <?php echo number_format($data->total_berat,0,',','.'); ?>
                            </td>
                            <td style="text-align:right;color:blue">
                                <?php echo number_format($data->total_harga,0,',','.'); ?>
                            </td>
                            <td><?php echo $data->no_do_pabrik; ?></td> 
                            <td style="text-align:center">
                                <?php 
                                if($data->flag_bayar==1){
                                    echo '<div style="background-color:green;color:white; padding:4px">Lunas</div>';
                                }else{
                                    echo '<div style="background-color:red;color:white; padding:4px">Pending</div>';
                                }
                                ?>
                            </td> 
                            <td style="text-align:center">
                                <a href="<?php echo base_url(); ?>index.php/BackOffice/print_do_cv/<?php echo $data->id; ?>" 
                                   class="btn btn-xs btn-circle blue-hoki" style="margin-bottom:4px">
                                   &nbsp; <i class="fa fa-print"></i> Cetak &nbsp;</a>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>                                                                                    
                    </tbody>
                    </table>
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
}

function check(){
    $('#uniform-check_all span').attr('class', '');
    $('#check_all').attr('checked', false);    
}

function simpandata(){
    var item_check = 0;
    $('input').each(function(i){
        if($('#check_'+i).prop("checked")){
            item_check += 1;                    
        }
    });
    
    $('#btnSave').attr("disabled", true);    
    if(item_check==0){
        $('#msg_invoice').html("Silahkan pilih invoice yang akan diproses!"); 
        $('.alert-danger').show(); 
    $('#btnSave').attr("disabled", false);
    }else{
        $('#msg_invoice').html("");
        $('.alert-danger').hide();
        $('#formku').submit();
    }
};
</script>