<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if( ($group_id==1)||($hak_akses['sales_order']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>Daftar Sales Order
                </div>
                <div class="tools"> 
                    <?php
                        if( ($group_id==1)||($hak_akses['add_sales_order']==1) ){
                    ?>
                    <a href="<?php echo base_url(); ?>index.php/BackOffice/add_sales_order" 
                       style="height:28px" class="btn btn-circle btn-sm default">
                        <i class="fa fa-plus"></i> Tambah</a>
                    <?php } ?>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Entry</th>   
                    <th>Nomor SO</th> 
                    <th>Nama Customer</th> 
                    <th>PIC</th> 
                    <th>Kota</th> 
                    <th>Nilai Order (Rp)</th> 
                    <th>Realisasi DO (Rp)</th> 
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
                        <td><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>
                        <td><?php echo $data->no_sales_order; ?></td>
                        <td><?php echo $data->nama_customer; ?></td>
                        <td><?php echo $data->pic; ?></td>
                        <td><?php echo $data->city_name; ?></td>
                        <td style="text-align:right;color:blue"><?php echo number_format($data->nilai_order,0,',','.'); ?></td>
                        <td style="text-align:right;color:blue"><?php echo number_format($data->realisasi_do,0,',','.'); ?></td>
                        <td style="text-align:center"> 
                            <?php
                                if( ($group_id==1)||($hak_akses['edit_sales_order']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/BackOffice/edit_sales_order/<?php echo $data->id; ?>" 
                               class="btn btn-xs btn-circle green" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                            <?php 
                                }
                                if( ($group_id==1)||($hak_akses['delete_sales_order']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/BackOffice/delete_sales_order/<?php echo $data->id; ?>" 
                               class="btn btn-xs btn-circle red" style="margin-bottom:4px" 
                               onclick="return confirm('Anda yakin menghapus data ini?');">
                                <i class="fa fa-trash-o"></i> Hapus </a>
                            <?php }?>
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
        