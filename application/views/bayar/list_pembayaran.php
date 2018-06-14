<div class="row">                            
    <div class="col-md-12"> 
        <?php
            if( ($group_id==1)||($hak_akses['index']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>Daftar Nota Pembayaran
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>   
                    <th>No Nota</th> 
                    <th>Tempat Transaksi</th> 
                    <th>Agen</th>
                    <th>No. Kendaraan</th> 
                    <th>Nama Supir</th> 
                    <th>Jenis Barang</th> 
                    <th>Netto (Kg)</th> 
                    <th>Harga (Rp)</th> 
                    <th>Total Harga (Rp)</th>                     
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
                        <td><?php echo $data->no_nota; ?></td>
                        <td><?php echo $data->tempat_transaksi; ?></td>
                        <td><?php echo $data->nama_agen; ?></td>
                        <td><?php echo $data->no_kendaraan; ?></td>
                        <td><?php echo $data->supir; ?></td>
                        <td><?php echo $data->jenis_barang; ?></td>
                        <td style="text-align:right;"><?php echo number_format($data->berat_bersih,0,',','.'); ?></td>
                        <td style="text-align:right;"><?php echo number_format($data->harga,0,',','.'); ?></td>
                        <td style="text-align:right;"><?php echo number_format($data->total_harga,0,',','.'); ?></td>
                        <td style="text-align:center"> 
                            <a href="#" 
                               class="btn btn-xs btn-circle green" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Lihat &nbsp; </a> 
                            <a href="#" 
                               class="btn btn-xs btn-circle green" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-print"></i> Cetak &nbsp; </a>
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
        