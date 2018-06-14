var TableEditableAgreementGeneral = function () {

    var handleTable = function () {

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow) {
            var myUrl = "http://localhost/mtcon/index.php/";
            var aData = oTable.fnGetData(nRow);
            var words = new Array();
            words     = aData[0].split(' ');
            
            var teks_id = new Array();
            teks_id     = words[3].split('"');

            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = aData[0];
            //jqTds[1].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[1] + '">';
            //jqTds[2].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[2] + '">';
            //jqTds[3].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[3] + '">';
            
            $.ajax({
                type: "POST",
                data: "id="+ teks_id[1],
                url: myUrl+"MAgreementGenerals/edit_tarif",
                cache: false,
                success: function(detail) {
                    jqTds[4].innerHTML = '<select id="rw_container_size" name="rw_container_size" \n\
                                class="form-control myline" style="margin-bottom:5px">\n\
                                <option value="20" '+ ((detail['container_size']=="20")? 'selected': '') +'>20</option>\n\
                                <option value="40" '+ ((detail['container_size']=="40")? 'selected': '') +'>40</option>\n\
                                </select>';
                    
                    jqTds[5].innerHTML = '<select id="rw_normal_special_flag" name="rw_normal_special_flag" \n\
                                class="form-control myline" style="margin-bottom:5px">\n\
                                <option value="N" '+ ((detail['normal_special_flag']=="N")? 'selected': '') +'>Normal</option>\n\
                                <option value="S" '+ ((detail['normal_special_flag']=="S")? 'selected': '') +'>Special</option>\n\
                                </select>';
            
                    jqTds[6].innerHTML = '<select id="rw_owner_user_flag" name="rw_owner_user_flag" \n\
                                class="form-control myline" style="margin-bottom:5px">\n\
                                <option value="O" '+ ((detail['owner_user_flag']=="O")? 'selected': '') +'>Owner</option>\n\
                                <option value="U" '+ ((detail['owner_user_flag']=="U")? 'selected': '') +'>User</option>\n\
                                </select>\n\
                                <input id="rw_detail_id" name="rw_detail_id" type="hidden" value="'+ detail['id'] +'">'; 
                    
                    $.ajax({
                        type: "POST",
                        url: myUrl+"MAgreementGenerals/get_currency_list",
                        cache: false,
                        success: function(hasil) {
                            var dd_cur = "";
                            dd_cur = '<select id="rw_m_currency_id" name="rw_m_currency_id" class="form-control myline" \n\
                                        style="margin-bottom:5px">';                            
                            for(i=0; i<hasil.length; i++){
                                dd_cur += "<option value='"+ hasil[i]['id'] +"' "+ ((detail['m_currency_id']==hasil[i]['id'])? 'selected': '') +">"+ hasil[i]['currency_code'] +"</option>";
                            }
                            dd_cur += "</select>";
                            jqTds[7].innerHTML = dd_cur; 
                        } 
                    });
                    
                    $.ajax({
                        type: "POST",
                        url: myUrl+"MAgreementGenerals/get_vat_list",
                        cache: false,
                        success: function(data_tax) {
                            var dd_tax = "";
                            dd_tax = '<select id="rw_m_tax_id" name="rw_m_tax_id" class="form-control myline" \n\
                                        style="margin-bottom:5px">';
                            dd_tax += "<option value=''></option>";
                            for(i=0; i<data_tax.length; i++){
                                dd_tax += "<option value='"+ data_tax[i]['id'] +"' "+ ((detail['m_tax_id']==data_tax[i]['id'])? 'selected': '') +">"+ data_tax[i]['tax_name'] +"</option>";
                            }
                            dd_tax += "</select>";
                            jqTds[9].innerHTML = dd_tax; 
                        } 
                    });
                } 
            });                              
            
            jqTds[8].innerHTML = '<input id="rw_amount" name="rw_amount" type="text" class="form-control myline" \n\
                                    value="' + aData[8] + '" onkeydown="return myCurrency(event);" onkeyup="getComa(this.value)">';
            jqTds[10].innerHTML = '<a class="btn btn-circle blue-hoki btn-xs" id="btnSaveRow" onclick="saveRow();" style="margin-bottom:4px;">&nbsp; \n\
                                     Save &nbsp;</a>&nbsp;\n\
                                    <a class="cancel btn btn-circle yellow btn-xs" href="" style="margin-bottom:4px;">\n\
                                    Cancel&nbsp;</a>';

        }

        function saveRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
            oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 4, false);
            oTable.fnUpdate('<a class="delete" href="">Delete</a>', nRow, 5, false);
            oTable.fnDraw();
        }

        var table = $('#sample_editable_1');
        var oTable = table.dataTable({

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,

            "language": {
                "lengthMenu": " _MENU_ records"
            },
            "columnDefs": [{ // set default column settings
                'orderable': true,
                'targets': [0]
            }, {
                "searchable": true,
                "targets": [0]
            }],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = $("#sample_editable_1_wrapper");

        tableWrapper.find(".dataTables_length select").select2({
            showSearchInput: false //hide search box with special css class
        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        $('#sample_editable_1_new').click(function (e) {
            e.preventDefault();

            if (nNew && nEditing) {
                if (confirm("Previose row not saved. Do you want to save it ?")) {
                    saveRow(oTable, nEditing); // save
                    $(nEditing).find("td:first").html("Untitled");
                    nEditing = null;
                    nNew = false;

                } else {
                    oTable.fnDeleteRow(nEditing); // cancel
                    nEditing = null;
                    nNew = false;
                    
                    return;
                }
            }

            var aiNew = oTable.fnAddData(['', '', '', '', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });


        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();

            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleTable();
        }

    };

}();