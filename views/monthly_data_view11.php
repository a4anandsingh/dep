

<style>
.ui-state-dim{background:#eee; color:#000; border:1px solid #CCC}
</style>
<?php $status_options = array('', '', 'Not Started', 'Ongoing', 'Stopped', 'Completed', 'Dropped', 'Current Year AA');
$isBlank = FALSE;
$arrMonthlyData = $arrDataFields = array();
$arrEstimationDataJS=array();
function getWorkStatusOptions($type, $Sel=0, $prevMonthStatus=0){
    $myOptions ='';
	//type 0-Work Status
	if($type==0){
		$statusOptionValues = array('Please Select'=>0, 'NA'=>1, 'Not Started'=>2,'Ongoing'=>3, 'Stopped'=>4, 'Completed'=>5,'Current Year AA'=>7);
	}else{
		$statusOptionValues = array('Please Select'=>0, 'NA'=>1, 'Not Started'=>2, 'Ongoing'=>3, 'Stopped'=>4, 'Completed'=>5, 'Current Year AA'=>7);
	}
	switch($prevMonthStatus){
		case 2: //Not started
			$filteredStatus = array('Please Select', 'Not Started', 'Ongoing', 'Stopped');
			break;
		case 3: //Ongoing
			$filteredStatus = array('Please Select', 'Ongoing', 'Stopped', 'Completed');
			break;
		case 4: //Stopped
			$filteredStatus = array('Please Select', 'Ongoing', 'Stopped');
			break;
		case 7: //Current Year AA
			$filteredStatus = array('Please Select', 'Not Started', 'Ongoing', 'Stopped');
			break;
		default : 
			$filteredStatus = array('Please Select', 'Ongoing', 'Stopped');
			break;
		/*case 5: //completed
			$filteredStatus = array('Please Select', 'NA', 'Stopped');
			break;*/
	}
	//if project status
	if($type==0){
		$statusOptionValues['Dropped']=6;
		array_push($filteredStatus, 'Dropped');
	}
	for($i=0;$i<count($filteredStatus);$i++){
		$selText = '';
		$statusValueFromKey = $statusOptionValues[ $filteredStatus[$i] ];
		//if current month doesn't have status
		//if($Sel==0){
			/*if($statusValueFromKey==$prevMonthStatus)
				$selText = 'selected="selected"';*/
		//}else{
			if($Sel==$statusValueFromKey)
				$selText = 'selected="selected"';
		//}
		$myOptions .= '<option value="'.$statusValueFromKey.'" '.$selText.'>'.
			$filteredStatus[$i].
			'</option>';
	}
	return $myOptions;
}?>
<form id="frmMonthly" name="frmMonthly" method="post" action="">
<?php $mon = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug','Sep', 'Oct', 'Nov', 'Dec');
$arrForValidationControls = array();
$arrForValidation = array();
$arrForValidationMessage = array();
  //if($this->PROJECT_ID==4546){   showArrayValues($arrCurrentMonthData);exit;}
  ?>
<input type="hidden" id="PROJECT_NAME" name="PROJECT_NAME" value="<?php echo $arrProjectData['WORK_NAME'];?>" />
<input type="hidden" name="PROJECT_SETUP_ID" id="PROJECT_SETUP_ID" value="<?php echo $PROJECT_SETUP_ID;?>" />
<input type="hidden" name="MONTHLY_DATA_ID" id="MONTHLY_DATA_ID" value="<?php echo $arrCurrentMonthData['MONTHLY_DATA_ID'];?>" />
<input type="hidden" name="MONTH_DATE" id="MONTH_DATE" value="<?php echo $MONTH_DATE;?>" />
<input type="hidden" name="START_MONTH_DATE" id="START_MONTH_DATE" value="<?php echo date("d-m-Y", $MONTH_DATE);?>" />
<input type="hidden" name="END_MONTH_DATE" id="END_MONTH_DATE" value="<?php echo date("t-m-Y", $MONTH_DATE);?>" />
<input type="hidden" name="SESSION_ID" id="SESSION_ID" value="<?php echo $SESSION_ID;?>" />
<div class="panel panel-primary">
<!-- Default panel contents -->
<div class="panel-heading">
    <strong><big><big>Monthly Entry ( <?php echo date('F Y', $MONTH_DATE);?> )</big>
    <br />
    <?php echo $arrProjectData['WORK_NAME']. '</big><br />Code : '.$arrProjectData['PROJECT_CODE'];?></strong>
</div>
<div class="panel-body">
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="ui-widget-content">
<tr>
    <td nowrap="nowrap" class="ui-state-default"><strong>Status of Scheme <?php   echo $arrPreviousMonthData['WORK_STATUS']; ?></strong></td>
    <td class="ui-widget-content" style="font-weight:900">

        <?php

            //echo '=> '.$arrCurrentMonthData['WORK_STATUS'].' ### '.$arrPreviousMonthData['WORK_STATUS'];
        ?>

     <?php //echo 'cur month status = '. $arrCurrentMonthData['WORK_STATUS'].', prev month status ='.$arrPreviousMonthData['WORK_STATUS'];?>
        <select name="WORK_STATUS" id="WORK_STATUS" class="mysel2"
            style="width:150px" onchange="setProjectStatus(this.value)">
        <?php echo getWorkStatusOptions(0, $arrCurrentMonthData['WORK_STATUS'], $arrPreviousMonthData['WORK_STATUS']);?>
        </select>
        <?php
            //echo "STATUS =". $arrCurrentMonthData['WORK_STATUS'] ." < > ". $arrPreviousMonthData['WORK_STATUS'];
        ?>
    </td>
    <td class="ui-state-default">Proposed Completion Date</td>
    <td align="center" class="ui-widget-content"> As Per Target
      <span class="label label-warning" style="float:center">
        <strong><?php echo myDateFormat($ACTUAL_COMPLETION_DATE);?></strong>
        <input type="hidden" id="ACTUAL_COMPLETION_DATE" value="<?php echo $ACTUAL_COMPLETION_DATE;?>" />
        </span>
	</td>
</tr>
<tr>
    <td colspan="5" nowrap="nowrap" class="ui-widget-content">
		<?php 
		$remarkDiv = 'none';
		$staDiv = 'none';
		switch($arrCurrentMonthData['WORK_STATUS']){
			case 4:
			case 2:
			case 5:
			case 6:	$remarkDiv = 'block'; break;
			case 3: if( strtotime($ACTUAL_COMPLETION_DATE)<=$MONTH_DATE) $remarkDiv = 'block'; break;
		}
		//echo $ACTUAL_COMPLETION_DATE.'<='.$MONTH_DATE;
		switch($arrCurrentMonthData['WORK_STATUS']){
			case 5:
			case 6:	$staDiv = 'block'; break;
		}?>
		<table width="100%" border="0" cellpadding="10" cellspacing="2" id="divStatus" style="display:<?php echo $staDiv;?>">
        <tr>
	        <td width="140px" align="left" nowrap="nowrap" class="ui-state-default">
                <div id="completedDateCaption" style="font-weight:bold">
                	Completion Date
                </div>
            </td>
	        <td align="center" class="ui-widget-content">
                <div id="completionDiv" style="display:<?php echo $staDiv;?>">
                    <input name="COMPLETION_DATE" type="text" class="centertext" id="COMPLETION_DATE" 
                    value="<?php echo myDateFormat($arrCurrentMonthData['COMPLETION_DATE']);?>" size="16" 
                    maxlength="10" style="font-weight:900" />
                </div>
            </td>
            <td align="left" class="ui-state-default">
                <div id="completedNoCaption" style="font-weight:bold">
                	Completion Certificate No
                </div>
            </td>
	        <td align="center" class="ui-widget-content">
				<div id="completionDiv1" style="display:<?php echo $staDiv;?>">
                    <input id="PROJECT_STATUS_DISPATCH_NO" name="PROJECT_STATUS_DISPATCH_NO" 
                        type="text" value="<?php echo $monthlyStatusData['PROJECT_STATUS_DISPATCH_NO'];?>"
                          style="width:97%;" maxlength="100" />
				</div>
            </td>
        </tr>
        <tr>
	        <td align="center" nowrap="nowrap" class="ui-widget-content" colspan="4">
                <div id="divCompletionType" style="display:<?php echo ($arrCurrentMonthData['WORK_STATUS']==5)? '':'none';?>">
                    <div id="radioset">
                    <?php /*$completionData = array('COMPLETION_TYPE'=>1, 
						'LA_PAYMENT'=>0, 'FA_PAYMENT'=>0, 'CONTRACTOR_LIABILITY'=>0);*/
						?>
                        <input type="radio" id="radio1" name="COMPLETION_TYPE" value="1" 
	                        onclick="checkCompletionType(this.value)"
                        <?php echo ($monthlyStatusData['COMPLETION_TYPE']==1)? 'checked="checked"':'';?> />
                        <label for="radio1">Physically & Financially Completed</label>

                        <input type="radio" id="radio2" name="COMPLETION_TYPE" value="2" 
                        	onclick="checkCompletionType(this.value)"
                        <?php echo ($monthlyStatusData['COMPLETION_TYPE']==2)? 'checked="checked"':'';?> />
                        <label for="radio2">Physically Completed but Financially not Completed</label>
                    </div>
                    <div id="divReasonsOfIncompletion" style="display:<?php 
						echo ($monthlyStatusData['COMPLETION_TYPE']==2)? '':'none';?> "> 
                        <strong>Reasons for Incompletion :</strong>
                    <input type="checkbox" id="LA_PAYMENT" name="LA_PAYMENT" 
                        value="1" class="css-checkbox"
                    <?php echo ($monthlyStatusData['LA_PAYMENT']==1)?'checked="checked"':'';?> />
                    <label for="LA_PAYMENT" class="css-label lite-red-check"><strong>LA Payment</strong></label>
                    
                    <input type="checkbox" id="FA_PAYMENT" name="FA_PAYMENT" 
                        value="1" class="css-checkbox"
                    <?php echo ($monthlyStatusData['FA_PAYMENT']==1)?'checked="checked"':'';?> />
                    <label for="FA_PAYMENT" class="css-label lite-red-check"><strong>FA Payment</strong></label>
                    
                    <input type="checkbox" id="CL_PAYMENT" name="CL_PAYMENT" 
                        value="1" class="css-checkbox"
                    <?php echo ($monthlyStatusData['CL_PAYMENT']==1)?'checked="checked"':'';?> />
                    <label for="CL_PAYMENT" class="css-label lite-red-check">
                    	<strong>Liabilities of Contractor</strong></label>
                    </div>
               </div>
            </td>
            </tr>
            </table>
            
            <table width="100%" border="0" cellpadding="3" cellspacing="2" 
            	id="divRemarks" style="display:<?php echo $remarkDiv;?>">
            <tr>
            <td align="left" class="ui-state-default" width="140px">
                <div id="completedCaption" style="font-weight:bold">
					Project Status Remark 
                </div>
            </td>
	        <td align="left" class="ui-widget-content">
                <div id="remarkDiv" style="display:<?php echo $remarkDiv;?>">
                    <textarea name="WORK_STATUS_REMARK" id="WORK_STATUS_REMARK"
                            rows="2"  style="width:97%"
                       ><?php echo $monthly_remarks['WORK_STATUS_REMARK'];?></textarea>
                </div>
            </td>
        </tr>
        </table>
    </td>
</tr>
 
</table>
<div class="wrdlinebreak"></div>
<!-- FIXED FORMAT START -->
<table width="100%" border="0" cellpadding="3" cellspacing="2" class="ui-widget-content">
<tbody>
<tr><th class="ui-widget-header">SNo.</th>
    <th colspan="3" class="ui-widget-header">&nbsp;</th>
    <th align="center" class="ui-widget-header">Unit</th>
    <th align="center" class="ui-widget-header">Estimated</th>
    <th align="center" class="ui-widget-header">Current Month</th>
    <th align="center" class="ui-widget-header">Previous Month</th>
    <th width="10%" align="center" class="ui-widget-header">Total in<br />Current<br />Financial Year</th>
    <th width="9%" align="center" class="ui-widget-header">Till Last Year</th>
    <th width="11%" align="center" class="ui-widget-header">Cumulative<br />Till Date<br />(f+g)</th>
</tr>
<tr>
    <th class="ui-state-default" width="20">&nbsp;</th>
    <th colspan="3" align="center" class="ui-state-default">a</th>
    <th align="center" class="ui-state-default">b</th>
    <th align="center" class="ui-state-default">c</th>
    <th align="center" class="ui-state-default">d</th>
    <th width="10%" align="center" class="ui-state-default">e</th>
    <th align="center" class="ui-state-default">f</th>
    <th align="center" class="ui-state-default">g</th>
    <th align="center" class="ui-state-default">h</th>
</tr>
<?php 
if($setupData['LA_NA']==0){
	array_push($arrDataFields, 'LA_NO');
	array_push($arrDataFields, 'LA_HA');
	array_push($arrDataFields, 'LA_COMPLETED_NO');
	array_push($arrDataFields, 'LA_COMPLETED_HA');
}
?>
<tr>
    <td rowspan="4" align="center" class="ui-widget-content"><strong>1</strong></td>
    <td rowspan="4" class="ui-widget-content"><strong>Land acquistion cases </strong></td>
    <td colspan="2" rowspan="2" class="ui-widget-content"><strong>Submitted</strong></td>
    <td class="ui-widget-content"><strong>Numbers</strong></td>
    <td class="ui-widget-content" id="" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrEstimationData['LA_NO'];?></td>
    <td class="ui-widget-content" align="center">
    <?php 
	if($setupData['LA_NA']){
		echo 'NA';
        array_push($arrEstimationDataJS, 'LA_NO : 0');
	}else{
        array_push($arrEstimationDataJS, "'LA_NO' :".$arrEstimationData['LA_NO']);
        ?>
      <input type="text" name="LA_NO" id="LA_NO" size="10" maxlength="15" autocomplete="off" 
            onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['LA_NO'];?>" />
    <?php 
    $esti= $arrEstimationData['LA_NO'];
    $max_val=$esti-($arrCFY['LA_NO'] + $arrTLY['LA_NO']);
		array_push($arrMonthlyData, "'LA_NO':{'ESTI':".(($arrEstimationData['LA_NO'])?$arrEstimationData['LA_NO']:0).", 'CFY':".$arrCFY['LA_NO'].", 'TLY':".$arrTLY['LA_NO']."}");
		array_push($arrForValidation, "'LA_NO':{required : true, digits:true, min:0, checkMyDigit:'', max: $max_val}");
		array_push($arrForValidationMessage, "'LA_NO':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', digits:'Numeric', min:'Min Value 0', max: 'Max value $max_val'}");
	}
    ?>
    </td>
    <td class="ui-widget-content" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrPreviousMonthData['LA_NO'];?></td>
    <td class="ui-widget-content" align="center" id="divCFY_LA_NO"><?php echo ($setupData['LA_NA'])? 'NA':($arrCFY['LA_NO'] + $arrCurrentMonthData['LA_NO']);?></td>
    <td class="ui-widget-content" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrTLY['LA_NO'];?></td>
    <td class="ui-widget-content" align="center" id="divTOTAL_LA_NO"><?php echo ($setupData['LA_NA'])? 'NA':($arrCFY['LA_NO'] + $arrCurrentMonthData['LA_NO']+$arrTLY['LA_NO']);?></td>
</tr>
    <tr>
      <td class="ui-widget-content"><strong>Hectares</strong></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrEstimationData['LA_HA'];?></td>
      <td class="ui-widget-content" align="center">
       <?php 

		if($setupData['LA_NA']){
            array_push($arrEstimationDataJS, "'LA_HA' :0");
			echo 'NA';
		}else{
            array_push($arrEstimationDataJS, "'LA_HA' :".$arrEstimationData['LA_HA']);
            ?>
   		  <input type="text" name="LA_HA" id="LA_HA" size="10" maxlength="15" autocomplete="off" 
            	onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['LA_HA'];?>" />
		<?php 
		array_push($arrMonthlyData, "'LA_HA':{'ESTI':".(($arrEstimationData['LA_HA'])?$arrEstimationData['LA_HA']:0).", 'CFY':".$arrCFY['LA_HA'].", 'TLY':".$arrTLY['LA_HA']."}");
        $esti= $arrEstimationData['LA_HA'];
    $max_val=$esti-($arrCFY['LA_HA'] + $arrTLY['LA_HA']);
		array_push($arrForValidation, "'LA_HA':{required : true, number:true, min:0, checkMyDigit:'', max: $max_val}");
		array_push($arrForValidationMessage, "'LA_HA':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', number:'number', min:'Min Value 0', max: 'Max value $max_val'}"	);
		}?>
      </td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrPreviousMonthData['LA_HA'];?></td>
      <td class="ui-widget-content" align="center" id="divCFY_LA_HA"><?php echo ($setupData['LA_NA'])? 'NA':($arrCFY['LA_HA'] + $arrCurrentMonthData['LA_HA']);?></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrTLY['LA_HA'];?></td>
      <td class="ui-widget-content" align="center" id="divTOTAL_LA_HA"><?php echo ($setupData['LA_NA'])? 'NA':($arrCFY['LA_HA'] + $arrCurrentMonthData['LA_HA']+$arrTLY['LA_HA']);?></td>
    </tr>
    <tr>
      <td colspan="2" rowspan="2" class="ui-widget-content"><strong>Completed</strong></td>
      <td class="ui-widget-content" ><strong>Numbers</strong></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrEstimationData['LA_COMPLETED_NO'];?></td>
      <td class="ui-widget-content" align="center">
      	 <?php 
		if($setupData['LA_NA']){
            array_push($arrEstimationDataJS, "'LA_COMPLETED_NO' : 0 ");
			echo 'NA';
		}else{
            array_push($arrEstimationDataJS, "'LA_COMPLETED_NO' :".$arrEstimationData['LA_NO']);
            ?>
   		  <input type="text" name="LA_COMPLETED_NO" id="LA_COMPLETED_NO" size="10" maxlength="15" autocomplete="off" 
            	onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['LA_COMPLETED_NO'];?>" />
		<?php 
		array_push($arrMonthlyData, "'LA_COMPLETED_NO':{'ESTI':".(($arrEstimationData['LA_NO'])?$arrEstimationData['LA_NO']:0).", 'CFY':".$arrCFY['LA_NO'].", 'TLY':".$arrTLY['LA_NO']."}");
           $esti= $arrEstimationData['LA_NO'];
    $max_val=$esti-($arrCFY['LA_NO'] + $arrTLY['LA_NO']);
		array_push($arrForValidation, "'LA_COMPLETED_NO':{required : true, digits:true, min:0, checkMyDigit:'', max: $max_val}");
		array_push($arrForValidationMessage, "'LA_COMPLETED_NO':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', digits:'Numeric', min:'Min Value 0', max: 'Max value $max_val'}");
		}?>
      </td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrPreviousMonthData['LA_COMPLETED_NO'];?></td>
      <td class="ui-widget-content" align="center" id="divCFY_LA_COMPLETED_NO"><?php echo ($setupData['LA_NA'])? 'NA':($arrCFY['LA_COMPLETED_NO'] + $arrCurrentMonthData['LA_COMPLETED_NO']);?></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrTLY['LA_COMPLETED_NO'];?></td>
      <td class="ui-widget-content" align="center" id="divTOTAL_LA_COMPLETED_NO"><?php echo ($setupData['LA_NA'])? 'NA':($arrCFY['LA_COMPLETED_NO'] + $arrCurrentMonthData['LA_COMPLETED_NO']+$arrTLY['LA_COMPLETED_NO']);?></td>
    </tr>
    <tr>
      <td class="ui-widget-content" ><strong>Hectares</strong></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrEstimationData['LA_COMPLETED_HA'];?></td>
      <td class="ui-widget-content" align="center">
       <?php 
		if($setupData['LA_NA']){
			echo 'NA';
            array_push($arrEstimationDataJS, "'LA_COMPLETED_HA' : 0 ");
		}else{
            array_push($arrEstimationDataJS, "'LA_COMPLETED_HA' :".$arrEstimationData['LA_HA']);
            ?>
   		  <input type="text" name="LA_COMPLETED_HA" id="LA_COMPLETED_HA" size="10" maxlength="15" autocomplete="off" 
            	onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['LA_COMPLETED_HA'];?>" />
		<?php
		array_push($arrMonthlyData, "'LA_COMPLETED_HA':{'ESTI':".(($arrEstimationData['LA_HA'])?$arrEstimationData['LA_HA']:0).", 'CFY':".$arrCFY['LA_HA'].", 'TLY':".$arrTLY['LA_HA']."}");
          $esti= $arrEstimationData['LA_HA'];
    $max_val=$esti-($arrCFY['LA_HA'] + $arrTLY['LA_HA']);
		array_push($arrForValidation, "'LA_COMPLETED_HA':{required : true, number:true, min:0, checkMyDigit:'', max: $max_val}");
		array_push($arrForValidationMessage, "'LA_COMPLETED_HA':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', number:'number', min:'Min Value 0', max: 'Max value $max_val'}"	);
		}?>
      </td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrPreviousMonthData['LA_COMPLETED_HA'];?></td>
      <td class="ui-widget-content" align="center" id="divCFY_LA_COMPLETED_HA"><?php echo ($setupData['LA_NA'])? 'NA':($arrCFY['LA_COMPLETED_HA'] + $arrCurrentMonthData['LA_COMPLETED_HA']);?></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['LA_NA'])? 'NA':$arrTLY['LA_COMPLETED_HA'];?></td>
      <td class="ui-widget-content" align="center" id="divTOTAL_LA_COMPLETED_HA"><?php echo ($setupData['LA_NA'])? 'NA':($arrCFY['LA_COMPLETED_HA'] + $arrCurrentMonthData['LA_COMPLETED_HA']+$arrTLY['LA_COMPLETED_HA']);?></td>
    </tr>
     <?php 
      
	if($setupData['FA_NA']==0){
		array_push($arrDataFields, 'FA_HA');
		array_push($arrDataFields, 'FA_COMPLETED_HA');
	}?>
    <tr>
      <td rowspan="2" align="center" class="ui-widget-content"><strong>2</strong><strong></strong></td>
      <td rowspan="2" class="ui-widget-content"><strong>Forest cases </strong></td>
      <td colspan="2" class="ui-widget-content"><strong>Submitted</strong></td>
      <td class="ui-widget-content" ><strong>Hectares</strong></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['FA_NA'])? 'NA':$arrEstimationData['FA_HA'];?></td>
      <td class="ui-widget-content" align="center">
      <?php 
		if($setupData['FA_NA']){
            array_push($arrEstimationDataJS, "'FA_HA' : 0 ");
			echo 'NA';
		}else{
            array_push($arrEstimationDataJS, "'FA_HA' :".$arrEstimationData['FA_HA']);
            ?>
   		  <input type="text" name="FA_HA" id="FA_HA" size="10" maxlength="15" autocomplete="off" 
            	onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['FA_HA'];?>" />
		<?php 
		array_push($arrMonthlyData, "'FA_HA':{'ESTI':".(($arrEstimationData['FA_HA'])?$arrEstimationData['FA_HA']:0).", 'CFY':".$arrCFY['FA_HA'].", 'TLY':".$arrTLY['FA_HA']."}");
         $esti= $arrEstimationData['FA_HA'];
    $max_val=$esti-($arrCFY['FA_HA'] + $arrTLY['FA_HA']);
		array_push($arrForValidation, "'FA_HA':{required : true, number:true, min:0, checkMyDigit:'', max: $max_val}");
		array_push($arrForValidationMessage, "'FA_HA':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', number:'number', min:'Min Value 0', max: 'Max value $max_val'}"	);
		}?>
      </td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['FA_NA'])? 'NA':$arrPreviousMonthData['FA_HA'];?></td>
      <td class="ui-widget-content" align="center" id="divCFY_FA_HA"><?php echo ($setupData['FA_NA'])? 'NA':($arrCFY['FA_HA'] + $arrCurrentMonthData['FA_HA']);?></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['FA_NA'])? 'NA':$arrTLY['FA_HA'];?></td>
      <td class="ui-widget-content" align="center" id="divTOTAL_FA_HA"><?php echo ($setupData['FA_NA'])? 'NA':($arrCFY['FA_HA'] + $arrCurrentMonthData['FA_HA']+$arrTLY['FA_HA']);?></td>
    </tr>
    <tr>
      <td colspan="2" class="ui-widget-content"><strong>Completed</strong></td>
      <td class="ui-widget-content" ><strong>Hectares</strong></td>
      <td class="ui-widget-content" align="center"><?php echo  ($setupData['FA_NA'])? 'NA':$arrEstimationData['FA_COMPLETED_HA'];?></td>
      <td class="ui-widget-content" align="center">
      <?php 
		if($setupData['FA_NA']){
			echo 'NA';
            array_push($arrEstimationDataJS, "'FA_COMPLETED_HA' : 0 ");
		}else{
            array_push($arrEstimationDataJS, "'FA_COMPLETED_HA' :".$arrEstimationData['FA_HA']);
            ?>
   		  <input type="text" name="FA_COMPLETED_HA" id="FA_COMPLETED_HA" size="10" maxlength="15" autocomplete="off" 
            	onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['FA_COMPLETED_HA'];?>" />
        <?php 
		array_push($arrMonthlyData, "'FA_COMPLETED_HA':{'ESTI':".(($arrEstimationData['FA_HA'])?$arrEstimationData['FA_HA']:0).", 'CFY':".$arrCFY['FA_COMPLETED_HA'].", 'TLY':".$arrTLY['FA_COMPLETED_HA']."}");
         $esti= $arrEstimationData['FA_HA'];
         $max_val=$esti-($arrCFY['FA_COMPLETED_HA'] + $arrTLY['FA_COMPLETED_HA']);
		array_push($arrForValidation, "'FA_COMPLETED_HA':{required : true, number:true, min:0, checkMyDigit:'', max: $max_val}");
		array_push($arrForValidationMessage, "'FA_COMPLETED_HA':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', number:'number', min:'Min Value 0', max: 'Max value $max_val'}"	);
		}?>
      </td>
      <td class="ui-widget-content" align="center"><?php echo  ($setupData['FA_NA'])? 'NA':$arrPreviousMonthData['FA_COMPLETED_HA'];?></td>
      <td class="ui-widget-content" align="center" id="divCFY_FA_COMPLETED_HA"><?php echo  ($setupData['FA_NA'])? 'NA':($arrCFY['FA_COMPLETED_HA'] + $arrCurrentMonthData['FA_COMPLETED_HA']);?></td>
      <td class="ui-widget-content" align="center"><?php echo  ($setupData['FA_NA'])? 'NA':$arrTLY['FA_COMPLETED_HA'];?></td>
      <td class="ui-widget-content" align="center" id="divTOTAL_FA_COMPLETED_HA"><?php echo  ($setupData['FA_NA'])? 'NA':($arrCFY['FA_COMPLETED_HA'] + $arrCurrentMonthData['FA_COMPLETED_HA']+$arrTLY['FA_COMPLETED_HA']);?></td>
    </tr>
    <?php 
	if($setupData['HW_EARTHWORK_NA']==0){
		array_push($arrDataFields, 'HW_EARTHWORK');
	}?>
    <tr>
      <td class="ui-widget-content" align="center"><strong>3</strong></td>
      <td class="ui-widget-content" colspan="3"><strong>Headworks Earthwork (As per "L" Earthwork section of DPR)</strong></td>
      <td class="ui-widget-content"><strong>Th Cum</strong></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['HW_EARTHWORK_NA'])? 'NA':$arrEstimationData['HW_EARTHWORK'];?></td>
      <td class="ui-widget-content" align="center">
      <?php 
		if($setupData['HW_EARTHWORK_NA']){
            array_push($arrEstimationDataJS, "'HW_EARTHWORK' : 0 ");
			echo 'NA';
		}else{
            array_push($arrEstimationDataJS, "'HW_EARTHWORK' :".$arrEstimationData['HW_EARTHWORK']);
            ?>
   		  <input type="text" name="HW_EARTHWORK" id="HW_EARTHWORK" size="10" maxlength="15" autocomplete="off" 
            	onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['HW_EARTHWORK'];?>" />
		<?php 
         $esti= $arrEstimationData['HW_EARTHWORK'];
         $max_val=$esti-($arrCFY['HW_EARTHWORK'] + $arrTLY['HW_EARTHWORK']);

			array_push($arrMonthlyData, "'HW_EARTHWORK':{'ESTI':".(($arrEstimationData['HW_EARTHWORK'])?$arrEstimationData['HW_EARTHWORK']:0).", 'CFY':".$arrCFY['HW_EARTHWORK'].", 'TLY':".$arrTLY['HW_EARTHWORK']."}");
			array_push($arrForValidation, "'HW_EARTHWORK':{required : true, number:true, min:0, checkMyDigit:'', max: $max_val}");
			array_push($arrForValidationMessage, "'HW_EARTHWORK':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', number:'number', min:'Min Value 0', max: 'Max value $max_val'}"	);
		}?>
      </td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['HW_EARTHWORK_NA'])? 'NA':$arrPreviousMonthData['HW_EARTHWORK'];?></td>
      <td class="ui-widget-content" align="center" id="divCFY_HW_EARTHWORK"><?php echo ($setupData['HW_EARTHWORK_NA'])? 'NA':($arrCFY['HW_EARTHWORK'] + $arrCurrentMonthData['HW_EARTHWORK']);?></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['HW_EARTHWORK_NA'])? 'NA':$arrTLY['HW_EARTHWORK'];?></td>
      <td class="ui-widget-content" align="center" id="divTOTAL_HW_EARTHWORK"><?php echo ($setupData['HW_EARTHWORK_NA'])? 'NA':($arrCFY['HW_EARTHWORK'] + $arrCurrentMonthData['HW_EARTHWORK']+$arrTLY['HW_EARTHWORK']);?></td>
    </tr>
	<?php    
    if($setupData['HW_MASONRY_NA']==0){  array_push($arrDataFields, 'HW_MASONRY'); } ?>
    <tr>
        <td class="ui-widget-content"   align="center" ><strong>4</strong></td>
        <td class="ui-widget-content" colspan="3"  ><strong>Headworks Masonry / Concrete </strong></td>
        
        <td class="ui-widget-content" ><strong>Th Cum</strong></td>
        <td class="ui-widget-content" align="center"><?php echo ($setupData['HW_MASONRY_NA'])? 'NA':$arrEstimationData['HW_MASONRY'];?></td>
        <td class="ui-widget-content" align="center">
        <?php 
		if($setupData['HW_MASONRY_NA']){
            array_push($arrEstimationDataJS, "'HW_MASONRY' : 0 ");
			echo 'NA';
		}else{
            array_push($arrEstimationDataJS, "'HW_MASONRY' :".$arrEstimationData['HW_MASONRY']);
            ?>
              <input type="text" name="HW_MASONRY" id="HW_MASONRY" size="10" maxlength="15" autocomplete="off" 
                    onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['HW_MASONRY'];?>" />
            <?php
             $esti= $arrEstimationData['HW_MASONRY'];
         $max_val=$esti-($arrCFY['HW_MASONRY'] + $arrTLY['HW_MASONRY']);          
			array_push($arrMonthlyData, "'HW_MASONRY':{'ESTI':".(($arrEstimationData['HW_MASONRY'])?$arrEstimationData['HW_MASONRY']:0).", 'CFY':".$arrCFY['HW_MASONRY'].", 'TLY':".$arrTLY['HW_MASONRY']."}");
            array_push($arrForValidation, "'HW_MASONRY':{required : true, number:true, min:0, checkMyDigit:'', max: $max_val}");
            array_push($arrForValidationMessage, "'HW_MASONRY':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', number:'number', min:'Min Value 0', max: 'Max value $max_val'}"	);
		}?>
        </td>
        <td class="ui-widget-content" align="center"><?php echo ($setupData['HW_MASONRY_NA'])? 'NA':$arrPreviousMonthData['HW_MASONRY'];?></td>
        <td class="ui-widget-content" align="center" id="divCFY_HW_MASONRY"><?php echo ($setupData['HW_MASONRY_NA'])? 'NA':($arrCFY['HW_MASONRY'] + $arrCurrentMonthData['HW_MASONRY']);?></td>
        <td class="ui-widget-content" align="center"><?php echo ($setupData['HW_MASONRY_NA'])? 'NA':$arrTLY['HW_MASONRY'];?></td>
        <td class="ui-widget-content" align="center" id="divTOTAL_HW_MASONRY"><?php echo ($setupData['HW_MASONRY_NA'])? 'NA':($arrCFY['HW_MASONRY'] + $arrCurrentMonthData['HW_MASONRY']+$arrTLY['HW_MASONRY']);?></td>
    </tr>            
	<?php 
    if($setupData['STEEL_WORK_NA']==0){array_push($arrDataFields, 'STEEL_WORK');}?>
    <tr>
      <td class="ui-widget-content"   align="center" ><strong>5</strong></td>
      <td class="ui-widget-content"   colspan="3"   ><strong>Steel Work </strong></td>    
      <td class="ui-widget-content" ><strong>Th Cum</strong></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['STEEL_WORK_NA'])? 'NA':$arrEstimationData['STEEL_WORK'];?></td>
      <td class="ui-widget-content" align="center">
      <?php 
		if($setupData['STEEL_WORK_NA']){
            array_push($arrEstimationDataJS, "'STEEL_WORK' : 0 ");
			echo 'NA';
		}else{
            array_push($arrEstimationDataJS, "'STEEL_WORK' :".$arrEstimationData['STEEL_WORK']);
            ?> 
   		  <input type="text" name="STEEL_WORK" id="STEEL_WORK" size="10" maxlength="15" autocomplete="off" 
            	onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['STEEL_WORK'];?>" />
		<?php 
		array_push($arrMonthlyData, "'STEEL_WORK':{'ESTI':".(($arrEstimationData['STEEL_WORK'])?$arrEstimationData['STEEL_WORK']:0).", 'CFY':".$arrCFY['STEEL_WORK'].", 'TLY':".$arrTLY['STEEL_WORK']."}");
         $esti= $arrEstimationData['STEEL_WORK'];
         $max_val=$esti-($arrCFY['STEEL_WORK'] + $arrTLY['STEEL_WORK']); 
		array_push($arrForValidation, "'STEEL_WORK':{required : true, digits:true, min:0, checkMyDigit:'', max: $max_val}");
		array_push($arrForValidationMessage, "'STEEL_WORK':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', digits:'Numeric', min:'Min Value 0', max: 'Max value $max_val'}");
		}?>
      </td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['STEEL_WORK_NA'])? 'NA':$arrPreviousMonthData['STEEL_WORK'];?></td>
      <td class="ui-widget-content" align="center" id="divCFY_STEEL_WORK"><?php echo ($setupData['STEEL_WORK_NA'])? 'NA':($arrCFY['STEEL_WORK'] + $arrCurrentMonthData['STEEL_WORK']);?></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['STEEL_WORK_NA'])? 'NA':$arrTLY['STEEL_WORK'];?></td>
      <td class="ui-widget-content" align="center" id="divTOTAL_STEEL_WORK"><?php echo ($setupData['STEEL_WORK_NA'])? 'NA':($arrCFY['STEEL_WORK'] + $arrCurrentMonthData['STEEL_WORK']+$arrTLY['STEEL_WORK']);?></td>
    </tr>
	<?php    
     if($setupData['CANAL_EARTHWORK_NA']==0){ array_push($arrDataFields, 'CANAL_EARTHWORK');}?>
    <tr>
      <td class="ui-widget-content"   align="center" ><strong>6</strong></td>
      <td class="ui-widget-content"   colspan="3"   ><strong>Canals Earth Work </strong></td>    
     
      <td class="ui-widget-content" ><strong>Mtrs</strong></td>
      <td class="ui-widget-content" align="center" id="CANAL_EARTHWORK_esti"><?php echo ($setupData['CANAL_EARTHWORK_NA'])? 'NA':$arrEstimationData['CANAL_EARTHWORK'];?></td>
      <td class="ui-widget-content" align="center">
      <?php 
		if($setupData['CANAL_EARTHWORK_NA']){
            array_push($arrEstimationDataJS, "'CANAL_EARTHWORK' : 0 ");
			echo 'NA';
		}else{
            array_push($arrEstimationDataJS, "'CANAL_EARTHWORK' :".$arrEstimationData['CANAL_EARTHWORK']);
            ?>
   		  <input type="text" name="CANAL_EARTHWORK" id="CANAL_EARTHWORK" size="10" maxlength="15" autocomplete="off" 
            	onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['CANAL_EARTHWORK'];?>" />
		<?php 
		array_push($arrMonthlyData, "'CANAL_EARTHWORK':{'ESTI':".(($arrEstimationData['CANAL_EARTHWORK'])?$arrEstimationData['CANAL_EARTHWORK']:0).", 'CFY':".$arrCFY['CANAL_EARTHWORK'].", 'TLY':".$arrTLY['CANAL_EARTHWORK']."}");
           $esti= $arrEstimationData['CANAL_EARTHWORK'];
         $max_val=$esti-($arrCFY['CANAL_EARTHWORK'] + $arrTLY['CANAL_EARTHWORK']); 
		array_push($arrForValidation, "'CANAL_EARTHWORK':{required : true, digits:true, min:0, checkMyDigit:'', max: $max_val}");
		array_push($arrForValidationMessage, "'CANAL_EARTHWORK':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', digits:'Numeric', min:'Min Value 0', max: 'Max value $max_val'}");
		}?>
      </td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['CANAL_EARTHWORK_NA'])? 'NA':$arrPreviousMonthData['CANAL_EARTHWORK'];?></td>
      <td class="ui-widget-content" align="center" id="divCFY_CANAL_EARTHWORK"><?php echo ($setupData['CANAL_EARTHWORK_NA'])? 'NA':($arrCFY['CANAL_EARTHWORK'] + $arrCurrentMonthData['CANAL_EARTHWORK']);?></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['CANAL_EARTHWORK_NA'])? 'NA':$arrTLY['CANAL_EARTHWORK'];?></td>
      <td class="ui-widget-content" align="center" id="divTOTAL_CANAL_EARTHWORK">
	  	<?php echo ($setupData['CANAL_EARTHWORK_NA'])? 'NA':($arrCFY['CANAL_EARTHWORK'] + $arrCurrentMonthData['CANAL_EARTHWORK']+($arrCFY['CANAL_EARTHWORK'] + $arrCurrentMonthData['CANAL_EARTHWORK']+$arrTLY['CANAL_EARTHWORK']));?>
      </td>
    </tr>
	<?php 
   if($setupData['CANAL_STRUCTURE_NA']==0){array_push($arrDataFields, 'CANAL_STRUCTURE');}?>
      <tr>
        <td class="ui-widget-content"   align="center" ><strong>7</strong></td>
        <td class="ui-widget-content"   colspan="3"   ><strong>Canals Structure </strong></td>             
        <td class="ui-widget-content" ><strong>Numbers</strong></td>
        <td class="ui-widget-content" align="center"><?php echo ($setupData['CANAL_STRUCTURE_NA'])? 'NA':$arrEstimationData['CANAL_STRUCTURE'];?></td>
      <td class="ui-widget-content" align="center">
      <?php 
		if($setupData['CANAL_STRUCTURE_NA']){
            array_push($arrEstimationDataJS, "'CANAL_STRUCTURE' : 0 ");
			echo 'NA';
		}else{
            array_push($arrEstimationDataJS, "'CANAL_STRUCTURE' :".$arrEstimationData['CANAL_STRUCTURE']);?>

   		  <input type="text" name="CANAL_STRUCTURE" id="CANAL_STRUCTURE" size="10" maxlength="15" autocomplete="off" 
            	onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['CANAL_STRUCTURE'];?>" />
		<?php 
		array_push($arrMonthlyData, "'CANAL_STRUCTURE':{'ESTI':".(($arrEstimationData['CANAL_STRUCTURE'])?$arrEstimationData['CANAL_STRUCTURE']:0).", 'CFY':".$arrCFY['CANAL_STRUCTURE'].", 'TLY':".$arrTLY['CANAL_STRUCTURE']."}");

          $esti= $arrEstimationData['CANAL_STRUCTURE'];
         $max_val=$esti-($arrCFY['CANAL_STRUCTURE'] + $arrTLY['CANAL_STRUCTURE']); 

		array_push($arrForValidation, "'CANAL_STRUCTURE':{required : true, digits:true, min:0, checkMyDigit:'', max: $max_val}");
		array_push($arrForValidationMessage, "'CANAL_STRUCTURE':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', digits:'Numeric', min:'Min Value 0', max: 'Max value $max_val'}");
		}?>
      </td>
        <td class="ui-widget-content" align="center"><?php echo ($setupData['CANAL_STRUCTURE_NA'])? 'NA':$arrPreviousMonthData['CANAL_STRUCTURE'];?></td>
        <td class="ui-widget-content" align="center" id="divCFY_CANAL_STRUCTURE"><?php echo ($setupData['CANAL_STRUCTURE_NA'])? 'NA':($arrCFY['CANAL_STRUCTURE'] + $arrCurrentMonthData['CANAL_STRUCTURE']);?></td>
        <td class="ui-widget-content" align="center"><?php echo ($setupData['CANAL_STRUCTURE_NA'])? 'NA':$arrTLY['CANAL_STRUCTURE'];?></td>
        <td class="ui-widget-content" align="center" id="divTOTAL_CANAL_STRUCTURE"><?php echo ($setupData['CANAL_STRUCTURE_NA'])? 'NA':($arrCFY['CANAL_STRUCTURE'] + $arrCurrentMonthData['CANAL_STRUCTURE']+$arrTLY['CANAL_STRUCTURE']);?></td>                
    </tr>

       <?php  if($setupData['CANAL_STRUCTURE_MASONRY_NA']==0){ array_push($arrDataFields, 'CANAL_STRUCTURE_MASONRY');}?>
      <tr>
      <td class="ui-widget-content" align="center"><strong>8</strong></td>
      <td class="ui-widget-content" colspan="3"><strong>Canal Structure Masonry / Conc.</strong></td>
      <td class="ui-widget-content" ><strong>Numbers</strong></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['CANAL_STRUCTURE_MASONRY_NA'])? 'NA':$arrEstimationData['CANAL_STRUCTURE_MASONRY'];?></td>
      <td class="ui-widget-content" align="center">
      <?php 
		if($setupData['CANAL_STRUCTURE_MASONRY_NA']){
            array_push($arrEstimationDataJS, "'CANAL_STRUCTURE_MASONRY' :".$arrEstimationData['CANAL_STRUCTURE_MASONRY']);
			echo 'NA';
		}else{
            array_push($arrEstimationDataJS, "'CANAL_STRUCTURE_MASONRY' :".$arrEstimationData['CANAL_STRUCTURE_MASONRY']);
            ?>
   		  <input type="text" name="CANAL_STRUCTURE_MASONRY" id="CANAL_STRUCTURE_MASONRY" size="10" maxlength="15" autocomplete="off" 
            	onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['CANAL_STRUCTURE_MASONRY'];?>" />
		<?php 
		array_push($arrMonthlyData, "'CANAL_STRUCTURE_MASONRY':{'ESTI':".(($arrEstimationData['CANAL_STRUCTURE_MASONRY'])?$arrEstimationData['CANAL_STRUCTURE_MASONRY']:0).", 'CFY':".$arrCFY['CANAL_STRUCTURE_MASONRY'].", 'TLY':".$arrTLY['CANAL_STRUCTURE_MASONRY']."}");

        $esti= $arrEstimationData['CANAL_STRUCTURE_MASONRY'];
         $max_val=$esti-($arrCFY['CANAL_STRUCTURE_MASONRY'] + $arrTLY['CANAL_STRUCTURE_MASONRY']); 

		array_push($arrForValidation, "'CANAL_STRUCTURE_MASONRY':{required : true, digits:true, min:0, checkMyDigit:'', max: $max_val}");
		array_push($arrForValidationMessage, "'CANAL_STRUCTURE_MASONRY':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', digits:'Numeric', min:'Min Value 0', max: 'Max value $max_val'}");
		}?>
      </td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['CANAL_STRUCTURE_MASONRY_NA'])? 'NA':$arrPreviousMonthData['CANAL_STRUCTURE_MASONRY'];?></td>
      <td class="ui-widget-content" align="center" id="divCFY_CANAL_STRUCTURE_MASONRY"><?php echo ($setupData['CANAL_STRUCTURE_MASONRY_NA'])? 'NA':($arrCFY['CANAL_STRUCTURE_MASONRY'] + $arrCurrentMonthData['CANAL_STRUCTURE_MASONRY']);?></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['CANAL_STRUCTURE_MASONRY_NA'])? 'NA':$arrTLY['CANAL_STRUCTURE_MASONRY'];?></td>
      <td class="ui-widget-content" align="center" id="divTOTAL_CANAL_STRUCTURE_MASONRY"><?php echo ($setupData['CANAL_STRUCTURE_MASONRY_NA'])? 'NA':($arrCFY['CANAL_STRUCTURE_MASONRY'] + $arrCurrentMonthData['CANAL_STRUCTURE_MASONRY']+$arrTLY['CANAL_STRUCTURE_MASONRY']);?></td>
    </tr>
       <?php  if($setupData['CANAL_LINING_NA']==0){ array_push($arrDataFields, 'CANAL_LINING');}?>
      <tr>
      <td class="ui-widget-content" align="center"><strong>9</strong></td>
      <td class="ui-widget-content" colspan="3"><strong>CANAL LINING</strong></td>
      <td class="ui-widget-content" ><strong>Numbers</strong></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['CANAL_LINING_NA'])? 'NA':$arrEstimationData['CANAL_LINING'];?></td>
      <td class="ui-widget-content" align="center">
      <?php 
        if($setupData['CANAL_LINING_NA']){
            array_push($arrEstimationDataJS, "'CANAL_LINING' : 0 ");
            echo 'NA';
        }else{
            array_push($arrEstimationDataJS, "'CANAL_LINING' :".$arrEstimationData['CANAL_LINING']);?>

          <input type="text" name="CANAL_LINING" id="CANAL_LINING" size="10" maxlength="15" autocomplete="off" 
                onkeyup="calculate(this.name)" class="centertext" value="<?php echo $arrCurrentMonthData['CANAL_LINING'];?>" />
        <?php 
        array_push($arrMonthlyData, "'CANAL_LINING':{'ESTI':".(($arrEstimationData['CANAL_LINING'])?$arrEstimationData['CANAL_LINING']:0).", 'CFY':".$arrCFY['CANAL_LINING'].", 'TLY':".$arrTLY['CANAL_LINING']."}");
         $esti= $arrEstimationData['CANAL_LINING'];
         $max_val=$esti-($arrCFY['CANAL_LINING'] + $arrTLY['CANAL_LINING']); 
        array_push($arrForValidation, "'CANAL_LINING':{required : true, digits:true, min:0, checkMyDigit:'', max: $max_val}");
        array_push($arrForValidationMessage, "'CANAL_LINING':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', digits:'Numeric', min:'Min Value 0', max: 'Max value $max_val'}");
        }?>
      </td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['CANAL_LINING_NA'])? 'NA':$arrPreviousMonthData['CANAL_LINING'];?></td>
      <td class="ui-widget-content" align="center" id="divCFY_CANAL_LINING"><?php echo ($setupData['CANAL_LINING_NA'])? 'NA':($arrCFY['CANAL_LINING'] + $arrCurrentMonthData['CANAL_LINING']);?></td>
      <td class="ui-widget-content" align="center"><?php echo ($setupData['CANAL_LINING_NA'])? 'NA':$arrTLY['CANAL_LINING'];?></td>
      <td class="ui-widget-content" align="center" id="divTOTAL_CANAL_LINING"><?php echo ($setupData['CANAL_LINING_NA'])? 'NA':($arrCFY['CANAL_LINING'] + $arrCurrentMonthData['CANAL_LINING']+$arrTLY['CANAL_LINING']);?></td>
    </tr>
    
      <tr>
        <td class="ui-widget-content" align="center"><strong>10</strong></td>
        <td class="ui-widget-content" colspan="3"><strong>Irrigation Potential Created</strong></td>
        <td class="ui-widget-content"><strong>Hectares</strong></td>
        <td colspan="6" align="center" class="ui-widget-content"></td>
      </tr>
    <?php 
    //showArrayValues($arrBlockData);     
    //foreach($arrMonthly as $arrM){
	$arrMonthlyBlockData = array();
	$iBCount = 97;
	$arrTotalTemp = array('ESTIMATION'=>0, 'CURRENT_MONTH'=>0, 'PREV_MONTH'=>0, 'CFY'=>0, 'TLY'=>0, 'TOTAL'=>0);
	$arrTotal = array('KHARIF' => $arrTotalTemp, 'RABI' => $arrTotalTemp, 'TOTAL' => $arrTotalTemp);
	$arrBenefitedBlocks = array();
	foreach($arrBlockData as $k=>$v){
		array_push($arrBenefitedBlocks, $k);
		//(($arrEstimationData['LA_NO'])?$arrEstimationData['LA_NO']:0)
        //(($v['ESTIMATION_IP']['KHARIF'])
$s = $k.": {
			'KHARIF':{'ESTI':".(($v['ESTIMATION_IP']['KHARIF'])?$v['ESTIMATION_IP']['KHARIF']:0).", 'CFY':".$v['ACHIEVEMENT_IP_CFY']['KHARIF'].", 'TLY':".$v['ACHIEVEMENT_IP_TLY']['KHARIF']."}, 
			'RABI':{'ESTI':".(($v['ESTIMATION_IP']['RABI'])?$v['ESTIMATION_IP']['RABI']:0).", 'CFY':".$v['ACHIEVEMENT_IP_CFY']['RABI'].", 'TLY':".$v['ACHIEVEMENT_IP_TLY']['RABI']."}, 
			'TOTAL':{'ESTI':".(($v['ESTIMATION_IP']['IP'])?$v['ESTIMATION_IP']['IP']:0).", 'CFY':".$v['ACHIEVEMENT_IP_CFY']['IP'].", 'TLY':".$v['ACHIEVEMENT_IP_TLY']['IP']."} 
			}";


		array_push($arrMonthlyBlockData, $s);
		
		$keyup = ' onkeyup="calculateSubIrri('.$k.')" ';
		$arrTotal['KHARIF']['ESTIMATION']+= $v['ESTIMATION_IP']['KHARIF'];
		$arrTotal['KHARIF']['CURRENT_MONTH']+= $v['CUR_MONTH_IP']['KHARIF'];
		$arrTotal['KHARIF']['PREV_MONTH']+= $v['PREV_MONTH_IP']['KHARIF'];
		$arrTotal['KHARIF']['CFY']+= $v['ACHIEVEMENT_IP_CFY']['KHARIF'];
		$arrTotal['KHARIF']['TLY']+= $v['ACHIEVEMENT_IP_TLY']['KHARIF'];
		$arrTotal['KHARIF']['TOTAL']+= ($v['ACHIEVEMENT_IP_CFY']['KHARIF']+$v['ACHIEVEMENT_IP_TLY']['KHARIF']);

          $arrTotal['RABI']['ESTIMATION']+= $v['ESTIMATION_IP']['RABI'];
          $arrTotal['RABI']['CURRENT_MONTH']+= $v['CUR_MONTH_IP']['RABI'];
          $arrTotal['RABI']['PREV_MONTH']+= $v['PREV_MONTH_IP']['RABI'];
          $arrTotal['RABI']['CFY']+= $v['ACHIEVEMENT_IP_CFY']['RABI'];
          $arrTotal['RABI']['TLY']+= $v['ACHIEVEMENT_IP_TLY']['RABI'];
          $arrTotal['RABI']['TOTAL']+= ($v['ACHIEVEMENT_IP_CFY']['RABI']+$v['ACHIEVEMENT_IP_TLY']['RABI']);

          $arrTotal['TOTAL']['ESTIMATION']+= $v['ESTIMATION_IP']['IP'];
          $arrTotal['TOTAL']['CURRENT_MONTH']+= $v['CUR_MONTH_IP']['IP'];
          $arrTotal['TOTAL']['PREV_MONTH']+= $v['PREV_MONTH_IP']['IP'];
          $arrTotal['TOTAL']['CFY']+= $v['ACHIEVEMENT_IP_CFY']['IP'];
          $arrTotal['TOTAL']['TLY']+= $v['ACHIEVEMENT_IP_TLY']['IP'];
          $arrTotal['TOTAL']['TOTAL']+= ($v['ACHIEVEMENT_IP_CFY']['IP']+$v['ACHIEVEMENT_IP_TLY']['IP']);
