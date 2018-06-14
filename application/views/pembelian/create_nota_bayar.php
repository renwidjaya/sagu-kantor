<div class="row">                            
    <div class="col-md-12">   
        <?php
            if( ($group_id==1)||($hak_akses['create_nota_bayar']==1) ){
        ?>
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-car"></i>Nota Bayar : <?php echo $mydata['no_nota']; ?>
                </div>                
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend> Info Kendaraan </legend>
                            <div class="row">
                                <div class="col-md-5">
                                    Nama Agen
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nama_agen" name="nama_agen" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $mydata['nama_agen']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Jenis Agen
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jenis_agen" name="jenis_agen" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $mydata['jenis_agen']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Kendaraan (No Polisi)
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="no_kendaraan" name="no_kendaraan" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $mydata['no_kendaraan']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Type Kendaraan
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="type_kendaraan" name="type_kendaraan" class="form-control myline" 
                                           readonly="readonly" style="margin-bottom:5px" 
                                           value="<?php echo $mydata['type_kendaraan']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                   Nama Supir
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="supir" name="supir" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="<?php echo $mydata['supir']; ?>">
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
                                        value="<?php echo number_format($mydata['berat1'],0,',','.');?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                   Berat #2 (Kg)<font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="berat_timbang2" name="berat_timbang2" class="form-control myline" 
                                        style="margin-bottom:5px" value="<?php echo number_format($mydata['berat2'],0,',','.');?>" readonly="readonly">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                   Bruto (Kg)<font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="berat_kotor" name="berat_kotor" class="form-control myline" 
                                        style="margin-bottom:5px" readonly="readonly" value="<?php echo number_format($mydata['berat_kotor'],0,',','.');?>">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend> Potongan </legend>
                            <div class="row">
                                <div class="col-md-5">
                                   Refraksi <font color="#f00">*</font>
                                </div>                                
                                <div class="col-md-2">
                                    <input type="text" id="refraksi_faktor" name="refraksi_faktor" class="form-control myline" 
                                           style="margin-bottom:5px" readonly="readonly" value="<?php echo $mydata['refraksi_faktor'] ;?>">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="type_potongan" name="type_potongan" class="form-control myline" 
                                           style="margin-bottom:5px" readonly="readonly" value="<?php echo $mydata['type_potongan'] ;?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="refraksi_value" name="refraksi_value" class="form-control myline" 
                                        style="margin-bottom:5px" readonly="readonly" value="<?php echo $mydata['refraksi_value'] ;?>">
                                </div>
                            </div>
                        </fieldset>
                        <div class="row">
                            <div class="col-md-5">
                                <strong>Berat Bersih</strong> <font color="#f00">*</font>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="berat_bersih" name="berat_bersih" class="form-control myline" 
                                    style="margin-bottom:5px" readonly="readonly" 
                                    value="<?php echo number_format($mydata['berat_bersih'],0,',','.'); ?>">
                            </div>
                        </div>
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
                                        value="<?php echo $mydata['jenis_barang']; ?>">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Jenis Transaksi
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jenis_transaksi" name="jenis_transaksi" class="form-control myline" 
                                        readonly="readonly" style="margin-bottom:5px" 
                                        value="Beli">
                                </div>
                            </div> 
                        </fieldset>
                        
                        <fieldset>
                            <legend> Kontrol Kualitas </legend>
                            <div class="row">
                                <div class="col-md-5">
                                    QC01 - Pasir
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="qc01" name="qc01" class="form-control myline" 
                                           style="margin-bottom:5px" readonly="readonly" value="<?php echo $mydata['qc01']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    QC02 - Tanah
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="qc02" name="qc02" class="form-control myline" 
                                        style="margin-bottom:5px" readonly="readonly" value="<?php echo $mydata['qc02']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    QC03 - Kadar Aci (%)
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="qc03" name="qc03" class="form-control myline" 
                                        style="margin-bottom:5px" readonly="readonly" value="<?php echo $mydata['qc03']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    QC04 - Ukuran Singkong
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="qc04" name="qc04" class="form-control myline" 
                                        style="margin-bottom:5px" readonly="readonly" value="<?php echo $mydata['qc04']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    QC05 - Bonggol
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="qc05" name="qc05" class="form-control myline" 
                                        style="margin-bottom:5px" readonly="readonly" value="<?php echo $mydata['qc05']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">Keterangan</div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea id="keterangan" name="keterangan" class="form-control myline" 
                                        rows="3" readonly="readonly" style="margin-bottom:5px">
                                        <?php echo $mydata['keterangan']; ?>
                                    </textarea>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row" <?php echo ($mydata['jenis_agen']=='Luar')? "style='display:none;'": ""; ?>>
                            <div class="col-md-5">
                                <strong>Harga Singkong (Rp/ Kg)</strong> <font color="#f00">*</font>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="harga" name="harga" class="form-control myline" 
                                    style="margin-bottom:5px" value="<?php echo number_format($mydata['harga'],0,',','.'); ?>" 
                                    readonly="readonly">
                            </div>
                        </div>
                        <div class="row" <?php echo ($mydata['jenis_agen']=='Luar')? "style='display:none;'": ""; ?>>
                            <div class="col-md-5">
                                <strong>Total Harga (Rp)</strong> <font color="#f00">*</font>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="total_harga" name="total_harga" class="form-control myline" 
                                    style="margin-bottom:5px" readonly="readonly" 
                                    value="<?php echo number_format($mydata['total_harga'],0,',','.'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                &nbsp;<br>
                <a href="<?php echo base_url('index.php/Pembelian/print_nota/'.$mydata['id']); ?>" 
                   class="btn btn-primary" id="btnPrint" onclick="disableTombol();"><i class="fa fa-print"></i>&nbsp; Print Nota</a>
                <a href="<?php echo base_url('index.php/Pembelian/index/SINGKONG'); ?>" class="btn btn-default">
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
function disableTombol(){
    $('#btnPrint').attr('disabled', true);
}
</script>