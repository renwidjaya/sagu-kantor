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
                            <fieldset>
                                <legend> Info Kendaraan </legend>
                                <div class="row">
                                    <div class="col-md-5">
                                        Nama Agen
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="nama_agen" name="nama_agen" class="form-control myline" 
                                               readonly="readonly" style="margin-bottom:5px">
                                        <input type="hidden" id="otorisasi_id" name="otorisasi_id">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        Kendaraan (No Polisi)
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="no_kendaraan" name="no_kendaraan" class="form-control myline" 
                                               readonly="readonly" style="margin-bottom:5px">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                       Nama Supir
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="supir" name="supir" class="form-control myline" 
                                            readonly="readonly" style="margin-bottom:5px">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend> Transaksi </legend>
                                <div class="row">
                                    <div class="col-md-5">
                                        Muatan
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="nama_muatan" name="nama_muatan" class="form-control myline" 
                                            readonly="readonly" style="margin-bottom:5px">
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-5">
                                        Jenis Transaksi
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="jenis_transaksi" name="jenis_transaksi" class="form-control myline" 
                                            readonly="readonly" style="margin-bottom:5px">
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-5">
                                        Berat (kg)<font color="#f00">*</font>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="berat_timbang_1" name="berat_timbang_1" class="form-control myline" 
                                            style="margin-bottom:5px" onkeydown="return myCurrency(event);" onkeyup="getComa(this.value)">
                                    </div>
                                </div>
                            </fieldset>
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
                    <i class="fa fa-car"></i>Pos Timbang
                </div>                
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>  
                    <th>Jam Masuk</th>
                    <th>Transaksi</th>
                    <th>Agen</th>   
                    <th>No. Kendaraan</th> 
                    <th>Supir</th>
                    <th>Muatan</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 0;
                        $status = array(1=>'Masuk', 2=>'Timbang 1', 3=>'Timbang 2');
                        foreach ($list_data as $data){
                            $no++;
                    ?>
                    <tr> 
                        <td style="width:50px; text-align:center"><?php echo $no; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($data->time_in)); ?></td>  
                        <td style="text-align:center"><?php echo date('h:m', strtotime($data->time_in)); ?></td>
                        <td><?php echo $data->jenis_transaksi; ?></td>
                        <td><?php echo $data->nama_agen." (".$data->jenis_agen.")"; ?></td>                       
                        <td><?php echo $data->no_kendaraan." -- ".$data->type_kendaraan; ?></td> 
                        <td><?php echo $data->supir; ?></td>
                        <td><?php echo (trim($data->deskripsi," ")!="")? $data->deskripsi: 'Kendaraan Kosong'; ?></td> 
                        <td style="color:red;"><?php echo $status[$data->status]; ?></td> 
                        <td style="text-align:center"> 
                            <?php
                                if($data->status==1){
                                    if( ($group_id==1)||($hak_akses['timbang_1']==1) ){
                            ?>
                                
                            <a class="btn btn-circle btn-xs green" onclick="timbang_pertama(<?php echo $data->id; ?>)" style="margin-bottom:4px">
                                &nbsp; <i class="fa fa-edit"></i> Timbang 1&nbsp; </a>   
                            <?php
                                    }
                                }else{
                                    if($data->finish_timbang==0){
                                        if( ($group_id==1)||($hak_akses['timbang_2']==1) ){                                        
                                            echo '<a class="btn btn-circle btn-xs green" style="margin-bottom:4px" '
                                            . 'href="'.base_url('index.php/Penjualan/sagu_timbang_kedua/'.$data->id).'"> &nbsp; '
                                            . '<i class="fa fa-edit"></i> Timbang 2&nbsp; </a>';                                         
                                        }
                                    }else{
                                        echo '<a class="btn btn-circle btn-xs blue-hoki" style="margin-bottom:4px" '
                                            . 'href="'.base_url('index.php/Penjualan/print_do/'.$data->t_delivery_order_id).'"> &nbsp; '
                                            . '<i class="fa fa-print"></i> Print DO&nbsp; </a>';
                                    }
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
<script>
function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function timbang_pertama(id){
    $.ajax({
        url: "<?php echo base_url('index.php/Penjualan/get_data_otorisasi'); ?>",
        type: "POST",
        data : {id: id},
        success: function (result){
            //console.log(result);
            if($.trim(result['nama_muatan'])==""){
                judul  = "Kendaraan Kosong";
                muatan = "Kendaraan Kosong";
            }else{
                if(result['nama_muatan']=="LAIN-LAIN"){
                    judul  = result['deskripsi'];
                    muatan = "MATERIAL";
                }else{
                    judul  = result['nama_muatan'];
                    muatan = result['nama_muatan'];
                }
            }

            $('#nama_agen').val(result['nama_agen']);           
            $('#no_kendaraan').val(result['no_kendaraan']);
            $('#nama_muatan').val(muatan);
            $('#supir').val(result['supir']);
            $('#jenis_transaksi').val(result['jenis_transaksi']);

            $('#otorisasi_id').val(result['id']);
            
            
            $("#myModal").find('.modal-title').text(judul + ' - Proses Timbang 1');
            $("#myModal").modal('show',{backdrop: 'true'});           
        }
    });
}

function simpandata(){
    $('#btnSave').attr("disabled", true); 
    if($.trim($("#berat_timbang_1").val()) == ""){
        $('#message').html("Berat harus diisi!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    }else{        
        $('#message').html("");
        $('.alert-danger').hide();
        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/Pembelian/save_timbang_pertama");
        $('#formku').submit();                    
    };
};

function getComa(nilai){
    $('#berat_timbang_1').val(nilai.toString().replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}

</script>