$val_kharif=$v['ESTIMATION_IP']['KHARIF'];
            array_push($arrForValidation, "'BLOCK_IP_K[$k]':{required : true, digits:true,min:0,  checkMyDigit:''}");
        array_push($arrForValidationMessage, "'BLOCK_IP_K[$k]':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', digits:'Numeric', min:'Min Value 0'}");

         array_push($arrForValidation, "'BLOCK_IP_R[$k]':{required : true, digits:true,min:0,  checkMyDigit:''}");
        array_push($arrForValidationMessage, "'BLOCK_IP_R[$k]':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', digits:'Numeric', min:'Min Value 0'}");
      ?>
      <tr>
        <td class="ui-widget-content" align="center" rowspan="3"><?php echo chr($iBCount++); ?></td>
        <td class="ui-widget-content" rowspan="3" colspan="3"><?php echo $v['BLOCK_NAME']; ?></td>
        <td><strong>Kharif</strong></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ESTIMATION_IP']['KHARIF'];?>
            <input type="hidden" id="BLOCK_IP_E_K_<?php echo $k;?>"   name="BLOCK_IP_E_K[<?php echo $k;?>]"
                 value="<?php echo $v['CUR_MONTH_IP']['KHARIF'];?>" />
        </td>
        <td class="ui-widget-content" align="center">
        	<input type="text" name="BLOCK_IP_K[<?php echo $k;?>]" id="BLOCK_IP_K_<?php echo $k;?>" autocomplete="off"
				size="10" maxlength="15" class="centertext" <?php echo $keyup;?> value="<?php echo $v['CUR_MONTH_IP']['KHARIF'];?>" />
		</td>
        <td class="ui-widget-content" align="center"><?php echo $v['PREV_MONTH_IP']['KHARIF'];?></td>
        <td class="ui-widget-content" align="center" id="BLOCK_IP_K_CFY_<?php echo $k;?>"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['KHARIF']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['KHARIF'];?></td>
        <td class="ui-widget-content" align="center" id="BLOCK_IP_K_TLY_<?php echo $k;?>"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_CFY']['KHARIF']+$v['ACHIEVEMENT_IP_TLY']['KHARIF']));?></td>
      </tr>
      <tr>
        <td ><strong>Rabi</strong></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ESTIMATION_IP']['RABI'];?></td>
         <td class="ui-widget-content" align="center">
        	<input type="text" name="BLOCK_IP_R[<?php echo $k;?>]" id="BLOCK_IP_R_<?php echo $k;?>" autocomplete="off"
				size="10" maxlength="15" class="centertext" <?php echo $keyup;?> value="<?php echo $v['CUR_MONTH_IP']['RABI'];?>" />
		</td>
        <td class="ui-widget-content" align="center"><?php echo $v['PREV_MONTH_IP']['RABI'];?></td>
        <td class="ui-widget-content" align="center" id="BLOCK_IP_R_CFY_<?php echo $k;?>"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['RABI']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['RABI'];?></td>
        <td class="ui-widget-content" align="center" id="BLOCK_IP_R_TLY_<?php echo $k;?>"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_CFY']['RABI']+$v['ACHIEVEMENT_IP_TLY']['RABI']));?></td>
      </tr>
      <tr>
        <td class="ui-state-default" ><strong>Total</strong></td>
        <td class="ui-state-default" align="center"><?php echo $v['ESTIMATION_IP']['IP'];?></td>
        <td class="ui-state-default" align="center" id="BLOCK_IP_T_<?php echo $k;?>"><?php echo (($isBlank)?'':$v['CUR_MONTH_IP']['IP']);?></td>
        <td class="ui-state-default" align="center"><?php echo $v['PREV_MONTH_IP']['IP'];?></td>
        <td class="ui-state-default" align="center" id="BLOCK_IP_T_CFY_<?php echo $k;?>"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['IP']);?></td>
        <td class="ui-state-default" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['IP'];?></td>
        <td class="ui-state-default" align="center" id="BLOCK_IP_T_TLY_<?php echo $k;?>"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_TLY']['IP']+$v['ACHIEVEMENT_IP_CFY']['IP']));?></td>
      </tr>
  <?php } ?>
    <tr>
      <td class="ui-state-default" colspan="4" rowspan="3">Total Irrigation Potential Created</td>
      <td><strong>Kharif</strong></td>
      <td class="ui-widget-content" align="center" id="IP_ESTI_K"><?php echo $arrTotal['KHARIF']['ESTIMATION'];?></td>
      <td class="ui-widget-content" align="center" id="IP_CUR_MONTH_K"><?php echo $arrTotal['KHARIF']['CURRENT_MONTH'];?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['KHARIF']['PREV_MONTH'];?></td>
      <td class="ui-widget-content" align="center" id="IP_CFY_K"><?php echo $arrTotal['KHARIF']['CFY'];?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['KHARIF']['TLY'];?></td>
      <td class="ui-widget-content" align="center" id="IP_TOTAL_K"><?php echo $arrTotal['KHARIF']['TOTAL'];?></td>
    </tr>
    <tr>
      <td ><strong>Rabi</strong></td>
      <td class="ui-widget-content" align="center" id="IP_ESTI_R"><?php echo $arrTotal['RABI']['ESTIMATION'];?></td>
      <td class="ui-widget-content" align="center" id="IP_CUR_MONTH_R"><?php echo $arrTotal['RABI']['CURRENT_MONTH'];?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['RABI']['PREV_MONTH'];?></td>
      <td class="ui-widget-content" align="center" id="IP_CFY_R"><?php echo $arrTotal['RABI']['CFY'];?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['RABI']['TLY'];?></td>
      <td class="ui-widget-content" align="center" id="IP_TOTAL_R"><?php echo $arrTotal['RABI']['TOTAL'];?></td>
    </tr>
    <tr>
      <td class="ui-state-default" ><strong>Total</strong></td>
      <td class="ui-state-default" align="center"><?php echo $arrTotal['TOTAL']['ESTIMATION'];?></td>
      <td class="ui-state-default" align="center" id="IP_CUR_MONTH_T"><?php echo $arrTotal['TOTAL']['CURRENT_MONTH'];?></td>
      <td class="ui-state-default" align="center"><?php echo $arrTotal['TOTAL']['PREV_MONTH'];?></td>
      <td class="ui-state-default" align="center" id="IP_CFY_T"><?php echo $arrTotal['TOTAL']['CFY'];?></td>
      <td class="ui-state-default" align="center"><?php echo $arrTotal['TOTAL']['TLY'];?></td>
      <td class="ui-state-default" align="center" id="IP_TOTAL_T"><?php echo $arrTotal['TOTAL']['TOTAL'];?></td>
    </tr>

        <tr>
        <td class="ui-widget-content" align="center"><strong>11</strong></td>
        <td class="ui-widget-content" colspan="3"><strong>Irrigation Potential To be Restored</strong></td>
        <td class="ui-widget-content"><strong>Hectares</strong></td>
        <td colspan="6" align="center" class="ui-widget-content"></td>
      </tr>
       <?php 
    //showArrayValues($arrBlockDataRestored);  
    //arrBlockDataRestored   
    //foreach($arrMonthly as $arrM){

       /*
       old var 
       1. arrMonthlyBlockData   :          arrMonthlyRestoreBlockData  
       2. arrBenefitedBlocks    :          arrBenefitedRestoredBlocks

       */

          /*
       old var 
       1. arrMonthlyRestoreBlockData    
       */

    $arrMonthlyRestoreBlockData = array();
    $iBCount = 97;
    $arrTotalTemp = array('ESTIMATION'=>0, 'CURRENT_MONTH'=>0, 'PREV_MONTH'=>0, 'CFY'=>0, 'TLY'=>0, 'TOTAL'=>0);
    $arrTotal = array('KHARIF_RESTORED' => $arrTotalTemp, 'RABI_RESTORED' => $arrTotalTemp, 'TOTAL' => $arrTotalTemp);
    $arrBenefitedRestoredBlocks = array();
    foreach($arrBlockDataRestored as $k=>$v){
        array_push($arrBenefitedRestoredBlocks, $k);
        
$s = $k.": {
            'KHARIF_RESTORED':{'ESTI':".(($v['ESTIMATION_IP']['KHARIF_RESTORED'])?$v['ESTIMATION_IP']['KHARIF_RESTORED']:0).", 'CFY':".$v['ACHIEVEMENT_IP_CFY']['KHARIF_RESTORED'].", 'TLY':".$v['ACHIEVEMENT_IP_TLY']['KHARIF_RESTORED']."}, 
            'RABI_RESTORED':{'ESTI':".(($v['ESTIMATION_IP']['RABI_RESTORED'])?$v['ESTIMATION_IP']['KHARIF']:0).", 'CFY':".$v['ACHIEVEMENT_IP_CFY']['RABI_RESTORED'].", 'TLY':".$v['ACHIEVEMENT_IP_TLY']['RABI_RESTORED']."}, 
            'TOTAL':{'ESTI':".(($v['ESTIMATION_IP']['IP'])?$v['ESTIMATION_IP']['IP']:0).", 'CFY':".$v['ACHIEVEMENT_IP_CFY']['IP'].", 'TLY':".$v['ACHIEVEMENT_IP_TLY']['IP']."} 
            }";
