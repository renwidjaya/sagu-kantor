<div class="row">                            
    <div class="col-md-12">         
        <?php
            if( ($group_id==1)||($hak_akses['detail_giling']==1) ){
        ?>
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-4">No. Giling</div>
                    <div class="col-md-6">
                        <input type="text" id="no_giling" name="no_giling" class="form-control myline" 
                               readonly="readonly" value="<?php echo $header['no_giling']; ?>" style="margin-bottom:4px">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">Tanggal</div>
                    <div class="col-md-6">
                        <input type="text" id="tanggal" name="tanggal" class="form-control myline" style="margin-bottom:4px"
                            readonly="readonly" value="<?php echo date('d-m-Y', strtotime($header['tanggal'])); ?>">
                    </div>
                </div>
                
            </div>
            <div class="col-md-2">&nbsp;</div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-5">Assign ke CV</div>
                    <div class="col-md-7">
                        <input type="text" id="nama_cv" name="nama_cv" class="form-control myline" style="margin-bottom:4px"
                            readonly="readonly" value="<?php echo $header['nama_cv']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">Total berat diproses</div>
                    <div class="col-md-7">
                        <input type="text" id="berat_diproses" name="berat_diproses" class="form-control myline" style="margin-bottom:4px"
                            readonly="readonly" value="<?php echo number_format($header['berat_diproses'],0,',','.'); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-text-o"></i>Detail item yang digiling
                </div>   
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pembelian</th>  
                        <th>Jam Masuk</th>
                        <th>Nama Agen</th>   
                        <th>Nomor Polisi</th> 
                        <th>Nama Supir</th>
                        <th>Berat (Kg)</th>
                        <th>Pasir</th>
                        <th>Tanah</th>
                        <th>Kadar Aci</th>
                        <th>Ukuran</th>
                        <th>Bonggol</th>
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
                            <td><?php echo date('d-m-Y', strtotime($data->time_in)); ?></td>  
                            <td style="text-align:center"><?php echo date('h:m', strtotime($data->time_in)); ?></td> 
                            <td><?php echo $data->nama_agen; ?></td>  
                            <td><?php echo $data->no_kendaraan; ?></td> 
                            <td><?php echo $data->supir; ?></td>
                            <td style="text-align:right; background-color: #ccccff"><?php echo number_format($data->berat_bersih,0,',','.'); ?></td> 
                            <td><?php echo $data->qc01; ?></td>
                            <td><?php echo $data->qc02; ?></td>
                            <td><?php echo $data->qc03; ?></td>
                            <td><?php echo $data->qc04; ?></td>
                            <td><?php echo $data->qc05; ?></td>                        
                        </tr>
                        <?php
                            }                        
                        ?>                                                                                    
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">                
                <a class="btn blue" 
                    href="<?php echo base_url(); ?>index.php/Laporan/giling_harian">
                     <i class="fa fa-chevron-left"></i> Kembali</a>
                     
                <a href="<?php echo base_url('index.php/Laporan/print_detail_giling/'.$header['id']); ?>" 
                    class="btn green" style="margin-right:0">
                        <i class="fa fa-print"></i> Export to Excel </a>
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
