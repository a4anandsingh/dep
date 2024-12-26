<?php error_reporting(0); 
$myheight = ($isBlank) ? 'height="30px"':'';?>
<?php echo getPrintButton('prjmonthly_report', 'Print', 'xprjmonthly_report');?>
<div id="prjmonthly_report">
<?php $statusOptions = array(' ', 'NA', 'Not Started', 'Ongoing', 'Stopped', 'Completed', 'Dropped');
$mon = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug","Sep", "Oct", "Nov", "Dec");
function getStatusOptions($prevStatus){
	$status = '';
	$arrData = array();
	switch($prevStatus){
		case 0: 
		case 1: $status = 'NA'; break;
		case 2: //not started
			$arrData = array('Ongoing', 'Not Started');break;
		case 3: //ongoing
			$arrData = array('Ongoing', 'Stopped', 'Completed');break;
		case 4: //stopped
		 	$arrData = array('Ongoing', 'Stopped', 'Completed');break;
		case 5: //completed
			$status = 'Completed';break;
	}
	if($arrData){
		for($i=0;$i<count($arrData);$i++){
			$status .= '<big>&#x25a2;</big><strong> '.$arrData[$i].'</strong> <br />';
		}
	}
	return $status;
}
function getWorkStatusOptions($Sel=0, $prevMonthStatus=0){
    $myOptions ='';
	//type 0-Work Status
	/*if($type==0){
		$statusOptionValues = array('NA'=>1, 'Not Started'=>2,'Ongoing'=>3, 'Stopped'=>4, 'Completed'=>5);
	}else{
		$statusOptionValues = array('NA'=>1, 'Not Started'=>2, 'Ongoing'=>3, 'Stopped'=>4, 'Completed'=>5);
	}*/
	switch($prevMonthStatus){
		case 2: //Not started
			$filteredStatus = array('Not Started', 'Ongoing', 'Stopped');
			break;
		case 3: //Ongoing
			$filteredStatus = array('Ongoing', 'Stopped', 'Completed');
			break;
		case 4: //Stopped
			$filteredStatus = array('Ongoing', 'Stopped');
			break;
		case 7: //Current Year AA
			$filteredStatus = array('Not Started', 'Ongoing', 'Stopped');
			break;
		case 5: //completed
			$filteredStatus = array('Completed');
			break;
		default : 
			$filteredStatus = array('Ongoing', 'Stopped');
			break;
	}
	$s = array();;
	//showArrayValues($filteredStatus);
	foreach($filteredStatus as $f){
		array_push($s, '<big>&#x25a2;</big> '.$f);
	}
	return implode('<br />', $s);
}
?>
<table width="100%" border="0" cellpadding="3" cellspacing="2"  class="ui-widget-content" id="xprjmonthly_report">
<tr>
    <td class="ui-widget-content" align="center" colspan="5"><strong><big><big><?php echo $PROJECT_NAME;?></big></big></strong></td>
</tr>
<tr>
    <td nowrap="nowrap" class="ui-state-default"><strong>Code</strong></td>
    <td class="ui-widget-content" colspan="2"><strong><?php echo $PROJECT_CODE;?></strong></td>
    <td class="ui-state-default"><strong>Month</strong></td>
    <td align="center" class="ui-widget-content"><strong><?php echo date('F, Y', $MONTH_DATE);?></strong></td>
</tr>
<tr>
    <td nowrap="nowrap" class="ui-state-default"><strong>Status of Scheme</strong></td>
    <td class="ui-widget-content" colspan="2" width="150" nowrap="nowrap">
        <?php if($isBlank){?>
        <big>&#x25a2;</big><strong> Ongoing</strong> &nbsp;
        <big>&#x25a2;</big><strong> Stopped</strong> &nbsp;
        <big><br />
        &#x25a2;</big><strong> Completed</strong>
        <big>&#x25a2;</big><strong> Dropped</strong>
    <?php }else{ 
        echo $statusOptions[$arrCurrentMonthData['WORK_STATUS']];
      }?>
    </td>
    <td class="ui-state-default" width="180">Proposed Completion Date : <br />(As Per Target)</td>
    <td align="center" class="ui-widget-content"><strong><?php echo myDateFormat($ACTUAL_COMPLETION_DATE);?></strong></td>
</tr>

