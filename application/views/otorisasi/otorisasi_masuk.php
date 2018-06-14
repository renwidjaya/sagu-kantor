<div class="row">                            
    <div class="col-md-12">         
        <?php
            if( ($group_id==1)||($hak_akses['otorisasi_masuk']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-car"></i>Otorisasi Kendaraan - Masuk
                </div>
                <div class="tools">                                            
                    <a href="<?php echo base_url(); ?>index.php/Otorisasi/add_masuk" style="height:28px" class="btn btn-circle btn-sm default">
                        <i class="fa fa-plus"></i> Tambah</a>
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
                    <th>Status</th>
                    <?php
                        if( ($group_id==1)||($hak_akses['edit_masuk']==1) ||($hak_akses['delete']==1)){
                    ?>
                    <th>Actions</th>
                    <?php } ?>
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
                        <td style="text-align: center">
                            <?php 
                                if($data->status==1){
                                    echo "<div style='color:red'>MASUK</div>";
                                }else if($data->status==2){
                                    echo "<div style='color:blue'>TIMBANG 1</div>";
                                }else{
                                    echo "<div style='color:green'>TIMBANG 2</div>";
                                }
                            ?>
                        </td> 
                        <td style="text-align:center"> 
                            <?php
                                if( ($group_id==1)||($hak_akses['edit_masuk']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/Otorisasi/edit_masuk/<?php echo $data->id; ?>" class="btn btn-circle btn-xs green" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                            <?php 
                                }
                                if( ($group_id==1)||($hak_akses['delete']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/Otorisasi/delete/<?php echo $data->id; ?>" 
                               class="btn btn-circle btn-xs red" style="margin-bottom:4px" onclick="return confirm('Anda yakin menghapus data ini?');">
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
