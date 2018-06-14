<div class="row">                            
    <div class="col-md-12">        
        <?php
            if( ($group_id==1)||($hak_akses['otorisasi_keluar']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-car"></i>Otorisasi Kendaraan - Keluar
                </div>                
            </div>
            <div class="portlet-body">
                <form class="eventInsForm" method="post" target="_self" name="formku" 
                    id="formku" action="<?php echo base_url('index.php/Otorisasi/save_keluar'); ?>">
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="alert alert-danger display-hide" id="msg_box">
                                <button class="close" data-close="alert"></button>
                                <span id="pesan_error">&nbsp;</span>
                            </div>
                        </div>
                    </div>
                
                    <table class="table table-striped table-bordered table-hover" id="sample_6">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="check_all" name="check_all" onclick="checkAll()" class="form-control">
                        </th>
                        <th>No</th>
                        <th>Tanggal</th>                     
                        <th>Agen</th>   
                        <th>Type Agen</th>
                        <th>Nomor Polisi</th> 
                        <th>Nama Supir</th>
                        <th>Transaksi</th>
                        <th>Muatan</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 0;
                            foreach ($list_data as $data){
                                $no++;
                        ?>
                        <tr> 
                            <td>                                                    
                                <input type="checkbox" value="1" id="check_<?php echo $no; ?>" name="mydata[<?php echo $no; ?>][check]" 
                                    onclick="check();" class="form-control">                            
                            </td>
                            <td style="width:50px; text-align:center">
                                <?php echo $no; ?>
                                <input type="hidden" id="id_otorisasi_<?php echo $no; ?>" name="mydata[<?php echo $no; ?>][otorisasi_id]" value="<?php echo $data->id; ?>">
                            </td>
                            <td><?php echo date('d-m-Y h:m:s', strtotime($data->time_in)); ?></td>                        
                            <td><?php echo $data->nama_agen; ?></td>  
                            <td><?php echo $data->jenis_agen; ?></td>
                            <td><?php echo $data->no_kendaraan; ?></td> 
                            <td><?php echo $data->supir; ?></td>
                            <td><?php echo $data->jenis_transaksi; ?></td>
                            <td><?php echo ($data->nama_muatan=="LAIN-LAIN")? $data->deskripsi: $data->nama_muatan; ?></td>                             
                            <td style="color:red; text-align: center">Timbang 2</td>                         
                        </tr>
                        <?php
                            }
                        ?>                                                                                    
                    </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <input type="button" onClick="simpandata();" name="btnSave" 
                                value="Otorisasi" class="btn btn-primary" id="btnSave">
                        </div>
                     </div>
                </form>
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
function checkAll(){
    if ($('#check_all').prop("checked")) {
        for(i=1;i<50;i++){
            $('#uniform-check_'+i+' span').attr('class', 'checked');
            $('#check_'+i).attr('checked', true);
        }
    }else{
        for(i=1;i<50;i++){
            $('#uniform-check_'+i+' span').attr('class', '');
            $('#check_'+i).attr('checked', false);
        }
    }    
}

function check(){
    $('#uniform-check_all span').attr('class', '');
    $('#check_all').attr('checked', false);          
}

function simpandata(){
    var item_check = 0;
    $('input').each(function(i){
        if($('#check_'+i).prop("checked")){
            item_check += 1;                    
        }
    });
    if(item_check==0){
        $('#pesan_error').html("Silahkan pilih kendaraan yang akan diotorisasi!"); 
        $('#msg_box').show();
    }else{
        $('#pesan_error').html("");
        $('#msg_box').hide();
        $('#formku').submit();                    
    };
};

function newData(){
    var dt = $('#jmldata').val();
    if (dt>=2){
        if(confirm('Seharusnya jumlah kendaraan masuk tidak boleh lebih dari 2 (dua). Apakah anda yakin melakukan proses otorisasi masuk?')){				
            window.location = "<?php echo base_url(); ?>index.php/Otorisasi/add_masuk";
        }else{
            return false;
        } 
    }else{
        window.location = "<?php echo base_url(); ?>index.php/Otorisasi/add_masuk";
    }
}
</script>