//RABI

        array_push($arrMonthlyRestoreBlockData, $s);
        //RABI
        $keyup = ' onkeyup="calculateSubRestoredIrri('.$k.')" ';
        $arrTotal['KHARIF_RESTORED']['ESTIMATION']+= $v['ESTIMATION_IP']['KHARIF_RESTORED'];
        $arrTotal['KHARIF_RESTORED']['CURRENT_MONTH']+= $v['CUR_MONTH_IP']['KHARIF_RESTORED'];
        $arrTotal['KHARIF_RESTORED']['PREV_MONTH']+= $v['PREV_MONTH_IP']['KHARIF_RESTORED'];
        $arrTotal['KHARIF_RESTORED']['CFY']+= $v['ACHIEVEMENT_IP_CFY']['KHARIF_RESTORED'];
        $arrTotal['KHARIF_RESTORED']['TLY']+= $v['ACHIEVEMENT_IP_TLY']['KHARIF_RESTORED'];
        $arrTotal['KHARIF_RESTORED']['TOTAL']+= ($v['ACHIEVEMENT_IP_CFY']['KHARIF_RESTORED']+$v['ACHIEVEMENT_IP_TLY']['KHARIF_RESTORED']);

          $arrTotal['RABI_RESTORED']['ESTIMATION']+= $v['ESTIMATION_IP']['RABI_RESTORED'];
          $arrTotal['RABI_RESTORED']['CURRENT_MONTH']+= $v['CUR_MONTH_IP']['RABI_RESTORED'];
          $arrTotal['RABI_RESTORED']['PREV_MONTH']+= $v['PREV_MONTH_IP']['RABI_RESTORED'];
          $arrTotal['RABI_RESTORED']['CFY']+= $v['ACHIEVEMENT_IP_CFY']['RABI_RESTORED'];
          $arrTotal['RABI_RESTORED']['TLY']+= $v['ACHIEVEMENT_IP_TLY']['RABI_RESTORED'];
          $arrTotal['RABI_RESTORED']['TOTAL']+= ($v['ACHIEVEMENT_IP_CFY']['RABI_RESTORED']+$v['ACHIEVEMENT_IP_TLY']['RABI_RESTORED']);

          $arrTotal['TOTAL']['ESTIMATION']+= $v['ESTIMATION_IP']['RESTORED_IP'];
          $arrTotal['TOTAL']['CURRENT_MONTH']+= $v['CUR_MONTH_IP']['RESTORED_IP'];
          $arrTotal['TOTAL']['PREV_MONTH']+= $v['PREV_MONTH_IP']['RESTORED_IP']; 
          $arrTotal['TOTAL']['CFY']+= $v['ACHIEVEMENT_IP_CFY']['RESTORED_IP'];
          $arrTotal['TOTAL']['TLY']+= $v['ACHIEVEMENT_IP_TLY']['RESTORED_IP'];
          $arrTotal['TOTAL']['TOTAL']+= ($v['ACHIEVEMENT_IP_CFY']['RESTORED_IP']+$v['ACHIEVEMENT_IP_TLY']['RESTORED_IP']);

           array_push($arrForValidation, "'BLOCK_IP_K[$k]':{required : true, digits:true,min:0,  checkMyDigit:''}");
        array_push($arrForValidationMessage, "'BLOCK_IP_K[$k]':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', digits:'Numeric', min:'Min Value 0'}");
         array_push($arrForValidation, "'BLOCK_IP_R[$k]':{required : true, digits:true,min:0,  checkMyDigit:''}");
        array_push($arrForValidationMessage, "'BLOCK_IP_R[$k]':{required : 'आंकड़े प्रविष्ट करना अनिवार्य है...', digits:'Numeric', min:'Min Value 0'}");
      ?>
      <tr>
        <td class="ui-widget-content" align="center" rowspan="3"><?php echo chr($iBCount++); ?></td>
        <td class="ui-widget-content" rowspan="3" colspan="3"><?php echo $v['BLOCK_NAME']; ?></td>
        <td><strong>Kharif</strong></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ESTIMATION_IP']['KHARIF_RESTORED'];?></td>
        <td class="ui-widget-content" align="center">
            <input type="text" name="BLOCK_IP_K[<?php echo $k;?>]" id="BLOCK_IP_K_<?php echo $k;?>" autocomplete="off"
                size="10" maxlength="15" class="centertext" <?php echo $keyup;?> value="<?php echo $v['CUR_MONTH_IP']['KHARIF_RESTORED'];?>" />
        </td>
        <td class="ui-widget-content" align="center"><?php echo $v['PREV_MONTH_IP']['KHARIF_RESTORED'];?></td>
        <td class="ui-widget-content" align="center" id="BLOCK_IP_K_CFY_<?php echo $k;?>"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['KHARIF_RESTORED']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['KHARIF_RESTORED'];?></td>
        <td class="ui-widget-content" align="center" id="BLOCK_IP_K_TLY_<?php echo $k;?>"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_CFY']['KHARIF_RESTORED']+$v['ACHIEVEMENT_IP_TLY']['KHARIF_RESTORED']));?></td>
      </tr>
      <tr>
        <td ><strong>Rabi</strong></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ESTIMATION_IP']['RABI_RESTORED'];?></td>
         <td class="ui-widget-content" align="center">
            <input type="text" name="BLOCK_IP_R[<?php echo $k;?>]" id="BLOCK_IP_R_<?php echo $k;?>" autocomplete="off"
                size="10" maxlength="15" class="centertext" <?php echo $keyup;?> value="<?php echo $v['CUR_MONTH_IP']['RABI_RESTORED'];?>" />
        </td>
        <td class="ui-widget-content" align="center"><?php echo $v['PREV_MONTH_IP']['RABI_RESTORED'];?></td>
        <td class="ui-widget-content" align="center" id="BLOCK_IP_R_CFY_<?php echo $k;?>"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['RABI_RESTORED']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['RABI_RESTORED'];?></td>
        <td class="ui-widget-content" align="center" id="BLOCK_IP_R_TLY_<?php echo $k;?>"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_CFY']['RABI_RESTORED']+$v['ACHIEVEMENT_IP_TLY']['RABI_RESTORED']));?></td>
      </tr>
      <tr>
        <td class="ui-state-default" ><strong>Total</strong></td>
        <td class="ui-state-default" align="center"><?php echo $v['ESTIMATION_IP']['RESTORED_IP'];?></td>
        <td class="ui-state-default" align="center" id="BLOCK_IP_T_<?php echo $k;?>"><?php echo (($isBlank)?'':$v['CUR_MONTH_IP']['RESTORED_IP']);?></td>
        <td class="ui-state-default" align="center"><?php echo $v['PREV_MONTH_IP']['KHARIF_RESTORED'];;?></td>
        <td class="ui-state-default" align="center" id="BLOCK_IP_T_CFY_<?php echo $k;?>"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['RESTORED_IP']);?></td>
        <td class="ui-state-default" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['RESTORED_IP'];?></td>
        <td class="ui-state-default" align="center" id="BLOCK_IP_T_TLY_<?php echo $k;?>"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_TLY']['RESTORED_IP']+$v['ACHIEVEMENT_IP_CFY']['RESTORED_IP']));?></td>
      </tr>
  <?php } ?>
    <tr>
      <td class="ui-state-default" colspan="4" rowspan="3">Total Irrigation Potential Created</td>
      <td><strong>Kharif</strong></td>
      <td class="ui-widget-content" align="center" id="IP_ESTI_RESTORED_K"><?php echo $arrTotal['KHARIF_RESTORED']['ESTIMATION'];?></td>
      <td class="ui-widget-content" align="center" id="IP_CUR_MONTH_RESTORED_K"><?php echo $arrTotal['KHARIF_RESTORED']['CURRENT_MONTH'];?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['KHARIF_RESTORED']['PREV_MONTH'];?></td>
      <td class="ui-widget-content" align="center" id="IP_CFY_RESTORED_K"><?php echo $arrTotal['KHARIF_RESTORED']['CFY'];?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['KHARIF_RESTORED']['TLY'];?></td>
      <td class="ui-widget-content" align="center" id="IP_TOTAL_RESTORED_K"><?php echo $arrTotal['KHARIF_RESTORED']['TOTAL'];?></td>
    </tr>
    <tr>
      <td ><strong>Rabi</strong></td>  
      <td class="ui-widget-content" align="center" id="IP_ESTI_RESTORED_R"><?php echo $arrTotal['RABI_RESTORED']['ESTIMATION'];?></td>
      <td class="ui-widget-content" align="center" id="IP_CUR_MONTH_RESTORED_R"><?php echo $arrTotal['RABI_RESTORED']['CURRENT_MONTH'];?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['RABI_RESTORED']['PREV_MONTH'];?></td>
      <td class="ui-widget-content" align="center" id="IP_CFY_RESTORED_R"><?php echo $arrTotal['RABI_RESTORED']['CFY'];?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['RABI_RESTORED']['TLY'];?></td>
      <td class="ui-widget-content" align="center" id="IP_TOTAL_RESTORED_R"><?php echo $arrTotal['RABI_RESTORED']['TOTAL'];?></td>
    </tr>
    <tr>
      <td class="ui-state-default" ><strong>Total</strong></td>
      <td class="ui-state-default" align="center"><?php echo $arrTotal['TOTAL']['ESTIMATION'];?></td>
      <td class="ui-state-default" align="center" id="IP_CUR_MONTH_RESTORED_T"><?php echo $arrTotal['TOTAL']['CURRENT_MONTH'];?></td>
      <td class="ui-state-default" align="center"><?php echo $arrTotal['TOTAL']['PREV_MONTH'];?></td>
      <td class="ui-state-default" align="center" id="IP_CFY_RESTORED_T"><?php echo $arrTotal['TOTAL']['CFY'];?></td>
      <td class="ui-state-default" align="center"><?php echo $arrTotal['TOTAL']['TLY'];?></td>
      <td class="ui-state-default" align="center" id="IP_TOTAL_RESTORED_T"><?php echo $arrTotal['TOTAL']['TOTAL'];?></td>
    </tr>
  <?php 
 // exit;
  //} 
