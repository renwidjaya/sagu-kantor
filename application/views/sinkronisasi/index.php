<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if(isset($type_message)&& $type_message=="error"){
        ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span id="msg_error"><?php echo $message; ?></span>
        </div>
        <?php
            }else if(isset($type_message)&& $type_message=="success"){
        ?>
        <div class="alert alert-success">
            <button class="close" data-close="alert"></button>
            <span id="msg_error"><?php echo $message; ?></span>
        </div>
        <?php 
            }else{
        ?>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span id="message">&nbsp;</span>
        </div>

        <?php
            }
            if( ($group_id==1)||($hak_akses['index']==1) ){
        ?>    
        <p>
            Anda dapat meng-upload data sinkronisasi dalam format file csv (.csv). <br>
            Load file anda dengan mengklik tombol BROWSE di bawah ini, kemudian klik tombol UPLOAD. 
            Setelah proses upload data selesai, klik tombol <strong>Sinkronisasi Data</strong>.
            <br>&nbsp;
        </p>
        <form id="formku" action="<?php echo base_url(); ?>index.php/SinkronisasiByEmail" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-1">File name</div>
                <div class="col-md-4">
                    <input type="file" id="document_url" name="document_url">
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">&nbsp;</div>
                <div class="col-md-4">&nbsp;<br>
                    <a href="javascript:;" onClick="simpandata();" class="btn btn-primary" id="btnSave">
                        <i class="fa fa-upload"></i> Upload 
                    </a> &nbsp;
                    
                    <a href="javascript:;" onClick="sinkronisasiData();" class="btn green" id="btnSinkronisasi">
                        <i class="fa fa-refresh"></i> Sinkronisasi Data 
                    </a>
                </div>
            </div>
        </form>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success display-hide" id="box_msg_success">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_success">&nbsp;</span>
                </div>
            </div>
        </div>
        <div class="row" id="loader" style="display:none">
            <div class="col-md-12">
                <img src="<?php echo base_url(); ?>img/page-loader.gif" width="80px">
                Mohon tunggu sampai proses sinkronisasi selesai
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
    $('#btnSave').attr('disabled', true);
    if($.trim($("#document_url").val()) == ""){
        $('#message').html("Silahkan load file terlebih dahulu!");
        $('.alert-danger').show(); 
        $('#btnSave').attr('disabled', false);
    }else{             
        $('#formku').submit();
    };
};

function sinkronisasiData(){
    $('#btnSinkronisasi').attr('disabled', true);
    $('#loader').show(200);
    
    $.ajax({
        type:"POST",
        url:'<?php echo base_url('index.php/SinkronisasiByEmail/proses_sinkronisasi'); ?>',
        success:function(result){
            if(result['type_message']=="success"){
                $('#msg_success').html("Proses sinkronisasi data selesai...");
                $('#box_msg_success').show(); 
                $('#loader').hide(200);
                $('#btnSinkronisasi').attr('disabled', false);
            }            
        }
    });
}

</script>

        