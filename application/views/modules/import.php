<div class="row">                            
    <div class="col-md-12"> 
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span id="message">&nbsp;</span>
        </div>

        <?php
            if( ($group_id==1)||($hak_akses['index']==1) ){
        ?>    
        <p>
            You can upload a list of modules in csv file format. <br>
            Select your file by clicking the BROWSE button, then klik UPLOAD button.   
            <br>&nbsp;
        </p>
        <form id="formku" action="<?php echo base_url(); ?>index.php/Modules/upload" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-1">File name</div>
                <div class="col-md-4">
                    <input type="file" id="document_url" name="document_url">
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">&nbsp;</div>
                <div class="col-md-4">&nbsp;<br>
                    <input type="button" onClick="simpandata();" name="btnSave" 
                        value="Save" class="btn btn-primary" id="btnSave">
                </div>
            </div>
        </form>
        
          
        <?php
            }else{
        ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span id="message">You are not authorized to access that location!</span>
        </div>
        <?php
            }
        ?>
    </div>
</div>  
<script>		
function simpandata(){		
    if($.trim($("#document_url").val()) == ""){
        $('#message').html("Please select your file!");
        $('.alert-danger').show(); 	  
    }else{             
        $('#formku').submit();
    };
};

</script>

        