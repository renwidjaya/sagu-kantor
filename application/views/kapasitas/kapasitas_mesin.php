<div class="row">                            
    <div class="col-md-12">         
        <?php
            if( ($group_id==1)||($hak_akses['kapasitas_mesin']==1) ){
        ?>        
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-sun-o"></i>Kapasitas Mesin
                </div>                 
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Start</th>  
                    <th>Jam Start</th>
                    <th>Delay (menit)</th>   
                    <th>Tanggal Stop</th> 
                    <th>Jam Stop</th>
                    <th>Waktu Operasional</th> 
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
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($data->tanggal_start)); ?></td>  
                        <td style="text-align:center">
                            <?php echo $data->jam_start; ?>
                        </td> 
                        <td style="text-align:right"><?php echo $data->delay; ?></td>  
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($data->tanggal_stop)); ?></td>  
                        <td style="text-align:center">
                            <?php echo $data->jam_stop; ?>
                        </td>
                        <td style="text-align:center">
                            <?php echo $data->waktu." (".$data->waktu2.")"; ?>
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