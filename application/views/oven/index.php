<div class="row">                            
    <div class="col-md-12">  
        <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Judul</h4>
                    </div>
                    <div class="modal-body">
                        <form class="eventInsForm" method="post" target="_self" name="formku" 
                              id="formku">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger display-hide">
                                        <button class="close" data-close="alert"></button>
                                        <span id="message">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-5">
                                    No. Giling <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="t_giling_id" name="t_giling_id" class="form-control myline select2me" 
                                        data-placeholder="Pilih no giling..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_giling as $row){
                                                echo '<option value="'.$row->t_giling_id.'">'.$row->no_giling.' -- '.date('d-m-Y', strtotime($row->tanggal)).'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>    
                            <div class="row">                                
                                <div class="col-md-5">
                                    Assign ke CV <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="m_cv_id" name="m_cv_id" class="form-control myline select2me" 
                                        data-placeholder="Pilih nama CV..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_cv as $row){
                                                echo '<option value="'.$row->id.'">'.$row->nama_cv.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" onClick="simpandata();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            if( ($group_id==1)||($hak_akses['index']==1) ){
        ?>        
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-coffee"></i>Hasil Oven
                </div>  
                <div class="tools">    
                    <a style="height:28px" class="btn btn-circle btn-sm default" onclick="newData()">
                        <i class="fa fa-plus"></i> Assign ke CV</a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>  
                    <th>No Giling</th>
                    <th>Oven</th>   
                    <th>Sak</th> 
                    <th>Pulau (Kg)</th>
                    <th>KWR (Kg)</th>
                    <th>PH (Kg)</th>
                    <th>Polos (Kg)</th>
                    <th>Total (Kg)</th>
                    <th>Assign ke CV</th>
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
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>  
                        <td><?php echo $data->no_giling; ?></td>
                        <td style="text-align:center"><?php echo $data->oven; ?></td> 
                        <td style="text-align:center"><?php echo $data->sak; ?></td>
                        <td style="text-align:right"><?php echo number_format($data->sagu_pulau,0,',','.'); ?></td>
                        <td style="text-align:right"><?php echo number_format($data->sagu_kwr,0,',','.'); ?></td>
                        <td style="text-align:right"><?php echo number_format($data->sagu_ph,0,',','.'); ?></td>
                        <td style="text-align:right"><?php echo number_format($data->sagu_polos,0,',','.'); ?></td>
                        <td style="text-align:right; background-color: #ccccff"><?php echo number_format($data->total,0,',','.'); ?></td> 
                        <td style="text-align:right;">
                            <?php echo $data->nama_cv; ?>
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
<script>
function newData(){  
    $("#t_giling_id").select2('val', '');
    $("#m_cv_id").select2('val', '');
    
    $("#myModal").find('.modal-title').text('Assign Data Hasil Oven ke CV');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){    
    if($.trim($("#t_giling_id").val()) == ""){
        $('#message').html("Pilih dulu nomor giling!");
        $('.alert-danger').show(); 
    }else if($.trim($("#m_cv_id").val()) == ""){
        $('#message').html("Pilih dulu nama CV!");
        $('.alert-danger').show();    
        
    }else{   
        $('#message').html("");
        $('.alert-danger').hide();
        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Oven/save");
        $('#formku').submit();
    };
};
</script>