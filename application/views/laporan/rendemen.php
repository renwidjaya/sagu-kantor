<div class="row">                            
    <div class="col-md-12">         
        <?php
            if(($group_id==1)||($hak_akses['rendemen']==1)){
        ?>  
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-coffee"></i>Laporan Rendemen
                </div>  
                
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Produksi</th>  
                    <th>Total Giling (Kg)</th>
                    <th>Total Produksi Sagu (Kg)</th>   
                    <th>Total Sisa (Kg)</th> 
                    <th>Rendemen (%)</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0;
                        foreach ($list_data as $data){
                            $no++;
                            $total_sagu = $data->total_sagu_ovn1 + $data->total_sagu_ovn2;
                            $rendamen = (($total_sagu - $data->total_sisa)/ $data->total_giling)*100;
                    ?>
                    <tr> 
                        <td style="width:50px; text-align:center"><?php echo $no; ?></td>
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>  
                        <td style="text-align:right"><?php echo number_format($data->total_giling,0,',','.'); ?></td>
                        <td style="text-align:right"><?php echo number_format($total_sagu,0,',','.'); ?></td>
                        <td style="text-align:right"><?php echo number_format($data->total_sisa,0,',','.'); ?></td>
                        <td style="text-align:right"><?php echo number_format($rendamen,2,',','.'); ?></td>
                        <td style="text-align:right">
                            <?php
                                if( ($group_id==1)||($hak_akses['print_rendemen']==1) ){
                                    $uri = $data->tanggal.'/'.$data->total_giling.'/';
                                    $uri .= (!empty($data->total_sagu_ovn1))? $data->total_sagu_ovn1: '0';
                                    $uri .= '/';
                                    $uri .= (!empty($data->total_sagu_ovn2))? $data->total_sagu_ovn2: '0';
                                    $uri .= '/';
                                    $uri .= (!empty($data->total_sisa))? $data->total_sisa: '0';
                                    $uri .= '/';
                                    $uri .= (!empty($rendamen))? $rendamen: '0';
                                    
                                    echo '<a href="'.base_url().'index.php/Laporan/print_rendemen/'.$uri.'" 
                                            class="btn btn-circle btn-xs green" style="margin-bottom:4px">
                                            &nbsp; <i class="fa fa-print"></i> Print &nbsp; </a>';
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
