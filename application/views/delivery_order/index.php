<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success <?php echo (empty($this->session->flashdata('flash_msg'))? "display-hide": ""); ?>" id="box_msg_sukses">
            <button class="close" data-close="alert"></button>
            <span id="msg_sukses"><?php echo $this->session->flashdata('flash_msg'); ?></span>
        </div>
    </div>
</div>
<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if( ($group_id==1)||($hak_akses['delivery_order']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>Daftar Delivery Order - PABRIK
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>   
                    <th>Nomor DO</th>
                    <th>Produk</th> 
                    <th>Customer</th> 
                    <th>PIC</th> 
                    <th style="width:180px">Alamat</th>
                    <th>Ekspedisi</th>
                    <th>Flag <br>Sumbangan</th>
                    <th>Total <br>Order (Kg)</th> 
                    <th>Actions</th>
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
                        <td><?php echo $data->no_delivery_order; ?></td>
                        <td><?php echo $data->produk; ?></td>
                        <td><?php echo $data->nama_customer; ?></td>
                        <td><?php echo $data->pic; ?></td>
                        <td><?php echo $data->alamat; ?></td>
                        <td><?php echo $data->nama_ekspedisi; ?></td>
                        <td style="text-align:center"><?php echo (($data->flag_sumbangan==1)? "Yes": ""); ?></td>
                        <td style="text-align:right;color:blue">
                            <?php echo number_format($data->total_berat,0,',','.'); ?>
                        </td>
                        <td style="text-align:center">
                            <?php
                                if($data->flag_set_harga==0 && $data->produk=="SAGU"){
                            ?>
                            <a href="<?php echo base_url('index.php/BackOffice/set_harga/'.$data->id); ?>" 
                                class="btn btn-xs btn-circle green" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-print"></i> Set Harga &nbsp;</a>
                            <?php } ?>
                        </td>
                        <td style="text-align:center">
                            <?php 
                                if( ($group_id==1)||($hak_akses['cetak_delivery_order']==1) ){
                                    if($data->produk=="SAGU"){
                                        echo '<a href="'.base_url().'index.php/BackOffice/print_do/'.$data->id.'" 
                                                class="btn btn-xs btn-circle blue-hoki" style="margin-bottom:4px">
                                                &nbsp; <i class="fa fa-print"></i> Cetak &nbsp;</a>';
                                    }else{
                                        echo '<a href="'.base_url().'index.php/BackOffice/print_do_onggok/'.$data->id.'" 
                                                class="btn btn-xs btn-circle blue-hoki" style="margin-bottom:4px">
                                                &nbsp; <i class="fa fa-print"></i> Cetak &nbsp;</a>';
                                    }
                                } 
                            ?>
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
        