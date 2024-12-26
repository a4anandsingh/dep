<form name="frmProject" id="frmProject" onsubmit="return false;">
	<input type="hidden" name="PROJECT_SETUP_ID" id="PROJECT_SETUP_ID" value="<?php echo $PROJECT_SETUP_ID;?>" />
	<input type="hidden" name="RAA_PROJECT_ID" id="RAA_PROJECT_ID" value="<?php echo $raaData['RAA_PROJECT_ID'];?>" />
	<input type="hidden" name="ESTIMATED_QTY_ID" id="ESTIMATED_QTY_ID" value="<?php echo $currentEstimation['ESTIMATED_QTY_ID'];?>" />
	<input type="hidden" name="AA_DATE" id="AA_DATE" value="<?php echo myDateFormat($projectData['AA_DATE']);?>" />
	<input type="hidden" name="MY_DATE" id="MY_DATE" value="<?php echo date("d-m-Y");?>" />
	<input type="hidden" name="ADDED_BY" id="ADDED_BY" value="<?php echo $raaData['ADDED_BY'];?>" />
<table width="100%" border="0" cellpadding="3" class="ui-widget-content">
<tr>
    <td align="center" class="ui-widget-header">
        <strong>
        <?php echo $projectData['WORK_NAME'].' - '.$projectData['WORK_NAME_HINDI'];?>
        </strong>
    </td>
</tr>
<tr>
	<td class="ui-widget-content" align="center">
        <div id="radioset"><strong>Entry Type : </strong>
            <input type="radio" id="radio1" name="IS_RAA" value="1" 
            	onchange="changeCheckBoxOption(1, this.checked)"
			<?php echo ($raaData['IS_RAA']==1)? 'checked="checked"':'';?> />
            <label for="radio1">RAA</label>
            <input type="radio" id="radio2" name="IS_RAA" value="2" 
	            onchange="changeCheckBoxOption(2, this.checked)"
			<?php echo ($raaData['IS_RAA']==2)? 'checked="checked"':'';?> />
            <label for="radio2">Extra Quantity</label>
            <input type="radio" id="radio3" name="IS_RAA" value="3" 
            	onchange="changeCheckBoxOption(3, this.checked)"
			<?php echo ($raaData['IS_RAA']==3)? 'checked="checked"':'';?> />
            <label for="radio3">TS</label>
            <?php $arrMode = array('', 'RAA', 'Sanction', 'TS');
			$entryMode = $arrMode[ $raaData['IS_RAA'] ];?>
        </div>
	</td>
</tr>
</table>
<div class="wrdlinebreak"></div>
<div class="ui-state-error" style="padding:5px">
<span class="cus-lightbulb"></span> 
<strong>अगर नवीनतम मात्रा में कमी हो तभी कम मात्रा भरें। <br />
अगर नवीनतम मात्रा(Latest) में कोई भी परिवर्तन न हो तो नवीनतम मात्रा(Latest) कॉलम में पुरानी मात्रा(Old) को ही डालना है।</strong>
</div>
<table width="100%" border="0" cellpadding="3" class="ui-widget-content" id="RAA_DETAIL">
<tr>
    <td class="ui-state-default">
    	<strong id="raa_no"><?php echo $entryMode;?> No : </br><span style="color:red;">(Only numeric.)</span></strong>
    </td>
    <td class="ui-widget-content">
		<input name="RAA_NO"  id="RAA_NO" type="text" 
        	size="6" maxlength="5"
        	value="<?php echo $raaData['RAA_NO'];?>"
            class="" />
    </td>
    <td class="ui-state-default"><strong id="raa_date"><?php echo $entryMode;?> Date :</strong></td>
    <td class="ui-widget-content">
        <input name="RAA_DATE" type="text" id="RAA_DATE" 
            size="18" maxlength="50" 
            value="<?php echo myDateFormat($raaData['RAA_DATE']);?>" 
            class="centertext"  />
	</td>