?>
  </tbody>
</table>

<!-- FIXED FORMAT END -->
<?php
$arrF = array(
	'LA_CASES_STATUS',  'SPILLWAY_WEIR_STATUS', 'FLANKS_AF_BUNDS_STATUS', 'SLUICE_STATUS',
	'NALLA_CLOSER_STATUS','CANAL_EW_STATUS', 'CANAL_STRUCTURE_STATUS', 'CANAL_LINING_STATUS'
);
$arrComponentStatus = $arrComponentsIncluded = array();
$arrShow = array();
foreach($arrF as $f){
	if($isCurrentMonthExists){
		if($arrCurrentMonthData[$f]==0){
			 $arrComponentStatus[$f] = 0;//$prevMonthStatus[$f];
		}else if($prevMonthStatus[$f]==1 || $prevMonthStatus[$f]==0){
			$arrComponentStatus[$f] = 1;//'NA';
		}else{
			if($arrCurrentMonthData[$f]==1){
				if($prevMonthStatus[$f]>1)
					$arrComponentStatus[$f] = $prevMonthStatus[$f];
				else
					$arrComponentStatus[$f] = 1;
			}else{
				$arrComponentStatus[$f] = $arrCurrentMonthData[$f];
			}
		}
	}else{
		//if($prevMonthStatus[$f]==5 || $prevMonthStatus[$f]==1  || $prevMonthStatus[$f]==0){
		if($prevMonthStatus[$f]==1  || $prevMonthStatus[$f]==0){
			$arrComponentStatus[$f] = 1;//'NA';
		}else{
			$arrComponentStatus[$f] = 0;// $prevMonthStatus[$f];
		}
	}
	if($arrComponentStatus[$f]==1){
		$arrShow[$f] = FALSE;
	}else{
		if($prevMonthStatus[$f]==5 || $prevMonthStatus[$f]==1){
			$arrShow[$f] = FALSE;
		}else{
			$arrShow[$f] = TRUE;
		}
	}
	if($arrShow[$f]==FALSE){
		if(!$isCurrentMonthExists){
			$arrComponentStatus[$f] = 0;
		}
	}
	if($arrShow[$f])
		array_push($arrComponentsIncluded, $f);
}
//showArrayValues($arrComponentStatus);
$arrRemarkShow = array();
//$status_options = 0 1'NA', 2'Not Started', 3'Ongoing', 4'Stopped', 5'Completed', 6'Dropped'
foreach($arrF as $f){
	$arrRemarkShow[$f] = 0;
	if($isCurrentMonthExists){
		if(	$arrComponentStatus[$f]==2 || 
			$arrComponentStatus[$f]==4 ){
				$arrRemarkShow[$f] = 1;
		}else{
			$arrRemarkShow[$f] = 0;
		}
		//2-not started 4-stopped
		/*if( ($arrCurrentMonthData[$arrF[$i]]==2) || ($arrCurrentMonthData[$arrF[$i]]==4) ){
			if($prevMonthStatus[$arrF[$i]]==1){
				$arrRemarkShow[$arrF[$i]] = 0;
			}else{
				$arrRemarkShow[$arrF[$i]] = 1;
			}
		}*/
	}else{
		//if($prevMonthStatus){
		//if( ($prevMonthStatus[$arrF[$i]]==2) || ($prevMonthStatus[$arrF[$i]]==4) )
			$arrRemarkShow[$f] = 0;
	}
}

