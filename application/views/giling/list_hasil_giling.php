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
        changeYear: true
    });       
} );
</script>
<div class="row">                            
    <div class="col-md-12">         
        <?php
            if( ($group_id==1)||($hak_akses['list_hasil_giling']==1) ){
        ?>
        
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cog"></i>List Hasil Giling
                </div>                
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>No Giling</th>
                    <th>Tanggal</th> 
                    <th>Berat diproses (Kg)</th>                                         
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
                        <td><?php echo $data->no_giling; ?></td> 
                        <td><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td> 
                        <td style="text-align:right; color:red"><?php echo number_format($data->berat_diproses,0,',','.'); ?></td> 
                        <td style="text-align:center"> 
                            <a class="btn btn-circle btn-xs green" 
                               href="<?php echo base_url(); ?>index.php/Giling/view/<?php echo $data->id; ?>" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-file-text"></i> Lihat Rincian &nbsp; </a>                            
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
function checkAll(){
    if ($('#check_all').prop("checked")) {
        for(i=1;i<50;i++){
            $('#uniform-check_'+i+' span').attr('class', 'checked');
            $('#check_'+i).attr('checked', true);
        }
    }else{
        for(i=1;i<50;i++){
            $('#uniform-check_'+i+' span').attr('class', '');
            $('#check_'+i).attr('checked', false);
        }
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