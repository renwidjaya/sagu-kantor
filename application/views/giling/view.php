<div class="row">                            
    <div class="col-md-12">         
        <?php
            if( ($group_id==1)||($hak_akses['view']==1) ){
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">No. Giling</div>
                    <div class="col-md-6">: <strong><?php echo $header['no_giling']; ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-md-4">Tanggal</div>
                    <div class="col-md-6">: <?php echo date('d-m-Y', strtotime($header['tanggal'])); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-4">Total berat diproses</div>
                    <div class="col-md-6">: <?php echo number_format($header['berat_diproses'],0,',','.'); ?> Kg</div>
                </div>
            </div>
            <div class="col-md-6" style="text-align:right">
                <a class="btn green" 
                    href="<?php echo base_url(); ?>index.php/Giling">
                     <i class="fa fa-chevron-left"></i> Kembali</a>
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