/////////////////////// [ see below to delete ]
if($PROJECT_SETUP_ID==0){
	showArrayValues($arrRemarkShow);
	showArrayValues($arrComponentStatus);
}
$i=0;
$arrHideRemarks = array(2,4);
?>
<div class="wrdlinebreak"></div>
<table width="100%" border="0" cellpadding="6" cellspacing="1" class="ui-widget-content">
<tr>
    <td rowspan="2" width="33%" class="ui-state-default">2] Status of Milestone</td>
    <td colspan="2" width="33%" align="center" class="ui-state-default"><strong>Status</strong></td>
    <td rowspan="2" width="33%" align="center" class="ui-state-default"><strong>Remarks</strong></td>
</tr>
<tr>
  <td align="center" class="ui-state-default">Previous Month</td>
  <td align="center" class="ui-state-default">Current Month</td>
</tr>
<?php if($arrShow['LA_CASES_STATUS']){?>
<tr>
    <td class="ui-widget-content"><strong>a. Submission of LA Cases</strong></td>
    <td class="ui-widget-content" align="center"><?php echo $status_options[$prevMonthStatus['LA_CASES_STATUS']]?></td>
    <td class="ui-widget-content" align="center">
	<select name="LA_CASES_STATUS" id="LA_CASES_STATUS" style="width:150px" class="mysel2" 
    	onchange="setComponentStatus(this.name)" >
        <?php echo getWorkStatusOptions(1, $arrComponentStatus['LA_CASES_STATUS'], $prevMonthStatus['LA_CASES_STATUS']);?>
	</select>
	<?php //echo $arrComponentStatus['LA_CASES_STATUS'];?>
    </td>
        <td class="ui-widget-content" align="center">
        <div id="LA_CASES_STATUSremarkDiv" style="display:<?php echo (in_array($arrComponentStatus['LA_CASES_STATUS'], $arrHideRemarks))?'block':'none';?>">
        <textarea id="LA_CASES_STATUS_REMARK" name="LA_CASES_STATUS_REMARK" cols="35" 
            rows="2"><?php echo $monthly_remarks['LA_CASES_STATUS_REMARK'];?></textarea>
        </div>
	</td>
</tr>
<?php }else{
	?>
<tr>
    <td class="ui-widget-content"><strong>a. Submission of LA Cases</strong></td>
    <td class="ui-state-dim" align="center" colspan="3">NA</td>
</tr>
<?php }?>
<?php if($arrShow['SPILLWAY_WEIR_STATUS']){?>
<tr>
    <td class="ui-widget-content"><strong>b. Spillway / weir </strong></td>
    <td class="ui-widget-content" align="center"><?php echo $status_options[$prevMonthStatus['SPILLWAY_WEIR_STATUS']]?></td>
    <td class="ui-widget-content" align="center">
	<select name="SPILLWAY_WEIR_STATUS" id="SPILLWAY_WEIR_STATUS" style="width:150px" class="mysel2" 
    	onchange="setComponentStatus(this.name)" >
        <?php echo getWorkStatusOptions(1, $arrComponentStatus['SPILLWAY_WEIR_STATUS'], $prevMonthStatus['SPILLWAY_WEIR_STATUS']);?>
	</select>
	<?php //echo $arrComponentStatus['LA_CASES_STATUS'];?>
    </td>
    <td class="ui-widget-content" align="center">
        <div id="SPILLWAY_WEIR_STATUSremarkDiv" style="display:<?php echo (in_array($arrComponentStatus['SPILLWAY_WEIR_STATUS'], $arrHideRemarks))? 'block':'none';?>">
        <textarea id="SPILLWAY_WEIR_STATUS_REMARK" name="SPILLWAY_WEIR_STATUS_REMARK" cols="35" 
            rows="2"><?php echo $monthly_remarks['SPILLWAY_WEIR_STATUS_REMARK'];?></textarea>
        </div>
	</td>
</tr>
<?php }else{?>
<tr>
    <td class="ui-widget-content"><strong>b. Spillway / weir </strong></td>
    <td class="ui-state-dim" align="center" colspan="3">NA</td>
</tr>
<?php }?>
<?php if($arrShow['FLANKS_AF_BUNDS_STATUS']){?>
<tr>
    <td class="ui-widget-content"><strong>c. Flanks /Af. bunds</strong></td>
    <td class="ui-widget-content" align="center"><?php echo $status_options[$prevMonthStatus['FLANKS_AF_BUNDS_STATUS']];?></td>
    <td class="ui-widget-content" align="center">
	<select name="FLANKS_AF_BUNDS_STATUS" id="FLANKS_AF_BUNDS_STATUS" style="width:150px" class="mysel2" 
    	onchange="setComponentStatus(this.name)" >
        <?php echo getWorkStatusOptions(1, $arrComponentStatus['FLANKS_AF_BUNDS_STATUS'], $prevMonthStatus['FLANKS_AF_BUNDS_STATUS']);?>
	</select>
	<?php //echo $arrComponentStatus['LA_CASES_STATUS'];?>
    </td>
    <td class="ui-widget-content" align="center">
        <div id="FLANKS_AF_BUNDS_STATUSremarkDiv" style="display:<?php echo (in_array($arrComponentStatus['FLANKS_AF_BUNDS_STATUS'], $arrHideRemarks))? 'block':'none';?>">
        <textarea id="FLANKS_AF_BUNDS_STATUS_REMARK" name="FLANKS_AF_BUNDS_STATUS_REMARK" cols="35" 
            rows="2"><?php echo $monthly_remarks['FLANKS_AF_BUNDS_STATUS_REMARK'];?></textarea>
        </div>
	</td>
</tr>
<?php }else{?>
<tr>
    <td class="ui-widget-content"><strong>c. Flanks /Af. bunds</strong></td>
    <td class="ui-state-dim" align="center" colspan="3">NA</td>
</tr>
<?php }?>
<?php if($arrShow['SLUICE_STATUS']){?>
<tr>
    <td class="ui-widget-content"><strong>d.    Sluice/s</strong></td>
    <td class="ui-widget-content" align="center"><?php echo $status_options[$prevMonthStatus['SLUICE_STATUS']];?></td>
    <td class="ui-widget-content" align="center">
	<select name="SLUICE_STATUS" id="SLUICE_STATUS" style="width:150px" class="mysel2" 
    	onchange="setComponentStatus(this.name)" >
        <?php echo getWorkStatusOptions(1, $arrComponentStatus['SLUICE_STATUS'], $prevMonthStatus['SLUICE_STATUS']);?>
	</select>
	<?php //echo $arrComponentStatus['LA_CASES_STATUS'];?>
    </td>
    <td class="ui-widget-content" align="center">
        <div id="SLUICE_STATUSremarkDiv" style="display:<?php echo (in_array($arrComponentStatus['SLUICE_STATUS'], $arrHideRemarks))?'block':'none';?>">
        <textarea id="SLUICE_STATUS_REMARK" name="SLUICE_STATUS_REMARK" cols="35" 
            rows="2"><?php echo $monthly_remarks['SLUICE_STATUS_REMARK'];?></textarea>
        </div>
	</td>
</tr>
<?php }else{?>
<tr>
    <td class="ui-widget-content"><strong>d.    Sluice/s</strong></td>
    <td class="ui-state-dim" align="center" colspan="3">NA</td>
</tr>
<?php }?>
<?php if($arrShow['NALLA_CLOSER_STATUS']){?>
<tr>
    <td class="ui-widget-content"><strong>e. Nalla Closer</strong></td>
    <td class="ui-widget-content" align="center"><?php echo $status_options[$prevMonthStatus['NALLA_CLOSER_STATUS']];?></td>
    <td class="ui-widget-content" align="center">
	<select name="NALLA_CLOSER_STATUS" id="NALLA_CLOSER_STATUS" style="width:150px" class="mysel2" 
    	onchange="setComponentStatus(this.name)" >
        <?php echo getWorkStatusOptions(1, $arrComponentStatus['NALLA_CLOSER_STATUS'], $prevMonthStatus['NALLA_CLOSER_STATUS']);?>
	</select>
	<?php //echo $arrComponentStatus['LA_CASES_STATUS'];?>
    </td>
    <td class="ui-widget-content" align="center">
        <div id="NALLA_CLOSER_STATUSremarkDiv" style="display:<?php echo (in_array($arrComponentStatus['NALLA_CLOSER_STATUS'], $arrHideRemarks))? 'block':'none';?>">
        <textarea id="NALLA_CLOSER_STATUS_REMARK" name="NALLA_CLOSER_STATUS_REMARK" cols="35" 
            rows="2"><?php echo $monthly_remarks['NALLA_CLOSER_STATUS_REMARK'];?></textarea>
        </div>
	</td>
</tr>
<?php }else{?>
<tr>
    <td class="ui-widget-content"><strong>e. Nalla Closer</strong></td>
    <td class="ui-state-dim" align="center" colspan="3">NA</td>
</tr>
<?php }?>
<?php if($arrShow['CANAL_EW_STATUS']){?>
<tr>
    <td class="ui-widget-content"><strong>f. Canal E/W</strong></td>
    <td class="ui-widget-content" align="center"><?php echo $status_options[$prevMonthStatus['CANAL_EW_STATUS']];?></td>
    <td class="ui-widget-content" align="center">
	<select name="CANAL_EW_STATUS" id="CANAL_EW_STATUS" style="width:150px" class="mysel2" 
    	onchange="setComponentStatus(this.name)" >
        <?php echo getWorkStatusOptions(1, $arrComponentStatus['CANAL_EW_STATUS'], $prevMonthStatus['CANAL_EW_STATUS']);?>
	</select>
	<?php //echo $arrComponentStatus['LA_CASES_STATUS'];?>
    </td>
    <td class="ui-widget-content" align="center">
        <div id="CANAL_EW_STATUSremarkDiv" style="display:<?php echo (in_array($arrComponentStatus['CANAL_EW_STATUS'], $arrHideRemarks))?'block':'none';?>">
        <textarea id="CANAL_EW_STATUS_REMARK" name="CANAL_EW_STATUS_REMARK" cols="35" 
            rows="2"><?php echo $monthly_remarks['CANAL_EW_STATUS_REMARK'];?></textarea>
        </div>
	</td>
</tr>
<?php }else{?>
<tr>
    <td class="ui-widget-content"><strong>f. Canal E/W</strong></td>
    <td class="ui-state-dim" align="center" colspan="3">NA</td>
</tr>
<?php }?>
<?php if($arrShow['CANAL_STRUCTURE_STATUS']){?>
<tr>
    <td class="ui-widget-content"><strong>g. Canal Structure</strong></td>
    <td class="ui-widget-content" align="center"><?php echo $status_options[$prevMonthStatus['CANAL_STRUCTURE_STATUS']];?></td>
    <td class="ui-widget-content" align="center">
	<select name="CANAL_STRUCTURE_STATUS" id="CANAL_STRUCTURE_STATUS" style="width:150px" class="mysel2" 
    	onchange="setComponentStatus(this.name)" >
        <?php echo getWorkStatusOptions(1, $arrComponentStatus['CANAL_STRUCTURE_STATUS'], $prevMonthStatus['CANAL_STRUCTURE_STATUS']);?>
	</select>
	<?php //echo $arrComponentStatus['LA_CASES_STATUS'];?>
    </td>
    <td class="ui-widget-content" align="center">
        <div id="CANAL_STRUCTURE_STATUSremarkDiv" style="display:<?php echo (in_array($arrComponentStatus['CANAL_STRUCTURE_STATUS'], $arrHideRemarks))?'block':'none';?>">
        <textarea id="CANAL_STRUCTURE_STATUS_REMARK" name="CANAL_STRUCTURE_STATUS_REMARK" cols="35" 
            rows="2"><?php echo $monthly_remarks['CANAL_STRUCTURE_STATUS_REMARK'];?></textarea>
        </div>
	</td>
</tr>
<?php }else{?>
<tr>
    <td class="ui-widget-content"><strong>g. Canal Structure</strong></td>
    <td class="ui-state-dim" align="center" colspan="3">NA</td>
</tr>
<?php }?>
<?php if($arrShow['CANAL_LINING_STATUS']){?>
<tr>
    <td class="ui-widget-content"><strong>h. Canal Lining</strong></td>
    <td class="ui-widget-content" align="center"><?php echo $status_options[$prevMonthStatus['CANAL_LINING_STATUS']];?></td>
    <td class="ui-widget-content" align="center">
	<select name="CANAL_LINING_STATUS" id="CANAL_LINING_STATUS" style="width:150px" class="mysel2" 
    	onchange="setComponentStatus(this.name)" >
        <?php echo getWorkStatusOptions(1, $arrComponentStatus['CANAL_LINING_STATUS'], $prevMonthStatus['CANAL_LINING_STATUS']);?>
	</select>
	<?php //echo $arrComponentStatus['LA_CASES_STATUS'];?>
    </td>
    <td class="ui-widget-content" align="center">
        <div id="CANAL_LINING_STATUSremarkDiv" style="display:<?php echo (in_array($arrComponentStatus['CANAL_LINING_STATUS'], $arrHideRemarks))? 'block':'none';?>">
        <textarea id="CANAL_LINING_STATUS_REMARK" name="WATER_STORAGE_TANK_STATUS_REMARK" cols="35" 
            rows="2"><?php echo $monthly_remarks['CANAL_LINING_STATUS_REMARK'];?></textarea>
        </div>
	</td>
</tr>
<?php }else{?>
<tr>
    <td class="ui-widget-content"><strong>h. Canal Lining</strong></td>
    <td class="ui-state-dim" align="center" colspan="3">NA</td>
</tr>
<?php }?> 
</table>
</form>
<div id="mySaveMonthlyDiv" align="right" class="mysavebar">
<?php echo $buttons;?>
</div>
</div>
</div>
<script language="javascript">
//
var arrMonthlyData = {<?php echo implode(',', $arrMonthlyData);?>};
var arrMonthlyBlockData = {<?php echo implode(',', $arrMonthlyBlockData);?>};
var arrMonthlyRestoreBlockData={<?php echo implode(',', $arrMonthlyRestoreBlockData);?>};
var arrEstimationDataJs={<?php echo implode(',', $arrEstimationDataJS); ?>}
function getMyValue(id, mode){
	var num1 = parseFloat( $('#' + id).val() );
	return ((isNaN(num1))?0:num1);
}

