<div class="row">                            
    <div class="col-md-12">                
        <form class="eventInsForm" method="post" target="_self" name="formku" 
            id="formku" action="<?php echo base_url('index.php/BackOffice/new_pecah_do/'.$mydata['id']); ?>">
            <div class="row">
                <div class="col-md-12 col-sm-12"><h4>Pecah DO Pabrik</h4></div>
            </div>                      
            <div class="row">
                <div class="col-md-2">
                    Tanggal <font color="#f00">*</font>
                </div>
                <div class="col-md-3">
                    <input type="text" id="tanggal" name="tanggal" 
                           class="form-control myline" style="margin-bottom:5px;" readonly="readonly"
                        value="<?php echo date('d-m-Y', strtotime($mydata['tanggal'])); ?>">
                    <input id="id" name="id" type="hidden" value="<?php echo $mydata['id']; ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    Nomor Delivery Order <font color="#f00">*</font>
                </div>
                <div class="col-md-3">
                    <input type="text" id="no_delivery_order" name="no_delivery_order" 
                        class="form-control myline" style="margin-bottom:5px;" 
                        value="<?php echo $mydata['no_delivery_order']; ?>" readonly="readonly">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    Nama Customer <font color="#f00">*</font>
                </div>
                <div class="col-md-3">
                    <input type="text" id="nama_customer" name="nama_customer" 
                        class="form-control myline" style="margin-bottom:5px;" 
                        value="<?php echo $mydata['nama_customer']; ?>" readonly="readonly">  

                    <input id="m_customer_id" name="m_customer_id" type="hidden" 
                        value="<?php echo $mydata['m_customer_id']; ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    Ekspedisi <font color="#f00">*</font>
                </div>
                <div class="col-md-3">
                    <input type="text" id="nama_ekspedisi" name="nama_ekspedisi" 
                        class="form-control myline" style="margin-bottom:5px;" 
                        value="<?php echo $mydata['nama_ekspedisi']; ?>" readonly="readonly">  

                    <input id="m_ekspedisi_id" name="m_ekspedisi_id" type="hidden" 
                        value="<?php echo $mydata['m_ekspedisi_id']; ?>"/>
                </div>
                <div class="col-md-7" style="text-align:right">
                    <a href="javascript:;" class="btn green dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-fax"></i> Limit Penjualan CV
                    </a>
                    
                    <div class="dropdown-menu pull-right">
                        <div class="portlet box blue-hoki">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-fax"></i>Limit Penjualan CV <i class="fa fa-angle-down"></i>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama CV</th>
                                        <th>Limit Penjualan</th>
                                        <th>Total Penjualan</th>
                                        <th>Sisa Limit</th>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $no = 0;
                                            foreach ($list_cv as $index=>$value){
                                                $no++;                                            
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?php echo $no; ?></td>
                                            <td><?php echo $value->nama_cv; ?></td>
                                            <td style="text-align:right"><?php echo number_format($value->limit_penjualan,0,',','.'); ?></td>
                                            <td style="text-align:right"><?php echo number_format($value->total_penjualan,0,',','.'); ?></td>
                                            <td style="text-align:right"><?php echo number_format($value->sisa_limit,0,',','.'); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
										
                </div>
            </div>                   
               
            
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-car"></i>Detail produk DO PABRIK
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-bordered table-hover table-stripped">
                                    <thead>
                                        <th>No</th>
                                        <th>Merek</th> 
                                        <th>Sak</th>
                                        <th>Harga (Rp)</th>                                        
                                        <th>Jumlah (sak)</th>
                                        <th>Total Berat (Kg)</th>
                                        <th>Total Harga (Rp)</th>
                                        <th>Catatan</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if( (isset($mydetails)&& (!empty($mydetails))) ){
                                                $no = 0;
                                                foreach ($mydetails as $key=>$value){
                                                    $no++;
                                                    echo "<tr>";
                                                    echo "<td style='text-align:center'>".$no."</td>";
                                                    echo "<td>".$value->merek."</td>";
                                                    echo "<td>".$value->sak."</td>";                                                    
                                                    echo "<td style='text-align:right'>".number_format($value->harga,0,',','.')."</td>";
                                                    echo "<td style='text-align:right'>".number_format($value->jumlah_sak,0,',','.')."</td>";
                                                    echo "<td style='text-align:right'>".number_format(($value->jumlah_sak * $value->sak),0,',','.')."</td>";
                                                    echo "<td style='text-align:right'>".number_format($value->total_harga,0,',','.')."</td>";
                                                    echo "<td>".$value->catatan."</td>";                                                    
                                                    echo "</tr>";
                                                }
                                            }
                                        ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <?php
                if(!isset($simulasi)){
            ?>
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <input type="submit" name="btnSimulasi" 
                        value="Simulasi" class="btn btn-primary" id="btnSimulasi">
                    <a href="<?php echo base_url('index.php/BackOffice/pecah_do'); ?>" class="btn btn-default">
                        Batal</a>
                </div>
            </div>
            <?php
                }else{
                    $num = 0;
                    foreach ($simulasi as $index=>$value){
                        $num++;
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue-ebonyclay">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-truck"></i>Hasil Simulasi untuk item #<?php echo $num; ?>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php 
                                $remarks = "SAGU ".$value['merek']." ".$value['sak']." Kg, "
                                        . "harga = Rp. ".number_format($value['harga'],0,',','.')." sebanyak "
                                        . number_format($value['jumlah_sak'],0,',','.')." sak dengan total berat = "
                                        . number_format($value['total_berat'],0,',','.')." Kg dan total harga = Rp. "
                                         . number_format($value['total_harga'],0,',','.');
                                echo $remarks; 
                            ?>
                            <input type="hidden" id="jumlah_sak_<?php echo $index; ?>" class="jumlah_sak_header" 
                                   name="mydata[<?php echo $index; ?>][jumlah_sak]" value="<?php echo $value['jumlah_sak']; ?>">
                            
                            <input type="hidden" name="mydata[<?php echo $index; ?>][merek]" 
                                value="<?php echo $value['merek']; ?>">

                            <table class="table table-bordered table-hover table-stripped">
                                <thead>
                                    <th>&nbsp;</th>
                                    <th>No</th>
                                    <th>Nama CV</th>
                                    <th>Merek</th> 
                                    <th>Sak</th>
                                    <th>Harga (Rp)</th>                                        
                                    <th>Jumlah (sak)</th>
                                    <th>Total Berat (Kg)</th>
                                    <th>Total Harga (Rp)</th>
                                    <th>Status</th>
                                    <!--th>Ekspedisi</th-->
                                </thead>
                                <tbody>
                                    <?php
                                        if(!empty($value['list_simulasi'])){
                                            $nbr = 0;
                                            foreach ($value['list_simulasi'] as $key=>$val){
                                                $nbr++;
                                                if($val['sisa_limit']>=$val['total_harga']){
                                                    $status = "<div style='background-color:green; color:white; margin:2px' "
                                                            . "id='status_".$index."_".$nbr."'>OK</div>";
                                                }else{
                                                    $status = "<div style='background-color:red; margin:2px' "
                                                            . "id='status_".$index."_".$nbr."'>Over Limit</div>";
                                                }
                                                echo "<tr>";
                                                echo "<td><input type='checkbox' value='1' id='check_".$index."_".$nbr."' "
                                                        . "name='mydata[".$index."][simulasi][".$nbr."][check]' class='form-control'></td>";
                                                
                                                echo "<td style='text-align:center'>".$nbr."</td>";
                                                echo "<td>".$val['nama_cv']."</td>";
                                                echo "<td>".$val['merek']."</td>";
                                                echo "<td>".$val['sak']."</td>";
                                                echo "<td style='text-align:right'>".number_format($val['harga'],0,',','.');
                                                
                                                echo "<input type='hidden' name='mydata[".$index."][simulasi][".$nbr."][m_cv_id]' "
                                                    . "value='".$val['m_cv_id']."'>";
                                                
                                                echo "<input type='hidden' name='mydata[".$index."][simulasi][".$nbr."][kode_cv]' "
                                                    . "value='".$val['kode_cv']."'>";
                                                
                                                echo "<input type='hidden' id='harga_".$index."_".$nbr."' "
                                                    . "name='mydata[".$index."][simulasi][".$nbr."][harga]' value='".$val['harga']."'>";
                                                
                                                echo "<input type='hidden' id='sak_".$index."_".$nbr."' "
                                                    . "name='mydata[".$index."][simulasi][".$nbr."][sak]' value='".$val['sak']."'>";
                                                
                                                echo "<input type='hidden' id='sisa_limit_".$index."_".$nbr."' "
                                                    . "name='mydata[".$index."][simulasi][".$nbr."][sisa_limit]' value='".$val['sisa_limit']."'>";
                                                
                                                echo "<input type='hidden' id='stok_".$index."_".$nbr."' "
                                                    . "name='mydata[".$index."][simulasi][".$nbr."][stok]' value='".$val['stok']."'>";
                                                
                                                echo "</td>";
                                                
                                                echo "<td><input type='text' id='jumlah_sak_".$index."_".$nbr."' "
                                                    . "name='mydata[".$index."][simulasi][".$nbr."][jumlah_sak]' class='form-control jumlah_sak_detail_".$index."' "
                                                    . "value='".number_format($val['jumlah_sak'],0,',','.')."' "
                                                    . "onkeydown='return myCurrency(event);' onkeyup='hitungTotal(".$index.",".$nbr.");'></td>";
                                                
                                                echo "<td><input type='text' id='total_berat_".$index."_".$nbr."' "
                                                    . "name='mydata[".$index."][simulasi][".$nbr."][total_berat]' class='form-control' "
                                                    . "value='".number_format($val['total_berat'],0,',','.')."' readonly='readonly'></td>";
                                                
                                                echo "<td><input type='text' id='total_harga_".$index."_".$nbr."' "
                                                    . "name='mydata[".$index."][simulasi][".$nbr."][total_harga]' class='form-control' "
                                                    . "value='".number_format($val['total_harga'],0,',','.')."' readonly='readonly'></td>";

                                                echo "<td style='text-align:center'>".$status."</td>";
                                                /*echo '<td><select id="m_ekspedisi_id_'.$index.'_'.$nbr.'" '
                                                        . 'name="mydata['.$index.'][simulasi]['.$nbr.'][m_ekspedisi_id]" '
                                                        .'class="form-control myline select2me" '
                                                        .'data-placeholder="Pilih ekspedisi..." style="margin-bottom:5px">';
                                                echo '<option value=""></option>';
                                                        foreach ($list_ekspedisi as $row){
                                                        echo '<option value="'.$row->id.'" '.(($val['m_ekspedisi_id']==$row->id)? "selected='selected'": "").'>'.$row->nama_ekspedisi.'</option>';
                                                        }
                                                        
                                                echo '</select></td>';*/
                                                echo "</tr>";
                                            }
                                        }else{
                                            echo "<tr><td colspan='11'>Tidak ada CV yang memiliki stok untuk item ini</td></tr>";
                                        }
                                        
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php                     
                }
            ?>
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
                    <input type="button" name="btnSave" onclick="saveData();"
                        value="Proses" class="btn btn-primary" id="btnSave">
                    <a href="<?php echo base_url('index.php/BackOffice/pecah_do'); ?>" class="btn btn-default">
                        Batal</a>
                </div>
            </div>
            <?php
                }
            ?>
            
        </form>
    </div>
</div>  

<script>
function myCurrency(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function hitungTotal(idx, nbr){
    sak        = $('#sak_'+ idx +'_'+ nbr).val();
    harga      = $('#harga_'+ idx +'_'+ nbr).val();
    jml_sak    = $('#jumlah_sak_'+ idx +'_'+ nbr).val().toString().replace(/\./g, "");
    sisa_limit = $('#sisa_limit_'+ idx +'_'+ nbr).val();
    stok       = $('#stok_'+ idx +'_'+ nbr).val();
    
    total_berat = Number(sak)* Number(jml_sak);
    total_harga = Number(harga)* Number(jml_sak);
    console.log('total berat',total_berat);
    console.log('total harga',total_harga);
    console.log('jml sak',jml_sak);
    console.log('stok', stok);
    console.log('sisa limit', sisa_limit);
    
    if(total_harga> sisa_limit){
        $('#status_'+ idx + '_'+ nbr).html('Over Limit');
        $('#status_'+ idx + '_'+ nbr).attr('style', 'background-color:red; margin:2px');
    }else{
        $('#status_'+ idx + '_'+ nbr).html('OK');
        $('#status_'+ idx + '_'+ nbr).attr('style', 'background-color:green; color:white; margin:2px');
    }
    $('#total_berat_'+idx+'_'+ nbr).val(total_berat.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    $('#total_harga_'+idx+'_'+ nbr).val(total_harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    
    if(total_berat> stok){
        alert ("Stok tidak cukup!, Cek kembali data anda...");
        return false;
    }
}
    
function saveData(){
    $('#btnSave').attr("disabled", true);   
    var cek = 0;
    $('.jumlah_sak_header').each(function(i){
        sak_header = $('#jumlah_sak_'+i).val();
        console.log('sak header', sak_header);
        
        sak_detail = 0;
        $('.jumlah_sak_detail_'+i).each(function(j){
            k = j+1;
            if ($('#check_'+i + '_'+k).prop("checked")) {  
                sak_detail += Number($('#jumlah_sak_'+i+'_'+k).val());
            }
        });
        console.log('sak detail', sak_detail);
        
        if(sak_header != sak_detail){
            cek += 1;
        }
    });
    
    if(cek>0){
        $('#message').html("Jumlah sak awal setiap item harus sama dengan jumlah \n\
                akumulasi sak setelah proses pemecahan DO. Cek kembali perhitungan jumlah sak anda!");
        $('.alert-danger').show();
        $('#btnSave').attr("disabled", false);   
    }else{
        $('#message').html("");
        $('.alert-danger').hide();
        $('#formku').attr("action", "<?php echo base_url(); ?>index.php/BackOffice/save_pecah_do");
        $('#formku').submit(); 
    }
}   
</script>
        