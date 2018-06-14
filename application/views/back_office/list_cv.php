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
                                    Kode CV <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="kode_cv" name="kode_cv" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()" maxlength="5">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama CV <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_cv" name="nama_cv" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                    
                                    <input type="hidden" id="id" name="id">                                    
                                    <input type="hidden" id="total_penjualan" name="total_penjualan">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Limit Penjualan <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="limit_penjualan" name="limit_penjualan" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeydown="return myCurrency(event);" 
                                        onkeyup="getComa(this.value);">
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
            if( ($group_id==1)||($hak_akses['list_cv']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user"></i>List CV
                </div>
                <div class="tools">    
                    <a style="height:28px" class="btn btn-circle btn-sm default" onclick="newData()">
                        <i class="fa fa-plus"></i> Tambah</a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Kode CV</th>
                    <th>Nama CV</th> 
                    <th>Limit Penjualan (Rp)</th> 
                    <th>Akumulasi Penjualan (Rp)</th> 
                    <th>Sisa Limit (Rp)</th>  
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
                        <td><?php echo $data->kode_cv; ?></td> 
                        <td><?php echo $data->nama_cv; ?></td> 
                        <td style="text-align:right"><?php echo number_format($data->limit_penjualan,0,',','.'); ?></td> 
                        <td style="text-align:right"><?php echo number_format($data->total_penjualan,0,',','.'); ?></td> 
                        <td style="text-align:right"><?php echo number_format($data->sisa_limit,0,',','.'); ?></td> 
                        <td> 
                            <?php
                                if( ($group_id==1)||($hak_akses['edit_cv']==1) ){
                            ?>
                            <a class="btn btn-circle btn-xs green" onclick="editData(<?php echo $data->id; ?>)" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                            <?php 
                                }
                                if( ($group_id==1)||($hak_akses['delete_cv']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/BackOffice/delete_cv/<?php echo $data->id; ?>" 
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
<script>
var dsState;

function newData(){
    $('#kode_cv').val('');
    $('#nama_cv').val('');
    $('#limit+penjualan').val('');
    $('#id').val('');
    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Input Data CV');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#kode_cv").val()) == ""){
        $('#message').html("Kode CV harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#nama_cv").val()) == ""){
        $('#message').html("Nama CV harus diisi!");
        $('.alert-danger').show();
    }else if($.trim($("#limit_penjualan").val()) == ""){
        $('#message').html("Limit penjualan harus diisi!");
        $('.alert-danger').show();
    }else{      
        if(dsState=="Input"){
            $.ajax({
                type:"POST",
                url:'<?php echo base_url('index.php/BackOffice/cek_cv'); ?>',
                data:"data="+$("#nama_cv").val(),
                success:function(result){
                    //console.log(result);
                    if(result=="ADA"){
                        $('#message').html("Nama CV sudah ada, silahkan ganti dengan nama lain agar mudah dalam maintenance data!");
                        $('.alert-danger').show();
                    }else{
                        $('#message').html("");
                        $('.alert-danger').hide();
                        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/BackOffice/save_cv");
                        $('#formku').submit();                    
                    }
                }
            });
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/BackOffice/update_cv");
            $('#formku').submit(); 
        }
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/BackOffice/edit_cv'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            console.log(result);
            $('#kode_cv').val(result['kode_cv']);
            $('#nama_cv').val(result['nama_cv']);
            $('#limit_penjualan').val(result['limit_penjualan']);
            $('#total_penjualan').val(result['total_penjualan']);
            $('#id').val(result['id']);
            
            $("#myModal").find('.modal-title').text('Edit CV');
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
    $('#limit_penjualan').val(nilai.toString().replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}
</script>         