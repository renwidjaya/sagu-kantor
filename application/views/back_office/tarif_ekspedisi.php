<div class="row">                            
    <div class="col-md-12">   
        <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">&nbsp;</h4>
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
                                    Kota Asal <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">                                    
                                    <select id="asal_id" name="asal_id" class="form-control select2me myline" 
                                        data-placeholder="Pilih kota asal..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_city as $value){
                                                echo "<option value='".$value->id."'>".$value->city_name."</option>";
                                            }
                                        ?>
                                    </select>
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="m_ekspedisi_id" name="m_ekspedisi_id" value="<?php echo $header_id; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Kota Tujuan <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="tujuan_id" name="tujuan_id" class="form-control select2me myline" 
                                        data-placeholder="Pilih kota tujuan..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_city as $value){
                                                echo "<option value='".$value->id."'>".$value->city_name."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Tarif <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="tarif" name="tarif" class="form-control myline" 
                                        style="margin-bottom:5px" onkeydown="return myCurrency(event);" 
                                        onkeyup="getComa(this.value);" >
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
            if( ($group_id==1)||($hak_akses['tarif_ekspedisi']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cc-visa"></i>
                    Tarif Ekspedisi <?php echo $header_data[0]->nama_ekspedisi; ?>
                </div>
                <div class="tools">                                                              
                    <?php
                        if( ($group_id==1)||($hak_akses['add_tarif']==1) ){
                            echo '<a style="height:28px" class="btn btn-circle btn-sm default" onclick="newData()">
                                <i class="fa fa-plus"></i> Tambah</a>';
                        }
                    ?>  
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Kota Asal</th>   
                    <th>Kota Tujuan</th> 
                    <th>Tarif (Rp)</th> 
                    <th>Actions</th>
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
                        <td><?php echo $data->kota_asal; ?></td>
                        <td><?php echo $data->kota_tujuan; ?></td>
                        <td style="text-align:right"><?php echo number_format($data->tarif,0,',','.'); ?></td>
                        <td style="text-align:center"> 
                            <?php
                                if( ($group_id==1)||($hak_akses['edit_tarif']==1) ){
                            ?>
                            <a class="btn btn-circle btn-xs green" onclick="editData(<?php echo $data->id; ?>)" style="margin-bottom:4px">
                               &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                            <?php 
                                }
                                if( ($group_id==1)||($hak_akses['delete_tarif']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/BackOffice/delete_tarif/<?php echo $data->id; ?>" 
                               class="btn btn-xs btn-circle red" style="margin-bottom:4px" 
                               onclick="return confirm('Anda yakin menghapus data ini?');">
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
<script>
var dsState;

function newData(){
    $('#asal_id').select2('val', '');
    $('#tujuan_id').select2('val', '');
    $('#tarif').val('');
    $('#id').val('');
    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Input Tarif Ekspedisi');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#asal_id").val()) == ""){
        $('#message').html("Pilih dulu kota asal!");
        $('.alert-danger').show();       
    }else if($.trim($("#tujuan_id").val()) == ""){
        $('#message').html("Pilih dulu kota tujuan!");
        $('.alert-danger').show();
    }else if($.trim($("#tarif").val()) == ""){
        $('#message').html("Tarif tidak boleh kosong!");
        $('.alert-danger').show();
    }else{       
        $('#message').html("");
        $('.alert-danger').hide();
        if(dsState=="Input"){
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/BackOffice/save_tarif");
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/BackOffice/update_tarif");            
        }
        $('#formku').submit(); 
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/BackOffice/edit_tarif'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
           console.log(result);
           $('#asal_id').select2('val', result['asal_id']);
           $('#tujuan_id').select2('val', result['tujuan_id']);
           $('#tarif').val(result['tarif']);
           $('#id').val(result['id']);
           
           $("#myModal").find('.modal-title').text('Edit Tarif');
           $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}

function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function getComa(nilai){
    $('#tarif').val(nilai.toString().replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}
</script>
        