<?php if($isBlank){?>
<tr>
    <td class="ui-state-default">Completion Date :</td>
    <td class="ui-widget-content" colspan="2" <?php echo $myheight;?>></td>
    <td class="ui-state-default">Completion Certificate No.:</td>
    <td class="ui-widget-content" width="140"></td>
</tr>
<tr>
    <td nowrap="nowrap" class="ui-state-default"><strong>Completion Type</strong></td>
    <td class="ui-widget-content" colspan="4"  nowrap="nowrap">
        <big>&#x25a2;</big><strong> Physically & Financially Completed</strong> &nbsp; &nbsp;
        <big>&#x25a2;</big><strong> Physically Completed but Financially not Completed</strong> 
    </td>
</tr>
<tr>
    <td nowrap="nowrap" class="ui-state-default">Financially not completed due to</td>
    <td class="ui-widget-content" colspan="4"><big>&#x25a2; </big> LA Payment &nbsp; &nbsp;  <big>&#x25a2; </big> FA Payment  &nbsp; &nbsp; <big>&#x25a2; </big> Liabilities of Contractor</td>
</tr>
<tr>
    <td class="ui-state-default">Remarks</td>
    <td class="ui-widget-content" colspan="4"><big><big>&nbsp;</big></big></td>
</tr>

<?php 
}else{
	//completionStatusData
	$projectStatus = $arrCurrentMonthData['WORK_STATUS'];
	if($projectStatus==5){
		$arrCompletionType = array('', 'Physically & Financially Completed', 'Physically Completed but Financially not Completed');
		$strPayType ='';
		if($completionStatusData['COMPLETION_TYPE']==2){
			$payType = $completionStatusData['LA_PAYMENT'].$completionStatusData['FA_PAYMENT'].$completionStatusData['CL_PAYMENT'];
			if($payType=='100'){
				$strPayType = 'LA Payment';
			}else if($payType=='010'){
				$strPayType = 'FA Payment';
			}else if($payType=='001'){
				$strPayType = 'Liabilities of Contractor';
			}else if($payType=='110'){
				$strPayType = 'LA Payment and FA Payment';
			}else if($payType=='101'){
				$strPayType = 'LA Payment and Liabilities of Contractor';
			}else if($payType=='011'){
				$strPayType = 'FA Payment and Liabilities of Contractor';
			} 
			$strPayType = ' Due to <strong>'.$strPayType.'</strong>' ;
		}
	}//if
	//echo '::'.$completionStatusData['COMPLETION_TYPE'].$strPayType.'::';
	$remarkDiv = false;
	switch($projectStatus){
		case 4:case 2: case 5:case 6:
			$remarkDiv = true; break;
	}//switch
	if($projectStatus==5 || $projectStatus==6 || $remarkDiv){?>
<tr>
    <td nowrap="nowrap" class="ui-widget-content" colspan="5">
		<?php 
		if($projectStatus==5 || $projectStatus==6){
			if($projectStatus==5){?>
            <table width="100%" border="0" cellpadding="3" cellspacing="2">
            <tr>
                <td align="left" class="ui-state-default" width="140px">Completion Type</td>
                <td align="left" class="ui-widget-content"><?php echo $arrCompletionType[$completionStatusData['COMPLETION_TYPE']]. $strPayType;?></td>
            </tr>
            </table>
			<?php }//if?>
        <table width="100%" border="0" cellpadding="3" cellspacing="2">
        <tr>
        	<td align="left" class="ui-state-default" width="140px">
            <?php if ($projectStatus==5) echo 'Completion Date';
				if ($projectStatus==6) echo 'Drop Date';?>
            </td>
          	<td align="center" class="ui-widget-content"><?php echo myDateFormat($arrCurrentMonthData['COMPLETION_DATE']);?></td>
            <td align="left" class="ui-state-default">
				<?php if ($projectStatus==5) echo 'Completion Certificate No';
				if($projectStatus==6) echo 'Memo No';?>
            </td>
			<td align="center" class="ui-widget-content"><?php echo $monthlyStatusData['PROJECT_STATUS_DISPATCH_NO'];?></td>
		</tr>
		</table>
        <?php }//if($projectStatus==5)
		if($remarkDiv){?>
        <table width="100%" border="0" cellpadding="3" cellspacing="2">
        <tr>
            <td align="left" class="ui-state-default" width="140px">Remark </td>
            <td align="left" class="ui-widget-content"><?php echo $monthly_remarks['PROJECT_STATUS_REMARK'];?></td>
        </tr>
        </table>
        <?php }?>
	</td>
</tr>
<?php }//if($projectStatus==5 || $projectStatus==6)
}?>
</table>

<div class="wrdlinebreak"></div>