//
var validator;
var arrBenefitedBlocks = new Array();
var arrBenefitedRestoredBlocks=new Array();
$().ready(function(){

 
   


$.validator.addMethod('myLess1', function(value, element, param) {
    var m_id = new String(element.id);

    var estifield="";
    if(m_id == 'BLOCK_IP_K[92]'){
        estifield = "BLOCK_IP_E_K[92]";
    } 
    //$('#divtest').html(m_id+" : "); 
    //$('#divtest').append(estifield+"::");
    var estival = $('#' + estifield).val();
    var e = checkNo(estival);
    var a = checkNo(value);
    
    //$('#divtest').append(estival+"::");
    return this.optional(element) || ((a<=e) ? true:false);
    //return this.optional(element) || value <= $(param).val();
}, function(params, element) {     
    var m_id = new String(element.id);
    //$('#divtest').append(m_id+" : z : ");
    var estifield="";
    if(m_id == 'BLOCK_IP_K[92]'){
        estifield = "BLOCK_IP_E_K[92]";
    } 
   
    var estival = $('#' + estifield).val();
    //$('#divtest').html(m_id+"fg");
    
    //$('#divtest').html( $(params).val() +"gg");
    var achVal = element.value;// $(m_id).val();
    var e = checkNo(estival);
    var a = checkNo(achVal);
    //$('#divtest').append(estival+" : y : " + achVal + " : u ");
    if(a<=e)
        return "";
    else
      return 'Max Limit : ' + estival;
});

	$(".mysel2").select2();
	$('#COMPLETION_DATE').attr("placeholder", "dd-mm-yyyy").datepicker({ 
		dateFormat:'dd-mm-yy', changeMonth:true, changeYear:true, showOtherMonths: true,
		beforeShow: function(input, inst) {	return setMinMaxDate('#START_MONTH_DATE', '#END_MONTH_DATE'); }
	});
	
	//setSelect2();//always use this for validation Engine
	window.validator = 
		$("#frmMonthly").validate({
			rules: {
				<?php if(count($arrForValidation)){
					echo implode(",\n", $arrForValidation);
				}?>
			},
			messages: {
				<?php if(count($arrForValidationMessage )){
					echo implode(',', $arrForValidationMessage);
				}?>
			}
		});
	<?php
	echo 'window.arrBenefitedBlocks = ['.implode(',', $arrBenefitedBlocks).'];';
    echo 'window.arrBenefitedRestoredBlocks = ['.implode(',', $arrBenefitedRestoredBlocks).'];';
    
	if($arrCurrentMonthData['WORK_STATUS']==5){
		echo '$("#COMPLETION_DATE").rules("add", "required");';
		echo '$("#WORK_STATUS_REMARK").rules("add", "required");';
	}
	foreach($arrRemarkShow as $k=>$v){
		if($v==1){
			echo '$("#'.$k.'_REMARK").rules("add", "required");';
		}
	}?>
	setProjectStatus(<?php echo $arrCurrentMonthData['WORK_STATUS'];?>);
	var $demoabs = $('#monthly_table');
	$demoabs.floatThead({
		scrollContainer: function($table){
			return $table.closest('.wrapper');
		}
	});
	
	//$( "#radioset" ).buttonset();
});
//

