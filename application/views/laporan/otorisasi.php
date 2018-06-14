<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$( function() {    
    $("#tgl_awal").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>img/Kalender.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy'
    });    
    
    $("#tgl_akhir").datepicker({
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
            if( ($group_id==1)||($hak_akses['otorisasi']==1) ){
        ?>
        <div class="row">
            <div class="col-md-12">
                <form accept-charset="utf-8" action="<?php echo base_url().'index.php/Laporan/otorisasi'; ?>" 
                    method="post" id="frm_search">
                <fieldset>
                    <legend>Filter Data</legend>
                    <div class="row">
                        <div class="col-md-1">
                            Mulai Tanggal
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="tgl_awal" name="tgl_awal" 
                                class="form-control myline" style="margin-bottom:5px;float:left; width:70%" 
                                value="<?php echo date('d-m-Y', strtotime($tgl_awal_show)); ?>">
                        </div>
                        <div class="col-md-1">
                            Sampai Tanggal
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="tgl_akhir" name="tgl_akhir" 
                                class="form-control myline" style="margin-bottom:5px;float:left; width:70%" 
                                value="<?php echo date('d-m-Y', strtotime($tgl_akhir_show)); ?>">
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="btn green" id="btnSubmit" 
                                name="btnSubmit" value=" Search "> &nbsp;

                            <a href="<?php echo base_url().'index.php/Laporan/otorisasi'; ?>" class="btn default">
                                <i class="fa fa-times"></i> Reset </a>
                        </div>
                        <div class="col-md-3" style="text-align:right">
                            <?php
                                if( ($group_id==1)||($hak_akses['print_otorisasi']==1) ){
                                    echo '<a href="'.base_url().'index.php/Laporan/print_otorisasi/'.((!empty($tgl_awal))? $tgl_awal: "NULL").'/'.$tgl_akhir.'" 
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
                    <i class="fa fa-file-o"></i>Laporan Kendaraan Masuk dan Keluar
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>  
                    <th>Jam <br>Masuk</th>
                    <th>Transaksi</th>
                    <th>Agen</th>   
                    <th>No. Kendaraan</th> 
                    <th>Supir</th>
                    <th>Muatan</th>
                    <th>Status</th>
                    <th>Waktu <br>Timbang 1</th>
                    <th>Waktu <br>Timbang 2</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0;
                        $status = array(1=>'Masuk', 2=>'Timbang 1', 3=>'Timbang 2', 9=>'Keluar');
                        foreach ($list_data as $data){
                            $no++;
                    ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no; ?></td>  
                        <td><?php echo date('d-m-Y', strtotime($data->time_in)); ?></td>  
                        <td style="text-align:center"><?php echo date('h:m', strtotime($data->time_in)); ?></td>
                        <td><?php echo $data->jenis_transaksi; ?></td>
                        <td><?php echo $data->nama_agen.((!empty($data->jenis_agen))? " (".$data->jenis_agen.")": ""); ?></td>                       
                        <td><?php echo $data->no_kendaraan." -- ".$data->type_kendaraan; ?></td> 
                        <td><?php echo $data->supir; ?></td>
                        <td><?php 
                                if($data->nama_muatan=="LAIN-LAIN"){
                                    echo $data->deskripsi;
                                }else{
                                    if(!empty($data->nama_muatan)){
                                        echo $data->nama_muatan;
                                    }else{
                                        $muatan = trim(str_replace(" ", "", $data->deskripsi), "\n");
                                        if(empty($muatan)){
                                            echo "Kendaraan Kosong";
                                        }else{
                                            echo $data->deskripsi;                                
                                        }
                                    }
                                }
                            ?>
                        </td> 
                        <td style="color:red;"><?php echo $status[$data->status]; ?></td> 
                        <td><small>
                            <?php 
                                if($data->start_timbang_1!="0000-00-00 00:00:00" && $data->start_timbang_1!=NULL){
                                    $start1  = new DateTime($data->start_timbang_1);
                                    $end1    = new DateTime($data->end_timbang_1);
                                    $durasi1 = $end1->diff($start1);
                                    $jam1    = $durasi1->format('%h');
                                    $menit1  = $durasi1->format('%i');
                                    $detik1  = $durasi1->format('%s');
                                    $mydurasi1 = "";
                                    if($jam1>0){
                                        $mydurasi1 .= $jam1." jam ";
                                    }
                                    if($menit1>0){
                                        $mydurasi1 .= $menit1." menit ";
                                    }
                                    if($detik1>0){
                                        $mydurasi1 .= $detik1." detik ";
                                    }
                                    $mydurasi1 .= "(".date('h:m:s', strtotime($data->start_timbang_1))." s/d ";
                                    $mydurasi1 .= date('h:m:s', strtotime($data->end_timbang_1)).")";
                                    echo $mydurasi1;
                                }  
                            ?>
                            </small>
                        </td> 
                        <td>
                            <small>
                            <?php 
                                if($data->start_timbang_2!="0000-00-00 00:00:00" && $data->start_timbang_2!=NULL){
                                    $start2  = new DateTime($data->start_timbang_2);
                                    $end2    = new DateTime($data->end_timbang_2);
                                    $durasi2 = $end2->diff($start2);
                                    $jam2    = $durasi2->format('%h');
                                    $menit2  = $durasi2->format('%i');
                                    $detik2  = $durasi2->format('%s');
                                    $mydurasi2 = "";
                                    if($jam2){
                                        $mydurasi2 .= $jam2." jam ";
                                    }
                                    if($menit2>0){
                                        $mydurasi2 .= $menit2." menit ";
                                    }
                                    if($detik2>0){
                                        $mydurasi2 .= $detik2." detik ";
                                    }
                                    $mydurasi2 .= "(".date('h:m:s', strtotime($data->start_timbang_2))." s/d ";
                                    $mydurasi2 .= date('h:m:s', strtotime($data->end_timbang_2)).")";
                                    echo $mydurasi2;
                                }  
                            ?>
                            </small>
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
