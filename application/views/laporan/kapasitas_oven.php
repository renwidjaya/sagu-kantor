<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$(function(){    
    window.setTimeout(function() { $(".alert-success").hide(); }, 4000);
    
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
        <?php
            if( ($group_id==1)||($hak_akses['kapasitas_oven']==1) ){
        ?> 
        <div class="row">
            <div class="col-md-12">
                <form accept-charset="utf-8" action="<?php echo base_url().'index.php/Laporan/kapasitas_oven'; ?>" 
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
                                value="<?php echo date('d-m-Y', strtotime($tgl_awal_show)); ?>">
                        </div>
                        <div class="col-md-1">
                            Sampai Tanggal
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="tgl_akhir" name="tgl_akhir" 
                                class="form-control myline" style="margin-bottom:5px;float:left; width:70%" 
                                value="<?php echo date('d-m-Y', strtotime($tgl_akhir_show)); ?>">
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="btn green" id="btnSubmit" 
                                name="btnSubmit" value=" Search "> &nbsp;

                            <a href="<?php echo base_url().'index.php/Laporan/kapasitas_oven'; ?>" class="btn default">
                                <i class="fa fa-times"></i> Reset </a>
                        </div>
                        <div class="col-md-3" style="text-align:right">
                            <?php
                                if( ($group_id==1)||($hak_akses['print_kapasitas_oven']==1) ){
                                    echo '<a href="'.base_url().'index.php/Laporan/print_kapasitas_oven/'.((!empty($tgl_awal))? $tgl_awal: "NULL").'/'.$tgl_akhir.'" 
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
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-sun-o"></i>Kapasitas Oven
                </div>                  
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Oven #</th>
                    <th>Tanggal Start</th>  
                    <th>Jam Start</th>
                    <th>Delay (menit)</th>   
                    <th>Tanggal Stop</th> 
                    <th>Jam Stop</th>
                    <th>Waktu Operasional</th>
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
                        <td style="text-align:center">Oven #<?php echo $data->type_mesin; ?></td>
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($data->tanggal_start)); ?></td>  
                        <td style="text-align:center">
                            <?php echo $data->jam_start; ?>
                        </td> 
                        <td style="text-align:right"><?php echo $data->delay; ?></td>  
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($data->tanggal_stop)); ?></td>  
                        <td style="text-align:center">
                            <?php echo $data->jam_stop; ?>
                        </td> 
                        <td style="text-align:center">
                            <?php echo $data->waktu." (".$data->waktu2.")"; ?>
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