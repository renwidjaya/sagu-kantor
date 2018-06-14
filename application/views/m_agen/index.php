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
                                    Nama Agen <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_agen" name="nama_agen" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Alamat
                                </div>
                                <div class="col-md-7">
                                    <textarea id="alamat" name="alamat" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Provinsi
                                </div>
                                <div class="col-md-7">
                                    <select id="m_province_id" name="m_province_id" class="form-control select2me myline" 
                                        data-placeholder="Pilih provinsi..." style="margin-bottom:5px" onclick="get_city_list(this.value);">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_provinsi as $value){
                                                echo "<option value='".$value->id."'>".$value->province_name."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Kota
                                </div>
                                <div class="col-md-7">
                                    <select id="m_city_id" name="m_city_id" class="form-control select2me myline" 
                                        data-placeholder="Pilih kota..." style="margin-bottom:5px">
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
                                    Penanggung Jawab (PIC)
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="pic" name="pic" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Nomor Telepon
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="telepon" name="telepon" 
                                        class="form-control myline" style="margin-bottom:5px">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Jenis Agen <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <select id="jenis_agen" name="jenis_agen" class="form-control myline select2me" 
                                        data-placeholder="Select..." style="margin-bottom:5px">
                                        <option value="Lokal">Lokal</option>
                                        <option value="Luar">Luar</option>
                                    </select>
                                </div>
                            </div>
                            <!--div class="row">
                                <div class="col-md-5">
                                    Ekspedisi <small><i>Nama ekspedisi yang digunakan</i></small>
                                </div>
                                <div class="col-md-7">
                                    <select id="m_ekspedisi_id" name="m_ekspedisi_id" class="form-control select2me myline" 
                                        data-placeholder="Pilih ekspedisi..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <?php
                                            foreach ($list_ekspedisi as $value){
                                                echo "<option value='".$value->id."'>".$value->nama_ekspedisi."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div-->
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
                    <i class="fa fa-user"></i>Master Agen
                </div>
                <div class="tools">    
                    <?php
                        if( ($group_id==1)||($hak_akses['add']==1) ){
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
                    <th>Nama Agen</th>   
                    <th>Alamat</th> 
                    <th>Provinsi</th>
                    <th>Kota</th>
                    <th>Penanggung Jawab</th> 
                    <th>Nomor Telepon</th>
                    <th>Jenis Agen</th> 
                    <!--th>Ekspedisi</th-->
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
                        <td><?php echo $data->nama_agen; ?></td>
                        <td><?php echo $data->alamat; ?></td>
                        <td><?php echo $data->province_name; ?></td> 
                        <td><?php echo $data->city_name; ?></td> 
                        <td><?php echo $data->pic; ?></td> 
                        <td><?php echo $data->telepon; ?></td> 
                        <td><?php echo $data->jenis_agen; ?></td> 
                        <!--td><?php #echo $data->nama_ekspedisi; ?></td--> 
                        <td style="text-align:center"> 
                            <?php
                                if( ($group_id==1)||($hak_akses['edit']==1) ){
                            ?>
                            <a class="btn btn-circle btn-xs green" onclick="editData(<?php echo $data->id; ?>)" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Edit &nbsp; </a>
                            <?php 
                                }
                                if( ($group_id==1)||($hak_akses['delete']==1) ){
                            ?>
                            <a href="<?php echo base_url(); ?>index.php/MAgen/delete/<?php echo $data->id; ?>" 
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
    $('#nama_agen').val('');
    $('#alamat').val('');
    $('#m_province_id').select2('val', '');
    $('#m_city_id').select2('val', '');
    $('#pic').val('');
    $('#telepon').val('');
    //$('#m_ekspedisi_id').select2('val', '');
    $('#id').val('');
    dsState = "Input";
    
    $("#myModal").find('.modal-title').text('Tambah Agen');
    $("#myModal").modal('show',{backdrop: 'true'}); 
}

function simpandata(){
    if($.trim($("#nama_agen").val()) == ""){
        $('#message').html("Nama agen harus diisi!");
        $('.alert-danger').show();
    }else{      
        //$('#btnSave').attr("disabled", true); 
        if(dsState=="Input"){
            $.ajax({
                type:"POST",
                url:'<?php echo base_url('index.php/MAgen/cek_code'); ?>',
                data:"data="+$("#nama_agen").val(),
                success:function(result){
                    //console.log(result);
                    if(result=="ADA"){
                        $('#message').html("Nama agen sudah ada, silahkan ganti dengan nama lain!");
                        $('.alert-danger').show();
                    }else{
                        $('#message').html("");
                        $('.alert-danger').hide();
                        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MAgen/save");
                        $('#formku').submit();                    
                    }
                }
            });
        }else{
            $('#formku').attr("action", "<?php echo base_url(); ?>index.php/MAgen/update");
            $('#formku').submit(); 
        }
    };
};

function editData(id){
    dsState = "Edit";
    $.ajax({
        url: "<?php echo base_url('index.php/MAgen/edit'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            console.log(result);
            $('#nama_agen').val(result['nama_agen']);
            $('#alamat').val(result['alamat']);
            $('#m_province_id').select2('val',result['m_province_id']);
            $('#m_city_id').select2('val',result['m_city_id']);
            $('#pic').val(result['pic']);
            $('#jenis_agen').select2('val',result['jenis_agen']);
            $('#telepon').val(result['telepon']);
            //$('#m_ekspedisi_id').select2('val',result['m_ekspedisi_id']);
            $('#id').val(result['id']);
            
            $("#myModal").find('.modal-title').text('Edit Agen');
            $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}

function get_city_list(id){
    $.ajax({
        url: "<?php echo base_url('index.php/BackOffice/get_city_list'); ?>",
        async: false,
        type: "POST",
        data: "id="+id,
        dataType: "html",
        success: function(result) {
            $('#m_city_id').html(result);
        }
    })
}
</script>         