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
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
                </div>
            </div>
        </div>
        <?php
            if(($group_id==1)||($hak_akses['giling_harian']==1)){
        ?>  
        <div class="row">            
            <div class="col-md-12">
                <form accept-charset="utf-8" action="<?php echo base_url().'index.php/Laporan/giling_harian'; ?>" 
                    method="post" id="frm_search">
                <fieldset>
                    <legend>Filter Data</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-2">
                                    Tanggal
                                </div>
                                <div class="col-md-5">
                                    <input type="text" id="tanggal" name="tanggal" 
                                        class="form-control myline input-small" style="margin-bottom:5px;float:left" 
                                        value="<?php echo date('d-m-Y', strtotime($parameter_show)); ?>">
                                </div>
                                <div class="col-md-5">
                                    <input type="submit" class="btn green" id="btnSubmit" 
                                        name="btnSubmit" value=" Search "> &nbsp;

                                    <a href="<?php echo base_url().'index.php/Laporan/giling_harian'; ?>" class="btn default">
                                        <i class="fa fa-times"></i> Reset </a>
                                </div>
                            </div>  
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            <?php
                                if( ($group_id==1)||($hak_akses['print_giling_harian']==1) ){
                                    echo '<a href="'.base_url().'index.php/Laporan/print_giling_harian/'.$parameter.'" 
                                        class="btn green" style="margin-right:0">
                                            <i class="fa fa-print"></i> Export to Excel </a>';
                                }
                            ?>
                        </div>
                    </div>
                </fieldset>
                </form>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span id="msg_giling">&nbsp;</span>
                </div>
            </div>
        </div>
        <form class="eventInsForm" method="post" target="_self" name="formku" 
            id="formku" action="<?php echo base_url('index.php/Laporan/update_giling'); ?>">
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-coffee"></i>List Hasil Giling
                    </div>  
                    <div class="tools">    
                    <a style="height:28px" class="btn btn-circle btn-sm default" onclick="showBoxCV();">
                        <i class="fa fa-download"></i> Assign ke CV</a>
                </div>
                </div>
                <div class="portlet-body">
                    <div class="row" id="boxCV" style="display:none">
                        <div class="col-md-2">
                            Assign ke CV <font color="#f00">*</font>
                        </div>
                        <div class="col-md-4">
                            <select id="m_cv_id" name="m_cv_id" class="form-control myline select2me" 
                                data-placeholder="Pilih nama CV..." style="margin-bottom:5px">
                                <option value=""></option>
                                <?php
                                    foreach ($list_cv as $row){
                                        echo '<option value="'.$row->id.'">'.$row->nama_cv.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:;" id="btnSave" class="btn green" onclick="assignCV();"> <i class="fa fa-floppy-o"></i> Save </a>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="text-align:center">No</th>
                        <th style="width:40px; text-align:center">
                            <input type="checkbox" id="check_all" name="check_all" onclick="checkAll();" class="form-control">
                        </th>
                        <th style="text-align:center">No Giling</th>
                        <th style="text-align:center">Tanggal</th>   
                        <th style="text-align:center">Berat Diproses (Kg)</th> 
                        <th style="text-align:center">Assign ke CV</th> 
                        <th style="text-align:center">Actions</th>
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
                            <td style="text-align:center">
                                <?php
                                    if($data->m_cv_id==0){
                                ?>
                                <input type="checkbox" value="1" id="check_<?php echo $no; ?>" name="mydata[<?php echo $no; ?>][check]" 
                                    onclick="check();" class="form-control"> 
                                <input type="hidden" name="mydata[<?php echo $no; ?>][giling_id]" value="<?php echo $data->id; ?>">
                                <?php
                                    }
                                ?>
                            </td>
                            <td><?php echo $data->no_giling; ?></td> 
                            <td style="text-align:center"><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>  
                            <td style="text-align:right"><?php echo number_format($data->berat_diproses,0,',','.'); ?></td>
                            <td><?php echo $data->nama_cv; ?></td> 
                            <td style="text-align:center">
                                <a class="btn btn-circle btn-xs green" 
                                   href="<?php echo base_url(); ?>index.php/Laporan/detail_giling/<?php echo $data->id; ?>" style="margin-bottom:4px">
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

function showBoxCV(){
    $('#boxCV').show();
}

function assignCV(){
    var item_check = 0;
    $('input').each(function(i){
        if($('#check_'+i).prop("checked")){
            item_check += 1;                    
        }
    });
    
    $('#btnSave').attr("disabled", true); 
    if($.trim($("#m_cv_id").val()) == ""){
        $('#msg_giling').html("Silahkan pilih nama CV!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    }else{   
        if(item_check==0){
            $('#msg_giling').html("Silahkan pilih hasil giling yang akan di-assign!"); 
            $('.alert-danger').show(); 
            $('#btnSave').attr("disabled", false);
        }else{
            $('#msg_giling').html("");
            $('.alert-danger').hide();
            $('#formku').submit();
        }
    };
}
</script>