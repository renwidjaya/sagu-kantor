<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script>
$( function() {
    $("#tanggal").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>img/Kalender.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy"
    });

} );
</script>
<div class="row">                            
    <div class="col-md-12"> 
        <!-- Pop Up Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">&nbsp;</h4>
                    </div>
                    <div class="modal-body">
                        <form class="eventInsForm" method="post" target="_self" id="frm_produk">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger display-hide" id="msg_box">
                                        <button class="close" data-close="alert"></button>
                                        <span id="message">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    Merek <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">                                            
                                    <select id="merek" name="merek" class="form-control myline select2me" 
                                        data-placeholder="Pilih produk..." style="margin-bottom:5px">
                                        <option value=""></option>
                                        <option value="Pulau">Pulau</option>
                                        <option value="KWR">KWR</option>
                                        <option value="PH">PH</option>
                                        <option value="Polos">Polos</option>
                                    </select>

                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="t_sales_order_id" name="t_sales_order_id">
                                </div>
                            </div>   
                            <div class="row">
                                <div class="col-md-5">
                                    Jumlah (Sak) <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="jumlah_sak" name="jumlah_sak" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeydown="return myCurrency(event);" maxlength="15"
                                        onkeyup="getJumlahComa(this.value);">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Deal Harga (Rp) <font color="#f00">*</font>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="harga" name="harga" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeydown="return myCurrency(event);" maxlength="15" 
                                        onkeyup="getHargaComa(this.value);">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    Catatan
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="catatan" name="catatan" 
                                        class="form-control myline" style="margin-bottom:5px" 
                                        onkeyup="this.value = this.value.toUpperCase()">
                                </div>
                            </div>                                                                                                  
                        </form>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn blue" onClick="simpanProduk();">Simpan</button>
                        <button type="button" class="btn default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Pop Up Modal -->
        
        <form class="eventInsForm" method="post" target="_self" name="formku" 
            id="formku" action="<?php echo base_url('index.php/BackOffice/update_sales_order'); ?>">
            <div class="row">
                <div class="col-md-12 col-sm-12"><h4>Edit Sales Order</h4></div>
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
                            Tanggal <font color="#f00">*</font>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="tanggal" name="tanggal" 
                                class="form-control myline input-small" style="margin-bottom:5px; float:left" 
                                value="<?php echo date('d-m-Y', strtotime($mydata['tanggal'])); ?>">
                            <input id="header_id" name="header_id" type="hidden" value="<?php echo $mydata['id']; ?>"/>
                        </div>
                    </div>                                     
                    <div class="row">
                        <div class="col-md-5">
                            Nama Customer <font color="#f00">*</font>
                        </div>
                        <div class="col-md-7">
                            <select id="m_customer_id" name="m_customer_id" class="form-control myline select2me" 
                                data-placeholder="Pilih customer..." style="margin-bottom:5px">
                                <option value="<?php echo $mydata['m_customer_id']; ?>" selected="selected">
                                    <?php echo $mydata['nama_customer']; ?>
                                </option>
                                <?php
                                    foreach ($list_customer as $row){
                                        echo '<option value="'.$row->id.'">'.$row->nama_customer.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-5">
                            Nomor Sales Order <font color="#f00">*</font>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="no_sales_order" name="no_sales_order" 
                                class="form-control myline" style="margin-bottom:5px;" 
                                value="<?php echo $mydata['no_sales_order']; ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            Nilai Order (Rp) <font color="#f00">*</font>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="nilai_order" name="nilai_order" 
                                class="form-control myline" style="margin-bottom:5px;" 
                                value="<?php echo number_format($mydata['nilai_order'],0,',','.'); ?>" readonly="readonly">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align:right; margin-bottom:4px">
                    <a class="btn btn-success" onclick="newData(<?php echo $mydata['id']; ?>)">
                        <i class="fa fa-plus"></i> Tambah Produk</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Rincian produk yang di order
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-bordered table-hover table-stripped">
                                    <thead>
                                        <th>No</th>
                                        <th>Merek</th>
                                        <th>Jumlah (sak)</th>
                                        <th>Deal Harga (Rp)</th>
                                        <th>Catatan</th>
                                        <th>Action</th>
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
                                                    echo "<td style='text-align:right'>".number_format($value->jumlah_sak,0,',','.')."</td>";
                                                    echo "<td style='text-align:right'>".number_format($value->harga,0,',','.')."</td>";
                                                    echo "<td>".$value->catatan."</td>";
                                                    echo "<td>";
                                                    echo "<a class='btn btn-circle green btn-xs' style='margin-bottom:4px' onclick='editData(".$value->id.")'>"
                                                            . "&nbsp; <i class='fa fa-pencil'></i> Edit &nbsp; </a>";
                                                    echo "<a href='".base_url()."index.php/BackOffice/delete_produk/".$value->id."' "
                                                            . "class='btn btn-circle red-sunglo btn-xs' style='margin-bottom:4px' onclick='return confirm(&quot;Anda yakin menghapus item produk ini?&quot;);'>"
                                                            . "<i class='fa fa-times'></i> Hapus </a>";
                                                    echo "</td>";
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
                    <a href="<?php echo base_url('index.php/BackOffice/sales_order'); ?>" class="btn btn-default">
                        Back</a>
                </div>
             </div>
        </form>
    </div>
</div>  

<script>
    var dsState;
    
    function myCurrency(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    
    function simpandata(){		
        if($.trim($("#tanggal").val()) == ""){
            $('#message').html("Tanggal harus diisi, tidak boleh kosong!");
            $('.alert-danger').show();   
        }else if($.trim($("#m_customer_id").val()) == ""){
            $('#message').html("Silahkan pilih customer!");
            $('.alert-danger').show(); 
        }else{
            $('#btnSave').attr("disabled", true);                  
            $('#formku').submit();
        };
    };
    
    
    function simpanProduk(){
        if($.trim($("#merek").val()) == ""){
            $('#message').html("Silahkan pilih merek!");
            $('#msg_box').show();       
        }else if($.trim($("#harga").val()) == ""){
            $('#message').html("Harga tidak boleh kosong!");
            $('#msg_box').show();
        }else if($.trim($("#jumlah_sak").val()) == ""){
            $('#message').html("Jumlah tidak boleh kosong");
            $('#msg_box').show();        
        }else{    
            $('#message').html("");
            $('#msg_box').hide();
            if(dsState=="Input"){                            
                $('#frm_produk').attr("action", "<?php echo base_url(); ?>index.php/BackOffice/save_produk");                            
            }else{
                $('#frm_produk').attr("action", "<?php echo base_url(); ?>index.php/BackOffice/update_produk");                
            }
            $('#frm_produk').submit(); 
        };
    };
    
    function newData(id){
        $('#merek').select2('val', '');
        $('#jumlah_sak').val('');
        $('#harga').val('');
        $('#catatan').val('');
        
        $('#t_sales_order_id').val(id);
        $('#id').val('');
        dsState = "Input";

        $("#myModal").find('.modal-title').text('Input Produk');
        $("#myModal").modal('show',{backdrop: 'true'}); 
    }
    
    function editData(id){
        dsState = "Edit";
        $.ajax({
            url: "<?php echo base_url('index.php/BackOffice/edit_produk'); ?>",
            type: "POST",
            data : {id: id},
            success: function (result){
               console.log(result);                                         
               $('#merek').select2('val', result['merek']);
               $('#jumlah_sak').val(result['jumlah_sak']);
               $('#harga').val(result['harga']);
               $('#catatan').val(result['catatan']);              
               
               $('#t_sales_order_id').val(result['t_sales_order_id']);
               $('#id').val(result['id']);

               $("#myModal").find('.modal-title').text('Edit Produk');
               $("#myModal").modal('show',{backdrop: 'true'});           
            }
        });
    }

    function getHargaComa(nilai){
        $('#harga').val(nilai.toString().replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    }
    
    function getJumlahComa(nilai){
        $('#jumlah_sak').val(nilai.toString().replace(/\./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    }
</script>
        