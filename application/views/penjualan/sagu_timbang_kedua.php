<div class="row">                            
    <div class="col-md-12">   
        <?php
            if( ($group_id==1)||($hak_akses['sagu_timbang_kedua']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-car"></i>SAGU - Proses Timbang 2
                </div>                
            </div>
            <div class="portlet-body">
                <form class="eventInsForm" method="post" target="_self" name="formku" 
                    id="formku" action="<?php echo base_url('index.php/Penjualan/save_sagu_timbang_kedua'); ?>">
                <div class="row">
                    <div class="col-md-5">
                        <fieldset>
                            <legend> Info Kendaraan </legend>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama Agen
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_agen" name="nama_agen" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $data_otorisasi['nama_agen']; ?>">
                                    <input type="hidden" id="otorisasi_id" name="otorisasi_id" 
                                        value="<?php echo $data_otorisasi['id']; ?>">
                                    <input type="hidden" id="timbang_id" name="timbang_id" 
                                        value="<?php echo $timbang1['id']; ?>">
                                    
                                    <input type="hidden" id="m_agen_id" name="m_agen_id" 
                                        value="<?php echo $data_otorisasi['m_agen_id']; ?>">
                                    <input type="hidden" id="m_kendaraan_id" name="m_kendaraan_id" 
                                        value="<?php echo $data_otorisasi['m_kendaraan_id']; ?>">
                                    
                                    
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-5">
                                    Kendaraan (No Polisi)
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_kendaraan" name="no_kendaraan" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $data_otorisasi['no_kendaraan']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Type Kendaraan
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="type_kendaraan" name="type_kendaraan" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $data_otorisasi['type_kendaraan']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                   Nama Supir
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="supir" name="supir" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo $data_otorisasi['supir']; ?>">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend> Data Timbangan </legend>
                            <div class="row">
                                <div class="col-md-5">
                                   Berat #1 (Kg)<font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="berat_timbang1" name="berat_timbang1" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo ($data_otorisasi['status']==2)? $timbang1['berat1']: $timbang1['berat2']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                   Berat #2 (Kg)<font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="berat_timbang2" name="berat_timbang2" class="form-control myline" 
                                        style="margin-bottom:5px" onkeydown="return myCurrency(event);" onkeyup="hitungBruto(this.value);">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                   Bruto (Kg)<font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="berat_kotor" name="berat_kotor" class="form-control myline" 
                                        style="margin-bottom:5px" readonly="readonly">
 
                                    <input type="hidden" id="status" name="status" 
                                        value="<?php echo $data_otorisasi['status']; ?>">
                                </div>
                            </div>
                        </fieldset>
                        
                    </div>
                    <div class="col-md-7">
                        <fieldset>
                            <legend> Transaksi </legend>
                            <div class="row">
                                <div class="col-md-3">
                                    Muatan
                                </div>
                                <?php
                                    $deskripsi = trim($data_otorisasi['deskripsi'], " ");
                                ?>
                                <div class="col-md-5">
                                    <input type="text" id="nama_muatan" name="nama_muatan" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo $deskripsi; ?>">
                                    
                                    <input type="hidden" id="deskripsi" name="deskripsi" 
                                        value="<?php echo $deskripsi; ?>">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-3">
                                    Jenis Transaksi
                                </div>
                                <div class="col-md-5">
                                    <input type="text" id="jenis_transaksi" name="jenis_transaksi" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo $data_otorisasi['jenis_transaksi']; ?>">
                                </div>
                            </div> 
                        </fieldset>                        
                        <div class="row">
                            <div class="col-md-12">
                                &nbsp;<br>
                                <small><i>Beri tanda centang pada muatan yang sedang diproses timbang</i></small></div>
                        </div> 
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet box blue-hoki">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cog"></i>Detail Order
                                        </div>                
                                    </div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="check_all" name="check_all" onclick="checkAll()" class="form-control">
                                            </th>
                                            <th>No</th>
                                            <th>Item</th>  
                                            <th>Type Produk</th>
                                            <th>Sak</th>   
                                            <th>Jumlah</th> 
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 0;
                                                foreach ($muatan as $data){ 
                                                    $no++;
                                            ?>
                                            <tr>  
                                                <td>   
                                                    <?php
                                                        if($data->flag_timbang==0){
                                                            echo '<input type="checkbox" value="1" id="check_'.$no.'" name="detail['.$no.'][check]" 
                                                                onclick="check();" class="form-control">';
                                                        }
                                                    ?>
                                                     
                                                </td>
                                                <td style="width:50px; text-align:center">
                                                    <?php echo $no; ?>
                                                    <input type="hidden" id="produk_id_<?php echo $no; ?>" name="detail[<?php echo $no; ?>][id]" 
                                                        value="<?php echo $data->id; ?>">   
                                                    <input type="hidden" id="item_<?php echo $no; ?>" name="detail[<?php echo $no; ?>][item]" 
                                                        value="<?php echo $data->item; ?>">
                                                    <input type="hidden" id="type_produk_<?php echo $no; ?>" name="detail[<?php echo $no; ?>][type_produk]" 
                                                        value="<?php echo $data->type_produk; ?>"> 
                                                    <input type="hidden" id="sak_<?php echo $no; ?>" name="detail[<?php echo $no; ?>][sak]" 
                                                        value="<?php echo $data->sak; ?>"> 
                                                </td>
                                                <td><?php echo $data->item; ?></td> 
                                                <td><?php echo $data->type_produk; ?></td>
                                                <td><?php echo $data->sak; ?></td>
                                                <td style="text-align:right"><?php echo number_format($data->jumlah,0,',','.'); ?></td>                                                
                                            </tr>                            
                                            <?php                                
                                                }
                                            ?>                                        
                                        </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span id="message">&nbsp;</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                &nbsp;<br>
                <input type="button" onClick="simpandata();" name="btnSave" 
                    value="Simpan" class="btn btn-primary" id="btnSave">
                <a href="<?php echo base_url('index.php/Penjualan/index/SAGU/Jual'); ?>" class="btn btn-default">
                    Kembali</a>
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

function simpandata(){
    $('#btnSave').attr("disabled", true); 
    if($.trim($("#berat_timbang2").val()) == ""){
        $('#message').html("Berat timbang 2 harus diisi!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    }else if($.trim($("#berat_kotor").val()) == ""){
        $('#message').html("Berat kotor harus diisi!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    
    }else{   
        var item_check = 0;
        $('input').each(function(i){
            if($('#check_'+i).prop("checked")){
                item_check += 1;                    
            }
        });
        
        if(item_check==0){
            $('#message').html("Silahkan pilih item yang ditimbang!"); 
            $('.alert-danger').show(); 
            $('#btnSave').attr("disabled", false);
        }else{        
            $('#message').html("");
            $('.alert-danger').hide();
            $('#formku').submit();   
        }
    };
};

function hitungBruto(berat2){
    var berat1 = $('#berat_timbang1').val();
    bruto = Number(berat2)- Number(berat1);
    $('#berat_kotor').val(bruto);
}

function checkAll(){
    if ($('#check_all').prop("checked")) {  
        $('input').each(function(i){
            $('#uniform-check_'+i+' span').attr('class', 'checked');
            $('#check_'+i).attr('checked', true);
        });
    }else{
        $('input').each(function(i){
            $('#uniform-check_'+i+' span').attr('class', '');
            $('#check_'+i).attr('checked', false);
        });
    }   
    nama_muatan();
}

function check(){
    $('#uniform-check_all span').attr('class', '');
    $('#check_all').attr('checked', false);    
    nama_muatan();
}

function nama_muatan(){
    var muatan = $('#deskripsi').val();
    $('input').each(function(i){
        if($('#check_'+i).prop("checked")){
            muatan += $("#item_"+i).val() + " " + $("#type_produk_"+i).val() + " " + $("#sak_"+i).val()+ " Kg, ";               
        }
    });
    $('#nama_muatan').val(muatan);
}
</script>