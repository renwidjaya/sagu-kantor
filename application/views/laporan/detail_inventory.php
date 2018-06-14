<div class="row">                            
    <div class="col-md-12">       
        <?php
            if( ($group_id==1)||($hak_akses['detail_inventory']==1) ){
        ?>
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-5">Nama CV</div>
                    <div class="col-md-7">
                        <input type="text" id="nama_cv" name="nama_cv" readonly="readonly" class="form-control myline"
                               value="<?php echo ($header['m_cv_id']==0)? 'Pabrik': $header['nama_cv']; ?>" 
                               style="margin-bottom:5px">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">Barang/ Produk</div>
                    <div class="col-md-7">
                        <input type="text" id="nama_produk" name="nama_produk" readonly="readonly"
                            value="<?php echo $header['nama_produk']; ?>" class="form-control myline" 
                            style="margin-bottom:5px">
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5">                
                <div class="row">
                    <div class="col-md-5">Stok Sekarang (Kg)</div>   
                    <div class="col-md-7">
                        <input type="text" id="stok" name="stok" readonly="readonly"
                            value="<?php echo number_format($header['stok'],0,',','.'); ?>" 
                            class="form-control myline" style="margin-bottom:5px">
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-o"></i>List Detail Inventory
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th> 
                    <th>Jumlah Masuk (Kg)</th>
                    <th>Jumlah Keluar (Kg)</th>
                    <th>Referensi ke</th>
                    <th>Referensi index</th>
                    <th>Referensi No</th>
                    <th>Catatan</th>                    
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0;
                        foreach ($detail as $data){
                            $no++;
                    ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no; ?></td>  
                        <td><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>
                        <td style="text-align:right">
                            <?php echo number_format($data->jumlah_masuk,0,',','.'); ?>
                        </td>
                        <td style="text-align:right">
                            <?php echo number_format($data->jumlah_keluar,0,',','.'); ?>
                        </td>
                        <td><?php echo $data->referensi_name; ?></td>
                        <td><?php echo $data->referensi_id; ?></td>
                        <td><?php echo $data->referensi_no; ?></td>
                        <td>
                            <?php echo $data->catatan; ?>
                        </td>                                                                           
                    </tr>
                    <?php
                        }
                    ?>                     
                </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url('index.php/Laporan/inventory'); ?>" class="btn blue-ebonyclay">
                    Kembali</a>
                
                <?php
                    if( ($group_id==1)||($hak_akses['print_detail_inventory']==1) ){
                        echo '<a href="'.base_url().'index.php/Laporan/print_detail_inventory/'.$header['nama_produk'].'" 
                            class="btn green" style="margin-right:0">
                                <i class="fa fa-print"></i> Export to Excel </a>';
                    }
                ?>
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