<?php 
//showArrayValues($arrSetupStatus); arrCurrentMonthData
$arrData = array(
	'LA_NO'=>array(
		'ESTIMATION'=>(($arrSetupStatus['LA_NA']) ? 'NA':$arrEstimationData['LA_NO']),
		'MONTHLY'=>(($arrSetupStatus['LA_NA']) ? 'NA': (($isBlank)?'':$arrCurrentMonthData['LA_NO'])),
		'PREV_MONTH'=>(($arrSetupStatus['LA_NA']) ? 'NA':$arrPreviousMonthData['LA_NO']),
		'CFY'=>(($arrSetupStatus['LA_NA']) ? 'NA':(($isBlank)?'':$arrCFY['LA_NO'])),
		'TLY'=>(($arrSetupStatus['LA_NA']) ? 'NA':$arrTLY['LA_NO']),
		'TOTAL'=>(($arrSetupStatus['LA_NA']) ? 'NA':(($isBlank)?'':($arrCFY['LA_NO']+$arrTLY['LA_NO'])))
	),
	'LA_HA'=>array(
		'ESTIMATION'=>(($arrSetupStatus['LA_NA']) ? 'NA':giveComma($arrEstimationData['LA_HA'], 2)),
		'MONTHLY'=>(($arrSetupStatus['LA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCurrentMonthData['LA_HA'], 2))),
        'PREV_MONTH'=>(($arrSetupStatus['LA_NA']) ? 'NA':giveComma($arrPreviousMonthData['LA_HA'], 2)),
		'CFY'=>(($arrSetupStatus['LA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['LA_HA'], 2))),
		'TLY'=>(($arrSetupStatus['LA_NA']) ? 'NA':giveComma($arrTLY['LA_HA'], 2)),
		'TOTAL'=>(($arrSetupStatus['LA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['LA_HA']+$arrTLY['LA_HA'], 2)))
	),
	'LA_COMPLETED_NO'=>array(
		'ESTIMATION'=>(($arrSetupStatus['LA_NA']) ? 'NA':$arrEstimationData['LA_COMPLETED_NO']),
		'MONTHLY'=>(($arrSetupStatus['LA_NA']) ? 'NA':(($isBlank)?'':$arrCurrentMonthData['LA_COMPLETED_NO'])),
		'PREV_MONTH'=>(($arrSetupStatus['LA_NA']) ? 'NA':$arrPreviousMonthData['LA_COMPLETED_NO']),
		'CFY'=>(($arrSetupStatus['LA_NA']) ? 'NA':(($isBlank)?'':$arrCFY['LA_COMPLETED_NO'])),
		'TLY'=>(($arrSetupStatus['LA_NA']) ? 'NA':$arrTLY['LA_COMPLETED_NO']),
		'TOTAL'=>(($arrSetupStatus['LA_NA']) ? 'NA':(($isBlank)?'':($arrCFY['LA_COMPLETED_NO']+$arrTLY['LA_COMPLETED_NO'])))
	),
	'LA_COMPLETED_HA'=>array(
		'ESTIMATION'=>(($arrSetupStatus['LA_NA']) ? 'NA':giveComma($arrEstimationData['LA_COMPLETED_HA'], 2)),
		'MONTHLY'=>(($arrSetupStatus['LA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCurrentMonthData['LA_COMPLETED_HA'], 2))),
        'PREV_MONTH'=>(($arrSetupStatus['LA_NA']) ? 'NA':giveComma($arrPreviousMonthData['LA_COMPLETED_HA'], 2)),
		'CFY'=>(($arrSetupStatus['LA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['LA_COMPLETED_HA'], 2))),
		'TLY'=>(($arrSetupStatus['LA_NA']) ? 'NA':giveComma($arrTLY['LA_COMPLETED_HA'], 2)),
		'TOTAL'=>(($arrSetupStatus['LA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['LA_COMPLETED_HA']+$arrTLY['LA_COMPLETED_HA'], 2)))
	),
	'FA_HA'=>array(
		'ESTIMATION'=>(($arrSetupStatus['FA_NA']) ? 'NA':giveComma($arrEstimationData['FA_HA'], 2)),
		'MONTHLY'=>(($arrSetupStatus['FA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCurrentMonthData['FA_HA'], 2))),
		'PREV_MONTH'=>(($arrSetupStatus['FA_NA']) ? 'NA':giveComma($arrPreviousMonthData['FA_HA'], 2)),
		'CFY'=>(($arrSetupStatus['FA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['FA_HA'], 2))),
		'TLY'=>(($arrSetupStatus['FA_NA']) ? 'NA':giveComma($arrTLY['FA_HA'], 2)),
		'TOTAL'=>(($arrSetupStatus['FA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['FA_HA']+$arrTLY['FA_HA'], 2)))
	),
	'FA_COMPLETED_HA'=>array(
		'ESTIMATION'=>(($arrSetupStatus['FA_NA']) ? 'NA':giveComma($arrEstimationData['FA_COMPLETED_HA'], 2)),
		'MONTHLY'=>(($arrSetupStatus['FA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCurrentMonthData['FA_COMPLETED_HA'], 2))),
		'PREV_MONTH'=>(($arrSetupStatus['FA_NA']) ? 'NA':giveComma($arrPreviousMonthData['FA_COMPLETED_HA'], 2)),
		'CFY'=>(($arrSetupStatus['FA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['FA_COMPLETED_HA'], 2))),
		'TLY'=>(($arrSetupStatus['FA_NA']) ? 'NA':giveComma($arrTLY['FA_COMPLETED_HA'], 2)),
		'TOTAL'=>(($arrSetupStatus['FA_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['FA_COMPLETED_HA']+$arrTLY['FA_COMPLETED_HA'], 2)))
	),
	'HW_EARTHWORK'=>array(
		'ESTIMATION'=>(($arrSetupStatus['HW_EARTHWORK_NA']) ? 'NA':giveComma($arrEstimationData['HW_EARTHWORK'], 2)),
		'MONTHLY'=>(($arrSetupStatus['HW_EARTHWORK_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCurrentMonthData['HW_EARTHWORK'], 2))),
		'PREV_MONTH'=>(($arrSetupStatus['HW_EARTHWORK_NA']) ? 'NA':giveComma($arrPreviousMonthData['HW_EARTHWORK'], 2)),
		'CFY'=>(($arrSetupStatus['HW_EARTHWORK_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['HW_EARTHWORK'], 2))),
		'TLY'=>(($arrSetupStatus['HW_EARTHWORK_NA']) ? 'NA':giveComma($arrTLY['HW_EARTHWORK'], 2)),
		'TOTAL'=>(($arrSetupStatus['HW_EARTHWORK_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['HW_EARTHWORK']+$arrTLY['HW_EARTHWORK'], 2))) 
	),
	'HW_MASONRY'=>array(
		'ESTIMATION'=>(($arrSetupStatus['HW_MASONRY_NA']) ? 'NA':giveComma($arrEstimationData['HW_MASONRY'], 2)),
		'MONTHLY'=>(($arrSetupStatus['HW_MASONRY_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCurrentMonthData['HW_MASONRY'], 2))),
		'PREV_MONTH'=>(($arrSetupStatus['HW_MASONRY_NA']) ? 'NA':giveComma($arrPreviousMonthData['HW_MASONRY'], 2)),
		'CFY'=>(($arrSetupStatus['HW_MASONRY_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['HW_MASONRY'], 2))),
		'TLY'=>(($arrSetupStatus['HW_MASONRY_NA']) ? 'NA':giveComma($arrTLY['HW_MASONRY'], 2)),
		'TOTAL'=>(($arrSetupStatus['HW_MASONRY_NA']) ? 'NA':(($isBlank)?'':giveComma($arrCFY['HW_MASONRY']+$arrTLY['HW_MASONRY'], 2)))
	),
	'STEEL_WORK'=>array(
		'ESTIMATION'=>(($arrSetupStatus['STEEL_WORK_NA']) ? 'NA':$arrEstimationData['STEEL_WORK']),
		'MONTHLY'=>(($arrSetupStatus['STEEL_WORK_NA']) ? 'NA':(($isBlank)?'':$arrCurrentMonthData['STEEL_WORK'])),
		'PREV_MONTH'=>(($arrSetupStatus['STEEL_WORK_NA']) ? 'NA':$arrPreviousMonthData['STEEL_WORK']),
		'CFY'=>(($arrSetupStatus['STEEL_WORK_NA']) ? 'NA':(($isBlank)?'':$arrCFY['STEEL_WORK'])),
		'TLY'=>(($arrSetupStatus['STEEL_WORK_NA']) ? 'NA':$arrTLY['STEEL_WORK']),
		'TOTAL'=>(($arrSetupStatus['STEEL_WORK_NA']) ? 'NA':(($isBlank)?'':($arrCFY['STEEL_WORK']+$arrTLY['STEEL_WORK'])))
	),
	'CANAL_EARTHWORK'=>array(
		'ESTIMATION'=>(($arrSetupStatus['CANAL_EARTHWORK_NA']) ? 'NA':$arrEstimationData['CANAL_EARTHWORK']),
		'MONTHLY'=>(($arrSetupStatus['CANAL_EARTHWORK_NA']) ? 'NA':(($isBlank)?'':$arrCurrentMonthData['CANAL_EARTHWORK'])),
		'PREV_MONTH'=>(($arrSetupStatus['CANAL_EARTHWORK_NA']) ? 'NA':$arrPreviousMonthData['CANAL_EARTHWORK']),
		'CFY'=>(($arrSetupStatus['CANAL_EARTHWORK_NA']) ? 'NA':(($isBlank)?'':$arrCFY['CANAL_EARTHWORK'])),
		'TLY'=>(($arrSetupStatus['CANAL_EARTHWORK_NA']) ? 'NA':$arrTLY['CANAL_EARTHWORK']),
		'TOTAL'=>(($arrSetupStatus['CANAL_EARTHWORK_NA']) ? 'NA':(($isBlank)?'':($arrCFY['CANAL_EARTHWORK']+$arrTLY['CANAL_EARTHWORK'])))
	),
	'CANAL_STRUCTURE'=>array(
		'ESTIMATION'=>(($arrSetupStatus['CANAL_STRUCTURE_NA']) ? 'NA':$arrEstimationData['CANAL_STRUCTURE']),
		'MONTHLY'=>(($arrSetupStatus['CANAL_STRUCTURE_NA']) ? 'NA':(($isBlank)?'':$arrCurrentMonthData['CANAL_STRUCTURE'])),
		'PREV_MONTH'=>(($arrSetupStatus['CANAL_STRUCTURE_NA']) ? 'NA':$arrPreviousMonthData['CANAL_STRUCTURE']),
		'CFY'=>(($arrSetupStatus['CANAL_STRUCTURE_NA']) ? 'NA':(($isBlank)?'':$arrCFY['CANAL_STRUCTURE'])),
		'TLY'=>(($arrSetupStatus['CANAL_STRUCTURE_NA']) ? 'NA':$arrTLY['CANAL_STRUCTURE']),
		'TOTAL'=>(($arrSetupStatus['CANAL_STRUCTURE_NA']) ? 'NA':(($isBlank)?'':($arrCFY['CANAL_STRUCTURE']+$arrTLY['CANAL_STRUCTURE'])))
	),
	'CANAL_STRUCTURE_MASONRY'=>array(
		'ESTIMATION'=>(($arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA']) ? 'NA':$arrEstimationData['CANAL_STRUCTURE_MASONRY']),
		'MONTHLY'=>(($arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA']) ? 'NA':(($isBlank)?'':$arrCurrentMonthData['CANAL_STRUCTURE_MASONRY'])),
		'PREV_MONTH'=>(($arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA']) ? 'NA':$arrPreviousMonthData['CANAL_STRUCTURE_MASONRY']),
		'CFY'=>(($arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA']) ? 'NA':(($isBlank)?'':$arrCFY['CANAL_STRUCTURE_MASONRY'])),
		'TLY'=>(($arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA']) ? 'NA':$arrTLY['CANAL_STRUCTURE_MASONRY']),
		'TOTAL'=>(($arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA']) ? 'NA':(($isBlank)?'':($arrCFY['CANAL_STRUCTURE_MASONRY']+$arrTLY['CANAL_STRUCTURE_MASONRY'])))
	),
	'CANAL_LINING'=>array(
		'ESTIMATION'=>(($arrSetupStatus['CANAL_LINING_NA']) ? 'NA':$arrEstimationData['CANAL_LINING']),
		'MONTHLY'=>(($arrSetupStatus['CANAL_LINING_NA']) ? 'NA':(($isBlank)?'':$arrCurrentMonthData['CANAL_LINING'])),
		'PREV_MONTH'=>(($arrSetupStatus['CANAL_LINING_NA']) ? 'NA':$arrPreviousMonthData['CANAL_LINING']),
		'CFY'=>(($arrSetupStatus['CANAL_LINING_NA']) ? 'NA':(($isBlank)?'':$arrCFY['CANAL_LINING'])),
		'TLY'=>(($arrSetupStatus['CANAL_LINING_NA']) ? 'NA':$arrTLY['CANAL_LINING']),
		'TOTAL'=>(($arrSetupStatus['CANAL_LINING_NA']) ? 'NA':(($isBlank)?'':($arrCFY['CANAL_LINING']+$arrTLY['CANAL_LINING'])))
	)
);
$cellSpacing = ($isBlank)?0:2;
?>
<!-- FIXED FORMAT START -->
<table width="100%" border="0" cellpadding="3" cellspacing="<?php echo $cellSpacing;?>" class="ui-widget-content">
<tr><th width="30" class="ui-widget-header">#</th>
    <th colspan="3" class="ui-widget-header">&nbsp;</th>
    <th align="center" class="ui-widget-header">Unit</th>
    <th align="center" class="ui-widget-header">Estimated</th>
    <th width="40" align="center" class="ui-widget-header">Current Month</th>
    <th align="center" class="ui-widget-header">Previous Month</th>
    <th width="10%" align="center" class="ui-widget-header">Total in<br />Current<br />Financial Year</th>
    <th width="9%" align="center" class="ui-widget-header">Till Last Year</th>
    <th width="11%" align="center" class="ui-widget-header">Cumulative<br />Till Date<br />(f+g)</th>
</tr>
<tr>
    <th class="ui-state-default" width="30">&nbsp;</th>
    <th colspan="3" align="center" class="ui-state-default">a</th>
    <th align="center" class="ui-state-default">b</th>
    <th align="center" class="ui-state-default">c</th>
    <th align="center" class="ui-state-default">d</th>
    <th align="center" class="ui-state-default">e</th>
    <th align="center" class="ui-state-default">f</th>
    <th align="center" class="ui-state-default">g</th>
    <th align="center" class="ui-state-default">h</th>
</tr>
<tr>
  <th colspan="11" align="left" class="ui-state-default">1. Physical</th>
  </tr>
<tr>
    <td rowspan="4" align="center" class="ui-widget-content"><strong>1</strong></td>
    <td rowspan="4" class="ui-widget-content"><strong>Land aq cases </strong></td>
    <td colspan="2" rowspan="2" class="ui-widget-content"><strong>Submitted</strong></td>
    <td class="ui-widget-content">Numbers</td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_NO']['ESTIMATION'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_NO']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_NO']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_NO']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_NO']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_NO']['TOTAL'];?></td>
</tr>
<tr>
  <td class="ui-widget-content">Hectares</td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_HA']['ESTIMATION'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_HA']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_HA']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_HA']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_HA']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_HA']['TOTAL'];?></td>
</tr>
<tr>
  <td colspan="2" rowspan="2" class="ui-widget-content"><strong>Completed</strong></td>
	<td class="ui-widget-content" >Numbers</td>
	<td class="ui-widget-content diagonalRising " align="center">&nbsp;</td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_COMPLETED_NO']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_COMPLETED_NO']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_COMPLETED_NO']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_COMPLETED_NO']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_COMPLETED_NO']['TOTAL'];?></td>
</tr>
<tr>
  <td class="ui-widget-content">Hectares</td>
    <td class="ui-widget-content diagonalRising" align="center">&nbsp;</td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_COMPLETED_HA']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_COMPLETED_HA']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_COMPLETED_HA']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_COMPLETED_HA']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['LA_COMPLETED_HA']['TOTAL'];?></td>
</tr>
    <tr>
      <td rowspan="2" align="center" class="ui-widget-content"><strong>2</strong><strong></strong></td>
    <td rowspan="2" class="ui-widget-content"><strong>Forest cases </strong></td>
    <td colspan="2" class="ui-widget-content"><strong>Submitted</strong></td>
    <td class="ui-widget-content" >Hectares</td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['FA_HA']['ESTIMATION'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['FA_HA']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['FA_HA']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['FA_HA']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['FA_HA']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['FA_HA']['TOTAL'];?></td>
</tr>
<tr>
  <td colspan="2" class="ui-widget-content"><strong>Completed</strong></td>
    <td class="ui-widget-content" >Hectares</td>
    <td class="ui-widget-content diagonalRising" align="center">&nbsp;</td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['FA_COMPLETED_HA']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['FA_COMPLETED_HA']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['FA_COMPLETED_HA']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['FA_COMPLETED_HA']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['FA_COMPLETED_HA']['TOTAL'];?></td>
</tr>
<tr>
    <td class="ui-widget-content" align="center"><strong>3</strong></td>
    <td class="ui-widget-content" colspan="3"><strong>Headwork Earthwork <br />(As per "L" Earthwork section of DPR)</strong></td>
    <td class="ui-widget-content">Th Cum</td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['HW_EARTHWORK']['ESTIMATION'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['HW_EARTHWORK']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['HW_EARTHWORK']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['HW_EARTHWORK']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['HW_EARTHWORK']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['HW_EARTHWORK']['TOTAL'];?></td>
</tr>
<tr>
    <td class="ui-widget-content"  align="center" ><strong>4</strong></td>
    <td class="ui-widget-content"  colspan="3"><strong>Headworks Masonry / Concrete&nbsp;<br />(As per &quot;C&quot; Masonry section of DPR)</strong></td>
  <!--   <td colspan="2" class="ui-widget-content" ><strong>(a) Masonry/Concrete</strong></td> -->
    <td class="ui-widget-content" >Th Cum</td>
    <td class="ui-widget-content" align="center" <?php echo $myheight;?>><?php echo $arrData['HW_MASONRY']['ESTIMATION'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['HW_MASONRY']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['HW_MASONRY']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['HW_MASONRY']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['HW_MASONRY']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['HW_MASONRY']['TOTAL'];?></td>
</tr>            
<tr>
	<td class="ui-widget-content" align="center" ><strong>5</strong></td>
    <td  class="ui-widget-content" colspan="3" ><strong>Steel Work </strong></td>
  <!--   <td class="ui-widget-content" ><strong>i. DE/PE/PVC<br />(Main &amp; Submain)</strong></td> -->
    <td class="ui-widget-content" >MT</td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['STEEL_WORK']['ESTIMATION'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['STEEL_WORK']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['STEEL_WORK']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['STEEL_WORK']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['STEEL_WORK']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['STEEL_WORK']['TOTAL'];?></td>
</tr>
<tr>
	<td class="ui-widget-content" align="center" ><strong>6</strong></td>
    <td  class="ui-widget-content" colspan="3" ><strong>Canals Earth Work </strong></td> 
    <!-- <td class="ui-widget-content" ><strong>ii. Lateral for <br />Drip/sprinkler</strong></td> -->
    <td class="ui-widget-content" >Th Cum</td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_EARTHWORK']['ESTIMATION'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_EARTHWORK']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_EARTHWORK']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_EARTHWORK']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_EARTHWORK']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_EARTHWORK']['TOTAL'];?></td>
</tr>
<tr>
	<td class="ui-widget-content" align="center" ><strong>7</strong></td>
    <td  class="ui-widget-content" colspan="3" ><strong>Canals Structure  </strong></td> 
    <!-- <td colspan="2" class="ui-widget-content" ><strong>(c) Water Pumps</strong></td> -->
    <td class="ui-widget-content" >Numbers</td>
    <td class="ui-widget-content" align="center" <?php echo $myheight;?>><?php echo $arrData['CANAL_STRUCTURE']['ESTIMATION'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_STRUCTURE']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_STRUCTURE']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_STRUCTURE']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_STRUCTURE']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_STRUCTURE']['TOTAL'];?></td>
</tr>
<tr>
    <td class="ui-widget-content" align="center"><strong>8</strong></td>
    <td class="ui-widget-content" colspan="3"><strong>Canal Structure Masonry / Conc.
    </strong></td>
    <td class="ui-widget-content" >Th Cum</td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_STRUCTURE_MASONRY']['ESTIMATION'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_STRUCTURE_MASONRY']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_STRUCTURE_MASONRY']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_STRUCTURE_MASONRY']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_STRUCTURE_MASONRY']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_STRUCTURE_MASONRY']['TOTAL'];?></td>
</tr>
<tr>
    <td class="ui-widget-content" align="center"><strong>9</strong></td>
    <td class="ui-widget-content" colspan="3"><strong>Canal Lining
    </strong></td>
    <td class="ui-widget-content" >KM</td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_LINING']['ESTIMATION'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_LINING']['MONTHLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_LINING']['PREV_MONTH'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_LINING']['CFY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_LINING']['TLY'];?></td>
    <td class="ui-widget-content" align="center"><?php echo $arrData['CANAL_LINING']['TOTAL'];?></td>
</tr>

<tr>
    <td class="ui-widget-content" align="center"><strong>10</strong></td>
    <td class="ui-widget-content" colspan="3"><strong>Irrigation Potential Created</strong></td>
    <td class="ui-widget-content">Hectares</td>
    <td colspan="6" align="center" class="ui-widget-content"></td>
    </tr>
<?php 
    //showArrayValues($arrBlockData); arrRestoredBlockData
    //foreach($arrMonthly as $arrM){
	$arrMonthlyBlockData = array();
	$iBCount = 97;
	$arrTotalTemp = array('ESTIMATION'=>0, 'CURRENT_MONTH'=>0, 'PREV_MONTH'=>0, 'CFY'=>0, 'TLY'=>0, 'TOTAL'=>0);
	$arrTotal = array('KHARIF' => $arrTotalTemp, 'RABI' => $arrTotalTemp, 'TOTAL' => $arrTotalTemp);
	 
	foreach($arrBlockData as $k=>$v){ 		
	 
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
      ?>
      <tr>
        <td class="ui-widget-content" align="center" rowspan="3"><?php echo chr($iBCount++); ?></td>
        <td class="ui-widget-content" rowspan="3" colspan="3"><?php echo $v['BLOCK_NAME']; ?></td>
        <td class="ui-widget-content"><strong>Kharif</strong></td>
        <td class="ui-widget-content" align="center" <?php echo $myheight;?>><?php echo $v['ESTIMATION_IP']['KHARIF'];?></td>
        <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$v['CUR_MONTH_IP']['KHARIF']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['PREV_MONTH_IP']['KHARIF'];?></td>
        <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['KHARIF']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['KHARIF'];?></td>
        <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_CFY']['KHARIF']+$v['ACHIEVEMENT_IP_TLY']['KHARIF']));?></td>
      </tr>
      <tr>
        <td class="ui-widget-content"><strong>Rabi</strong></td>
        <td class="ui-widget-content" align="center" <?php echo $myheight;?>><?php echo $v['ESTIMATION_IP']['RABI'];?></td>
         <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$v['CUR_MONTH_IP']['RABI']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['PREV_MONTH_IP']['RABI'];?></td>
        <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['RABI']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['RABI'];?></td>
        <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_CFY']['RABI']+$v['ACHIEVEMENT_IP_TLY']['RABI']));?></td>
      </tr>
      <tr>
        <td class="ui-state-default" ><strong>Total</strong></td>
        <td class="ui-state-default" align="center" <?php echo $myheight;?>><?php echo $v['ESTIMATION_IP']['IP'];?></td>
        <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':$v['CUR_MONTH_IP']['IP']);?></td>
        <td class="ui-state-default" align="center"><?php echo $v['PREV_MONTH_IP']['IP'];?></td>
        <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['IP']);?></td>
        <td class="ui-state-default" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['IP'];?></td>
        <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_TLY']['IP']+$v['ACHIEVEMENT_IP_CFY']['IP']));?></td>
      </tr>
  <?php } ?>
  <tr>
      <td class="ui-state-default" rowspan="3">&nbsp;</td>
      <td colspan="3" rowspan="3" class="ui-state-default"><strong>Total Irrigation Potential Created</strong></td>
      <td class="ui-widget-content"><strong>Kharif</strong></td>
      <td class="ui-widget-content" align="center" <?php echo $myheight;?>><?php echo $arrTotal['KHARIF']['ESTIMATION'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['KHARIF']['CURRENT_MONTH']);?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['KHARIF']['PREV_MONTH'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['KHARIF']['CFY']);?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['KHARIF']['TLY'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['KHARIF']['TOTAL']);?></td>
    </tr>
    <tr>
      <td class="ui-widget-content"><strong>Rabi</strong></td>
      <td class="ui-widget-content" align="center" <?php echo $myheight;?>><?php echo $arrTotal['RABI']['ESTIMATION'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['RABI']['CURRENT_MONTH']);?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['RABI']['PREV_MONTH'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['RABI']['CFY']);?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['RABI']['TLY'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['RABI']['TOTAL']);?></td>
    </tr>
    <tr>
      <td class="ui-state-default" ><strong>Total</strong></td>
      <td class="ui-state-default" align="center" <?php echo $myheight;?>><?php echo $arrTotal['TOTAL']['ESTIMATION'];?></td>
      <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':$arrTotal['TOTAL']['CURRENT_MONTH']);?></td>
      <td class="ui-state-default" align="center"><?php echo $arrTotal['TOTAL']['PREV_MONTH'];?></td>
      <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':$arrTotal['TOTAL']['CFY']);?></td>
      <td class="ui-state-default" align="center"><?php echo $arrTotal['TOTAL']['TLY'];?></td>
      <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':$arrTotal['TOTAL']['TOTAL']);?></td>
    </tr>
    <!-- IP Restored start -->
    <tr>
    <td class="ui-widget-content" align="center"><strong>11</strong></td>
    <td class="ui-widget-content" colspan="3"><strong>Irrigation Potential to be Restored</strong></td>
    <td class="ui-widget-content">Hectares</td>
    <td colspan="6" align="center" class="ui-widget-content"></td>
    </tr>

    <?php 
    //showArrayValues($arrRestoredBlockData); 
    //foreach($arrMonthly as $arrM){
	$arrMonthlyBlockData = array();
	$iBCount = 97;
	$arrTotalTemp = array('ESTIMATION'=>0, 'CURRENT_MONTH'=>0, 'PREV_MONTH'=>0, 'CFY'=>0, 'TLY'=>0, 'TOTAL'=>0);
	$arrTotal = array('KHARIF_RESTORED' => $arrTotalTemp, 'RABI_RESTORED' => $arrTotalTemp, 'TOTAL_RESTORED' => $arrTotalTemp);
	 
	foreach($arrRestoredBlockData as $k=>$v){ 		
	 
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

          $arrTotal['TOTAL_RESTORED']['ESTIMATION']+= $v['ESTIMATION_IP']['IP_RESTORED'];
          $arrTotal['TOTAL_RESTORED']['CURRENT_MONTH']+= $v['CUR_MONTH_IP']['IP_RESTORED'];
          $arrTotal['TOTAL_RESTORED']['PREV_MONTH']+= $v['PREV_MONTH_IP']['IP_RESTORED'];
          $arrTotal['TOTAL_RESTORED']['CFY']+= $v['ACHIEVEMENT_IP_CFY']['IP_RESTORED'];
          $arrTotal['TOTAL_RESTORED']['TLY']+= $v['ACHIEVEMENT_IP_TLY']['IP_RESTORED'];
          $arrTotal['TOTAL_RESTORED']['TOTAL']+= ($v['ACHIEVEMENT_IP_CFY']['IP_RESTORED']+$v['ACHIEVEMENT_IP_TLY']['IP_RESTORED']);
      ?>
      <tr>
        <td class="ui-widget-content" align="center" rowspan="3"><?php echo chr($iBCount++); ?></td>
        <td class="ui-widget-content" rowspan="3" colspan="3"><?php echo $v['BLOCK_NAME']; ?></td>
        <td class="ui-widget-content"><strong>Kharif</strong></td>
        <td class="ui-widget-content" align="center" <?php echo $myheight;?>><?php echo $v['ESTIMATION_IP']['KHARIF_RESTORED'];?></td>
        <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$v['CUR_MONTH_IP']['KHARIF_RESTORED']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['PREV_MONTH_IP']['KHARIF_RESTORED'];?></td>
        <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['KHARIF_RESTORED']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['KHARIF_RESTORED'];?></td>
        <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_CFY']['KHARIF_RESTORED']+$v['ACHIEVEMENT_IP_TLY']['KHARIF_RESTORED']));?></td>
      </tr>
      <tr>
        <td class="ui-widget-content"><strong>Rabi</strong></td>
        <td class="ui-widget-content" align="center" <?php echo $myheight;?>><?php echo $v['ESTIMATION_IP']['RABI_RESTORED'];?></td>
         <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$v['CUR_MONTH_IP']['RABI_RESTORED']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['PREV_MONTH_IP']['RABI_RESTORED'];?></td>
        <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['RABI_RESTORED']);?></td>
        <td class="ui-widget-content" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['RABI_RESTORED'];?></td>
        <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_CFY']['RABI_RESTORED']+$v['ACHIEVEMENT_IP_TLY']['RABI_RESTORED']));?></td>
      </tr>
      <tr>
        <td class="ui-state-default" ><strong>Total</strong></td>
        <td class="ui-state-default" align="center" <?php echo $myheight;?>><?php echo $v['ESTIMATION_IP']['IP_RESTORED'];?></td>
        <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':$v['CUR_MONTH_IP']['IP_RESTORED']);?></td>
        <td class="ui-state-default" align="center"><?php echo $v['PREV_MONTH_IP']['IP_RESTORED'];?></td>
        <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':$v['ACHIEVEMENT_IP_CFY']['IP_RESTORED']);?></td>
        <td class="ui-state-default" align="center"><?php echo $v['ACHIEVEMENT_IP_TLY']['IP_RESTORED'];?></td>
        <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':($v['ACHIEVEMENT_IP_TLY']['IP_RESTORED']+$v['ACHIEVEMENT_IP_CFY']['IP_RESTORED']));?></td>
      </tr>
  <?php } ?>
  <tr>
      <td class="ui-state-default" rowspan="3">&nbsp;</td>
      <td colspan="3" rowspan="3" class="ui-state-default"><strong>Total Irrigation Potential to be Restored</strong></td>
      <td class="ui-widget-content"><strong>Kharif</strong></td>
      <td class="ui-widget-content" align="center" <?php echo $myheight;?>><?php echo $arrTotal['KHARIF_RESTORED']['ESTIMATION'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['KHARIF_RESTORED']['CURRENT_MONTH']);?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['KHARIF_RESTORED']['PREV_MONTH'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['KHARIF_RESTORED']['CFY']);?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['KHARIF_RESTORED']['TLY'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['KHARIF_RESTORED']['TOTAL']);?></td>
    </tr>
    <tr>
      <td class="ui-widget-content"><strong>Rabi</strong></td>
      <td class="ui-widget-content" align="center" <?php echo $myheight;?>><?php echo $arrTotal['RABI_RESTORED']['ESTIMATION'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['RABI_RESTORED']['CURRENT_MONTH']);?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['RABI_RESTORED']['PREV_MONTH'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['RABI_RESTORED']['CFY']);?></td>
      <td class="ui-widget-content" align="center"><?php echo $arrTotal['RABI_RESTORED']['TLY'];?></td>
      <td class="ui-widget-content" align="center"><?php echo (($isBlank)?'':$arrTotal['RABI_RESTORED']['TOTAL']);?></td>
    </tr>
    <tr>
      <td class="ui-state-default" ><strong>Total</strong></td>
      <td class="ui-state-default" align="center" <?php echo $myheight;?>><?php echo $arrTotal['TOTAL_RESTORED']['ESTIMATION'];?></td>
      <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':$arrTotal['TOTAL_RESTORED']['CURRENT_MONTH']);?></td>
      <td class="ui-state-default" align="center"><?php echo $arrTotal['TOTAL_RESTORED']['PREV_MONTH'];?></td>
      <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':$arrTotal['TOTAL_RESTORED']['CFY']);?></td>
      <td class="ui-state-default" align="center"><?php echo $arrTotal['TOTAL_RESTORED']['TLY'];?></td>
      <td class="ui-state-default" align="center"><?php echo (($isBlank)?'':$arrTotal['TOTAL_RESTORED']['TOTAL']);?></td>
    </tr>

    <!-- IP Restored end -->
</table>

<div class="wrdlinebreak" style="page-break-after:always"></div>

<?php 
$arrTitles = array(
	'LA_CASES_STATUS'=>'Submission of LA Cases', 
	'SPILLWAY_WEIR_STATUS'=>'Submission Spillway / weir', 
	'FLANKS_AF_BUNDS_STATUS'=>'Flanks /Af. bunds', 
	'SLUICE_STATUS'=>'Sluice/s', 
	'NALLA_CLOSER_STATUS'=>'Nalla Closer',
	'CANAL_EW_STATUS'=>'Canal E/W ', 
	'CANAL_STRUCTURE_STATUS'=>'Canal Structure',
	'CANAL_LINING_STATUS'=>'Canal Lining', 
);
$arrFields = array(
	'LA_CASES_STATUS', 'SPILLWAY_WEIR_STATUS', 'FLANKS_AF_BUNDS_STATUS', 'SLUICE_STATUS', 'NALLA_CLOSER_STATUS',
	'CANAL_EW_STATUS', 'CANAL_STRUCTURE_STATUS','CANAL_LINING_STATUS'
);
$arrStatus = array();
//showArrayValues($monthly_remarks);
foreach($arrFields as $f){
	$arrStatus[$f] = array(
		'TITLE'=>$arrTitles[$f],
		'CURRENT_MONTH'=>	(($arrComponentStatus[$f]==1)? 'NA': (($isBlank)? getWorkStatusOptions(0, $prevMonthStatus[$f]):$statusOptions[$arrCurrentMonthData[$f]])),
		'PREV_MONTH'=>		(($arrComponentStatus[$f]==1)? 'NA':$statusOptions[$prevMonthStatus[$f]]),
		'REMARKS'=>			(($arrComponentStatus[$f]==1)? 'NA':$monthly_remarks[$f.'_REMARK'])
    );
}
?>
<!-- Status -->
<table width="100%" border="0" cellpadding="3" class="ui-widget-content" cellspacing="<?php echo $cellSpacing;?>">
<tr>
  <th colspan="5" align="left" class="ui-widget-header">2. Status</th>
  </tr>
<tr>
    <th width="30" nowrap="nowrap" class="ui-widget-header"><strong>#</strong></th>
    <th width="80" class="ui-widget-header">Contents</th>
    <th width="50" nowrap="nowrap" class="ui-widget-header">Previous Month</th>
    <th width="70" nowrap="nowrap" class="ui-widget-header">Current Month</th>
    <th class="ui-widget-header">Remarks</th>
</tr>
<?php
$i = 0;
//showArrayValues($arrStatus );
foreach($arrStatus as $f=>$v){?>
<tr>
    <td align="center" class="ui-widget-content"><strong><?php echo chr(97+$i++);?></strong></td>
    <td nowrap="nowrap" class="ui-widget-content"><strong><?php echo $v['TITLE'];?></strong></td>
    <td align="center" nowrap="nowrap" class="ui-widget-content"><?php echo $v['PREV_MONTH'];?></td>
    <td align="center" nowrap="nowrap" class="ui-widget-content"><?php echo $v['CURRENT_MONTH'];?></td>
    <td align="center" class="ui-widget-content"><?php echo $v['REMARKS'];?></td>
</tr>
<?php }//foreach?>
</table>
<div class="wrdlinebreak"></div>
<?php if(!$isBlank){?> 
<div style="text-align:center;width:100%">
    Physical Progress : <?php echo $PROGRESS;?>%
</div>
<?php }?> 
<p><small>Printed on <?php echo date("d-m-Y h:i:s a");?></small></p>
<!-- FIXED FORMAT END -->
</div>
