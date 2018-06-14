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
                    id="formku" action="<?php echo base_url('index.php/TTimbang/save_sagu_timbang_kedua'); ?>">
                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend> Info Kendaraan </legend>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama Ekspedisi
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_ekspedisi" name="nama_ekspedisi" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $data_otorisasi['nama_ekspedisi']; ?>">
                                    <input type="hidden" id="otorisasi_id" name="otorisasi_id" 
                                        value="<?php echo $data_otorisasi['id']; ?>">
                                    <input type="hidden" id="timbang_id" name="timbang_id" 
                                        value="<?php echo $timbang1['id']; ?>">
                                    
                                    <input type="hidden" id="m_ekspedisi_id" name="m_ekspedisi_id" 
                                        value="<?php echo $data_otorisasi['m_ekspedisi_id']; ?>">
                                    <input type="hidden" id="m_kendaraan_id" name="m_kendaraan_id" 
                                        value="<?php echo $data_otorisasi['m_kendaraan_id']; ?>">
                                    <input type="hidden" id="m_customer_id" name="m_customer_id" 
                                        value="<?php echo $data_otorisasi['m_customer_id']; ?>">
                                    <input type="hidden" id="m_cv_id" name="m_cv_id" 
                                        value="<?php echo $data_otorisasi['m_cv_id']; ?>">
                                    <input type="hidden" id="t_delivery_order_id" name="t_delivery_order_id" 
                                        value="<?php echo $data_otorisasi['t_delivery_order_id']; ?>">
                                    
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
                                        value="<?php echo $timbang1['berat1'] ;?>">
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
                                </div>
                            </div>
                        </fieldset>
                        
                    </div>
                    <div class="col-md-6">
                        <fieldset>
                            <legend> Transaksi </legend>
                            <div class="row">
                                <div class="col-md-5">
                                    Muatan
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_muatan" name="nama_muatan" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="SAGU">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Jenis Transaksi
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jenis_transaksi" name="jenis_transaksi" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo $data_otorisasi['jenis_transaksi']; ?>">
                                </div>
                            </div> 
                        </fieldset>
                        
                        
                        
                        <fieldset>
                            <legend> Customer </legend>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama Customer
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_customer" name="nama_customer" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo $data_otorisasi['nama_customer']; ?>">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Alamat
                                </div>
                                <div class="col-md-7">
                                    <textarea id="alamat" name="alamat" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" rows="3">    
                                        <?php echo $data_otorisasi['alamat']; ?>
                                    </textarea>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    No. Delivery Order
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_delivery_order" name="no_delivery_order" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo $data_otorisasi['no_delivery_order']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Pemilik Order (CV)
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_cv" name="nama_cv" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo $data_otorisasi['nama_cv']; ?>">
                                </div>
                            </div>
                        </fieldset>                        
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <legend> Potongan </legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-2">
                                           Refraksi <font color="#f00">*</font>
                                        </div>
                                        <div class="col-md-5">
                                            <select id="type_potongan" name="type_potongan" class="form-control myline select2me" 
                                                    data-placeholder="Pilih type potongan..." style="margin-bottom:5px" onchange="hitungPotongan();">
                                                <option value=""></option> 
                                                <option value="%">Persentase (%)</option>
                                                <option value="Kg">Kilogram (Kg)</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <input type="text" id="refraksi_faktor" name="refraksi_faktor" class="form-control myline" 
                                                style="margin-bottom:5px" onkeydown="return myCurrency(event);" onkeyup="hitungPotongan();">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" id="refraksi_value" name="refraksi_value" class="form-control myline" 
                                                style="margin-bottom:5px" onkeydown="return myCurrency(event);" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <h4>Berat Bersih <font color="#f00">*</font></h4>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="berat_bersih" name="berat_bersih" class="form-control myline" 
                                                style="margin-bottom:5px" readonly="readonly">
                                        </div>                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <small><i style="color:green">Input jenis potongan dan jumlah potongan (jika diperlukan)</i></small>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                    
                <div class="row">
                    <div class="col-md-12"><small><i>Mohon diperiksa dengan teliti jumlah item produk di bawah ini. Lihat jumlah order 
                        dan jumlah yang dikirim, serta perbandingan berat kendaraan dan total order. <br>Total order seharusnya sama dengan berat bersih 
                        kendaraan</i></small></div>
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
                                    <th>No</th>
                                    <th>Item</th>  
                                    <th>Sak</th>
                                    <th>Harga (Rp)</th>   
                                    <th>Jml Order</th> 
                                    <th>Jml Dikirim</th>
                                    <th>Total Harga</th>
                                    <th>Catatan</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($mydetail as $data){ 
                                            $no++;
                                    ?>
                                    <tr>          
                                        <td style="width:50px; text-align:center">
                                            <?php echo $no; ?>
                                            <input type="hidden" name="detail[<?php echo $no; ?>][tod_id]" value="<?php echo $data->id; ?>">
                                            <input type="hidden" id="merek_<?php echo $no; ?>" name="detail[<?php echo $no; ?>][merek]" 
                                                value="<?php echo $data->merek; ?>">
                                            <input type="hidden" id="harga_<?php echo $no; ?>" name="detail[<?php echo $no; ?>][harga]" 
                                                value="<?php echo $data->harga; ?>">
                                            <input type="hidden" id="sak_<?php echo $no; ?>" name="detail[<?php echo $no; ?>][sak]" 
                                                value="<?php echo $data->sak; ?>">
                                        </td>
                                        <td><?php echo $data->merek; ?></td> 
                                        <td><?php echo $data->sak; ?></td>
                                        <td style="text-align:right"><?php echo number_format($data->harga,0,',','.'); ?></td>
                                        <td style="text-align:right"><?php echo number_format($data->jumlah_sak,0,',','.'); ?></td>
                                        <td>
                                            <input type="text" id="jml_dikirim_<?php echo $no; ?>" name="detail[<?php echo $no; ?>][jumlah_dikirim]" 
                                                   value="<?php echo number_format($data->jumlah_sak,0,',','.'); ?>" 
                                                   class="form-control myline input-small" maxlength="3" 
                                                   onkeydown="return myCurrency(event);" onkeyup="update_harga(<?php echo $no; ?>);">
                                        </td> 
                                    <script>
                                        function update_harga(id){
                                            var harga = $('#harga_'+id).val();
                                            var jml   = $('#jml_dikirim_'+id).val().toString().replace(/\./g, "");
                                            
                                            total_harga = Number(harga)* Number(jml);
                                            $('#ttl_harga_'+id).val(total_harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                                            
                                            update_total();
                                        }
                                        
                                        function update_total(){
                                            var total_berat = 0;
                                            var total_harga = 0;
                                            $('input').each(function(i){
                                                if($('#jml_dikirim_'+i).length>0){
                                                    harga = $('#harga_'+i).val();
                                                    sak = $('#sak_'+i).val();
                                                    jml   = $('#jml_dikirim_'+i).val().toString().replace(/\./g, "");

                                                    total_berat = total_berat + (Number(sak)* Number(jml));
                                                    total_harga = total_harga + (Number(harga)* Number(jml));
                                                }
                                            });
                                            $('#berat_dikirim').val(total_berat.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                                            $('#harga_dikirim').val(total_harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                                        }
                                    </script>
                                        <td>
                                            <input type="text" id="ttl_harga_<?php echo $no; ?>" name="detail[<?php echo $no; ?>][total_harga2]" 
                                                value="<?php echo number_format($data->total_harga,0,',','.'); ?>" class="form-control myline" readonly="readonly">
                                        </td>
                                        <td>
                                            <input type="text" id="catatan_<?php echo $no; ?>" name="detail[<?php echo $no; ?>][catatan]" 
                                                value="<?php echo $data->catatan; ?>" class="form-control myline">
                                        </td>
                                    </tr>                            
                                    <?php                                
                                        }
                                    ?>                                        
                                </tbody>
                                </table>
                                
                                <div class="row">&nbsp;</div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5">
                                                Berat Order (Kg)
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" id="berat_order" name="berat_order" 
                                                       value="<?php echo number_format($berat,0,',','.'); ?>" class="form-control myline" readonly="readonly" style="margin-bottom:5px">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                Berat yang Dikirim (Kg)
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" id="berat_dikirim" name="berat_dikirim" 
                                                    value="<?php echo number_format($berat,0,',','.'); ?>" class="form-control myline" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5">
                                                Total Harga Order (Rp)
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" id="harga_order" name="harga_order" 
                                                    value="<?php echo number_format($data_otorisasi['total_order'],0,',','.'); ?>" 
                                                    class="form-control myline" readonly="readonly" style="margin-bottom:5px">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                Total Harga Dikirim (Rp)
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" id="harga_dikirim" name="harga_dikirim" 
                                                    value="<?php echo number_format($data_otorisasi['total_order'],0,',','.'); ?>" 
                                                    class="form-control myline" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <a href="<?php echo base_url('index.php/TTimbang/index/SINGKONG'); ?>" class="btn btn-default">
                            Kembali</a>
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
    }else if($.trim($("#type_potongan").val()) == ""){
        $('#message').html("Silahkan pilih type potongan!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    }else if($.trim($("#refraksi_faktor").val()) == ""){
        $('#message').html("Refraksi faktor harus diisi!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    }else if($.trim($("#refraksi_value").val()) == ""){
        $('#message').html("Nilai potongan harus diisi!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    }else if($.trim($("#berat_bersih").val()) == ""){
        $('#message').html("Berat bersih harus diisi!");
        $('.alert-danger').show(); 
        $('#btnSave').attr("disabled", false);
    }else{        
        $('#message').html("");
        $('.alert-danger').hide();
        $('#formku').submit();                    
    };
};

function hitungBruto(berat2){
    var berat1 = $('#berat_timbang1').val();
    bruto = Number(berat2)- Number(berat1);
    $('#berat_kotor').val(bruto);
    $('#berat_bersih').val(bruto);
}

function hitungPotongan(){
    var nilai_potongan = $('#refraksi_faktor').val();
    var bruto = $('#berat_kotor').val();
    var refraksi = $('#type_potongan').val();
    if($.trim(refraksi)==""){
        alert("Silahkan pilih type potongan!");
        return false;
    }else if($.trim(bruto)==""){
        alert("Berat bruto tidak boleh kosong!");
        return false;
    }else{
        if(refraksi=="%"){
            refraksi = ((Number(bruto)* Number(nilai_potongan))/100).toFixed(0);
        }else{
            refraksi = nilai_potongan;            
        }
        netto = Number(bruto)- Number(refraksi);
        $('#refraksi_value').val(refraksi);
        $('#berat_bersih').val(netto);
    }        
}

</script>