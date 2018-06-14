<div class="row">                            
    <div class="col-md-12">         
        <?php
            if( ($group_id==1)||($hak_akses['list_otorisasi']==1) ){
        ?>

        <div class="row" style="margin-bottom:5px">
            <div class="col-md-6">
                <a href="<?php echo base_url().'index.php/Otorisasi/print_list_otorisasi'; ?>" class="btn green">
                    <i class="fa fa-print"></i> Export to Excel </a>
            </div>
        </div>
            
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-car"></i>List Kendaraan Keluar - Masuk ke Pabrik
                </div>
                
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>                     
                    <th>Agen</th>
                    <th>Type Agen</th> 
                    <th>Nomor Polisi</th> 
                    <th>Nama Supir</th>
                    <th>Transaksi</th>
                    <th>Muatan</th>                    
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0;
                        foreach ($list_data as $data){
                            $no++;
                    ?>
                    <tr> 
                        <td style="width:50px; text-align:center;"><?php echo $no; ?></td>
                        <td><?php echo date('d-m-Y h:m:s', strtotime($data->time_in)); ?></td>                        
                        <td><?php echo $data->nama_agen; ?></td>  
                        <td><?php echo $data->jenis_agen; ?></td> 
                        <td><?php echo $data->no_kendaraan; ?></td> 
                        <td><?php echo $data->supir; ?></td>
                        <td><?php echo $data->jenis_transaksi; ?></td>
                        <td>
                            <?php 
                                if(!empty($data->nama_muatan)){
                                    echo ($data->nama_muatan=="LAIN-LAIN")? $data->deskripsi: $data->nama_muatan; 
                                }else{
                                    echo "Kendaraan Kosong";
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
