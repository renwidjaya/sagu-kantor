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
        
        <?php
            if( ($group_id==1)||($hak_akses['proses_pembayaran']==1) ){
        ?>
        <div class="row">
            <div class="col-md-6">
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
                        <div class="col-md-3">Nama Customer</div>
                        <div class="col-md-5">
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
                        <div class="col-md-3">Nama CV</div>
                        <div class="col-md-5">
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
                    <div class="row">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-5">
                            <a href="#" class="btn green" style="margin-bottom:4px" onclick="showList();">
                                <i class="fa fa-file-o"></i> Generate List </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>        
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-md-6">                
                <div class="portlet box blue-hoki" id="boxInvoice" style="display:none">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-file-pdf-o"></i>List Piutang (Invoice) Customer
                        </div>                        
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>                            
                            <th>No</th>
                            <th>Tanggal</th>   
                            <th>No. Invoice</th> 
                            <th>Jumlah (Rp)</th>
                            <th>Cek Status</th> 
                        </tr>
                        </thead>
                        <tbody id="tableInvoice">
                                                                                                             
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="portlet box yellow-casablanca" id="boxTransfer" style="display:none">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-file-pdf-o"></i>List Pembayaran Customer
                        </div>                        
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>                            
                            <th>No</th>
                            <th>Tanggal</th>   
                            <th>Metode Pembayaran</th> 
                            <th>Nama Bank</th> 
                            <th>No. Rekening</th> 
                            <th>Jumlah (Rp)</th>                            
                        </tr>
                        </thead>
                        <tbody id="tableTransfer">
                                                                                                             
                        </tbody>
                        </table>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-8"><strong>Sisa cash setelah diproses (Rp)</strong></div>
                            <div class="col-md-4" style="background-color:greenyellow;text-align:right" id="boxSisa"></div>
                        </div>
                    </div>
                </div>

                <div class="row" id="boxTombol" style="display:none">
                    <div class="col-md-12">
                        <a href="#" class="btn blue-hoki" style="margin-bottom:4px" onclick="simulasiPembayaran();">
                            <i class="fa fa-check-circle"></i> Simulasi Pembayaran </a>

                        <a href="#" class="btn green" style="margin-bottom:4px" onclick="savePembayaran();">
                            <i class="fa fa-floppy-o"></i> Proses </a>
                    </div>
                </div>
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
function showList(){
    if($.trim($("#m_customer_id").val()) == ""){
        $('#message').html("Silahkan pilih customer!");
        $('.alert-danger').show();
    }else if($.trim($("#m_cv_id").val()) == ""){
        $('#message').html("Silahkan pilih CV!");
        $('.alert-danger').show();    
    }else{
        $('#message').html("");
        $('.alert-danger').hide();  
        $.ajax({
            type:"POST",
            url:'<?php echo base_url('index.php/Piutang/show_list'); ?>',
            data:{m_customer_id:$('#m_customer_id').val(), m_cv_id:$('#m_cv_id').val()},
            success:function(data){
                console.log(data);
                $('#tableInvoice').html(data.invoice_list);
                $('#boxInvoice').show();
                
                $('#tableTransfer').html(data.bayar_list);
                $('#boxTransfer').show();
                
                if(data.jumlah_invoice>0 && data.jumlah_bayar>0){
                    $('#boxTombol').show();
                }
            }
        });    
    };
};

function simulasiPembayaran(){
    $.ajax({
        type:"POST",
        url:'<?php echo base_url('index.php/Piutang/simulasi_pembayaran'); ?>',
        data:{m_customer_id:$('#m_customer_id').val(), m_cv_id:$('#m_cv_id').val()},
        success:function(data){
            console.log(data);
            for(i=0; i<data.jumlah_invoice;i++){
                j = i+1;
                $('#boxStatus_'+j).html(data.status[j]);
                if(data.status[j]=="Lunas"){
                    $('#boxStatus_'+j).attr('style', 'background-color:green;color:white');
                }else{
                    $('#boxStatus_'+j).attr('style', 'background-color:yellow');
                }
            }
            $('#boxSisa').html(data.sisa_cash);
        }
    });
}

function savePembayaran(){
    $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Piutang/seatle");
    $('#formku').submit(); 
}

</script>         