</tr>
<tr>
  <td class="ui-state-default"><strong id="raa_aid"><?php echo $entryMode;?> Authority :</strong></td>
  <td class="ui-widget-content">
    <select name="RAA_AUTHORITY_ID" id="RAA_AUTHORITY_ID" 
    	style="width:200px;" class=" raa-select" >
      <option value="" >Select Authority</option>
      <?php echo implode('', $RAA_AUTHORITY_ID);?>
      </select>
    </td>
  <td class="ui-state-default"><strong id="raa_amt"><?php echo $entryMode;?> Amount :</strong></td>
  <td class="ui-widget-content"><input name="RAA_AMOUNT" id="RAA_AMOUNT" type="text" 
        	size="12" maxlength="20" 
            value="<?php echo $raaData['RAA_AMOUNT'];?>" 
            class=" righttext" /> Rs. In Lacs
  </td>
</tr>
    <tr class="raa">
        <td nowrap="nowrap" class="ui-state-default">
            <?php echo getRequiredSign('right');?><strong>Scanned Copy  :</strong>
        </td>
        <td class="ui-widget-content" colspan="3">
            <div id="msg_raa_file"></div>
            <?php
            $filePath= FCPATH.'dep_uploads'.DIRECTORY_SEPARATOR.$raaData['RAA_FILE_URL'];
            if($raaData['RAA_USER_FILE_NAME']!='') {
                if (file_exists($filePath)) { ?>
                    <div id="raa_button_div">
                        <a class="fm-button ui-state-default ui-corner-all"  target="_blank"
                           href="<?php echo base_url() . 'dep_uploads/'.$raaData['RAA_FILE_URL']?>">
                            <span class=cus-eye></span> View </a>
                        <?php
                        if($raaData['ADDED_BY']){
                            if($isMonthlyExists){

                            }else{
                                echo getButton('Delete', 'removeFile('.$raaData['RAA_PROJECT_ID'].')', 4, 'cus-cross'). ' &nbsp; ';
                            }
                        }else{
                            if($raaData['RAA_PROJECT_ID']==0){
                                echo getButton('Delete', 'removeFile('.$raaData['RAA_PROJECT_ID'].')', 4, 'cus-cross'). ' &nbsp; ';
                            }
                        }
                        ?>
                    </div>
                    <div id="raa_upload_div" style="display: none;">
                        <input type="file"  onchange="showSize('RAA_SCAN_COPY')" id="RAA_SCAN_COPY" name="RAA_SCAN_COPY"/>
                        (.jpeg/.jpg/.pdf)
                    </div>
                    <?php
                }
            }else{ ?>
                <input type="file"  onchange="showSize('RAA_SCAN_COPY')" id="RAA_SCAN_COPY" name="RAA_SCAN_COPY"/>
                <span style="color:#f00">(.jpeg/.jpg/.pdf)</span>
                <?php
            }
            ?>
        </td>
    </tr>
</table>
<div class="wrdlinebreak"></div>
<table width="100%" cellpadding="3" cellspacing="2" class="ui-widget-content">
<tr>
    <th rowspan="2" class="ui-widget-header">Contents</th>
    <th rowspan="2" class="ui-widget-header">Unit</th>
    <!--<th rowspan="2" class="ui-widget-header"></th>-->
    <th colspan="2" class="ui-widget-header">Estimation</th>
  </tr>
<tr>
  <th width="100" class="ui-widget-header" style="min-width:55px">Old</th>
  <th width="130" class="ui-widget-header">Latest</th>
</tr>    
<tr>
    <td colspan="5" nowrap="nowrap" class="ui-state-default">
        <strong>Physical</strong></td>
