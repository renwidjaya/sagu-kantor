<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$(function(){ 
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
        <form class="eventInsForm" method="post" target="_self" name="formku" 
            id="formku" action="<?php echo base_url('index.php/BackOffice/save_delivery_order'); ?>">
            <div class="row">
                <div class="col-md-12 col-sm-12"><h4>Input Delivery Order</h4></div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span id="message">&nbsp;</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            Tanggal <font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="tanggal" name="tanggal" 
                                class="form-control myline input-small" style="margin-bottom:5px; float:left" 
                                value="<?php echo date('d-m-Y'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            No. Delivery Order<font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="no_delivery_order" name="no_delivery_order" 
                                class="form-control myline" style="margin-bottom:5px;" 
                                value="Auto generated by system" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Customer<font color="#f00">*</font>
                        </div>
                        <div class="col-md-8">
                            <select id="m_customer_id" name="m_customer_id" class="form-control myline select2me" 
                                data-placeholder="Pilih customer..." style="margin-bottom:5px" onclick="get_so_list(this.value);">
                                <option value=""></option>
                                <?php
                                    foreach ($list_customer as $row){
                                        echo '<option value="'.$row->id.'">'.$row->nama_customer.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            No. Sales Order
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <select id="t_sales_order_id" name="t_sales_order_id" class="form-control myline select2me" 
                                data-placeholder="Pilih nomor SO..." style="margin-bottom:5px">
                                <option value=""></option>
                                <?php
                                    foreach ($list_so as $row){
                                        echo '<option value="'.$row->id.'">'.$row->no_sales_order.'--'.$row->tanggal.' </option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            &nbsp;
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <input type="button" onClick="simpandata();" name="btnSave" 
                                value="Tambah Produk" class="btn btn-primary" id="btnSave">
                            <a href="<?php echo base_url('index.php/BackOffice/delivery_order'); ?>" class="btn btn-default">
                                Batal</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            Pemilik Order (CV)<font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <select id="m_cv_id" name="m_cv_id" class="form-control myline select2me" 
                                data-placeholder="Pilih nama CV..." style="margin-bottom:5px">
                                <option value=""></option>
                                <?php
                                    foreach ($list_cv as $row){
                                        echo '<option value="'.$row->id.'">'.$row->nama_cv.' </option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            Nama Ekspedisi<font color="#f00">*</font>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <select id="m_ekspedisi_id" name="m_ekspedisi_id" class="form-control myline select2me" 
                                data-placeholder="Pilih ekspedisi..." style="margin-bottom:5px">
                                <option value=""></option>
                                <?php
                                    foreach ($list_ekspedisi as $row){
                                        echo '<option value="'.$row->id.'">'.$row->nama_ekspedisi.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            Catatan
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <textarea id="catatan" name="catatan" class="form-control myline" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>  

<script>    
function simpandata(){		
    if($.trim($("#tanggal").val()) == ""){
        $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
        $('.alert-danger').show();   
    }else if($.trim($("#m_customer_id").val()) == ""){
        $('#message').html("Silahkan pilih customer!");
        $('.alert-danger').show();   
    }else if($.trim($("#m_cv_id").val()) == ""){
        $('#message').html("Silahkan pilih nama CV!");
        $('.alert-danger').show();   
    }else if($.trim($("#m_ekspedisi_id").val()) == ""){
        $('#message').html("Silahkan pilih ekspedisi!");
        $('.alert-danger').show();   
    }else{
        $('#btnSave').attr("disabled", true);        
        $('#formku').submit();
    };
};

function get_so_list(id){
    $.ajax({
        url: "<?php echo base_url('index.php/BackOffice/get_so_list'); ?>",
        async: false,
        type: "POST",
        data: "id="+id,
        dataType: "html",
        success: function(result) {
            $('#t_sales_order_id').html(result);
        }
    })
}

</script>
        