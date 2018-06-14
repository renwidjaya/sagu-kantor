<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$(function(){    
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
            if( ($group_id==1)||($hak_akses['pembelian_bulanan']==1) ){
        ?>
        <div class="row">
            <div class="col-md-12">
                <form accept-charset="utf-8" action="<?php echo base_url().'index.php/Laporan/pembelian_bulanan'; ?>" 
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

                            <a href="<?php echo base_url().'index.php/Laporan/pembelian_bulanan'; ?>" class="btn default">
                                <i class="fa fa-times"></i> Reset </a>
                        </div>
                        <div class="col-md-3" style="text-align:right">
                            <?php
                                if( ($group_id==1)||($hak_akses['print_pembelian_bulanan']==1) ){
                                    echo '<a href="'.base_url().'index.php/Laporan/print_pembelian_bulanan/'.((!empty($tgl_awal))? $tgl_awal: "NULL").'/'.$tgl_akhir.'" 
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
                    <i class="fa fa-file-o"></i>Laporan Pembelian Bulanan
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Tonase (Kg)</th> 
                    <th>Potongan(Kg)</th> 
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0;
                        foreach ($list_data as $data){
                            $no++;
                    ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no; ?></td>  
                        <td><?php echo date('d/m/Y', strtotime($data->tanggal)); ?></td>
                        <td style="text-align:right"><?php echo number_format($data->berat_bersih,0,',','.'); ?></td>
                        <td style="text-align:right"><?php echo number_format($data->potongan,0,',','.'); ?></td>                                                  
                    </tr>
                    <?php
                        }
                    ?>  
                    <tr><td colspan="2" style="text-align:right; font-weight:bold">
                            Total
                        </td>
                        <td style="text-align:right; background-color:#faf8b4">
                            <?php echo number_format($total['tot_berat_bersih'],0,',','.'); ?>
                        </td>
                        <td style="text-align:right; background-color:#faf8b4">
                            <?php echo number_format($total['tot_potongan'],0,',','.'); ?>
                        </td>
                    </tr>
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