function setProjectStatus(pstatus){
<?php echo "var noOfComponents = ".count($arrComponentsIncluded).";\n";
echo "var chkCompoFields = new Array('". implode("', '", $arrComponentsIncluded)."');";?>
	//alert();
	var ps = parseInt($('#WORK_STATUS').val());
	$('#completionDiv').hide();
	$('#completionDiv1').hide();
	$("#COMPLETION_DATE").rules("remove", "required");
	//$('#remarkDiv').hide();
	$("#WORK_STATUS_REMARK").rules("remove", "required");
	$('#divRemarks').hide();
	$('#divStatus').hide();
	$('#divCompletionType').hide();
	var mEnableIt = false;
	switch(ps){
		case 0://not clear
			 mEnableIt = true;
			 break;
		case 1://NA
			//$('#completionDiv').hide();
			//$('#remarkDiv').hide();
			break;
		case 3://ongoing
			var arrDate = $('#ACTUAL_COMPLETION_DATE').val().split("-");
			var mYear = parseInt(arrDate[0]);
			var mMonth = parseInt(arrDate[1]);
			var mYearC = <?php echo date("Y", $MONTH_DATE);?>;
			var mMonthC = <?php echo date("n", $MONTH_DATE);?>;
			var mValid = true;
			if(mYearC==mYear && mMonthC>mMonth) 
				mValid = false;
			else if(mYearC>mYear)
				mValid = false;
			
			if(mValid){
				//$('#remarkDiv').hide();
				//alert(1);
				$("#WORK_STATUS_REMARK").rules("remove", "required");
			}else{
				//alert(2);
				$('#divRemarks').show();
				$('#remarkDiv').show();
				$("#WORK_STATUS_REMARK").rules("add", "required");
			}
			mEnableIt = true;
			break;
		case 4://stopped 
			$('#divRemarks').show();
			mEnableIt = true;
		case 2://not started
			$('#remarkDiv').show();
			$('#divRemarks').show();
			$("#WORK_STATUS_REMARK").rules("add", "required");
			$('#completionDiv').hide();
			$('#completionDiv1').hide();
			break;
		case 5://completed
			$('#remarkDiv').show();
			$('#divRemarks').show();
			$('#divStatus').show();
			$('#completionDiv').show();
			$('#completionDiv1').show();
			$('#completedDateCaption').html('Completion Date');
			$('#completedNoCaption').html('Completion Certificate No');
			$("#COMPLETION_DATE").rules("add", "required");
			$("#PROJECT_STATUS_DISPATCH_NO").rules("add", "required");
			$("#WORK_STATUS_REMARK").rules("add", "required");
			$('#divCompletionType').show();
			
			mEnableIt = true;
			checkCompletionOnSubmit();
			$('html, body').animate({scrollTop: $("#completionDiv1").offset().top}, 2000);
			//$("#WORK_STATUS_REMARK").rules("remove", "required");
			break;
		case 6://dropped
			mEnableIt = false;
			$('#divRemarks').show();
			$('#remarkDiv').show();
			$('#divStatus').show();
			$('#completedDateCaption').html('Dropped Date');
			$('#completedNoCaption').html('Dropped Memo No');
			$("#WORK_STATUS_REMARK").rules("add", "required");
			$('#completionDiv').show();
			$('#completionDiv1').show();
			$("#COMPLETION_DATE").rules("add", "required");
			$("#PROJECT_STATUS_DISPATCH_NO").rules("add", "required");
			$('html, body').animate({scrollTop: $("#completionDiv1").offset().top}, 1000);
			<?php foreach($arrDataFields as $arrDataField){
				echo '$("#'.$arrDataField.'" ).rules("remove", "required");'."\n";
				//disable control
				echo '$("#'. $arrDataField.'").prop("disabled", true);'."\n";
			}?>
			break;
	}
	if(noOfComponents>0){
		//alert('Complet:' + chkCompoFields.length + " " + chkCompoFields.join("#") );
		for(i=0;i<chkCompoFields.length;i++){
			//alert('cjk:' + chkCompoFields[i]);
			console.log('chk' + i + ':' + chkCompoFields[i]);
			$('#'+chkCompoFields[i]).select2("enable", mEnableIt);
			console.log('chk' + i + 'OK');
			/*if(ps==4){
				$('#'+chkCompoFields[i]).val(4);
				$('#'+chkCompoFields[i]).select2("val", 4);
				$('#'+chkCompoFields[i]).trigger("updatecomplete");
			}*/
		}
	}
}
function setComponentStatus(compo){
	var ps = parseInt($('#'+compo).val());
	//alert('cccc:' + compo + ' ps:' + ps);
	$('#'+ compo +'remarkDiv').hide();
	$("#" + compo + '_REMARK').rules("remove", "required");
	switch(ps){
		case 1://NA 
			break;
		case 2://not started
			$('#'+ compo +'remarkDiv').show();
			$("#" + compo + '_REMARK').rules("add", "required");
			break;
		case 3://ongoing
			break;
		case 4://stopped
			$('#'+ compo +'remarkDiv').show();
			$("#" + compo + '_REMARK').rules("add", "required");
			break;
		case 5://completed
			break;
	}
}
function checkCompletionOnSubmit(){
	var mfields = new Array('<?php echo implode("','", $arrDataFields);?>');
	var mEstimation = 0;
	var mCumulative = 0;
	for(i=0; i<mfields.length; i++){
		mEstimation = parseFloat( $('#'+ mfields[i] + '_E').val() );
		mCumulative = parseFloat( $('#'+ mfields[i] + '_T').val() );
		if(mEstimation==mCumulative) {
			return true;
		}else{
			$('#remarkDiv').show();
			$("#WORK_STATUS_REMARK").rules("add", "required");
			return false;
		}
	}
	return false;
}
//
function saveMonthly(){
	var selectList = new Array();
	//selectList.push( Array('WORK_STATUS', 'Select Project Status', true) );
	var ps = parseInt($('#WORK_STATUS').val());
	if(ps<6){
        <?php
        $arrComponents = array(
            'LA_CASES_STATUS'=>'Select LA Case Status',
            'SPILLWAY_WEIR_STATUS'=>'Select Spillway Case Status',
            'FLANKS_AF_BUNDS_STATUS'=>'Select Flanks af Bunds Status',
            'SLUICE_STATUS'=>'Select Sluice Status',
            'NALLA_CLOSER_STATUS'=>'Select Nalla Closer Status',
            'CANAL_EW_STATUS'=>'Select Canal Earthwork Status',
            'CANAL_STRUCTURE_STATUS'=>'Select Canal Structure Status',
            'CANAL_LINING_STATUS'=>'Select Canal Lining Status',           
        );
        $contCompo = '';
        $i=1;
        //print_r($arrComponentsIncluded);
        foreach($arrComponentsIncluded as $compo){
            $contCompo .= "selectList.push( Array('".$compo."', '".$arrComponents[$compo]."', true));\n";
            $i++;
        }
        echo $contCompo;
        ?>
	}else{
		<?php foreach($arrDataFields as $arrDataField){
			echo '$("#'.$arrDataField.'" ).rules("remove", "required");'."\n";
			//disable control
			echo '$("#'. $arrDataField.'").prop("disabled", true);'."\n";
		}?>
	}

	selectList.push( Array('WORK_STATUS', 'Select Work Status',true));
	console.log(selectList);
	var mSelect = validateMyCombo(selectList);
	var myValidation = $("#frmMonthly").valid();
	if( !(mSelect==0 && myValidation)){
		showAlert('Oops...', 'You have : ' + ( window.validator.numberOfInvalids() + mSelect ) + ' errors in this form.', 'error');
		return ;
	}
	if(myValidation){
		var ps = parseInt($('#WORK_STATUS').val());
		if(ps==5){
			//check component status
			<?php echo "var noOfComponents = ".count($arrComponentsIncluded).";\n";
			 echo "var chkCompoFields = new Array('". implode("', '", $arrComponentsIncluded)."');";?>
			var countNotCompleted = 0;
			for(i=0;i<chkCompoFields.length;i++){
				if( $('#'+chkCompoFields[i]).val()!=5){
					countNotCompleted++;
				}
			}
			if((countNotCompleted>0) && (noOfComponents>0)){
				showAlert('Oops...', 'Please Check Component Status...', 'error');
				return false;
			}
			if(!checkCompletionOnSubmit()){
				if ($('#remarkDiv').css('display') == 'none') {
					showAlert('Oops...', 'Achievement Data is not equals to Estimation Data...' +
					 "\n" + 'Please Enter Remarks given below the Completion Date', 'error');
					 return;
				}else{
					if ( $('#WORK_STATUS_REMARK').val()==""){
						showAlert('Oops...', 'Project Status Remark is blank', 'error');
						return;
					}
				}
			}
			var SelectedType = 0;
			SelectedType = (($('#radio1').is(':checked')) ? 1:0) ;
			if(SelectedType==0)
				SelectedType = (($('#radio2').is(':checked')) ? 2:0) ;
			if(SelectedType==0){
				showAlert('Oops...', 'Select Completion Type...', 'error');
				return;
			}else{
				var message = new Array();
				var iptK = checkNo($('#IP_TOTAL_K').val());
				var iptR = checkNo($('#IP_TOTAL_R').val());
				var ipeK = checkNo($('#IP_ESTI_K').val());
				var ipeR = checkNo($('#IP_ESTI_R').val());
				if((iptK!=ipeK) || (iptR!=ipeR)){
					message.push("Irrigation Potential Achieved is not equal to Estimation\n");
				}
				//alert('iptK:' + iptK + ' ipeK:' +ipeK + 'iptR:' + iptR + ' ipeR:' +ipeR);
				if(iptK!=ipeK)
					message.push("Kharif => Estimation : " + ipeK + " Total Achieved : " + iptK);
				if(iptR!=ipeR)
					message.push("Rabi => Estimation : " + ipeR + " Total Achieved : " + iptR);

				if(message.length!=0) {
					showAlert('Oops...', message.join("\n"), 'error');
					return;
				}
			}
			if(SelectedType==2){
				var lapayment = (($('#LA_PAYMENT').is(':checked')) ? 1:0) ;
				var fapayment = (($('#FA_PAYMENT').is(':checked')) ? 1:0) ;
				var capayment = (($('#CL_PAYMENT').is(':checked')) ? 1:0) ;
				if( (lapayment==0) &&  (fapayment==0) &&  (capayment==0) ){
					showAlert('Oops...', 'Select Reason...', 'error');
					return;
				}
			}
		}
       
		var params = {
			'divid':'mySaveMonthlyDiv', 
			'url':'saveMonthlyData', 
			'data':$('#frmMonthly').serialize(), 
			'donefname': 'doneMonthlyData', 
			'failfname' :'failMonthlyData', 
			'alwaysfname':''
		};
		callMyAjax(params);
	}else{
		showMyAlert('Error...', 'There is/are some Required Data... <br />Please Check & Complete it.', 'warn');
	}
}
function calculateIrri(ids){
	var kh = checkNo($('#IRRIGATION_POTENTIAL_KHARIF').val());
	var rab = checkNo($('#IRRIGATION_POTENTIAL_RABI').val());
	var tot = kh + rab;
	$('#'+ids).val(roundNumber(tot, 3));
	calculate('IRRIGATION_POTENTIAL_KHARIF');
	calculate('IRRIGATION_POTENTIAL_RABI');
	calculate('IRRIGATION_POTENTIAL');
}
function checkCompletionType(mode){
	if(mode==2){
		$('#divReasonsOfIncompletion').show();
		$('html, body').animate({scrollTop: $("#completionDiv1").offset().top}, 1000);
		//$(document).scrollTop( 300 );
	}else{
		$('#divReasonsOfIncompletion').hide();
	}
}

