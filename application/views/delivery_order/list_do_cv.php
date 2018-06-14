<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if( ($group_id==1)||($hak_akses['list_do_cv']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>Daftar Delivery Order CV
                </div>                
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama CV</th> 
                    <th>Nomor DO</th>
                    <th>Customer</th> 
                    <th>PIC</th> 
                    <th>Alamat</th> 
                    <th>Ekspedisi</th> 
                    <th>Total Order (Kg)</th> 
                    <th>Nilai Order (Rp)</th> 
                    <th>No DO Pabrik</th> 
                    <?php 
                        if( ($group_id==1)||($hak_akses['cetak_delivery_order']==1) ){
                            echo "<th>Print</th>";
                        }
                    ?>
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
                                if( ($group_id==1)||($hak_akses['cetak_delivery_order']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/BackOffice/print_do_cv/<?php echo $data->id; ?>" 
                               class="btn btn-xs btn-circle blue-hoki" style="margin-bottom:4px">
                               &nbsp; <i class="fa fa-print"></i> Cetak &nbsp;</a>
                            <?php } ?>
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
        