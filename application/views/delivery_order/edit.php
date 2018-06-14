<div class="row">                            
    <div class="col-md-12">                
        <form class="eventInsForm" method="post" target="_self" name="formku" 
            id="formku" action="<?php echo base_url('index.php/BackOffice/update_delivery_order'); ?>">
            <div class="row">
                <div class="col-md-12 col-sm-12"><h4>Set harga untuk Delivery Order : <?php echo $mydata['no_delivery_order']; ?></h4></div>
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
                <div class="col-md-5"> 
                    <div class="row">
                        <div class="col-md-5">
                            Tanggal 
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="tanggal" name="tanggal" 
                                class="form-control myline" style="margin-bottom:5px; float:left" readonly="readonly"
                                value="<?php echo date('d-m-Y', strtotime($mydata['tanggal'])); ?>">
                            
                            <input id="id" name="id" type="hidden" value="<?php echo $mydata['id']; ?>"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            Nomor Delivery Order
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="no_delivery_order" name="no_delivery_order" 
                                class="form-control myline" style="margin-bottom:5px;" 
                                value="<?php echo $mydata['no_delivery_order']; ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            Nama Customer <font color="#f00">*</font>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="nama_customer" name="nama_customer" 
                                class="form-control myline" style="margin-bottom:5px;" 
                                value="<?php echo $mydata['nama_customer']; ?>" readonly="readonly">                                                       
                        </div>
                    </div>
                    
                    
                </div>
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-5">                    
                    
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            Nama Ekspedisi<font color="#f00">*</font>
                        </div>
                        <div class="col-md-7 col-sm-12">
                            <input type="text" id="nama_ekspedisi" name="nama_ekspedisi" 
                                class="form-control myline" style="margin-bottom:5px;" 
                                value="<?php echo $mydata['nama_ekspedisi']; ?>" readonly="readonly">          
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            No. Sales Order
                        </div>
                        <div class="col-md-7">
                            <select id="t_sales_order_id" name="t_sales_order_id" class="form-control myline select2me" 
                                data-placeholder="Pilih nomor SO..." style="margin-bottom:5px">
                                <option value=""></option>
                                <?php
                                    foreach ($list_so as $row){
                                        echo '<option value="'.$row->id.'">'.$row->no_sales_order.'--'.$row->tanggal.' </option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Rincian produk yang diorder
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-bordered table-hover table-stripped">
                                    <thead>
                                        <th>No</th>
                                        <th>Merek</th> 
                                        <th>Sak (Kg)</th>
                                        <th>Harga (Rp)</th>                                        
                                        <th>Jumlah (sak)</th>
                                        <th>Total Harga (Rp)</th>
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
                                                    echo '<td><input type="text" id="harga_'.$no.'" name="myDetail['.$no.'][harga]" value="'.number_format($value->harga,0,',','.').'" '
                                                            . 'class="form-control myline" onkeydown="return myCurrency(event);" onkeyup="hitungTotal(this.value, '.$no.');">'
                                                            . '<input type="hidden" name="myDetail['.$no.'][id]" value="'.$value->id.'"></td>'; 
                                                    echo '<td><input type="text" id="jumlah_sak_'.$no.'" name="myDetail['.$no.'][jumlah_sak]" value="'.number_format($value->jumlah_sak,0,',','.').'" '
                                                            . 'class="form-control myline" readonly="readonly"></td>';
                                                    echo '<td><input type="text" id="total_harga_'.$no.'" name="myDetail['.$no.'][total_harga]" value="'.number_format($value->total_harga,0,',','.').'" '
                                                            . 'class="form-control myline" readonly="readonly"></td>';    
                                                    echo "</tr>";
                                                }
                                            }else{
                                                echo "<tr><td colspan='6'>Belum ada item produk yang diinput...</td></tr>";
                                            }
                                        ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <input type="button" onClick="simpandata();" name="btnSave" 
                        value="Simpan" class="btn btn-primary" id="btnSave">
                    <a href="<?php echo base_url('index.php/BackOffice/delivery_order'); ?>" class="btn btn-default">
                        Back</a>
                </div>
             </div>
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

function hitungTotal(nilai, id){
    amount = nilai.toString().replace(/\./g, "");
    sak   = $('#jumlah_sak_'+id).val().toString().replace(/\./g, "");
    total_amount = Number(amount)* Number(sak);
    $('#harga_'+id).val(amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    $('#total_harga_'+id).val(total_amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}
    
function simpandata(){	
    $('#btnSave').attr("disabled", true);                  
    $('#formku').submit();
};    
    
    

</script>
        