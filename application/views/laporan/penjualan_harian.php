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
            if( ($group_id==1)||($hak_akses['penjualan_harian']==1) ){
        ?>
        <div class="row">
            <div class="col-md-12">
                <form accept-charset="utf-8" action="<?php echo base_url().'index.php/Laporan/penjualan_harian'; ?>" 
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
                                    <input type="submit" class="btn green" id="btnSearch" 
                                        name="btnSubmit" value="Search"> &nbsp;

                                    <a href="<?php echo base_url().'index.php/Laporan/penjualan_harian'; ?>" class="btn default">
                                        <i class="fa fa-times"></i> Reset </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="text-align:right">                            
                            <?php
                                if( ($group_id==1)||($hak_akses['print_penjualan_harian']==1) ){
                                    echo '<a href="'.base_url().'index.php/Laporan/print_penjualan_harian/'.$parameter.'" 
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
                    <i class="fa fa-file-o"></i>Laporan Penjualan Harian
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>No</th>
                    <th>No. Nota</th> 
                    <th>Jenis Sagu</th> 
                    <th>Unit/Sak (Kg)</th> 
                    <th>Tanggal</th>
                    <th>Waktu Timbang</th>
                    <th>Customer</th>
                    <th>Ekspedisi</th>
                    <th>No. Polisi</th> 
                    <th>Jumlah Sak</th>
                    <th>Tonase (Kg)</th> 
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
                        <td><?php echo $data->no_delivery_order; ?></td>
                        <td><?php echo $data->merek; ?></td>
                        <td><?php echo $data->sak; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($data->tanggal)); ?></td>
                        <td style="text-align:center"><?php echo date('h:m:s', strtotime($data->time_in)).'<br>'.date('h:m:s', strtotime($data->time_out)); ?></td>
                        <td><?php echo $data->nama_customer; ?></td>
                        <td><?php echo $data->nama_ekspedisi; ?></td>
                        <td><?php echo $data->no_kendaraan; ?></td>
                        <td style="text-align:right"><?php echo number_format($data->jumlah_sak,0,',','.'); ?></td>
                        <td style="text-align:right"><?php echo number_format($data->total_berat,0,',','.'); ?></td>                                                    
                    </tr>
                    <?php
                        }
                    ?>  
                    <tr><td colspan="10" style="text-align:right; font-weight:bold">
                            Total (Kg)
                        </td>
                        <td style="text-align:right; background-color:#faf8b4">
                            <?php echo number_format($total['total_berat'],0,',','.'); ?>
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
