<script language="javascript" type="text/javascript">
    function validateKeyStrokes(event) {
        var charCode = (event.which) ? event.which : event.keyCode;

        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return true;
        }
        return false;
    }

    /** ready OK */
    /*new validator to test file size*/
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param);
    }, "File must be less than 2MB");

    $.validator.addMethod('myLess1', function (value, element, param) {
        var m_id = new String(element.id);

        var estifield = "";
        if (m_id == 'LA_COMPLETED_HA_ACHIEVE') {
            estifield = "LA_HA";
        } else if (m_id == 'LA_COMPLETED_NO_ACHIEVE') {
            estifield = "LA_NO";
        } else if (m_id == 'FA_COMPLETED_HA_ACHIEVE') {
            estifield = "FA_HA";
        } else if (m_id == 'STEEL_WORK_ACHIEVE') {
            estifield = "STEEL_WORK";
        } else if (m_id == 'CANAL_STRUCTURE_ACHIEVE') {
            estifield = "CANAL_STRUCTURE";
        } else if (m_id == 'CANAL_STRUCTURE_MASONRY_ACHIEVE') {
            estifield = "CANAL_STRUCTURE_MASONRY";
        } else {
            estifield = m_id.replace("_ACHIEVE", "");
        }
        //$('#divtest').html(m_id+" : ");
        //$('#divtest').append(estifield+"::");
        var estival = $('#' + estifield).val();
        var e = checkNo(estival);
        var a = checkNo(value);

        //$('#divtest').append(estival+"::");
        return this.optional(element) || ((a <= e) ? true : false);
        //return this.optional(element) || value <= $(param).val();
    }, function (params, element) {
        var m_id = new String(element.id);
        //$('#divtest').append(m_id+" : z : ");
        var estifield = "";
        if (m_id == 'LA_COMPLETED_HA_ACHIEVE') {
            estifield = "LA_HA";
        } else if (m_id == 'LA_COMPLETED_NO_ACHIEVE') {
            estifield = "LA_NO";
        } else if (m_id == 'FA_COMPLETED_HA_ACHIEVE') {
            estifield = "FA_HA";
        } else if (m_id == 'STEEL_WORK_ACHIEVE') {
            estifield = "STEEL_WORK";
        } else if (m_id == 'CANAL_STRUCTURE_ACHIEVE') {
            estifield = "CANAL_STRUCTURE";
        } else if (m_id == 'CANAL_STRUCTURE_MASONRY_ACHIEVE') {
            estifield = "CANAL_STRUCTURE_MASONRY";
        } else {
            estifield = m_id.replace("_ACHIEVE", "");
        }

        var estival = $('#' + estifield).val();
        //$('#divtest').html(m_id+"fg");

        //$('#divtest').html( $(params).val() +"gg");
        var achVal = element.value;// $(m_id).val();
        var e = checkNo(estival);
        var a = checkNo(achVal);
        //$('#divtest').append(estival+" : y : " + achVal + " : u ");
        if (a <= e)
            return "";
        else
            return 'Max Limit : ' + estival;
    });

    $.validator.addMethod('myLess', function (value, element, param) {
            var m_id = '#' + new String(element.id);
            //$('#divtest').html(m_id+"y");
            var estifield = m_id.replace("AIP_", "EIP_");
            var estival = $(estifield).val();
//  $('#divtest').html(estival);
            var e = checkNo(estival);
            var a = checkNo(value);
            return this.optional(element) || ((a <= e) ? true : false);
            //return this.optional(element) || value <= $(param).val();
        },
        function (params, element) {
            var m_id = '#' + new String(element.id);
            //$('#divtest').html(m_id+"z");
            var estifield = m_id.replace("AIP_", "EIP_");
            var estival = $(estifield).val();
            //$('#divtest').append('<br/>' + m_id+"fg");
            //$('#divtest').html( $(params).val() +"gg");
            //$('#divtest').append('<br/>' + element.value+ ': ' + "fg");

            var achVal = element.value;
            var e = checkNo(estival);
            var a = checkNo(achVal);
            //$('#divtest').append('<br/>' + element.value+ ': ' + "fg");
            if (a <= e)
                return "";
            else
                return 'Max Limit : ' + estival;
        });

    var mCurrentProjectMode = '';
    var ipNa = false;
    var latLngArr = Array();

    var validator;
    var objIPData;
    var arrIPBlockData = new Array();
    <?php
    if($editMode){
    $arrB = array();
    foreach ($arrBlocks as $id) {
        array_push($arrB, "'" . $id . "'");
    }


    ?>
    var arrBlockIds = new Array(<?php echo implode(',', $arrB);?>);
    <?php

    $arrRestoredB = array();
    foreach ($arrRestoredBlocks as $id) {
        array_push($arrRestoredB, "'" . $id . "'");
    }
    ?>
    var arrRestoredBlockIds = new Array(<?php echo implode(',', $arrRestoredB);?>);
    <?php
    $arrB = array();
    foreach ($arrOptions as $k => $v) {
        array_push($arrB, "'" . $k . "':'" . $v . "'");
    }
    ?>
    var defaultOptions = {<?php echo implode(',', $arrB);?>};
    var initMode = 0;//
    <?php }//editmode?>
    $().ready(function () {


        $(".chosen-select").select2();
        $(".sel2").select2();
        //set date for project start date
        var aa_auth_id = $('#AA_AUTHORITY_ID').val();
        //alert(aa_auth_id);
        if (aa_auth_id == '5') {
            $('#TR_AA_AUTHORITY_ID').show();
        } else {
            $('#TR_AA_AUTHORITY_ID').hide();
        }

        var raa_auth_id = $('#RAA_AUTHORITY_ID').val();
        //alert(aa_auth_id);
        if (raa_auth_id == '5') {
            $('#TR_RAA_AUTHORITY_ID').show();
        } else {
            $('#TR_RAA_AUTHORITY_ID').hide();
        }

        $('#AA_DATE').attr("placeholder", "dd-mm-yyyy").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            maxDate: new Date,
            minDate: new Date(2015, 3, 1)
        });
        $('#RAA_DATE').attr("placeholder", "dd-mm-yyyy").datepicker({
            dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, showOtherMonths: true,
            beforeShow: function (input, inst) {
                return setMinMaxDate('#AA_DATE', 'today');
            }
        });
        <?php if($editMode){
        //echo 'window.arrBlockIds = ['.implode(',', $arrIPBlockIds).'];'."\n".'window.ipNa = '.(($IP_NA) ? 'true':'false').';'."\n";
        ?>
        doSessionChange();
        $('#sessionMinDate, #sessionMaxDate, #sessionRealMinDate').attr("placeholder", "dd-mm-yyyy").datepicker({
            dateFormat: 'dd-mm-yy'
        });
        $('#DATE_COMPLETION').attr("placeholder", "dd-mm-yyyy").datepicker({
            dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, showOtherMonths: true,
            beforeShow: function (input, inst) {
                return setMinMaxDate('#AA_DATE+1', '');
            }
        });
        $('#LA_DATE, #SPILLWAY_WEIR_DATE, #FLANKS_AF_BUNDS_DATE, ' +
            '#SLUICE_DATE, #NALLA_CLOSER_DATE, ' +
            '#CANAL_EW_DATE, #CANAL_STRUCTURE_DATE, ' +
            '#CANAL_LINING_DATE').attr("placeholder", "dd-mm-yyyy").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            beforeShow: function (input, inst) {
                return setMinMaxDate('#AA_DATE+1', '#DATE_COMPLETION-1');
            }
        });
        var project_id = $('#PROJECT_SETUP_ID').val();
        //change event
        $('#DISTRICT_ID').on('change', function () {
            getBlockHW(this.value);
            getTehsilHW(this.value);
        });
        $('#DISTRICT_BENEFITED').on('change', function () {
            showBenefitedBlocks($("#DISTRICT_BENEFITED").select2("val"));
            getVillages($("#DISTRICT_BENEFITED").select2("val"));
        });

        //show drop down Benefitted Assembly
        $('#ASSEMBLY_ID').on('change', function () {
            //  showBenefitedAssembly($("#ASSEMBLY_ID").select2("val"));
        });
        $("#BLOCKS_BENEFITED").select2({placeholder: "Select Block", allowClear: true});
        var $blockBenefited = $("#BLOCKS_BENEFITED");
        $blockBenefited.on("select2:unselect", function (evt) {

            if (!evt) {
                var args = "{}";
            } else {
                var id = evt.params.data.id;

                var args = evt.params.data.text;
                // console.log(window.arrBlockIds);
                if (window.arrBlockIds.length > 1) {
                    var index = window.arrBlockIds.indexOf(evt.params.data.id);
                    //      console.log('params id = '+evt.params.data.id);
                    //   console.log('index= '+index);
                    //if(index != -1){
                    var item = window.arrBlockIds.splice(index, 1);
                    //console.log('item = '+item);
                    if (item) {

                        $('.trb-' + id).remove();
                    }
                    //}
                } else {

                    window.arrBlockIds = new Array();
                    $('.trb-' + id).remove();
                }
            }
            afterDelete();
            //alert(args);
        });
        $blockBenefited.on("select2:select", function (evt) {
            if (!evt) {
                var args = "{}";
            } else {
                var args = evt.params.data.text;
                window.arrBlockIds.push(evt.params.data.id);
                showBlockIP(evt.params.data.id, evt.params.data.text);
            }
            //alert(args);
        });
        $('#VILLAGES_BENEFITED').on("select2-opening", function () {
            var noOfVillagesCovered = checkNo($('#NO_VILLAGES_COVERED').val());
            var selectedVillages = $('#VILLAGES_BENEFITED').select2("val");
            if (selectedVillages != null) {
                if (noOfVillagesCovered == selectedVillages.length) {
                    getCountVillages();
                    return false;
                }
            }
            getCountVillages();
        });
        $('#VILLAGES_BENEFITED').on('change', function (e) {
            getCountVillages();
        });
        $("#btnfrm2").click(function () {
            $('#frm2').slideToggle('slow');
            $('#sp_arrow_frm2_down').toggle();
            $('#sp_arrow_frm2_up').toggle();
        });
        $("#VILLAGES_BENEFITED").select2();
        getCountVillages();
        <?php }//$editMode ?>
        getToolTips();
        //setSelect2();
        //,filesize:2000000
        window.validator =
            $("#frmProject").validate({
                rules: {
                    "WORK_NAME": {required: true},
                    "WORK_NAME_HINDI": {required: true},
                    "DEPOSIT_SCHEME_ID": {required: true},
                    "AA_NO": {required: true, digits: true, maxlength: 5},
                    "AA_DATE": {required: true, indianDate: true},
                    "AA_AMOUNT": {required: true, min: 0, number: true},
                    "PROJECT_COMPLETION_DATE": {required: true},
                    <?php if(!$editMode){?>
                    "LONGITUDE_D": {required: true, number: true, range: [80, 84]},
                    "LONGITUDE_M": {required: true, number: true, range: [0, 60]},
                    "LONGITUDE_S": {required: true, number: true, range: [0, 60]},
                    "LATITUDE_D": {required: true, number: true, range: [17, 24]},
                    "LATITUDE_M": {required: true, number: true, range: [0, 60]},
                    "LATITUDE_S": {required: true, number: true, range: [0, 60]},
                    <?php }//$editMode ?>
                    "AA_SCAN_COPY": {required: true, extension: "pdf", filesize: 2000000},
                    "RAA_SCAN_COPY": {required: true, extension: "pdf", filesize: 2000000}

                    <?php if($editMode){?>,
                    "RAA_NO": {required: true, digits: true, maxlength: 5},
                    "RAA_DATE": {required: true, indianDate: true},
                    "RAA_AMOUNT": {required: true},
                    "PROJECT_START_DATE": {required: true, indianDate: true},
                    "DATE_COMPLETION": {required: true, indianDate: true}
                    <?php //if(count($arrV)>0){echo ','.implode(',', $arrV);}?>
                    <?php }?>
                },
                messages: {
                    "WORK_NAME": {required: "Work Name is Must"},
                    "WORK_NAME_HINDI": {required: "कार्य का नाम जरूरी है"},
                    "DEPOSIT_SCHEME_ID": {required: "Required - Deposit Scheme "},
                    "AA_NO": {required: "Required - AA No "},
                    "AA_DATE": {required: "Required - AA Date"},
                    "AA_AMOUNT": {required: "Required - AA Amount", min: "Required Positive Amount"},
                    "AA_SCAN_COPY": {
                        required: "Please upload scan copy of AA",
                        extension: "Please upload only .pdf  files"
                    },
                    "RAA_SCAN_COPY": {
                        required: "Please upload scan copy of RAA",
                        extension: "Please upload only .pdf files"
                    }
                }
            });
        $('#WORK_NAME').alphanum({
            allow: ' -:.,;[](){}%',
            allowSpace: true,
            allowNumeric: true,
            allowUpper: true,
            allowLower: true,
            allowCaseless: true,
            allowLatin: true,
            allowOtherCharSets: false,
            forceUpper: false,
            forceLower: false,
            maxLength: 1000
        });
        $('#WORK_NAME_HINDI').alphanum({
            allow: ' -:.,;[](){}%',
            allowSpace: true,
            allowNumeric: true,
            allowUpper: false,
            allowLower: false,
            allowCaseless: true,
            allowLatin: true,
            allowOtherCharSets: true,
            forceUpper: false,
            forceLower: false,
            maxLength: 1000
        });
        <?php if($editMode){?>
        $("#VILLAGES_BENEFITED").select2();
        checkAchievementReady();
        setRules();
        checkTotalExp();
        <?php }//$editMode?>

        $('div').on("keypress", ".onlynumber", function (event) {
            //event.stopPropagation();
            //if(event.which < 46 || event.which > 59) {
            if (event.which < 47 || event.which > 57) {
                event.preventDefault();
            } // prevent if not number/dot

            /*if(event.which == 46 && $(this).val().indexOf('.') != -1) {
            event.preventDefault();
        }*/
        });
        <?php if(!$editMode){?>
        $('#LONGITUDE_M').on('keyup', function () {
            //assignLatLngValue();
            checkProjectCodeRunTime();
            var value = $('#LONGITUDE_M').val();
            //console.log(value);
            if (value.length == 2) {
                $('#LONGITUDE_S').focus();
            }
        });
        $('#LONGITUDE_S').on('keyup', function () {
            //assignLatLngValue();
            checkProjectCodeRunTime();
            var value = $('#LONGITUDE_S').val();
            //console.log(value);
            if (value.length == 2) {
                $('#LATITUDE_M').focus();
            }
        });
        $('#LATITUDE_M').on('keyup', function () {
            //assignLatLngValue();
            checkProjectCodeRunTime();
            var value = $('#LATITUDE_M').val();
            //console.log(value);
            if (value.length == 2) {
                $('#LATITUDE_S').focus();
            }
        });

        $('#LATITUDE_S').on('blur', function () {
            //assignLatLngValue();
            checkProjectCodeRunTime();
        });
        <?php }else{?>
        window.initMode = 1;
        <?php }?>
    });

    function assignLatLngValue() {
        latLngArr[1] = $('#LONGITUDE_D').val();
        latLngArr[2] = $('#LONGITUDE_M').val();
        latLngArr[3] = $('#LONGITUDE_S').val();
        latLngArr[4] = $('#LATITUDE_D').val();
        latLngArr[5] = $('#LATITUDE_M').val();
        latLngArr[6] = $('#LATITUDE_S').val();
    }

    //
    function getCountVillages() {
        var selectedVillages = $('#VILLAGES_BENEFITED').select2("val");
        if (selectedVillages != null) {
            $('#villageCount').html(selectedVillages.length);
        } else {
            $('#villageCount').html(0);
        }
    }

    //
    function checkValidation() {
        var selectList = new Array();
        //selectList.push( Array('PROJECT_SUB_TYPE_ID', 'Select Project Sub Type'));
        selectList.push(Array('AA_AUTHORITY_ID', 'Select Authority'));
        selectList.push(Array('DISTRICT_ID', 'Select District'));
        var mSelect = validateMyCombo(selectList);
        if (mSelect > 0) {
            alert('Please Check Errors');
            return;
        }
    }

    //
    function checkForStatus() {

        var $selDate = $('#AA_DATE').val();
        var $setupSessionId = $('#SESSION_ID').val();
        // console.log($setupSessionId);
        $.ajax({
            type: "POST",
            url: 'getAASessionId',
            data: {'date': $selDate},
            success: function (data) {
                var $aaSessionId = data;
                $('#AA_SESSION_ID').val($aaSessionId);
                <?php if($editMode){?>
                checkAchievementReady1();
                if ($aaSessionId == $setupSessionId) {
                    $('#startInSession').val(1);
                    disableAchievement(true);
                } else {
                    $('#startInSession').val(0);
                    disableAchievement(false);
                }
                <?php }?>
                return;
                //$('#OFFICE_SDO_ID').html(data);
                //$('#OFFICE_SDO_ID').trigger("updatecomplete");
                //setLoadingStatus(false, 'OFFICE_SDO_ID');
            }
        });
    }

    //
    function check_validation() {
        $('.error').each(function () {
            var errId = $(this).attr('id');
            //$('#'+errId).css({backgroundColor:"#F00", color:"#FFF" });
            if (errId) {
                $('#' + errId).parents('div:eq(0)').css({display: "block"});
                $('#' + errId).parents('div:eq(0)').siblings().css({color: "#F00", border: "#F00 1px solid"});
            }
        });
    }

    //
    var mCurrentProjectMode = '';

    function saveProject(mode) {
        //debugger;

        /*    var aaFileName=$("#AA_SCAN_COPY1").val();

    if(aaFileName.length==0)
    {
         showAlert('Error...', 'Please upload AA File',
                'warn'
            );
            return false;
    }*/


        //mode 0-save_edit 1-save 2-save_modification
        $('#saveMode').val(mode);
        window.mCurrentProjectMode = mode;
        if (mode == 2) checkTotalExp();
        var selectList = new Array();
        var mSelect = 0;
        if (mode != 2) {
            //selectList.push( Array('PROJECT_SUB_TYPE_ID', 'Select Project Sub Type', false));
        }
        selectList.push(Array('AA_AUTHORITY_ID', 'Select AA Authority', false));
        <?php if($holdingPerson == 3){?>
        //selectList.push( Array('OFFICE_EE_ID', 'Select Division', true));
        <?php }?>
        //selectList.push( Array('OFFICE_SDO_ID', 'Select Sub Division', true, false));
        if (mode != 2) {
            selectList.push(Array('DISTRICT_ID', 'Select District', true));
        }
        if (mode == 2) {
            //selectList.push( Array('ALLOCATION_BUDGET_HEAD_ID', 'Allocation of Budget Head', false));
            //selectList.push( Array('FUND_ASSIS_ID', 'Select Fund Assitance', false));
            // selectList.push( Array('BLOCK_ID', 'Select Head Work Block', false));
            //  selectList.push( Array('TEHSIL_ID', 'Select Head Work Tehsil', false));
            //  selectList.push( Array('ASSEMBLY_ID', 'Select Assembly', false));
            selectList.push(Array('LA_CASES_STATUS', 'Select LA Case Status', true));
            selectList.push(Array('SPILLWAY_WEIR_STATUS', 'Select Spillway Case Status', true));
            selectList.push(Array('FLANKS_AF_BUNDS_STATUS', 'Select Flanks / af. bunds Status', true));
            selectList.push(Array('SLUICE_STATUS', 'Select Sluice Status', true));
            selectList.push(Array('NALLA_CLOSER_STATUS', 'Select Nall Closer Status', true));
            selectList.push(Array('CANAL_EW_STATUS', 'Select Canal E/W Status', true));
            selectList.push(Array('CANAL_STRUCTURE_STATUS', 'Select Canal Structure Status', true));

            selectList.push(Array('CANAL_LINING_STATUS', 'Select Canal Lining Status', true));
            //   selectList.push( Array('FERTI_PESTI_CARRIER_SYSTEM_STATUS', 'Select Fertilizer and Pesticide Carrier System Status', true));
            //   selectList.push( Array('CONTROL_ROOMS_STATUS', 'Select Control Rooms Status', true));
            <?php if(!$monthlyRecordExists){?>
            //selectList.push( Array('SESSION_ID', 'Select Session', true));
            <?php }?>
            //selectList.push( Array('GRANT_NO', 'Select Grant no', true));
            selectList.push(Array('DISTRICT_BENEFITED', 'Select Benefitted District', true, false));
            //   selectList.push( Array('BLOCKS_BENEFITED', 'Select Benefitted Block', true, false));
            selectList.push(Array('ASSEMBLY_BENEFITED', 'Select Benefitted Assembly Const.', true, false));
            selectList.push(Array('VILLAGES_BENEFITED', 'Select Benefitted Villages', true, false));
            //selectList.push( Array('VILLAGE_ID', 'Select Village', true));
            var mSelect = validateMyCombo(selectList);
        }
        mStCount = 0;
        if (mode == 2) {

            //Number of Villages Validation
            var noOfVillages = $('#NO_VILLAGES_BENEFITED').val();
            var selectedVillages = $('#VILLAGES_BENEFITED').select2("val");
            var selectedVillagesNos = $('#VILLAGES_BENEFITED :selected').length;
            //alert( $('#VILLAGES_BENEFITED :selected').text());

            //console.log(selectedVillages);
            if (noOfVillages != selectedVillagesNos) {
                showAlert('Error...',
                    'Your Input for Villages Covered is :- <ul><li>No of villages covered :' + noOfVillages +
                    '</li><li>No. of Selected Villages : ' + selectedVillagesNos + '</li></ul>Please correct your input.',
                    'warn'
                );
                return false;
            }

            var naFields = new Array(
                'LA_NA', 'FA_NA', 'HW_EARTHWORK_NA', 'HW_MASONRY_NA', 'STEEL_WORK_NA',
                'CANAL_EARTHWORK_NA', 'CANAL_STRUCTURE_NA', 'CANAL_STRUCTURE_MASONRY_NA', "CANAL_LINING_NA", "IRRIGATION_POTENTIAL_TO_BE_RESTORED_NA"
            );

            var a;
            var naCount = 0;
            for (var i = 0; i <= naFields.length; i++) {
                a = $('#' + naFields[i]).is(":checked");
                if (a) {
                    naCount++;
                }
                //alert(naFields[i] + '-------------' + a);
            }
            //alert(naCount);
            if (naCount == naFields.length) {
                showAlert('Error...', 'All fields in the <strong><u>Estimation Form</u></strong> can not be <strong><u>NA</u></strong>. Please verify your selection.', 'warn');
                return false;
            }

            var prevSettings = new Array();
            prevSettings[0] = $('#frm1').css('display');
            prevSettings[1] = $('#frm2').css('display');
            prevSettings[2] = $('#frm4').css('display');
            //show all div
            $('#frm1').css('display', '');
            $('#frm2').css('display', '');
            $('#frm4').css('display', '');

            if ($('#startInSession').val() == 1) {
                //in current session
                var arrValidValues = new Array("1", "2", "7");
                var arrFields = new Array(
                    "LA_CASES_STATUS", "SPILLWAY_WEIR_STATUS", "FLANKS_AF_BUNDS_STATUS", "SLUICE_STATUS",
                    "NALLA_CLOSER_STATUS", "CANAL_EW_STATUS", "CANAL_STRUCTURE_STATUS", "CANAL_LINING_STATUS"
                );
                for (i = 0; i < arrFields.length; i++) {
                    res = $.inArray($('#' + arrFields[i]).val(), arrValidValues);
                    if (res == -1) mStCount++;
                }
            }
            // console.log($('#startInSession').val());


        }

        var myValidation = $("#frmProject").valid();

        IPERR = 0;
        if (mode == 2) {

            a = $('#NEW_IRRIGATION_POTENTIAL_NA').is(":checked");
            if (!a) {
                for (i = 0; i < window.arrBlockIds.length; i++) {
                    blockid = window.arrBlockIds[i];
                    kt = checkNo($('#BLOCK_EIP_K_' + blockid).val());
                    rt = checkNo($('#BLOCK_EIP_R_' + blockid).val());
                    pass = 0;
                    if (kt > 0)
                        pass++;
                    if (rt > 0)
                        pass++;

                    if (pass == 0) {
                        $('#BLOCK_EIP_K_' + blockid).css("border-color", "red");
                        $('#BLOCK_EIP_R_' + blockid).css("border-color", "red");
                        myValidation = false;
                        IPERR = IPERR + 2;
                    }
                }
            }


        }

        if (!(mSelect == 0 && myValidation && mStCount == 0)) {
            if (mSelect == 0 && myValidation) {
                var msession = '';
                <?php if($monthlyRecordExists){?>
                msession = '<?php echo $SESSION_OPTIONS;?>';
                <?php }else{?>
                msession = $('#SESSION_ID[selected]').text();
                <?php }?>
                showAlert('Info',
                    'परियोजना की प्रारंभ तिथि ' + $('#AA_DATE').val() +
                    ' सॉफ्टवेयर में परियोजना की प्रविष्टी वाले सत्र ' + msession + ' में है ' + "\n" +
                    'अतः पिछले सत्र की स्थिति में फॉर्म 3 में ' + (mStCount) +
                    ' कम्पोनेन्ट के स्थिति को ' + "\n" + ' Not Started रखना होगा ' + "\n\n" +
                    'This project\'s start Date (' + $('#AA_DATE').val() +
                    ')is in Selected Session (' + msession + '). ' + "\n" +
                    ' You have to select Status as Not Started in : ' +
                    (mStCount) + ' component in this form.',
                    'info'
                );
            } else {
                showAlert('Oops...', 'You have : ' + (window.validator.numberOfInvalids() + mSelect + mStCount + IPERR) + ' errors in this form.', 'error');
            }
            return;
        }

        if (myValidation) {
            checkProjectCode();
        } else {
            showAlert('Error...', 'There is/are some Required Data... <br />Please Check & Complete it.', 'warn');
        }
    }

    function checkProjectCodeRunTime() {
        if ($('#LONGITUDE_D').val().length == 0 ||
            $('#LONGITUDE_M').val().length == 0 ||
            $('#LONGITUDE_S').val().length == 0 ||
            $('#LATITUDE_D').val().length == 0 ||
            $('#LATITUDE_M').val().length == 0 ||
            $('#LATITUDE_S').val().length == 0) {
            return;
        }

        $('#divCheckCode').show();
        var params = {
            'divid': 'none',
            'url': 'checkProjectCode',
            'data': {
                'PARENT_PROJECT_ID': $('#PARENT_PROJECT_ID').val(),
                'PROJECT_SETUP_ID': $('#PROJECT_SETUP_ID').val(),
                'DISTRICT_ID': $('#DISTRICT_ID').val(),
                'LONGITUDE_D': $('#LONGITUDE_D').val(),
                'LONGITUDE_M': $('#LONGITUDE_M').val(),
                'LONGITUDE_S': $('#LONGITUDE_S').val(),
                'LATITUDE_D': $('#LATITUDE_D').val(),
                'LATITUDE_M': $('#LATITUDE_M').val(),
                'LATITUDE_S': $('#LATITUDE_S').val()
            },
            'donefname': 'doneCheckProjectCodeRunTime',
            'failfname': 'failProject',
            'alwaysfname': 'doThisProjectCheck'
        };
        callMyAjax(params);
    }

    function doneCheckProjectCodeRunTime(response) {
        var myData = parseMyResponse(response);
        //  console.log('hi');
        //alert(myData.success);
        if (parseInt(myData.success) == 0) {
            //alert(myData.message);
            $('#divCheckCode').show();
            $('#divCheckCode').html("Unable to Save due to Duplicate Data for Project...<br />" + myData.message);

        } else if (parseInt(myData.success) == 1) {
            $('#divCheckCode').hide();
        }
        /*else{
        //$('#divCheckCode').html("Duplicate Data for Project...<br />Unable to Save Project <br /> " + myData.message);
        $('#divCheckCode').html(myData.message);
    }*/
    }

    function checkProjectCode() {
        $('#divCheckCode').show();
        var params = {
            'divid': 'divCheckCode',
            'url': 'checkProjectCode',
            'data': {
                'PARENT_PROJECT_ID': $('#PARENT_PROJECT_ID').val(),
                'PROJECT_SETUP_ID': $('#PROJECT_SETUP_ID').val(),
                'DISTRICT_ID': $('#DISTRICT_ID').val(),
                'LONGITUDE_D': $('#LONGITUDE_D').val(),
                'LONGITUDE_M': $('#LONGITUDE_M').val(),
                'LONGITUDE_S': $('#LONGITUDE_S').val(),
                'LATITUDE_D': $('#LATITUDE_D').val(),
                'LATITUDE_M': $('#LATITUDE_M').val(),
                'LATITUDE_S': $('#LATITUDE_S').val()
            },
            'donefname': 'doneCheckCodeProject',
            'failfname': 'failProject',
            'alwaysfname': 'doThisProjectCheck'
        };
        callMyAjax(params);
    }

    function doneCheckCodeProject(response) {
        //   console.log('hello');

        var myData = parseMyResponse(response);
        //alert(myData.success);
        if (parseInt(myData.success) == 0) {
            //   console.log(myData.message);
            $('#divCheckCode').html("Unable to Save due to Duplicate Data for Project...<br />" + myData.message);
            $('#divCheckCode').show();
        }
        //return;
        if (parseInt(myData.success) == 1) {
            //console.log('world');
            //return;
            $('#divCheckCode').hide();
            var fileData = new FormData($('#frmProject')[0]);
            var params = {
                'divid': 'mySaveDiv',
                'url': 'saveProjectSetup',
                'data': fileData,
                'donefname': 'doneProject',
                'failfname': 'failProject',
                'alwaysfname': 'doThisProject'
            };
            callMyAjaxUploadFile(params);
            //console.log('done');
            //return;
        }//else{
        //$('#divCheckCode').html("Duplicate Data for Project...<br />Unable to Save Project <br /> " + myData.message);
        //   $('#divCheckCode').html(myData.message);
        //}
    }

    function doThisProjectCheck() {
    }

    function doneProject(response) {
//  $('#divCheckCode').hide();
        //Reload only Micro Irrigation Grids (ongoing/completed)
        $("#projectList").trigger('reloadGrid');
        $("#depProjectList").trigger('reloadGrid');
        $("#depProjectCList").trigger('reloadGrid');

        if (window.mCurrentProjectMode == 0) {
            //replace dialog box with msg
            $('#modalBox').html(parseAndShowMyResponse(response));
        } else {
            $('#message').html(parseAndShowMyResponse(response));
            $("#modalBox").dialog('close');
        }
        gridReload();
    }

    function failProject() {
    }

    function doThisProject() {
    }

    //
    function enableDisableDate(targetControl, currentValue) {
        //console.log(targetControl+' currentValue:' + currentValue);
        currentValue = parseInt(currentValue);
        var arrControls = {
            'LA_CASES_STATUS': 'LA_DATE',
            'SPILLWAY_WEIR_STATUS': 'SPILLWAY_WEIR_DATE',
            'FLANKS_AF_BUNDS_STATUS': 'FLANKS_AF_BUNDS_DATE',
            'SLUICE_STATUS': 'SLUICE_DATE',
            'NALLA_CLOSER_STATUS': 'NALLA_CLOSER_DATE',
            'CANAL_EW_STATUS': 'CANAL_EW_DATE',
            'CANAL_STRUCTURE_STATUS': 'CANAL_STRUCTURE_DATE',
            'CANAL_LINING_STATUS': 'CANAL_LINING_DATE'
        };

        if (currentValue == 1 || currentValue == 0 || currentValue == 5) {

            $('#' + targetControl).attr('disable', true).removeClass('hasDatepicker').removeClass('required');
            $('#req' + targetControl).hide();
            targetControl = arrControls[targetControl];
            enableDisableDatePicker(targetControl, true);
        } else if (currentValue == 7) {
            //$('#'+targetControl).attr('disable', false).addClass('hasDatepicker').addClass('required');
            //addHiddenField(targetControl, 7, 'xx');
            $('#req' + targetControl).show();

            targetControl1 = arrControls[targetControl];
            enableDisableDatePicker(targetControl1, false);
            //console.log('remove it:'+'#HIDTXT_'+ targetControl + '_ACHIEVE');

        } else {

            $('#' + targetControl).attr('disable', false).addClass('hasDatepicker').addClass('required');
            $('#req' + targetControl).show();

            targetControl1 = arrControls[targetControl];
            enableDisableDatePicker(targetControl1, false);
        }
    }

    //
    function enableDisableDatePicker(ctrl, status) {
        //$( '#'+ctrl ).datepicker( "option", { disabled: status } );
        if (status) {//disable
            $('#' + ctrl).hide();
        } else {
            $('#' + ctrl).show();
            $('#' + ctrl).attr("placeholder", "dd-mm-yyyy").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true,
                beforeShow: function (input, inst) {
                    return setMinMaxDate('#AA_DATE', '#DATE_COMPLETION');
                }
            });
            $('#' + ctrl).rules("add", {
                required: true,
                indianDate: true,
                messages: {required: "Required."}
            });
        }
    }

    //
    function getS(status) {
        //$("#CANAL_EARTH_WORK_STATUS").select2("enable", status);
    }

    //
    function showHideRAA(status) {
        if (status) {
            $('.raa').show();
        } else {
            $('.raa').hide();
        }
    }

    function getSDOOffices(eeid) {
        setLoadingStatus(true, 'OFFICE_SDO_ID');
        $.ajax({
            type: "POST",
            url: 'getSDOOffices',
            data: {'eeid': eeid},
            success: function (data) {
                $('#OFFICE_SDO_ID').html(data);
                $('#OFFICE_SDO_ID').trigger("updatecomplete");
                setLoadingStatus(false, 'OFFICE_SDO_ID');
            }
        });
    }
    <?php if($editMode){?>
    function setEstimationFields(mName, status) {

        //  console.log('kutte');

        console.log('#sno= ' + '#mName =' + mName + '#status=' + status);
        var requiredField1 = mName.substr(0, (mName.length - 3));
        //$('#divCheckCode').html('<br />' + mName + ' req: ' + requiredField1);
        var arrIntFields = new Array(
            "LA_NO", "LA_NO_ACHIEVE", "LA_COMPLETED_NO_ACHIEVE", "LA_COMPLETED_HA_ACHIEVE",
            "CANAL_STRUCTURE", "C_CANAL_STRUCTURE_ACHIEVE",
        );
        /* Commented on 25 Apr 2019 */
        /*
     var arrIntFields = new Array(
        "LA_NO", "LA_NO_ACHIEVE","LA_HA","LA_HA_ACHIEVE", "LA_COMPLETED_NO_ACHIEVE", "LA_COMPLETED_HA_ACHIEVE",
        "FA_HA","FA_HA_ACHIEVE","FA_COMPLETED_HA_ACHIEVE",
        "HW_EARTHWORK","HW_EARTHWORK_ACHIEVE",
        "HW_MASONRY","HW_MASONRY_ACHIEVE",
        "STEEL_WORK", "STEEL_WORK_ACHIEVE",
        "CANAL_EARTHWORK", "CANAL_EARTHWORK_ACHIEVE",
        "CANAL_STRUCTURE", "C_CANAL_STRUCTURE_ACHIEVE",
        "CANAL_STRUCTURE_MASONRY", "CANAL_STRUCTURE_MASONRY_ACHIEVE",
        "CANAL_LINING","CANAL_LINING_ACHIEVE"
    );
    */
        /* comment end for 25 Apr 2019*/
        /*
    "NEW_IRRIGATION_POTENTIAL_KHARIF","NEW_IRRIGATION_POTENTIAL_KHARIF_ACHIEVE","NEW_IRRIGATION_POTENTIAL_RABI","NEW_IRRIGATION_POTENTIAL_RABI_ACHIEVE","NEW_IRRIGATION_POTENTIAL_TOTAL","NEW_IRRIGATION_POTENTIAL_TOTAL_ACHIEVE",
        "IRRIGATION_POTENTIAL_RESTORED_KHARIF","IRRIGATION_POTENTIAL_RESTORED_KHARIF_ACHIEVE","IRRIGATION_POTENTIAL_RESTORED_RABI","IRRIGATION_POTENTIAL_RESTORED_RABI_ACHIEVE","IRRIGATION_POTENTIAL_RESTORED_TOTAL","IRRIGATION_POTENTIAL_RESTORED_TOTAL_ACHIEVE"
        */
        //$('#'+requiredField1).prop('disabled', status);
        //if(status) $('#'+requiredField1).val('');
        var arrReadOnlyFields = new Array();
        if (mName == 'LA_NA') {
            var arrRulesFields = new Array(
                "LA_NO", "LA_HA", "LA_NO_ACHIEVE", "LA_HA_ACHIEVE",
                "LA_COMPLETED_HA_ACHIEVE", "LA_COMPLETED_NO_ACHIEVE"
            );
            var arrDisableFields = new Array(
                "LA_HA", "LA_NO", "LA_HA_ACHIEVE", "LA_NO_ACHIEVE",
                "LA_COMPLETED_HA_ACHIEVE", "LA_COMPLETED_NO_ACHIEVE"
            );
            if (status) {
                //disable controls
                arrRulesFields = new Array();
            } else {
                if ($('#startInSession').val() == 1) {
                    //disable achieve controls
                    arrRulesFields = new Array("LA_HA", "LA_NO");
                    arrDisableFields = new Array("LA_HA_ACHIEVE", "LA_NO_ACHIEVE", "LA_COMPLETED_NO_ACHIEVE", "LA_COMPLETED_HA_ACHIEVE");//, "HIDTXT_LA_CASES_STATUS_ACHIEVE");
                } else {
                    //enable both controls
                    arrDisableFields = new Array();
                }
            }
        } else if (mName == 'FA_NA') {
            var arrRulesFields = new Array("FA_HA", "FA_HA_ACHIEVE", "FA_COMPLETED_HA_ACHIEVE");
            var arrDisableFields = new Array("FA_HA", "FA_HA_ACHIEVE", "FA_COMPLETED_HA_ACHIEVE");//, "HIDTXT_FA_CASES_STATUS_ACHIEVE");
            if (status) {
                //disable controls
                arrRulesFields = new Array();
            } else {
                if ($('#startInSession').val() == 1) {
                    //disable achieve controls
                    arrRulesFields = new Array('FA_HA');
                    arrDisableFields = new Array('FA_HA_ACHIEVE', 'FA_COMPLETED_HA_ACHIEVE');
                } else {
                    //enable both controls
                    arrDisableFields = new Array();
                }
            }
        } else if (mName == 'HW_EARTHWORK_NA') {
            var arrRulesFields = new Array("HW_EARTHWORK", "HW_EARTHWORK_ACHIEVE");
            var arrDisableFields = new Array("HW_EARTHWORK", "HW_EARTHWORK_ACHIEVE");
            if (status) {
                //disable controls
                arrRulesFields = new Array();
            } else {
                if ($('#startInSession').val() == 1) {
                    //disable achieve controls
                    arrRulesFields = new Array('HW_EARTHWORK');
                    arrDisableFields = new Array("HW_EARTHWORK_ACHIEVE");
                } else {
                    //enable both controls
                    arrDisableFields = new Array();
                }
            }
        } else if (mName == 'HW_MASONRY_NA') {
            var arrRulesFields = new Array("HW_MASONRY", "HW_MASONRY_ACHIEVE");
            var arrDisableFields = new Array("HW_MASONRY", "HW_MASONRY_ACHIEVE");
            if (status) {
                //disable controls
                arrRulesFields = new Array();
            } else {
                if ($('#startInSession').val() == 1) {
                    //disable achieve controls
                    arrRulesFields = new Array('HW_MASONRY');
                    arrDisableFields = new Array("HW_MASONRY_ACHIEVE");
                } else {
                    //enable both controls
                    arrDisableFields = new Array();
                }
            }
        } else if (mName == 'STEEL_WORK_NA') {
            var arrRulesFields = new Array("STEEL_WORK", "STEEL_WORK_ACHIEVE");
            var arrDisableFields = new Array("STEEL_WORK", "STEEL_WORK_ACHIEVE");
            if (status) {
                //disable controls
                arrRulesFields = new Array();
            } else {
                if ($('#startInSession').val() == 1) {
                    //disable achieve controls
                    arrRulesFields = new Array('STEEL_WORK');
                    arrDisableFields = new Array("STEEL_WORK_ACHIEVE");
                } else {
                    //enable both controls
                    arrDisableFields = new Array();
                }
            }
        } else if (mName == 'CANAL_EARTHWORK_NA') {
            var arrRulesFields = new Array("CANAL_EARTHWORK", "CANAL_EARTHWORK_ACHIEVE");
            var arrDisableFields = new Array("CANAL_EARTHWORK", "CANAL_EARTHWORK_ACHIEVE");
            if (status) {
                //disable controls
                arrRulesFields = new Array();
            } else {
                if ($('#startInSession').val() == 1) {
                    //disable achieve controls
                    arrRulesFields = new Array('CANAL_EARTHWORK');
                    arrDisableFields = new Array('CANAL_EARTHWORK_ACHIEVE');
                } else {
                    //enable both controls
                    arrDisableFields = new Array();
                }
            }
        } else if (mName == 'CANAL_STRUCTURE_NA') {
            var arrRulesFields = new Array("CANAL_STRUCTURE", "CANAL_STRUCTURE_ACHIEVE");
            var arrDisableFields = new Array("CANAL_STRUCTURE", "CANAL_STRUCTURE_ACHIEVE");
            if (status) {
                //disable controls
                arrRulesFields = new Array();
            } else {
                if ($('#startInSession').val() == 1) {
                    //disable achieve controls
                    arrRulesFields = new Array('CANAL_STRUCTURE');
                    arrDisableFields = new Array('CANAL_STRUCTURE_ACHIEVE');
                } else {
                    //enable both controls
                    arrDisableFields = new Array();
                }
            }
        } else if (mName == 'CANAL_STRUCTURE_MASONRY_NA') {
            var arrRulesFields = new Array("CANAL_STRUCTURE_MASONRY", "CANAL_STRUCTURE_MASONRY_ACHIEVE");
            var arrDisableFields = new Array("CANAL_STRUCTURE_MASONRY", "CANAL_STRUCTURE_MASONRY_ACHIEVE");
            if (status) {
                //disable controls
                arrRulesFields = new Array();
            } else {
                if ($('#startInSession').val() == 1) {
                    //disable achieve controls
                    arrRulesFields = new Array('CANAL_STRUCTURE_MASONRY');
                    arrDisableFields = new Array("CANAL_STRUCTURE_MASONRY_ACHIEVE");
                } else {
                    //enable both controls
                    arrDisableFields = new Array();
                }
            }
        } else if (mName == 'CANAL_LINING_NA') {
            var arrRulesFields = new Array("CANAL_LINING", "CANAL_LINING_ACHIEVE");
            var arrDisableFields = new Array("CANAL_LINING", "CANAL_LINING_ACHIEVE");
            if (status) {
                //disable controls
                arrRulesFields = new Array();
            } else {
                if ($('#startInSession').val() == 1) {
                    //disable achieve controls
                    arrRulesFields = new Array('CANAL_LINING');
                    arrDisableFields = new Array("CANAL_LINING_ACHIEVE");
                } else {
                    //enable both controls
                    arrDisableFields = new Array();
                }
            }
        } else if (mName == 'NEW_IRRIGATION_POTENTIAL_NA') {
            arrRulesFields = new Array();
            arrDisableFields = new Array();
            $('.trbip').each(function (i, obj) {
                //test
                var id = this.id;
                var val = id.split("-");
                arrRulesFields.push("BLOCK_EIP_K_" + val[2]);
                arrRulesFields.push("BLOCK_EIP_R_" + val[2]);
                arrRulesFields.push("BLOCK_AIP_R_" + val[2]);
                arrRulesFields.push("BLOCK_AIP_K_" + val[2]);

                arrDisableFields.push("BLOCK_EIP_K_" + val[2]);
                arrDisableFields.push("BLOCK_EIP_R_" + val[2]);
                arrDisableFields.push("BLOCK_AIP_R_" + val[2]);
                arrDisableFields.push("BLOCK_AIP_K_" + val[2]);
            });

            if (status) {
                arrRulesFields = new Array();
                $('.trbip').each(function (i, obj) {
                    //test
                    var id = this.id;
                    var val = id.split("-");
                    $("#BLOCK_EIP_K_" + val[2]).attr("disabled", "disabled");
                    $("#BLOCK_EIP_R_" + val[2]).attr("disabled", "disabled");
                    $("#BLOCK_AIP_R_" + val[2]).attr("disabled", "disabled");
                    $("#BLOCK_AIP_K_" + val[2]).attr("disabled", "disabled");
                });
            } else {
                arrRulesFields = new Array();
                $('.trbip').each(function (i, obj) {
                    //test
                    var id = this.id;
                    var val = id.split("-");
                    $("#BLOCK_EIP_K_" + val[2]).removeAttr("disabled");
                    $("#BLOCK_EIP_R_" + val[2]).removeAttr("disabled");
                    arrRulesFields.push("BLOCK_EIP_K_" + val[2]);
                    arrRulesFields.push("BLOCK_EIP_R_" + val[2]);
                    if ($('#startInSession').val() == 1) {
                        arrDisableFields = new Array();
                        $("#BLOCK_AIP_R_" + val[2]).attr("disabled", "disabled");
                        $("#BLOCK_AIP_K_" + val[2]).attr("disabled", "disabled");
                        arrDisableFields.push("BLOCK_AIP_R_" + val[2]);
                        arrDisableFields.push("BLOCK_AIP_K_" + val[2]);
                    }
                    else {
                        arrDisableFields = new Array();
                        $("#BLOCK_AIP_R_" + val[2]).removeAttr("disabled");
                        $("#BLOCK_AIP_K_" + val[2]).removeAttr("disabled");
                    }
                });
            }

        } else if (mName == 'IRRIGATION_POTENTIAL_TO_BE_RESTORED_NA') {

            arrRulesFields = new Array();
            arrDisableFields = new Array();
            $('.trRestored').each(function (i, obj) {
                //test
                var id = this.id;
                var val = id.split("-");

                arrRulesFields.push("BLOCK_ERIP_K_" + val[3]);
                arrRulesFields.push("BLOCK_ERIP_R_" + val[3]);
                arrRulesFields.push("BLOCK_ARIP_R_" + val[3]);
                arrRulesFields.push("BLOCK_ARIP_K_" + val[3]);

                arrDisableFields.push("BLOCK_ERIP_K_" + val[3]);
                arrDisableFields.push("BLOCK_ERIP_R_" + val[3]);
                arrDisableFields.push("BLOCK_ARIP_R_" + val[3]);
                arrDisableFields.push("BLOCK_ARIP_K_" + val[3]);
            });

            if (status) {
                arrRulesFields = new Array();
                $('.trRestored').each(function (i, obj) {
                    var id = this.id;
                    var val = id.split("-");
                    $("#BLOCK_ERIP_K_" + val[3]).attr("disabled", "disabled");
                    $("#BLOCK_ERIP_R_" + val[3]).attr("disabled", "disabled");
                    if ($('#startInSession').val() == 1) {
                        $("#BLOCK_ARIP_R_" + val[3]).attr("disabled", "disabled");
                        $("#BLOCK_ARIP_K_" + val[3]).attr("disabled", "disabled");
                    }
                });
            } else {

                arrRulesFields = new Array();
                $('.trRestored').each(function (i, obj) {
                    var id = this.id;
                    var val = id.split("-");
                    $("#BLOCK_ERIP_K_" + val[3]).removeAttr("disabled");
                    $("#BLOCK_ERIP_R_" + val[3]).removeAttr("disabled");
                    arrRulesFields.push("BLOCK_ERIP_K_" + val[3]);
                    arrRulesFields.push("BLOCK_ERIP_R_" + val[3]);

                    if ($('#startInSession').val() == 1) {

                        arrDisableFields = new Array();
                        $("#BLOCK_ARIP_R_" + val[3]).attr("disabled", "disabled");
                        $("#BLOCK_ARIP_K_" + val[3]).attr("disabled", "disabled");
                        arrDisableFields.push("BLOCK_ARIP_R_" + val[3]);
                        arrDisableFields.push("BLOCK_ARIP_K_" + val[3]);
                    }
                    else {
                        arrDisableFields = new Array();
                        $("#BLOCK_ARIP_R_" + val[3]).removeAttr("disabled");
                        //  $("#BLOCK_AIP_R_"+val[2]).val(0);
                        $("#BLOCK_ARIP_K_" + val[3]).removeAttr("disabled");
                        // $("#BLOCK_AIP_K_"+val[2]).val(0);
                    }
                });
            }

        }


        for (i = 0; i < arrRulesFields.length; i++) {
            ctrlName = '#' + arrRulesFields[i];
            $(ctrlName).prop('disabled', false);
            $('#req_' + arrRulesFields[i]).show();
        }

        for (i = 0; i < arrDisableFields.length; i++) {
            //$('#divCheckCode').append(arrDisableFields[i]+'<br />');
            ctrlName = '#' + arrDisableFields[i];
            //alert('disable : ' + ctrlName );
            var rul = false;
            try {
                var rul = $(ctrlName).rules("remove");
            } catch (err) {

            }
            if (rul) {
                $(ctrlName).rules("remove");
            }
            //$(ctrlName).rules("remove");
            $(ctrlName).val('');
            $(ctrlName).prop('disabled', true);
            $('#req_' + arrDisableFields[i]).hide();
        }
        for (i = 0; i < arrReadOnlyFields.length; i++) {
            ctrlName = '#' + arrReadOnlyFields[i];
            $(ctrlName).prop('disabled', false);
            $(ctrlName).prop('readonly', true);
        }

        for (i = 0; i < arrRulesFields.length; i++) {
            ctrlName = '#' + arrRulesFields[i];
            //alert(status);
            if (status) {
                //alert(i + ' : ' +arrRulesFields[i]);
                //$(ctrlName).rules("remove");
            } else {
                startPositionOfAchieve = arrRulesFields[i].length - 8;
                var rightText = arrRulesFields[i].substr(startPositionOfAchieve);
                //alert(arrRulesFields[i] + " : " + rightText);
                if (rightText == '_ACHIEVE') {
                    if (jQuery.inArray(arrRulesFields[i], arrIntFields) != -1) {
                        $(ctrlName).rules("add", {
                            required: true,
                            min: 0,
                            myLess1: '',
                            digits: true,
                            messages: {required: "Required."}
                        });
                    } else {
                        //alert(arrRulesFields[i]);
                        $(ctrlName).rules("add", {
                            required: true,
                            min: 0,
                            myLess1: '',
                            number: true,
                            messages: {required: "Required."}
                        });
                    }
                } else {
                    if (jQuery.inArray(arrRulesFields[i], arrIntFields) != -1) {
                        $(ctrlName).rules("add", {
                            required: true,
                            minStrict: 0,
                            digits: true,
                            messages: {
                                required: "Required.",
                                minStrict: "Minimum value should be greater than 0"
                            }
                        });
                        //alert(arrRulesFields[i]);
                    } else {
                        //  console.log('arrRulesFields[i]:'+arrRulesFields[i]);
                        try {
                            //alert(arrRulesFields[i]);
                            $(ctrlName).rules("add", {
                                required: true,
                                minStrict: 0,
                                number: true,
                                messages: {
                                    required: "Required.",
                                    minStrict: "Minimum value should be greater than 0"
                                }
                            });
                        } catch (err) {
                            alert(arrRulesFields[i] + " " + err.message);
                        }
                    }
                }
            }
        }

        var arrFields = new Array(
            "LA_CASES_STATUS", "SPILLWAY_WEIR_STATUS", "FLANKS_AF_BUNDS_STATUS", "SLUICE_STATUS", "NALLA_CLOSER_STATUS", "CANAL_EW_STATUS", "CANAL_STRUCTURE_STATUS", "CANAL_LINING_STATUS"
        );

        if (mName == 'LA_NA') {
            enableDisableMilestoneFields("LA_CASES_STATUS", status);
        } else if (mName == 'CANAL_EARTHWORK_NA') {
            enableDisableMilestoneFields("CANAL_EW_STATUS", status);
        } else if (mName == 'CANAL_STRUCTURE_NA') {
            enableDisableMilestoneFields("CANAL_STRUCTURE_STATUS", status);
        } else if (mName == 'CANAL_LINING_NA') {
            enableDisableMilestoneFields('CANAL_LINING_STATUS', status);
        }
    }

    function enableDisableMilestoneFields(mName, status) {
        //status - disable control
        //  console.log('mmmmmmmmmmmmmmmmmmmmmmmmm'+mName + ' ---------- '+ status );
        if (mName != "") {
            var ctrlName = '#' + mName;
            if (status) {
                //$('#' + mName).trigger("updatecomplete");
            }
            $(ctrlName).prop("disabled", (status));
            //console.log('status ='+status);
            //$('#' + mName).select2("enable", (!status));
            //targetDate = mName.replace('_STATUS', '_TARGET_DATE');
            // console.log('mName:' + mName + ' status =' + status + ' target dt:'+targetDate);
            var arrControls = {
                'LA_CASES_STATUS': 'LA_DATE',
                'CANAL_EW_STATUS': 'CANAL_EW_DATE',
                'CANAL_STRUCTURE_STATUS': 'CANAL_STRUCTURE_DATE',
                'CANAL_LINING_STATUS': 'WATER_STORAGE_TANK_DATE',
            };
            targetDate = arrControls[mName];
            if (status) {
                if ($(ctrlName).length) {
                    //   console.log('kkkkkkkkk:' + mName + ' ---------- '+ status );
                    if (startInCurrentSession == 1) {
                        $(ctrlName).append("<option value='7'>Current Year AA</option>");
                    } else {
                        $(ctrlName + ' option[value=7]').remove();
                    }
                    $(ctrlName).append("<option value='1'>NA</option>");
                    $(ctrlName).select2("val", 1);
                    //}else
                    //$(ctrlName).select2("val", 1);
                    addHiddenField(mName, 1, 'x');
                    $(ctrlName).attr('disabled', 'disabled');
                    $(ctrlName).trigger("updatecomplete");
                    $('#' + targetDate).css("display", 'none');
                    //hiddenInput ='<input type="hidden" id="HIDTXT_'+mName+'_ACHIEVE" name="'+mName+'" value="1" />';
                    //$(ctrlName).after(hiddenInput);

                }
                /* if($('#'+targetDate).css('display')=='none'){
                //
            }else{
                $('#'+targetDate).css("display", 'none');
            }*/
            } else {
                if ($(ctrlName).length) {
                    //ctrl exists
                    var valOfCombo = $(ctrlName).select2("val");
                }
                //var pSessionId= $('#SESSION_ID').val();
                //var aaSessionId =$('#AA_SESSION_ID').val();
                if (startInCurrentSession == 1) {
                    //if(pSessionId == aaSessionId){
                    $(ctrlName).select2("val", "7");
                    $(ctrlName).attr('disabled', 'disabled');
                    addHiddenField(mName, 7, 'd');
                    //hiddenInput ='<input type="hidden" id="HIDTXT_'+mName+'_ACHIEVE" name="'+mName+'" value="7" />';
                    //$(ctrlName).after(hiddenInput);
                    $(mName).trigger("updatecomplete");
                    $(ctrlName).trigger("updatecomplete");

                } else {
                    $(ctrlName).select2("val", "0");
                    $(ctrlName).removeAttr('disabled');
                    $('#HIDTXT_' + mName).remove();
                    $(ctrlName + ' option[value=1]').remove();
                    $(ctrlName + ' option[value=7]').remove();
                    $(ctrlName).trigger("updatecomplete");
                }
                if (valOfCombo == 5) {
                    //completed
                    $('#' + targetDate).css("display", 'none');
                } else {
                    $('#' + targetDate).css("display", 'block');
                }
            }
        }
    }

    //
    function getBlockHW(dist_id) {
        setLoadingStatus(true, 'BLOCK_ID');
        $.ajax({
            type: "POST",
            url: "getBlockOptionsByDistrict",
            data: {'dist_id': dist_id},
            success: function (msg) {
                $("#BLOCK_ID").html(msg);
                $("#BLOCK_ID").trigger("updatecomplete");
                $("#BLOCK_ID").select2("val", "");
                setLoadingStatus(false, 'BLOCK_ID');
            }
        });
    }

    //
    function getTehsilHW(dist_id) {
        setLoadingStatus(true, 'TEHSIL_ID');
        $.ajax({
            type: "POST",
            url: "getTehsilOptionsByDistrict",
            data: {'dist_id': dist_id},
            success: function (msg) {
                $("#TEHSIL_ID").html(msg);
                $("#TEHSIL_ID").trigger("updatecomplete");
                $("#TEHSIL_ID").select2("val", "");
                setLoadingStatus(false, 'TEHSIL_ID');
            }
        });
    }

    //
    function getVillages(dist_id) {
        setLoadingStatus(true, 'VILLAGES_BENEFITED');
        if (isNull(dist_id)) {
            $("#VILLAGES_BENEFITED").html('');
            $("#VILLAGES_BENEFITED").trigger("updatecomplete");
            $("#VILLAGES_BENEFITED").select2("val", "");
            getCountVillages();
            setLoadingStatus(false, 'VILLAGES_BENEFITED');
        } else {
            $.ajax({
                type: "POST",
                url: "getVillagesByDistrict",
                data: {'DISTRICT_ID': dist_id, PARENT_PROJECT_ID: $("#PARENT_PROJECT_ID").val()},
                success: function (msg) {
                    $("#VILLAGES_BENEFITED").html(msg);
                    $("#VILLAGES_BENEFITED").trigger("updatecomplete");
                    setLoadingStatus(false, 'VILLAGES_BENEFITED');
                }
            });
        }
    }

    function doSessionChange() {
        var arrYear = '';
        <?php if($monthlyRecordExists){?>
        arrYear = "<?php echo $SESSION_OPTIONS;?>".split(' - ');
        <?php }else{?>
        arrYear = $("#SESSION_ID :selected").text().split(' - ');
        <?php }?>
        if (arrYear[0] == 2013 && arrYear[1] == 2014) {
            $("#sessionMinDate").val("<?php echo myDateFormat($projectSetupValues['AA_DATE']);?>");
            $("#sessionMaxDate").val(getMaxDate(arrYear[1]));
        } else {
            $("#sessionMinDate").val("<?php echo myDateFormat($projectSetupValues['AA_DATE']);?>");
            //$("#sessionMinDate").val(getMinDate(arrYear[0]));
            $("#sessionMaxDate").val(getMaxDate(arrYear[1]));
        }
    }

    function getMaxDate(mYear) {
        return '31-03-' + mYear;
    }

    function getMinDate(mYear) {
        return '01-04-' + mYear;
    }

    function checkAchievementReady1() {
        var sdate = $('#AA_DATE').val();
        var arrDate = sdate.split("-");
        var month = parseInt(arrDate[1]);
        if (month >= 1 && month <= 3) {
            sYear = parseInt(arrDate[1]) - 1;
            eYear = parseInt(arrDate[1]);
        } else {
            sYear = parseInt(arrDate[1]);
            eYear = parseInt(arrDate[1]) + 1;
        }
        //alert('sdate :' + sdate + 'sYear :' + sYear + 'eYear :'+ eYear );
        if ((sYear == 0) || (eYear == 0)) {
            disableAchievement(true);
        } else {
            setAchievement(sdate, sYear, eYear);
        }
    }

    function checkAchievementReady() {
        var sdate = "<?php echo myDateFormat($projectSetupValues['AA_DATE']);?>";
        var sYear = <?php echo $SESSION_START_YEAR;?>;
        var eYear = <?php echo $SESSION_END_YEAR;?>;
        //alert('sdate :' + sdate + 'sYear :' + sYear + 'eYear :'+ eYear );
        if ((sYear == 0) || (eYear == 0)) {
            disableAchievement(true);
        } else {
            setAchievement(sdate, sYear, eYear);
        }
    }

    function checkAchievement() {
        //sdate = $('#PROJECT_START_DATE').val();
        sdate = $('#AA_DATE').val();
        var mSession = '';
        <?php if($monthlyRecordExists){?>
        mSession = new String("<?php echo $SESSION_OPTIONS;?>");
        <?php }else{?>
        mSession = new String($("#SESSION_ID :selected").text());
        <?php }?>
        var arrYear = mSession.split(' - ');
        if ((mSession == "") || (sdate == "")) {
            disableAchievement(true);
            return;
        }
        setAchievement(sdate, arrYear[0], arrYear[1]);
    }

    function setAchievement(sdate, sYear, eYear) {
        var minDate = getMinDate(sYear);
        var maxDate = getMaxDate(eYear);
        //compare with
        var dc1 = dateCompare(sdate, minDate);
        var dc2 = dateCompare(sdate, maxDate);
        $('#startInSession').val(0);

        if (((dc1 >= 0) && (dc2 <= 0)) || (dc2 > 0)) {
            $('#startInSession').val(1);

            //start in selected session
            //disable achievements (no achievement)
            disableAchievement(true);
        } else {

            disableAchievement(false);
        }
    }

    function disableAchievement(status) {
        //alert('disableAchievement called'+status);
        var isSetupInCurrentSession = $('#startInSession').val();
        var arrAC = new Array('<?php echo implode("', '", $arrAchievementCompo);?>');
        var arrIntFields = new Array(
            "LA_NO", "LA_NO_ACHIEVE", "LA_COMPLETED_NO_ACHIEVE"
        );
        var arrIntFields = new Array(
            "LA_NO", "LA_NO_ACHIEVE", "LA_COMPLETED_NO_ACHIEVE", "LA_COMPLETED_HA_ACHIEVE",
            "CANAL_STRUCTURE", "C_CANAL_STRUCTURE_ACHIEVE",
        );
        //alert(arrAC.join(","));
        //debugger;
        var chkna = '';
        //var arrX = new Array();
        //console.log(arrAC);
        //return;
        //console.log("Gurdeep");
        // console.log(arrBlockIds);
        //return;
        // Disable block achievement text box
        chkna = 'IP_NA';
        mystatus = false;
        if ($('#' + chkna).is(':checked')) {
            mystatus = true;
        }
        //alert('mystatus ='+mystatus);
        for (ii = 0; ii < window.arrBlockIds.length; ii++) {
            blockId = window.arrBlockIds[ii];
            if (mystatus) {
                $('#BLOCK_AIP_K_' + blockId).prop('disabled', true).val('');
                $('#BLOCK_AIP_R_' + blockId).prop('disabled', true).val('');
                $('#BLOCK_AIP_T_' + blockId).prop('disabled', true).val('');
                $('#req_BLOCK_ARIP_K_' + blockId).hide();
                $('#req_BLOCK_ARIP_R_' + blockId).hide();
                //$('#BLOCK_AIP_T_' + blockId).prop('disabled', true).val('');
            } else {
                $('#BLOCK_AIP_K_' + blockId).prop('disabled', mystatus);
                $('#BLOCK_AIP_R_' + blockId).prop('disabled', mystatus);
                $('#BLOCK_AIP_T_' + blockId).prop('disabled', mystatus);
                $('#req_BLOCK_ARIP_K_' + blockId).show();
                $('#req_BLOCK_ARIP_R_' + blockId).show();
            }
            //BLOCK_AIP_R_88
        }

        for (ii = 0; ii < window.arrRestoredBlockIds.length; ii++) {
            blockId = window.arrRestoredBlockIds[ii];
            if (mystatus) {
                $('#BLOCK_ARIP_K_' + blockId).prop('disabled', true).val('');
                $('#BLOCK_ARIP_R_' + blockId).prop('disabled', true).val('');
                $('#BLOCK_ARIP_T_' + blockId).prop('disabled', true).val('');
                $('#req_BLOCK_ARIP_K_' + blockId).hide();
                $('#req_BLOCK_ARIP_R_' + blockId).hide();
                //$('#BLOCK_AIP_T_' + blockId).prop('disabled', true).val('');
            } else {
                $('#BLOCK_ARIP_K_' + blockId).prop('disabled', mystatus);
                $('#BLOCK_ARIP_R_' + blockId).prop('disabled', mystatus);
                $('#BLOCK_ARIP_T_' + blockId).prop('disabled', mystatus);
                $('#req_BLOCK_ARIP_K_' + blockId).show();
                $('#req_BLOCK_ARIP_R_' + blockId).show();
            }
            //BLOCK_AIP_R_88
        }


        iu = 0;
        if (!mystatus) {
            if ($('#startInSession').val() == 1) {
                iu = 1;
                for (ii = 0; ii < window.arrBlockIds.length; ii++) {
                    blockId = window.arrBlockIds[ii];
                    $('#BLOCK_AIP_K_' + blockId).prop('disabled', true).val('');
                    $('#BLOCK_AIP_R_' + blockId).prop('disabled', true).val('');
                    $('#BLOCK_AIP_T_' + blockId).prop('disabled', true).val('');
                    $('#req_BLOCK_AIP_K_' + blockId).hide();
                    $('#req_BLOCK_AIP_R_' + blockId).hide();
                }
                for (ii = 0; ii < window.arrRestoredBlockIds.length; ii++) {
                    blockId = window.arrRestoredBlockIds[ii];
                    $('#BLOCK_ARIP_K_' + blockId).prop('disabled', true).val('');
                    $('#BLOCK_ARIP_R_' + blockId).prop('disabled', true).val('');
                    $('#BLOCK_ARIP_T_' + blockId).prop('disabled', true).val('');
                    $('#req_BLOCK_ARIP_K_' + blockId).hide();
                    $('#req_BLOCK_ARIP_R_' + blockId).hide();
                }
            }
        }

        if (iu == 0) {
            for (ii = 0; ii < window.arrBlockIds.length; ii++) {
                blockId = window.arrBlockIds[ii];
                $('#BLOCK_AIP_K_' + blockId).rules("add", {
                    required: true,
                    min: 0,
                    digits: true,
                    myLess: '',
                    messages: {required: "Required.", min: "Minimum value should be greater than 0"}
                });
                $('#BLOCK_AIP_R_' + blockId).rules("add", {
                    required: true,
                    min: 0,
                    digits: true,
                    myLess: '',
                    messages: {required: "Required.", min: "Minimum value should be greater than 0"}
                });
            }
            for (ii = 0; ii < window.arrRestoredBlockIds.length; ii++) {
                blockId = window.arrRestoredBlockIds[ii];
                $('#BLOCK_AIP_K_' + blockId).rules("add", {
                    required: true,
                    min: 0,
                    digits: true,
                    myLess: '',
                    messages: {required: "Required.", min: "Minimum value should be greater than 0"}
                });
                $('#BLOCK_AIP_R_' + blockId).rules("add", {
                    required: true,
                    min: 0,
                    digits: true,
                    myLess: '',
                    messages: {required: "Required.", min: "Minimum value should be greater than 0"}
                });

                $('#BLOCK_EIP_K_' + blockId).rules("add", {
                    required: true,
                    min: 0,
                    digits: true,
                    myLess: '',
                    messages: {required: "Required.", min: "Minimum value should be greater than 0"}
                });
                $('#BLOCK_EIP_R_' + blockId).rules("add", {
                    required: true,
                    min: 0,
                    digits: true,
                    myLess: '',
                    messages: {required: "Required.", min: "Minimum value should be greater than 0"}
                });
            }
        }

        for (i = 0; i < arrAC.length; i++) {
            //arrX.push(arrAC[i].substr(0, 3));
            if (arrAC[i].substr(0, 3) == "LA_") {
                chkna = 'LA_NA';
            } else if (arrAC[i].substr(0, 3) == "FA_") {
                chkna = 'FA_NA';
            } else {
                chkna = arrAC[i].replace("_ACHIEVE", "_NA");
            }
            //arrX.push(chkna);
            if ($('#' + chkna).is(':checked')) {
                //arrX.push(arrAC[i]);
                //alert(3 + ': ' + $('#'+chkna).is(':checked') + ' : ' + arrAC[i]);
                //isSetupInCurrentSession
                $('#req_' + arrAC[i]).hide();
                $('#' + arrAC[i]).prop('disabled', true).val('');
            } else {
                //alert(4);
                $('#' + arrAC[i]).prop('disabled', status);
                if (status) {
                    $('#req_' + arrAC[i]).hide();
                    $('#' + arrAC[i]).val('');
                } else {
                    //alert(arrAC[i]);
                    $('#req_' + arrAC[i]).show();
                    /////////////////////////
                    if (jQuery.inArray(arrAC[i], arrIntFields) != -1) {
                        $('#' + arrAC[i]).rules("add", {
                            required: true,
                            min: 0,
                            digits: true,
                            myLess1: "",
                            messages: {required: "Required.", min: "Minimum value should be greater than 0"}
                        });
                    } else {
                        //console.log(i);
                        try {
                            $('#' + arrAC[i]).rules("add", {
                                required: true,
                                min: 0,
                                number: true,
                                myLess1: "",
                                messages: {required: "Required.", min: "Minimum value should be greater than 0"}
                            });
                        }
                        catch (err) {
                            //document.getElementById("demo").innerHTML = err.message;
                            //alert(err.message + '-----'+i + ' = '+ arrAC[i]);
                        }
                    }
                    ///////////////////////////

                }
            }
            if (arrAC[i] == 'IP_TOTAL') {
                $('#' + arrAC[i]).prop('readonly', true);//.rules("remove");
                $('#' + arrAC[i] + '_ACHIEVE').prop('readonly', true);//.rules("remove");
            }
            if (status) $('#' + arrAC[i]).val('');
        }
        //if(status){
        changeEstimationFields(status);
        //}
        //alert(arrAC.join("\n"));
        //alert(arrX.join("\n"));
    }

    function addHiddenField(f, myvalue, mode) {
        var ctrlId = 'HIDTXT_' + f + '_ACHIEVE';
        if ($('#' + ctrlId).length === 0) {
            hiddenInput = '<input type="hidden" title="' + mode + '" id="' + ctrlId + '" name="' + f + '" value="' + myvalue + '" />';
            $("#" + f).after(hiddenInput);
        } else {
            $('#' + ctrlId).attr('title', mode);
            $('#' + ctrlId).val(myvalue);
        }
        $("#" + f).select2("val", myvalue);
        $('#' + f).trigger("updatecomplete");
        // console.log('Control: ' + ctrlId + ' f:' +f + ' myval:' + myvalue + ' mode:' + mode  );
    }

    function changeEstimationFields(status) {
        //  console.log('changeEstimationFields :: Status :' + status + ' initmode:' + window.initMode);
        var arrStatusFields = new Array(
            'LA_CASES_STATUS',
            'SPILLWAY_WEIR_STATUS',
            'FLANKS_AF_BUNDS_STATUS',
            'SLUICE_STATUS',
            'NALLA_CLOSER_STATUS',
            'CANAL_EW_STATUS',
            'CANAL_STRUCTURE_STATUS',
            'CANAL_LINING_STATUS'
        );
        var naFields = new Array(
            'LA_NA',
            '',
            '',
            '',
            '',
            'CANAL_EARTHWORK_NA',
            'CANAL_STRUCTURE_NA',
            'CANAL_LINING_NA',
        );
        startInCurrentSession = $('#startInSession').val();

        // console.log('startInCurrentSession :'+ startInCurrentSession );
        var myoptions = '<option value="0">Select</option><option value="1">NA</option><option value="2">Not Started</option>' +
            '<option value="3">Ongoing</option><option value="4">Stopped</option>' +
            '<option value="5">Completed</option>';
        var myoptions1 = '<option value="0">Select</option><option value="1">NA</option><option value="7">Current Year AA</option>';

        var hiddenInput = '';

        //status=1 i.e., disable achievement
        if (status) {

            for (var i = 0; i < naFields.length; i++) {
                if (window.initMode == 1) {
                    myOptions = window.defaultOptions[arrStatusFields[i]];
                    myOptions = (startInCurrentSession == 1) ? myoptions1 : myOptions;
                }
                if (naFields[i] == "") {

                } else if ($("#" + naFields[i]).is(":checked")) {
                    // console.log('NA:' + naFields[i]);
                    addHiddenField(arrStatusFields[i], 1, 's4');
                    if ($("#" + arrStatusFields[i]).prop('disabled')) {
                        //console.log('Disabled : '+arrStatusFields[s]);
                    } else {
                        if (startInCurrentSession == 1) {
                            $("#" + arrStatusFields[i]).attr('disabled', 'disabled');
                            $('#' + arrStatusFields[i]).trigger("updatecomplete");
                        } else {
                        }
                    }
                } else {
                    if (window.initMode == 1) {
                        $('#' + arrStatusFields[i]).html(myOptions);
                    }
                    if (startInCurrentSession == 1) {
                        addHiddenField(arrStatusFields[i], 7, 's2');
                        $('#' + arrStatusFields[i]).trigger("updatecomplete");
                        $("#" + arrStatusFields[i]).attr('disabled', 'disabled');
                    } else {
                        $('#HIDTXT_' + arrStatusFields[i] + '_ACHIEVE').remove();
                    }
                    $('#' + arrStatusFields[i]).trigger("updatecomplete");
                }
            }
        } else {

            for (var i = 0; i < arrStatusFields.length; i++) {
                updateIt = false;
                // console.log('naFields[s]:' + naFields[i]+ ' arrStatusFields[i]:'+arrStatusFields[i]);
                if (window.initMode == 1) {
                    myOptions = (startInCurrentSession == 1) ? myoptions1 : myoptions;
                }
                if (naFields[i] == "") {
                    if (startInCurrentSession == 1) {
                        addHiddenField(arrStatusFields[i], 1, 'sa');
                        updateIt = true;
                    } else {
                    }
                    //  console.log('Ferti Options : '+myoptions);
                    if (window.initMode == 1) {
                        $('#FERTI_PESTI_CARRIER_SYSTEM_STATUS').html(myOptions);
                        updateIt = true;
                    }
                } else if ($("#" + naFields[i]).is(":checked")) {
                    $("#" + arrStatusFields[i]).select2("val", "1");
                    $("#" + arrStatusFields[i]).prop('disabled');
                    addHiddenField(arrStatusFields[i], 1, 'q');
                    updateIt = true;
                } else {
                    //   console.log(' opt:k::' + startInCurrentSession);///$("#"+arrStatusFields[s]+" option[value='7']").length);
                    if (startInCurrentSession == 1) {
                        //   console.log(' opt 7 :' + $("#"+arrStatusFields[i]+"option[value='7']").length);
                        addHiddenField(arrStatusFields[i], 7, 's');
                        updateIt = true;
                    } else {
                        // console.log(' opt ::8:: :' + $("#"+arrStatusFields[i]+" option[value='7']").length);
                        $('#HIDTXT_' + arrStatusFields[i] + '_ACHIEVE').remove();
                    }
                    if (window.initMode == 1) {
                        $("#" + arrStatusFields[i]).html(myOptions);
                        $("#" + arrStatusFields[i]).select2("val", "0");
                        updateIt = true;
                    }
                    $("#" + arrStatusFields[i] + " option[value='1']").remove();
                    $("#" + arrStatusFields[i]).removeAttr('disabled');
                }
                if (updateIt == true)
                    $('#' + arrStatusFields[i]).trigger("updatecomplete");
                if (window.initMode == 0) {
                    if (startInCurrentSession == 1) {
                    } else {
                        $("#" + arrStatusFields[i] + " option[value='7']").remove();
                    }
                }
            }//for
        }
        // control

    }

    function setRules() {
        <?php
        $arrComp = array();
        if ($arrSetupStatus['LA_NA'] == 0) {
            array_push($arrComp, '#LA_NO');
            array_push($arrComp, '#LA_HA');
            /*array_push($arrComp, '#LA_COMPLETED_NO');
        array_push($arrComp, '#LA_COMPLETED_HA');*/
        }
        if ($arrSetupStatus['FA_NA'] == 0) {
            array_push($arrComp, '#FA_HA');
            //     array_push($arrComp, '#FA_COMPLETED_HA');
        }

        if ($arrSetupStatus['HW_EARTHWORK_NA'] == 0) array_push($arrComp, '#HW_EARTHWORK');
        if ($arrSetupStatus['HW_MASONRY_NA'] == 0) array_push($arrComp, '#HW_MASONRY');
        if ($arrSetupStatus['STEEL_WORK_NA'] == 0) array_push($arrComp, '#STEEL_WORK');
        if ($arrSetupStatus['CANAL_EARTHWORK_NA'] == 0) array_push($arrComp, '#CANAL_EARTHWORK');
        if ($arrSetupStatus['CANAL_STRUCTURE_NA'] == 0) array_push($arrComp, '#CANAL_STRUCTURE');
        if ($arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA'] == 0) array_push($arrComp, '#CANAL_STRUCTURE_MASONRY');
        if ($arrSetupStatus['CANAL_LINING_NA'] == 0) array_push($arrComp, '#CANAL_LINING');

        /*    if($arrSetupStatus['NEW_IRRIGATION_POTENTIAL_NA']==0){
        array_push($arrComp, '#NEW_IRRIGATION_POTENTIAL_KHARIF');
        array_push($arrComp, '#NEW_IRRIGATION_POTENTIAL_RABI');
        array_push($arrComp, '#NEW_IRRIGATION_POTENTIAL_TOTAL');
    }

     if($arrSetupStatus['IRRIGATION_POTENTIAL_TO_BE_RESTORED_NA']==0){
        array_push($arrComp, '#IRRIGATION_POTENTIAL_RESTORED_KHARIF');
        array_push($arrComp, '#IRRIGATION_POTENTIAL_RESTORED_RABI');
        array_push($arrComp, '#IRRIGATION_POTENTIAL_RESTORED_TOTAL');
    }*/



        $naFields = array();
        foreach ($naFields as $f) {
            if ($arrSetupStatus[$f] == 0)
                array_push($arrComp, '#' . str_replace('_NA', '', $f));
        }
        /*if($arrComp){
        $x = implode(',', $arrComp);
        ?>
        console.log('::::'+'<?php echo $x;?>');
        $("<?php echo $x;?>").rules( "add", {required: true, minStrict: 0,
            messages: { required: "Required.", minStrict: "Minimum value should be greater than 0"}
        });
    <?php }*///if count
        if($arrComp){
        foreach($arrComp as $c){?>
        $("<?php echo $c;?>").rules("add", {
            required: true, minStrict: 0,
            messages: {required: "Required.", minStrict: "Minimum value should be greater than 0"}
        });
        <?php }//foreach
        }//if count?>
    }

    function checkTotalExp() {
        var aaAmount = checkNo($('#AA_AMOUNT').val());
        var raaAmount = checkNo($('#RAA_AMOUNT').val());
        var amountToCheck = ((raaAmount > 0) ? raaAmount : aaAmount);
        var expAmount = checkNo($('#EXPENDITURE_TOTAL').val());
        if (expAmount > amountToCheck) {
            $("#EXPENDITURE_TOTAL").rules("add", {
                required: true,
                max: amountToCheck,
                messages: {
                    required: "Required.",
                    max: "More than AA/RAA Amount: Rs." + amountToCheck
                }
            });
        }
    }

    //
    function showBenefitedBlocks(ids) {
        setLoadingStatus(true, 'BLOCKS_BENEFITED');
        var BLOCKS_BENEFITED = $("#BLOCKS_BENEFITED").select2('val');

        if (isNull(ids)) {
            $('#BLOCKS_BENEFITED').html('');
            $('#BLOCKS_BENEFITED').trigger("updatecomplete");
            setLoadingStatus(false, 'BLOCKS_BENEFITED');
            $("#BLOCKS_BENEFITED").select2("val", "");
        } else {
            $.ajax({
                type: "POST",
                url: 'getBlockBenefitedList',
                data: {'project_id': $('#PROJECT_SETUP_ID').val(), 'dist_id': ids, 'block_id': BLOCKS_BENEFITED},
                success: function (data) {
                    $('#BLOCKS_BENEFITED').html(data);
                    $('#BLOCKS_BENEFITED').trigger("updatecomplete");
                    setLoadingStatus(false, 'BLOCKS_BENEFITED');
                }
            });
        }
    }


    function showBenefitedAssembly(ids) {
        setLoadingStatus(true, 'ASSEMBLY_BENEFITED');
        //alert(ids);
        if (isNull(ids)) {
            $('#ASSEMBLY_BENEFITED').html('');
            $('#ASSEMBLY_BENEFITED').trigger("updatecomplete");
            $("#ASSEMBLY_BENEFITED").select2("val", "");
            setLoadingStatus(false, 'ASSEMBLY_BENEFITED');
        } else {
            $.ajax({
                type: "POST",
                url: 'getAssemblyBenefitedList',
                data: {'project_id': $('#PROJECT_SETUP_ID').val(), 'assembly_id': ids},
                success: function (data) {
                    $("#ASSEMBLY_BENEFITED").select2("val", "");
                    //$('#ASSEMBLY_BENEFITED').html('');
                    $('#ASSEMBLY_BENEFITED').trigger("updatecomplete");
                    $('#ASSEMBLY_BENEFITED').html(data);
                    $('#ASSEMBLY_BENEFITED').trigger("updatecomplete");
                    setLoadingStatus(false, 'ASSEMBLY_BENEFITED');
                }
            });
        }
    }

    /***/
    function getIrriTotal(mode) {
        var suffix = ((mode == 1) ? '_ACHIEVE' : '');
        var kh = checkNo($('#KHARIF' + suffix).val());
        var ra = checkNo($('#RABI' + suffix).val());
        var t = kh + ra;
        $('#IP_TOTAL' + suffix).val(t);
    }

    /***/
    function lockProject() {
        var conf = confirm("Do you want to Lock the Project Setup Record?");
        if (conf) {
            var params = {
                'divid': 'mySaveDiv',
                'url': 'lockProject',
                'data': {
                    'project_setup_id':<?php echo $projectSetupId;?>,
                    'PARENT_PROJECT_ID': $("#PARENT_PROJECT_ID").val()
                },
                'donefname': 'doneLockProject',
                'failfname': '',
                'alwaysfname': 'none'
            };
            callMyAjax(params);
        }
    }

    function showNewRow(blockId, blockName) {
        var dis = "", adis = '';
        //window.ipNa = $('#IP_NA').is(':checked');
        //alert(window.ipNa);
        /*if(window.ipNa){
        dis='disabled="disabled"';
    }else{
        if( ($('#startInSession').val()==1) || (window.ipNa)) adis='disabled="disabled"';
    }*/
        var totalRows = $('.trbip').length;
        var rowNo = String.fromCharCode(totalRows + 97);

        var startInSession = $('#startInSession').val();
        var adis = (startInSession) ? 'disabled="disabled"' : '';
        var aRequired = (startInSession) ? '' : '<?php echo getRequiredSign('left');?>';
        var cont = '<tr id="tr-bk-' + blockId + '" class="trb-' + blockId + ' trbip">' +
            '<td class="ui-widget-content" rowspan="3" align="center" >' + rowNo + '</td>' +
            '<td class="ui-widget-content" rowspan="3" colspan="5"><strong>' + blockName + '</strong></td>' +
            '<td class="ui-widget-content" align="center"><?php echo getRequiredSign('left');?>' +
            '<input name="BLOCK_EIP_K[' + blockId + ']" id="BLOCK_EIP_K_' + blockId + '" type="text" size="12" maxlength="12" ' +
            ' class="centertext" onkeyup="getIrriSubTotal(0, 0, ' + blockId + ')" value="" ' + dis + '/>' +
            '</td>' +
            '<td colspan="2" class="ui-state-default" align="center"><strong>Kharif</strong></td>' +
            '<td class="ui-widget-content" align="center">' + aRequired +
            '<input name="BLOCK_AIP_K[' + blockId + ']" id="BLOCK_AIP_K_' + blockId + '" type="text"  size="12" maxlength="12" ' +
            'class="centertext" onkeyup="getIrriSubTotal(0, 1, ' + blockId + ')" value="" ' + adis + '/>' +
            '</td>' +
            '</tr>' +
            '<tr id="tr-br-' + blockId + '" class="trb-' + blockId + '">' +
            '<td class="ui-widget-content" align="center"><?php echo getRequiredSign('left');?>' +
            '<input name="BLOCK_EIP_R[' + blockId + ']" id="BLOCK_EIP_R_' + blockId + '" type="text" size="12" maxlength="12"' +
            ' class="centertext" onkeyup="getIrriSubTotal(1, 0, ' + blockId + ')" value="" ' + dis + '/>' +
            '</td>' +
            '<td class="ui-state-default" align="center" colspan="2"><strong>Rabi</strong></td>' +
            '<td class="ui-widget-content" align="center">' + aRequired +
            '<input name="BLOCK_AIP_R[' + blockId + ']" id="BLOCK_AIP_R_' + blockId + '" type="text"  size="12" maxlength="12" ' +
            'class="centertext" onkeyup="getIrriSubTotal(1, 1, ' + blockId + ')" value="" ' + adis + '/>' +
            '</td>' +
            '</tr>' +
            '<tr id="tr-bt-' + blockId + '" class="trb-' + blockId + '">' +
            '<td class="ui-state-default" align="center" id="BLOCK_EIP_T_' + blockId + '"></td>' +
            '<td class="ui-state-default" align="center" colspan="2"><strong>Total</strong></td>' +
            '<td class="ui-state-default" align="center" id="BLOCK_AIP_T_' + blockId + '">' + '</td>' +
            '</tr>';
        $('#tr-bk-total').before(cont);
        $('#BLOCK_EIP_K_' + blockId).rules("add", {
            required: true,
            min: 0,
            minStrict: 0,
            digits: true,
            messages: {required: "Required.", min: "Minimum value should be greater than 0"}
        });
        $('#BLOCK_EIP_R_' + blockId).rules("add", {
            required: true,
            min: 0,
            digits: true,
            myLess: '',
            messages: {required: "Required.", min: "Minimum value should be 0"}
        });
        if (startInSession == 0) {
            $('#BLOCK_AIP_K_' + blockId).rules("add", {
                required: true,
                min: 0,
                digits: true,
                myLess: '',
                messages: {required: "Required.", min: "Minimum value should be 0"}
            });
            $('#BLOCK_AIP_R_' + blockId).rules("add", {
                required: true,
                min: 0,
                digits: true,
                myLess: '',
                messages: {required: "Required.", min: "Minimum value should be 0"}
            });
        }
        checkAchievementReady();
    }

    function checkAchievementReady() {
        var sdate = "<?php echo myDateFormat($projectSetupValues['AA_DATE']);?>";
        var sYear = <?php echo $SESSION_START_YEAR;?>;
        var eYear = <?php echo $SESSION_END_YEAR;?>;
        //alert('sdate :' + sdate + 'sYear :' + sYear + 'eYear :'+ eYear );
        if ((sYear == 0) || (eYear == 0)) {
            disableAchievement(true);
        } else {
            setAchievement(sdate, sYear, eYear);
        }
    }

    function showBlockIP(id, name) {

        window.arrIPBlockData.push(new clsIP(id, name, 0, 0, 0, 0, 0, 0));
        showNewRow(id, name);
    }

    function afterDelete() {
        recalculateTotal("E");
        recalculateTotal("A");
    }

    function getRestoredIrriSubTotal(kharifOrRabi, EstiOrAchi, blockId) {
        var mode = (kharifOrRabi == 0) ? "K" : "R";
        var esti = (EstiOrAchi == 0) ? "E" : "A";
        var ke = checkNo($('#BLOCK_' + esti + 'RIP_K_' + blockId).val());
        var re = checkNo($('#BLOCK_' + esti + 'RIP_R_' + blockId).val());
        var te = ke + re;
        //alert('Lenght:' + window.arrBlockIds.length);
        $('#BLOCK_' + esti + 'RIP_T_' + blockId).html(te);
        //else add max rules
        recalculateRestoredTotal(esti);
    }

    function recalculateRestoredTotal(mode) {
        var kt = 0;
        var rt = 0;
        //alert(window.arrBlockIds.join("\n"));
        for (i = 0; i < window.arrRestoredBlockIds.length; i++) {
            blockid = window.arrRestoredBlockIds[i];
            kt += checkNo($('#BLOCK_' + mode + 'RIP_K_' + blockid).val());
            rt += checkNo($('#BLOCK_' + mode + 'RIP_R_' + blockid).val());
        }
        var tt = kt + rt;
        //  console.log('Kt: ' + kt  + ' rt:' + rt);
        //alert(window.arrBlockIds.join(','));
        if (mode == "A") {
            $('#IP_KHARIF_R_ACHIEVE').html(kt);
            $('#IP_RABI_R_ACHIEVE').html(rt);
            $('#IP_TOTAL_R_ACHIEVE').html(tt);
        } else {
            $('#IP_KHARIF_R').html(kt);
            $('#IP_RABI_R').html(rt);
            $('#IP_TOTAL_R').html(tt);
        }
    }

    function getIrriSubTotal(kharifOrRabi, EstiOrAchi, blockId) {
        var mode = (kharifOrRabi == 0) ? "K" : "R";
        var esti = (EstiOrAchi == 0) ? "E" : "A";

        var ke = checkNo($('#BLOCK_' + esti + 'IP_K_' + blockId).val());
        var re = checkNo($('#BLOCK_' + esti + 'IP_R_' + blockId).val());
        var te = ke + re;
        //alert('Lenght:' + window.arrBlockIds.length);
        $('#BLOCK_' + esti + 'IP_T_' + blockId).html(te);
        //else add max rules
        recalculateTotal(esti);
    }

    function recalculateTotal(mode) {
        var kt = 0;
        var rt = 0;
        //alert(window.arrBlockIds.join("\n"));
        for (i = 0; i < window.arrBlockIds.length; i++) {
            blockid = window.arrBlockIds[i];
            kt += checkNo($('#BLOCK_' + mode + 'IP_K_' + blockid).val());
            rt += checkNo($('#BLOCK_' + mode + 'IP_R_' + blockid).val());
        }
        var tt = kt + rt;
        //   console.log('Kt: ' + kt  + ' rt:' + rt);
        //alert(window.arrBlockIds.join(','));
        if (mode == "A") {
            $('#IP_KHARIF_T_ACHIEVE').html(kt);
            $('#IP_RABI_T_ACHIEVE').html(rt);
            $('#IP_TOTAL_T_ACHIEVE').html(tt);
        } else {
            $('#IP_KHARIF_T').html(kt);
            $('#IP_RABI_T').html(rt);
            $('#IP_TOTAL_T').html(tt);
        }
    }
    <?php } ?>
    function showAA(vv) {
        if (vv == 0) return;
        var params = {
            'divid': 'divAA',
            'url': 'showAAData',
            'data': {'id': vv},
            'donefname': 'doneAA',
            'failfname': 'none',
            'alwaysfname': 'none'
        };
        callMyAjax(params);
    }

    function doneAA(data) {
        var mydata = parseMyResponse(data);
        $('#AA_NO').val(mydata.AA_NO);

        $("#DEPOSIT_SCHEME_ID").select2("val", mydata.DEPOSIT_SCHEME_ID);
        $("#DEPOSIT_SCHEME_ID").trigger("updatecomplete");
        $('#AA_DATE').val(mydata.AA_DATE);
        $('#AA_AMOUNT').val(mydata.AA_AMOUNT);
        $("#AA_AUTHORITY_ID").select2("val", mydata.AA_AUTHORITY_ID);
        $("#AA_AUTHORITY_ID").trigger("updatecomplete");
        if (mydata.RAA_NO == 0)
            $('#RAA_NO').val(mydata.RAA_NO);
        $('#RAA_DATE').val(mydata.RAA_DATE);
        $('#RAA_AMOUNT').val(mydata.RAA_AMOUNT);
        $("#RAA_AUTHORITY_ID").select2("val", mydata.RAA_AUTHORITY_ID);
        $("#RAA_AUTHORITY_ID").trigger("updatecomplete");
        $("#AA_AUTHORITY_ID").prop("disabled", true);
        $("#RAA_AUTHORITY_ID").prop("disabled", true);
    }

    function doneLockProject(data) {

        if (data == 1) {
            //locked
            $("#modalBox").dialog('close');
            //alert('Project Locked...');
            showAlert('Project Locked', 'Project Locked.', 'tick');

        } else {
            //fail to lock
        }
        $("#projectList").trigger('reloadGrid');
        $("#depProjectList").trigger('reloadGrid');
        $("#depProjectCList").trigger('reloadGrid');
    }

    function testme() {
        var arrCondition = new Array("1", "2");
        //var vv = parseInt($('#test').val());
        var vv = $('#test').val();
        alert($('#test').val() + ' : ' + $.inArray(vv, arrCondition));
    }

    var globalFileMode = '';

    function removeFile(mode, projectId) {
        //mode1= AA , mode2=RAA
        globalFileMode = mode;
        var ans = confirm("Are you sure to delete this file ?");
        if (!ans)
            return;
        var params = {
            'divid': '',
            'url': 'removeAARAAFile',
            'data': {'PROJECT_SETUP_ID': projectId, 'mode': mode},
            'donefname': 'doneRemoveFile',
            'failfname': 'none',
            'alwaysfname': 'none'
        };
        callMyAjax(params);
    }

    function doneRemoveFile(data) {
        var mydata = parseAndShowMyResponse(data);
        if (globalFileMode == 1) {
            $('#msg_aa_file').html(mydata);
            $('#aa_button_div').hide();
            $('#aa_upload_div').show();
        } else {
            $('#msg_raa_file').html(mydata);
            $('#raa_button_div').hide();
            $('#raa_upload_div').show();
        }
    }

    function closeMap() {
        $('#div_map').hide('slow');
        $('#div_button_close').hide('slow');
    }


    function closePDF() {
        $('#div_pdf').hide('slow');
        $('#div_pdf_button_close').hide('slow');
    }

    function viewPDF(id, val) {
        if ($('#div_pdf').is(':visible')) {
            $('#div_pdf').hide();
            $('#div_pdf_button_close').hide();
            return;
        }
        var value = val.id;

        $('#div_pdf').show();
        $("#div_pdf").html('<iframe src="' + value + '" width="800px" height="600px" >');
        $('#div_pdf_button_close').show();
    }

    function viewOnMap() {
        if ($('#div_map').is(':visible')) {
            $('#div_map').hide();
            $('#div_button_close').hide();
            return;
        }
        var LONGITUDE_D = $('#LONGITUDE_D').val();
        var LONGITUDE_M = $('#LONGITUDE_M').val();
        var LONGITUDE_S = $('#LONGITUDE_S').val();

        var LATITUDE_D = $('#LATITUDE_D').val();
        var LATITUDE_M = $('#LATITUDE_M').val();
        var LATITUDE_S = $('#LATITUDE_S').val();
        if ((LONGITUDE_M == "") || (LONGITUDE_S == "") || (LATITUDE_M == "") || (LATITUDE_S == "")) {
            alert('Fill Latitude & Longitude');
            return;
        }
        //console.log()

        var latsign = 1.;
        var lonsign = 1.;
        var absdlat = 0;
        var absdlon = 0;
        var absmlat = 0;
        var absmlon = 0;
        var absslat = 0;
        var absslon = 0;

        if (compareNumber(LATITUDE_D, 0) == '-') {
            latsign = -1.;
        } else {
            latsign = 1.;
        }
        absdlat = Math.abs(Math.round(LATITUDE_D * 1000000.));

        LATITUDE_M = Math.abs(Math.round(LATITUDE_M * 1000000.) / 1000000);
        absmlat = Math.abs(Math.round(LATITUDE_M * 1000000.));

        LATITUDE_S = Math.abs(Math.round(LATITUDE_S * 1000000.) / 1000000);
        absslat = Math.abs(Math.round(LATITUDE_S * 1000000.));

        if (compareNumber(LONGITUDE_D, 0) == '-') {
            lonsign = -1.;
        } else {
            lonsign = 1.;
        }
        absdlon = Math.abs(Math.round(LONGITUDE_D * 1000000.));

        LONGITUDE_M = Math.abs(Math.round(LONGITUDE_M * 1000000.) / 1000000);
        absmlon = Math.abs(Math.round(LONGITUDE_M * 1000000));  //integer

        LONGITUDE_S = Math.abs(Math.round(LONGITUDE_S * 1000000.) / 1000000);
        absslon = Math.abs(Math.round(LONGITUDE_S * 1000000.));

        var alat = ((Math.round(absdlat + (absmlat / 60.) + (absslat / 3600.)) / 1000000)) * latsign;
        var alon = ((Math.round(absdlon + (absmlon / 60.) + (absslon / 3600)) / 1000000)) * lonsign;

        //var uluru = {lat: 21.148611, lng: 82.005556};
        var uluru = {lat: alat, lng: alon};

        $('#div_map').show();
        $('#div_button_close').show();

        var map = new google.maps.Map(document.getElementById('div_map'), {
            zoom: 16,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });

    }

    function compareNumber(a, b) {
        if (a < b) return '-';
        else if (a === b) return '=';
        else if (a > b) return '+';
        else return 'z';
    }

    //
    function allowHindi(e, elem) {
        var savedcontent = elem.value;

        if (e && e.clipboardData && e.clipboardData.getData) {// Webkit - get data from clipboard, put into editdiv, cleanup, then cancel event
            //console.log('types:'+e.clipboardData.types);
            var pastedValue = '';
            if (/text\/html/.test(e.clipboardData.types)) {
                pastedValue = e.clipboardData.getData('text/html');
            }
            else if (/text\/plain/.test(e.clipboardData.types)) {
                //console.log('plain:' +e.clipboardData.getData('text/plain'));
                pastedValue = e.clipboardData.getData('text/plain');
            }
            else if (/text/.test(e.clipboardData.types)) {
                pastedValue = e.clipboardData.getData('Text');
            }
            else {
                pastedValue = e.clipboardData.getData('Text');
            }
            //console.log('paste:' + pastedValue);
            waitforpastedata(elem, pastedValue, savedcontent, 1);
            if (e.preventDefault) {
                e.stopPropagation();
                e.preventDefault();
            }
            //console.log('kutte');
            return false;
        }
        else {// Everything else - empty editdiv and allow browser to paste content into it, then cleanup
            elem.value = "";
            //console.log('kamine');
            waitforpastedata(elem, '', savedcontent, 1);
            return true;
        }
    }

    function waitforpastedata(elem, pastedValue, savedcontent, mode) {
        processpaste(elem, pastedValue, savedcontent, mode);
        /*if (elem.childNodes && elem.childNodes.length > 0) {
        processpaste(elem, pastedValue, savedcontent, mode);
        console.log('kamine1');
    }
    else{
        that = {e: elem, p:pastedValue, s: savedcontent, m:mode}
        that.callself = function () {
            console.log('kamine2');
            waitforpastedata(that.e, that.p, that.s, this.m);
        }
        //that.callself;
        //setTimeout(that.callself, 1200);
    }*/
    }

    function processpaste(elem, pastedValue, savedcontent, mode) {
        pasteddata = pastedValue;//$(elem).val();// elem.innerHTML;
        //^^Alternatively loop through dom (elem.childNodes or elem.getElementsByTagName) here
        //var ss = "xxxx";
        txt = pasteddata;
        //txt = savedcontent ;//new String(savedcontent);
//  txt = pastedText.repalce("'", "",);
        txt = txt.replace(/'/g, '');
        txt = txt.replace(/"/g, '');
        txt = txt.replace(/\t/g, '');
        txt = txt.replace(/  +/g, ' ');
        txt = txt.replace(/  +/g, ' ');
        txt = txt.replace(/  +/g, ' ');
        txt = txt.replace(/  +/g, ' ');
        txt = txt.replace(/  +/g, ' ');
        if (mode == 0) {
            //english
            txt = txt.replace(/([\u0901-\u25CC])/g, '');
            txt = txt.replace("&amp;", "and");
            txt = txt.replace("&amp;", "and");
            txt = txt.replace("&amp;", "and");
            txt = txt.replace("&", "and");
        } else {
            //hindi
            txt = txt.replace(/([a-zA-Z])/g, '');
            txt = txt.replace("&amp;", "एवं");
            txt = txt.replace("&amp;", "एवं");
            txt = txt.replace("&amp;", "एवं");
            txt = txt.replace("&", "एवं");
        }
        pastedText = txt;
        //alert('savedcontent:' + savedcontent + ' pastedText:' + pastedText);
        //elem.innerHTML = savedcontent + pastedText;
        //console.log('kamine3:'+pastedText);
        //$(elem).val(savedcontent + pastedText);
        $('#WORK_NAME_HINDI').val(savedcontent + pastedText);
        //$(elem).val(pastedText);
        // Do whatever with gathered data;
        //alert('aaa:'+pasteddata);
    }

    function showHideOtherAuth(id) {
        var authority = $('#' + id).val();
        if (authority == 5) {
            $('#TR_' + id).show('slow');
        } else {
            $('#TR_' + id).hide('slow');
        }
    }
    var myHeads = <?php echo json_encode($DEPOSIT_SCHEME_DETAILS); ?>;
    /* for (var i = 0; i < myHeads.length; i++) {
         alert(myHeads[i].HEAD);
     }*/

    function showHead(id) {
        var head_id = $("#DEPOSIT_SCHEME_ID").val();

        for (var i = 0; i < myHeads.length; i++) {

            if (head_id == myHeads[i].ID)
                $("#DEPOSIT_SCHEME_HEAD").html(myHeads[i].HEAD);
        }

    }

    showHead('1');

</script>
<style>
    #div_map {
        height: 400px;
        width: 100%;
    }
</style>