function calculateSubRestoredIrri(blockId111){
    var WORK_STATUS=$("#WORK_STATUS").val();
    if(WORK_STATUS==0)
    {
         showAlert('Oops...','Please select Work Status', 'error');
         $('#BLOCK_IP_K_'+blockId111).val("0");
         return;
    }
    <?php  echo 'var arrB = ['.implode(',', $arrBenefitedRestoredBlocks).'];';?>
    var curMonthK = cfyK = tlyK = curMonthR = cfyR = tlyR = curMonthT = cfyT = tlyT = 0;
    for(i=0;i<arrB.length;i++){
        var blockId = arrB[i];
        //alert(blockId);
        var ss = window.arrMonthlyRestoreBlockData[blockId]['KHARIF_RESTORED']['ESTI'];
         var rr = window.arrMonthlyRestoreBlockData[blockId]['RABI_RESTORED']['ESTI'];        
        //kharif arrMonthlyRestoreBlockData
        var curMonthBk = checkNo($('#BLOCK_IP_K_'+blockId).val());
        var cfyBk = checkNo(window.arrMonthlyRestoreBlockData[blockId]['KHARIF_RESTORED']['CFY']);
        var tlyBk = checkNo(window.arrMonthlyRestoreBlockData[blockId]['KHARIF_RESTORED']['TLY']);

      
        
        var totalcfyBk = cfyBk + curMonthBk;
        var totaltlyBk = totalcfyBk + tlyBk;

          if(totaltlyBk>ss)
            {
                $('#BLOCK_IP_K_'+blockId111).val("0");
            //alert("Total is not greater than Estimation ");
            showAlert('Oops...','Should be less than Estimation', 'error');
              totalcfyBk =  totalcfyBk-curMonthBk;         
            totaltlyBk = totalcfyBk + tlyBk;  
            curMonthBk=0;
            }
              else
            {                   
                   
                    curMonthK += curMonthBk;
                    cfyK += totalcfyBk;
                    tlyK += totaltlyBk; 
            }

                    $('#BLOCK_IP_K_CFY_'+blockId).html(totalcfyBk);
                    $('#BLOCK_IP_K_TLY_'+blockId).html(totaltlyBk);
        //rabi
        var curMonthBr = checkNo($('#BLOCK_IP_R_'+blockId).val());
        var cfyBr = checkNo(window.arrMonthlyRestoreBlockData[blockId]['RABI_RESTORED']['CFY']);
        var tlyBr = checkNo(window.arrMonthlyRestoreBlockData[blockId]['RABI_RESTORED']['TLY']);
     
        var totalcfyBr = cfyBr + curMonthBr;
        var totaltlyBr = totalcfyBr + tlyBr;
            if(totaltlyBr>rr)
           {
            $('#BLOCK_IP_R_'+blockId111).val("0");
            //alert("Total is not greater than Estimation ");           
             showAlert('Oops...','Should be less than Estimation', 'error');
            totalcfyBr = totalcfyBr - curMonthBr
            totaltlyBr = totalcfyBr + tlyBr;
            curMonthBr=0;
           }
           else
           {
               
                curMonthR += curMonthBr;
                cfyR += totalcfyBr;
                tlyR += totaltlyBr;
           }
            $('#BLOCK_IP_R_CFY_'+blockId).html(totalcfyBr);
                $('#BLOCK_IP_R_TLY_'+blockId).html(totaltlyBr);
        //total
        $('#BLOCK_IP_T_'+blockId).html(curMonthBk+curMonthBr);
        $('#BLOCK_IP_T_CFY_'+blockId).html(totalcfyBk+totalcfyBr);
        $('#BLOCK_IP_T_TLY_'+blockId).html(totaltlyBk+totaltlyBr);
        curMonthT += (curMonthBk+curMonthBr);
        cfyT += (totalcfyBk+totalcfyBr);
        tlyT += (totaltlyBk+totaltlyBr);
    }
    $('#IP_CUR_MONTH_RESTORED_K').html(curMonthK);
    $('#IP_CFY_RESTORED_K').html(cfyK);
    $('#IP_TOTAL_RESTORED_K').html(tlyK);
    
    $('#IP_CUR_MONTH_RESTORED_R').html(curMonthR);
    $('#IP_CFY_RESTORED_R').html(cfyR);
    $('#IP_TOTAL_RESTORED_R').html(tlyR);
    
    $('#IP_CUR_MONTH_RESTORED_T').html(curMonthT);
    $('#IP_CFY_RESTORED_T').html(cfyT);
    $('#IP_TOTAL_RESTORED_T').html(tlyT);
}

function calculateSubIrri(blockId111){
     var WORK_STATUS=$("#WORK_STATUS").val();
    if(WORK_STATUS==0)
    {
         showAlert('Oops...','Please select Work Status', 'error');
         $('#BLOCK_IP_K_'+blockId111).val("0");
         return;
    }
	<?php  echo 'var arrB = ['.implode(',', $arrBenefitedBlocks).'];';?>
	var curMonthK = cfyK = tlyK = curMonthR = cfyR = tlyR = curMonthT = cfyT = tlyT = 0;
	for(i=0;i<arrB.length;i++){
		var blockId = arrB[i];		 
		var ss = window.arrMonthlyBlockData[blockId]['KHARIF']['ESTI'];    
        var rr = window.arrMonthlyBlockData[blockId]['RABI']['ESTI'];        
		var curMonthBk = checkNo($('#BLOCK_IP_K_'+blockId).val());
		var cfyBk = checkNo(window.arrMonthlyBlockData[blockId]['KHARIF']['CFY']);
		var tlyBk = checkNo(window.arrMonthlyBlockData[blockId]['KHARIF']['TLY']);
   
	 var totalcfyBk = cfyBk + curMonthBk;
     var totaltlyBk = totalcfyBk + tlyBk;
//alert(totaltlyBk+"   === "+blockId);
        if(totaltlyBk>ss)
            {
            $('#BLOCK_IP_K_'+blockId111).val("0");
          //  alert("Total is not greater than Estimation ");
            showAlert('Oops...','Should be less than Estimation', 'error');
          //  calculateSubIrri(0);
            totalcfyBk =  totalcfyBk-curMonthBk;         
            totaltlyBk = totalcfyBk + tlyBk;  
            curMonthBk=0;
            }
            else
            {                   
                    $('#BLOCK_IP_K_CFY_'+blockId).html(totalcfyBk);
                    $('#BLOCK_IP_K_TLY_'+blockId).html(totaltlyBk);
                    curMonthK += curMonthBk;
                    cfyK += totalcfyBk;
                    tlyK += totaltlyBk; 
            }
		
		 
		//rabi
		var curMonthBr = checkNo($('#BLOCK_IP_R_'+blockId).val());
		var cfyBr = checkNo(window.arrMonthlyBlockData[blockId]['RABI']['CFY']);
		var tlyBr = checkNo(window.arrMonthlyBlockData[blockId]['RABI']['TLY']);
  
        var totalcfyBr = cfyBr + curMonthBr;
        var totaltlyBr = totalcfyBr + tlyBr;
	 
            if(totaltlyBr>rr)
           {
            $('#BLOCK_IP_R_'+blockId111).val("0");
         //   alert("Total is not greater than Estimation ");   
              showAlert('Oops...','Should be less than Estimation', 'error');        
            totalcfyBr = totalcfyBr - curMonthBr
            totaltlyBr = totalcfyBr + tlyBr;
            curMonthBr=0;
           }
           else
           {
                $('#BLOCK_IP_R_CFY_'+blockId).html(totalcfyBr);
                $('#BLOCK_IP_R_TLY_'+blockId).html(totaltlyBr);
                curMonthR += curMonthBr;
                cfyR += totalcfyBr;
                tlyR += totaltlyBr;
           }
	
		//total
		$('#BLOCK_IP_T_'+blockId).html(curMonthBk+curMonthBr);
		$('#BLOCK_IP_T_CFY_'+blockId).html(totalcfyBk+totalcfyBr);
		$('#BLOCK_IP_T_TLY_'+blockId).html(totaltlyBk+totaltlyBr);
		curMonthT += (curMonthBk+curMonthBr);
		cfyT += (totalcfyBk+totalcfyBr);
		tlyT += (totaltlyBk+totaltlyBr);
	}
	$('#IP_CUR_MONTH_K').html(curMonthK);
	$('#IP_CFY_K').html(cfyK);
	$('#IP_TOTAL_K').html(tlyK);
	
	$('#IP_CUR_MONTH_R').html(curMonthR);
	$('#IP_CFY_R').html(cfyR);
	$('#IP_TOTAL_R').html(tlyR);
	
	$('#IP_CUR_MONTH_T').html(curMonthT);
	$('#IP_CFY_T').html(cfyT);
	$('#IP_TOTAL_T').html(tlyT);
}
//
function calculate(ids){
    
     var WORK_STATUS=$("#WORK_STATUS").val();
     if(WORK_STATUS==0)
    {
         showAlert('Oops...','Please select Work Status', 'error');
         $("#"+ids).val("0");
         return;
    }
	var arrInt = new Array('LA_NO', 'LA_COMPLETED_NO');
//	var obj1 = window.arrMonthlyData.ids;
	var currentMonth = getMyValue(ids);    
    var esti=parseFloat(arrEstimationDataJs[ids]);
 
    esti=(isNaN(esti))?0:esti;
   
	var cfy = checkNo(window.arrMonthlyData[ids]['CFY']);
	var tly = checkNo(window.arrMonthlyData[ids]['TLY']);
    var totalCFY = currentMonth + cfy;
     var total = totalCFY + tly;
       var decimals = ($.inArray(ids, arrInt)>=0) ? 0:2;
    if(total>esti)
	{    
    var totalCFY = totalCFY-currentMonth;
     var total = totalCFY + tly;
        $('#' + ids).val("0");
    }
    
	 $('#divCFY_' + ids).html(roundNumber(totalCFY, decimals));
    $('#divTOTAL_' + ids).html(roundNumber(total, decimals));
    
}
jQuery.validator.addMethod("checkMyDigit", function(value, element, params) {
	return true;
	var nodecimals = new String(value | 0); //truncate the decimal part (no rounding)
	var lengthOfNo = nodecimals.length;
	var nodecimalsEsti = new String($('#'+element.id+'_esti').html() | 0);
	var lengthOfEsti = nodecimalsEsti.length;
	//alert(':' + lengthOfNo  + ':' + lengthOfEsti);
	//esti-3  no-12
	return ((lengthOfNo <= (lengthOfEsti+1))? true:false);
}, jQuery.validator.format("आपकी प्रविष्टि की गई मात्रा बहुत अधिक हो गयी है."));
//


</script>