</tr>
<?php
$arrEstimationAchievements = array(
    array(
        'SNO'=>1,
        'TITLE'=>'Land Acquisition Submited',
        'UNIT'=>'No. of Cases',
        'NA_VALUE'=>$estimationStatus['LA_NA'],
        'EA_NAME'=>'LA_NO',
        'EA_VALUE'=>$previousEstimation['LA_NO'],
        'AC_NAME'=>'LA_NO',
        'AC_VALUE'=>$currentEstimation['LA_NO'],
        'SHOW'=>1
    ),
    array(
        'SNO'=>2,
        'TITLE'=>'Land Acquisition Submited',
        'UNIT'=>'Hectares',
        'NA_VALUE'=>$estimationStatus['LA_NA'],
        'EA_NAME'=>'LA_HA',
        'EA_VALUE'=>$previousEstimation['LA_HA'],
        'AC_NAME'=>'LA_HA',
        'AC_VALUE'=>$currentEstimation['LA_HA'],
        'SHOW'=>1
    ),
    array(
        'SNO'=>3,
        'TITLE'=>'Forest Acquisition',
        'UNIT'=>'Hectares',
        'NA_VALUE'=>$estimationStatus['FA_NA'],
        'EA_NAME'=>'FA_HA',
        'EA_VALUE'=>$previousEstimation['FA_HA'],
        'AC_NAME'=>'FA_HA',
        'AC_VALUE'=>$currentEstimation['FA_HA'],
        'SHOW'=>1
    ),
    array(
        'SNO'=>4,
        'TITLE'=>'Earthwork <br />(As per "L" Earthwork section of AA)',
        'UNIT'=>'Th Cum',
        'NA_VALUE'=>$estimationStatus['L_EARTHWORK_NA'],
        'EA_NAME'=>'L_EARTHWORK',
        'EA_VALUE'=>$previousEstimation['L_EARTHWORK'],
        'AC_NAME'=>'L_EARTHWORK',
        'AC_VALUE'=>$currentEstimation['L_EARTHWORK'],
        'SHOW'=>1
    ),
    array(
        'SNO'=>5,
        'TITLE'=>'Earthwork',
        'UNIT'=>'Th Cum',
        'NA_VALUE'=>$estimationStatus['C_EARTHWORK_NA'],
        'EA_NAME'=>'C_EARTHWORK',
        'EA_VALUE'=>$previousEstimation['C_EARTHWORK'],
        'AC_NAME'=>'C_EARTHWORK',
        'AC_VALUE'=>$currentEstimation['C_EARTHWORK'],
        'SHOW'=>1
    ),
    array(
        'SNO'=>6,
        'TITLE'=>' Masonry/Concrete',
        'UNIT'=>'Th Cum',
        'NA_VALUE'=>$estimationStatus['C_MASONRY_NA'],
        'EA_NAME'=>'C_MASONRY',
        'EA_VALUE'=>$previousEstimation['C_MASONRY'],
        'AC_NAME'=>'C_MASONRY',
        'AC_VALUE'=>$currentEstimation['C_MASONRY'],
        'SHOW'=>1
    ),
    array(
        'SNO'=>7,
        'TITLE'=>' Pipe Works',
        'UNIT'=>'Mtrs',
        'NA_VALUE'=>$estimationStatus['C_PIPEWORK_NA'],
        'EA_NAME'=>'C_PIPEWORK',
        'EA_VALUE'=>$previousEstimation['C_PIPEWORK'],
        'AC_NAME'=>'C_PIPEWORK',
        'AC_VALUE'=>$currentEstimation['C_PIPEWORK'],
        'SHOW'=>1
    ),
    array(
        'SNO'=>8,
        'TITLE'=>' Drip Pipe',
        'UNIT'=>'Mtrs',
        'NA_VALUE'=>$estimationStatus['C_DRIP_PIPE_NA'],
        'EA_NAME'=>'C_DRIP_PIPE',
        'EA_VALUE'=>$previousEstimation['C_DRIP_PIPE'],
        'AC_NAME'=>'C_DRIP_PIPE',
        'AC_VALUE'=>$currentEstimation['C_DRIP_PIPE'],
        'SHOW'=>1
    ),
    array(
        'SNO'=>9,
        'TITLE'=>' Water Pumps',
        'UNIT'=>'Numbers',
        'NA_VALUE'=>$estimationStatus['C_WATERPUMP_NA'],
        'EA_NAME'=>'C_WATERPUMP',
        'EA_VALUE'=>$previousEstimation['C_WATERPUMP'],
        'AC_NAME'=>'C_WATERPUMP',
        'AC_VALUE'=>$currentEstimation['C_WATERPUMP'],
        'SHOW'=>1
    ),
    array(
        'SNO'=>10,
        'TITLE'=>'Building Works <br />( As per "K" Building section of AA) Control Rooms',
        'UNIT'=>'Numbers',
        'NA_VALUE'=>$estimationStatus['K_CONTROL_ROOMS_NA'],
        'EA_NAME'=>'K_CONTROL_ROOMS',
        'EA_VALUE'=>$previousEstimation['K_CONTROL_ROOMS'],
        'AC_NAME'=>'K_CONTROL_ROOMS',
        'AC_VALUE'=>$currentEstimation['K_CONTROL_ROOMS'],
        'SHOW'=>1
    )/*,
    array(
        'SNO'=>11 ,
        'TITLE'=>'Designed Irrigation Potential',
        'UNIT'=>'Hectares',
        'NA_VALUE'=>$estimationStatus['IP_TOTAL_NA'],
        'EA_NAME'=>'IP_TOTAL',
        'EA_VALUE'=>$previousEstimation['IP_TOTAL'],
        'AC_NAME'=>'IP_TOTAL',
        'AC_VALUE'=>$currentEstimation['IP_TOTAL'],
        'SHOW'=>1,
        'KHARIF'=>array(
            'EA_NAME'=>'KHARIF',
            'EA_VALUE'=>$previousEstimation['KHARIF'],
            'AC_NAME'=>'KHARIF',
            'AC_VALUE'=>$currentEstimation['KHARIF']
        ),
        'RABI' => array(
            'EA_NAME'=>'RABI',
            'EA_VALUE'=>$previousEstimation['RABI'],
            'AC_NAME'=>'RABI',
            'AC_VALUE'=>$currentEstimation['RABI']
        )
    )*/
);
/////////////////////////////////////
//$content = '';
$arrV = array();
$arrValidComponent = array();
foreach($arrEstimationAchievements as $x){
	if($x['NA_VALUE']) continue;
	$myClass = ($x['NA_VALUE'])? '' : 'required';
	$rowSpan = '';
	if($x['SNO']==11){
		$rowSpan = 'rowspan="3"';
	}
	echo '<tr>
		<td nowrap="nowrap" class="ui-widget-content" '.$rowSpan.'><strong>'.$x['TITLE'].'</strong></td>
		<td nowrap="nowrap" class="ui-widget-content" '.$rowSpan.'>'.$x['UNIT'].'</td>';

	if($x['SNO']==11){
		array_push($arrValidComponent, 'KHARIF');
		array_push($arrValidComponent, 'RABI');
		echo '<td align="center" class="ui-widget-content">Kharif</td>
			<td align="right" class="ui-widget-content"><strong>'.$x['KHARIF']['EA_VALUE'].'</strong></td>
			<td align="center" class="ui-widget-content">'.getRequiredSign('left').'
			  <input name="KHARIF" type="text" id="KHARIF"
			  onkeyup="calculateIrri()"			  	
				 size="12" maxlength="50"  class="righttext" value="'.$x['KHARIF']['AC_VALUE'].'"/>
			</td>
			</tr><tr>
			<td align="center" class="ui-widget-content">Rabi</td>
			<td align="right" class="ui-widget-content"><strong>'.$x['RABI']['EA_VALUE'].'</strong></td>
			<td align="center" class="ui-widget-content">'.getRequiredSign('left').'
			  <input name="RABI" type="text" id="RABI"
				 size="12" maxlength="50"  class="righttext" 
				onkeyup="calculateIrri()" value="'.$x['RABI']['AC_VALUE'].'"/>
			</td>
			</tr><tr>
			<td align="center" class="ui-state-default">Total</td>
			<td align="right" class="ui-state-default"><strong>'.$x['EA_VALUE'].'</strong></td>
			<td align="center" class="ui-state-default">
			  <input name="'.$x['AC_NAME'].'" type="text" id="'.$x['AC_NAME'].'"
				 size="12" maxlength="50" class="righttext" readonly="readonly" 
					value="'.$x['AC_VALUE'].'"/>
			</td>';
	}else{
		array_push($arrV, '"'.$x['AC_NAME'].'":{required : true, number:true, min:'.$x['EA_VALUE'].'}');
		array_push($arrValidComponent, $x['AC_NAME']);
		//<td align="center" class="ui-widget-content"></td>
		echo '<td align="right" class="ui-widget-content">
			<input type="hidden" id="esti'.$x['AC_NAME'].'" value="'.$x['EA_VALUE'].'" />
			<strong>'.$x['EA_VALUE'].'</strong>
			</td>
			<td align="center" class="ui-widget-content">'.getRequiredSign('left').'
			  <input name="'.$x['AC_NAME'].'" type="text" id="'.$x['AC_NAME'].'"
				 size="12" maxlength="50"  class="righttext" 
					value="'.$x['AC_VALUE'].'"/></td>';
	}
	echo '</tr>';
}//foreach?>
</table>
<div id="mySaveDiv" align="right" class="mysavebar">
<?php
if($raaData['ADDED_BY']){
	if($isMonthlyExists){
			
	}else
		echo getButton('Save', 'saveRAASetup()', 4, 'cus-disk'). ' &nbsp; ';
}else{
	if($raaData['RAA_PROJECT_ID']==0){
		echo getButton('Save', 'saveRAASetup()', 4, 'cus-disk'). ' &nbsp; ';
	}
}
echo getButton('Cancel', 'closeDialog()', 4, 'cus-cancel');?>
</div>
</form>
<script language="javascript" type="text/javascript">
//
var validator = '';
$().ready(function(){

    $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param);
    }, "File must less than 2MB");


	$('#RAA_DATE').attr("placeholder", "dd-mm-yyyy").datepicker({
		dateFormat:'dd-mm-yy', changeMonth:true, changeYear:true, showOtherMonths: true,
		beforeShow: function(input, inst) {	return setMinMaxDate('#AA_DATE', 'today'); }
	});
	//SESSION_ID = $('#SESSION_ID').val();
	$(".raa-select").select2();
	getToolTips();
	setSelect2();
	window.validator = 
	$("#frmProject").validate({
		rules: {
			"IS_RAA" : {required : true, min:1, max:3},
			"RAA_NO" : {required : true, digits:true,maxlength:5, number:true},
			"RAA_DATE" :{required : true, indianDate:true, 
				dpDate: true, dpCompareDate: {before:'#MY_DATE'}},
			"RAA_AMOUNT":{required : true, min:0, number:true},
            "RAA_SCAN_COPY":{required:true,extension: "pdf|jpg|jpeg",filesize:2000000}
		},
		messages: {
			"IS_RAA" : {required : "Select RAA / TS / Extra Quantity"},
			"RAA_NO" : {required : "Required - RAA / TS / Extra Quantity No ", number: "Required numeric value only."},
			"RAA_DATE" : {required : "Required - RAA / TS / Extra Quantity Date"},
			"RAA_AMOUNT" : {required : "Required - RAA / TS / Extra Quantity Amount", min:"Required Positive Amount"},
            "RAA_SCAN_COPY":{required:"Please upload scan copy of RAA",extension:"Please upload only .pdf or .jpg files"}
		}
	});
	$("#radioset").buttonset();
	<?php if($raaData['IS_RAA']){?>
	changeCheckBoxOption(<?php echo $raaData['IS_RAA'];?>, true);
	<?php }?>
});
//
function setEstimationFields(sno, mName, status){
	var requiredField1 = mName.substr(0, (mName.length-3));
	$('#'+requiredField1).prop('disabled', status);
	if(status) $('#'+requiredField1).val('');
}
function changeCheckBoxOption(mode, status){
	switch(mode){
		case 1://RAA
			//alert('raa');
			$('#raa_no').html("RAA No : ");
			$('#raa_date').html("RAA Date : ");
			$('#raa_aid').html("RAA Authority: ");
			$('#raa_amt').html("RAA Amount : ");
			//Add amount validation
			<?php $arrValidComponent;?>
			$('#RAA_AMOUNT').rules( "add", {
				required: true,
				min: 0,
				messages: {
					required: "Required.",
					min: "Minimum value 0"
				}
			});
			$('#RAA_AMOUNT').prop('disabled', false);
			<?php foreach($arrValidComponent as $comp){?>
				$('#<?php echo $comp;?>').rules("remove");
				$('#<?php echo $comp;?>').rules( "add", {
					required: true,
					min: 0,
					messages: {
						required: "Required.",
						min: "Minimum value 0"
					}
				});
			<?php }?>
			break;
		case 2://XTRA QTY
			//alert('xtra qty');
			$('#raa_no').html("Sanction No : ");
			$('#raa_date').html("Sanction Date : ");
			$('#raa_aid').html("Sanction Authority: ");
			$('#raa_amt').html("Sanction Amount : ");
			//remove amount validation
			$('#RAA_AMOUNT').prop('disabled', true);
			$('#RAA_AMOUNT').rules("remove");
			$('#RAA_AMOUNT').val(0);
			<?php foreach($arrValidComponent as $comp){?>
				$('#<?php echo $comp;?>').rules("remove");
				$('#<?php echo $comp;?>').rules( "add", {
					required: true,
					min: 0,
					messages: {
						required: "Required.",
						min: "Minimum value 0"
					}
				});
				//$('#esti<?php echo $comp;?>').val()
			<?php }?>
			break;
		case 3://TS
			//alert('ts');
			$('#raa_no').html("TS No : ");
			$('#raa_date').html("TS Date : ");
			$('#raa_aid').html("TS Authority: ");
			$('#raa_amt').html("TS Amount : ");
			//remove amount validation
			$('#RAA_AMOUNT').rules("remove");
			$('#RAA_AMOUNT').prop('disabled', true);
			$('#RAA_AMOUNT').val(0);
			<?php foreach($arrValidComponent as $comp){?>
				$('#<?php echo $comp;?>').rules("remove");
				$('#<?php echo $comp;?>').rules( "add", {
					required: true,
					min: 0,
					messages: {
						required: "Required.",
						min: "Minimum value 0"
					}
				});
			<?php }?>
			break;
	}
}
function calculateIrri(){
	var kh = checkNo($('#KHARIF').val());
	var rab = checkNo($('#RABI').val());
	var tot = kh + rab;
	$('#IP_TOTAL').val(roundNumber(tot, 3));
}

function removeFile(raaId) {
    var ans = confirm("Are you sure to delete this file ?");
    if(!ans)
        return;
    var params = {
        'divid':'',
        'url':'removeRAAFile',
        'data':{'RAA_PROJECT_ID':raaId},
        'donefname': 'doneRemoveFile',
        'failfname' :'none',
        'alwaysfname':'none'
    };
    callMyAjax(params);
}
function doneRemoveFile(data){
    var mydata = parseAndShowMyResponse(data);
    $('#msg_raa_file').html(mydata);
    $('#raa_button_div').hide();
    $('#raa_upload_div').show();
}
</script>
