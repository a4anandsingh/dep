<?php echo getPrintButton('pp_report', 'Print');?>
<form name="frmSELock" id="frmSELock" onsubmit="return false;">
<div id="pp_report">
<?php echo getReportTitle( array("Physical Progress", $monthYearTitle) );?>
<?php 
$lockMessage = '';
if($isLocked) {
	if(date("H:i:s", strtotime($lockData->LOCK_DATE))=="00:00:00")
		$cdate = date("d-m-Y", strtotime($lockData->LOCK_DATE));
	else
		$cdate = date("d-m-Y h:i:s a", strtotime($lockData->LOCK_DATE));
$lockMessage = '<div class="label label-warning" style="padding:12px 15px;float:left;"><big>Division Locked on '.
	$cdate.'</big></div>';
}
// print_r($reportData);
$i = 0;
if(!$reportData){
	echo 'No Data...';
	exit;
}
if($isLocked){
	if($maxMonthlyLockDate>$lockData->LOCK_DATE)
		$isLocked = false;
}

//echo $validMonth;
$m80 = 0;
$projectCount = count($reportData);
$isAllValid = true;
$progressCount = 0;
$invalidMonthCount = 0;
$noMonthlyEntryCount = 0;
$reportDate = strtotime($searchData['REPORT_DATE']);
//echo 'validMonth:'.$validMonth.'::';

$validMonth = strtotime($validMonth);
$bypass = 0;
if($bypass) $validMonth = strtotime("2016-09-01");
$reportOnlyPage = (($reportDate==$validMonth)?false:true);
if ($isLocked) $reportOnlyPage = true;

if($bypass) $reportOnlyPage = false;

$isValid = true;
$isPValid = true;
echo $lockMessage;
//echo 'reportOnlyPage:'.$reportOnlyPage.'::';
//echo 'current office id  ='. $this->session->userdata('CURRENT_OFFICE_ID');
?>
<table border="1" class="ui-widget-content pagebreakafter" cellpadding="2" cellspacing="1" width="100%" id="rptPP">
<thead>
<tr>
    <th align="center" class="ui-state-default"><strong>S.No.</strong></th>
    <th align="center" class="ui-state-default"><strong>Name of the Project (ongoing at the start of Financial Year & New Projects</strong></th>
    <th align="center" class="ui-state-default"><strong>Target date of completion</strong></th>
    <th align="center" class="ui-state-default"><strong>Item</strong></th>
    <th colspan="2" align="center" class="ui-state-default"><strong>Sub<br />Item</strong></th>
    <th align="center" class="ui-state-default"><strong>Unit</strong></th>
    <th align="center" class="ui-state-default"><strong>Estimated Quantity</strong></th>
    <th align="center" class="ui-state-default"><strong>Progress<br />to end of <br />last Financial year</strong></th>
    <th align="center" class="ui-state-default"><strong>Overall Target For Financial Year</strong></th>
    <th align="center" class="ui-state-default"><strong>Achieve-ments<br />to end of month in Financial Year</strong></th>
    <th align="center" class="ui-state-default"><strong>Overall <br />achieve-ments<br />to end of month<br />(8+10)</strong></th>
    <th align="center" class="ui-state-default"><strong>% Overall <br />achieve-ments<br />to end of month<br />(11/7 x 100)</strong></th>
    <th align="center" class="ui-state-default"><strong>Overall<br />calculated/<br />weighted progress in % </strong></th>
    <th align="center" class="ui-state-default">Lock Month / Lock Date</th>
    <?php if(!$reportOnlyPage){?>
    	<th align="center" class="ui-state-default">Select</th>
	<?php }?>
</tr>
<tr>
    <th class="ui-state-default" align="center"><strong>1</strong></th>
    <th class="ui-state-default" align="center"><strong>2 </strong></th>
    <th width="70" align="center" class="ui-state-default"><strong>3</strong></th>
    <th width="100" align="center" class="ui-state-default"><strong>4</strong></th>
    <th colspan="2" align="center" class="ui-state-default"><strong>5</strong></th>
    <th class="ui-state-default" align="center"><strong>6</strong></th>
    <th width="70" align="center" class="ui-state-default"><strong>7</strong></th>
    <th width="70" align="center" class="ui-state-default"><strong>8</strong></th>
    <th width="60" align="center" class="ui-state-default"><strong>9</strong></th>
    <th width="60" align="center" class="ui-state-default"><strong>10</strong></th>
    <th width="60" align="center" class="ui-state-default"><strong>11</strong></th>
    <th width="60" align="center" class="ui-state-default"><strong>12</strong></th>
    <th width="70" align="center" class="ui-state-default"><strong>13</strong></th>
    <th class="ui-state-default" align="center"><strong>14</strong></th>
    <?php if(!$reportOnlyPage){?>
    <th class="ui-state-default" align="center">
        <input type="checkbox" id="select_all" name="select_all" class="caseall css-checkbox ">
		<label for="select_all" class="css-label lite-red-check"></label>
		<input type="hidden" id="EE_ID" name="EE_ID" value="<?php echo $searchData['EE_ID'];?>" />
		<input type="hidden" id="MONTH_DATE" name="MONTH_DATE" value="<?php echo $searchData['REPORT_DATE'];?>" />
    </th>
	<?php }?>
</tr>
</thead>
<tbody>
<?php 
if($projectCount >0){ 
	$ceCount=0;
	$seCount=0;
	$eeCount=0;
	$ceid = 0;
	$seid = 0;
	$eeid = 0;
	$i=1;
	foreach($reportData as $val){
		$myData = $val['mydata'];

        /*if($myData['PROJECT_ID']=='3347'){
            continue;
        }*/
		$isValidMonthEntry = true;
		if(!$reportOnlyPage){
			$lockMonth = strtotime($myData['lockData']['MONTH_LOCK']);
			//$isValid = (($lockMonth<$reportDate) ? false:true);
			$isValid = (($lockMonth<$validMonth) ? false:true);
          	if($bypass)$isValid =true;
			//echo 'LM:'.$lockMonth.' <VM:'.$validMonth;
			$isPValid = (($myData['progress']>110)?false: true);
			if($myData['progress']>110) $progressCount++;
			if(!$isValid) $invalidMonthCount++;
			
			$isValidMonthEntry = array_key_exists('lockData', $myData);
			if(!$isValidMonthEntry) $noMonthlyEntryCount++;
			
			if( (!$isValid) || (!$isPValid) || (!$isValidMonthEntry))  $isAllValid = false;
			
		}
		if($ceid!=$val['OFFICE_CE_ID']){
			$ceCount++;
			$seCount=0;
			$eeCount=0;
			$ceid = $val['OFFICE_CE_ID'];?>
		<tr>
			<td colspan="16" align="left" valign="top" class="ui-widget-content" style="background:#aaa">
				<?php echo $ceCount.'. '.$val['OFFICE_CE_NAME'];?>
			</td>
		</tr><?php }//ce
				if($seid!=$val['OFFICE_SE_ID']){
					$seCount++;
					$eeCount=0;
					$seid = $val['OFFICE_SE_ID'];?>
		<tr>
			<td colspan="16" align="left" valign="top" class="ui-widget-content" style="background:#ccc">
				&nbsp;  &nbsp; <?php echo $seCount.'. '.$val['OFFICE_SE_NAME'];?>
			</td>
		</tr><?php }//se
				if($eeid!=$val['OFFICE_EE_ID']){
					$eeCount++;
					$i=1;
					$eeid = $val['OFFICE_EE_ID'];?>
		<tr>
			<td colspan="16" align="left" valign="top" class="ui-widget-content" style="background:#eee">
				&nbsp;  &nbsp; &nbsp;  &nbsp; <?php echo $eeCount.'. '.$val['OFFICE_NAME'];?>
			</td>
		</tr>
		<?php }//ee
		?>	  	<!-- Forest Case Submited --> 
        <tr>
            <td rowspan="12" align="center" valign="top" class="ui-widget-content"><strong><?php echo $i++;?></strong></td>
            <td width="130" rowspan="12" align="left" valign="top" 
            	class="<?php echo ( (!$isValid) || (!$isValidMonthEntry) ) ? 'ui-state-error':'ui-widget-content';?>">
				<?php echo "<b>". $val['PROJECT_NAME']."</b>";?>
                <input type="hidden" class="mhide" name="MYPROJECTS[]" value="<?php echo $myData['PROJECT_SETUP_ID'];?>" />
            </td>
            <td width="70" rowspan="12" align="center" valign="top" nowrap="nowrap" class="ui-widget-content"><?php echo $val['TARGET_DATE'];?></td>
            <td rowspan="2" class="ui-widget-content">Forest Cases </td>
            <td colspan="2" class="ui-widget-content"> Submitted </td>
            <td class="ui-widget-content">Hectares</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['FA_HA']['estQuantity'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['FA_HA']['progLastFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['FA_HA']['overallTargetFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['FA_HA']['achivEndMonthFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['FA_HA']['overallAchivEndMonth'];?>&nbsp;</td>
	        <td class="ui-widget-content" align="center"><?php echo $myData['FA_HA']['percentOverallAchivEndMonth'];?>&nbsp;</td>
          <td rowspan="12" align="center" valign="middle" class="<?php echo (!$isPValid) ? 'ui-state-error':'ui-widget-content';?>">
            	<big><strong><?php echo $myData['progress'];
				if($myData['progress']>=80) $m80++;
				?></strong></big>
            </td>
            <td rowspan="12" align="center" valign="middle" nowrap="nowrap" class="ui-widget-content">
            <?php 
			if($myData['lockData']) {
				echo '<span title="लॉक माह"><span class="cus-lock"></span> '.
					date("M, Y", strtotime($myData['lockData']['MONTH_LOCK'])).
					'</span><BR/><span title="लॉक दिनांक"><span class="cus-calendar"></span> '.
					date("d-m-Y", strtotime($myData['lockData']['SUBMISSION_DATE'])).'</span>';
			}else{
				echo '<span class="cus-flag-red"></span><br />Monthly<br/> Data <br/>Not <br/>Exists.';
			}
			//showArrayValues($myData['MONTH_LOCK']);
			?>
            </td>
            <?php if(!$reportOnlyPage){?>
            <td rowspan="12" align="center" valign="middle" class="ui-widget-content">
	            <?php if(!$reportOnlyPage){?>
    	        <input type="checkbox" value="<?php echo $myData['PROJECT_SETUP_ID'];?>"
                	id="chk<?php echo $myData['PROJECT_SETUP_ID'];?>" name="chkProject[]"
                    class="chkSelect css-checkbox ">
				<label for="chk<?php echo $myData['PROJECT_SETUP_ID'];?>" class="css-label lite-green-check"></label>
                <?php }?>
          </td>
          <?php }?>
        </tr>
        <tr>
            <td colspan="2" class="ui-widget-content"> Completed</td>
            <td class="ui-widget-content">Hectares</td>
           	<td class="ui-widget-content" align="center">
				<?php echo (($myData['FA_COMPLETED_HA']['estQuantity']=='NA')? 'NA':'-');?>
            </td>
            <td class="ui-widget-content" align="center"><?php echo $myData['FA_COMPLETED_HA']['progLastFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['FA_COMPLETED_HA']['overallTargetFY'];?></td>
            <td class="ui-widget-content" align="center"><?php echo $myData['FA_COMPLETED_HA']['achivEndMonthFY'];?></td>
            <td class="ui-widget-content" align="center"><?php echo $myData['FA_COMPLETED_HA']['overallAchivEndMonth'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['FA_COMPLETED_HA']['percentOverallAchivEndMonth'];?>&nbsp;</td>
        </tr>
        <!-- Land Acquisition --> 
		<tr>
            <td class="ui-widget-content" rowspan="4">Land Acquisition Cases </td>
            <td colspan="2" rowspan="2" class="ui-widget-content">Submitted </td>
            <td class="ui-widget-content">Number</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_NO']['estQuantity'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_NO']['progLastFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_NO']['overallTargetFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_NO']['achivEndMonthFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_NO']['overallAchivEndMonth'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_NO']['percentOverallAchivEndMonth'];?>&nbsp;</td>
        </tr>   
		<tr>
            <td class="ui-widget-content">Hectares</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_HA']['estQuantity'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_HA']['progLastFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_HA']['overallTargetFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_HA']['achivEndMonthFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_HA']['overallAchivEndMonth'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_HA']['percentOverallAchivEndMonth'];?>&nbsp;</td>
        </tr>  
        <!-- Land Acquisition 2 -->  
        <tr>
            <td colspan="2" rowspan="2" class="ui-widget-content">Completed</td>
            <td class="ui-widget-content">Number</td>
            <td class="ui-widget-content" align="center"><?php echo (($myData['LA_COMPLETED_NO']['estQuantity']=='NA')? 'NA':'-');?></td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_COMPLETED_NO']['progLastFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_COMPLETED_NO']['overallTargetFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_COMPLETED_NO']['achivEndMonthFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_COMPLETED_NO']['overallAchivEndMonth'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_COMPLETED_NO']['percentOverallAchivEndMonth'];?>&nbsp;</td>
        </tr>
		<tr>
            <td class="ui-widget-content">Hectares</td>
            <td class="ui-widget-content" align="center"><?php echo (($myData['LA_COMPLETED_HA']['estQuantity']=='NA')? 'NA':'-');?></td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_COMPLETED_HA']['progLastFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_COMPLETED_HA']['overallTargetFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_COMPLETED_HA']['achivEndMonthFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_COMPLETED_HA']['overallAchivEndMonth'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['LA_COMPLETED_HA']['percentOverallAchivEndMonth'];?>&nbsp;</td>
        </tr>
        <!-- Headworks -->
		<tr>
		  <td colspan="3" class="ui-widget-content">Earthwork <br />(As per "L" Earthwork section of AA)</td>
		  <td class="ui-widget-content">Th.Cum</td>
		 <td class="ui-widget-content" align="center"><?php echo $myData['L_EARTHWORK']['estQuantity'];?>&nbsp;</td>
	        <td class="ui-widget-content" align="center"><?php echo $myData['L_EARTHWORK']['progLastFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['L_EARTHWORK']['overallTargetFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['L_EARTHWORK']['achivEndMonthFY'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['L_EARTHWORK']['overallAchivEndMonth'];?>&nbsp;</td>
            <td class="ui-widget-content" align="center"><?php echo $myData['L_EARTHWORK']['percentOverallAchivEndMonth'];?>&nbsp;</td>
	    </tr>
		<tr>
			<td rowspan="4" class="ui-widget-content">Masonry/Concrete <br />(As per &quot;C&quot; Masonry section of AA)</td>
			<td colspan="2" class="ui-widget-content"><small>Masonry/Concrete</small></td>
            <td class="ui-widget-content">Th. Cum </td>
            <td align="center" class="ui-widget-content"><?php echo $myData['C_MASONRY']['estQuantity'];?>&nbsp;</td>
            <td align="center" class="ui-widget-content"><?php echo $myData['C_MASONRY']['progLastFY'];?>&nbsp;</td>
            <td align="center" class="ui-widget-content"><?php echo $myData['C_MASONRY']['overallTargetFY'];?>&nbsp;</td>
            <td align="center" class="ui-widget-content"><?php echo $myData['C_MASONRY']['achivEndMonthFY'];?>&nbsp;</td>
            <td align="center" class="ui-widget-content"><?php echo $myData['C_MASONRY']['overallAchivEndMonth'];?>&nbsp;</td>
            <td align="center" class="ui-widget-content"><?php echo $myData['C_MASONRY']['percentOverallAchivEndMonth'];?>&nbsp;</td>
        </tr>
		<tr>
		  <td rowspan="2" class="ui-widget-content">Pipe Works</td>
		  <td class="ui-widget-content" ><strong>i. DE/PE/PVC<br />(Main &amp; Submain)</strong></td>
		  <td nowrap="nowrap" class="ui-widget-content">Mtrs</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_PIPEWORK']['estQuantity'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_PIPEWORK']['progLastFY'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_PIPEWORK']['overallTargetFY'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_PIPEWORK']['achivEndMonthFY'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_PIPEWORK']['overallAchivEndMonth'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_PIPEWORK']['percentOverallAchivEndMonth'];?></td>
	    </tr>
		<tr>
		  <td class="ui-widget-content" ><strong>ii. Lateral for <br />Drip/sprinkler</strong></td>
		  <td nowrap="nowrap" class="ui-widget-content">Mtrs</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_DRIP_PIPE']['estQuantity'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_DRIP_PIPE']['progLastFY'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_DRIP_PIPE']['overallTargetFY'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_DRIP_PIPE']['achivEndMonthFY'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_DRIP_PIPE']['overallAchivEndMonth'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_DRIP_PIPE']['percentOverallAchivEndMonth'];?></td>
	    </tr>
		<tr>
		  <td colspan="2" class="ui-widget-content">Water Pumps</td>
		  <td nowrap="nowrap" class="ui-widget-content">Numbers</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_WATERPUMP']['estQuantity'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_WATERPUMP']['progLastFY'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_WATERPUMP']['overallTargetFY'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_WATERPUMP']['achivEndMonthFY'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_WATERPUMP']['overallAchivEndMonth'];?>&nbsp;</td>
		  <td align="center" class="ui-widget-content"><?php echo $myData['C_WATERPUMP']['percentOverallAchivEndMonth'];?></td>
	  </tr>
        <!-- Canals --> 
		<tr>
            <td colspan="3" class="ui-widget-content">Building Works <br />( As per &quot;K&quot; Building section of AA)<br /> Control Rooms</td>
            <td class="ui-widget-content">Numbers</td>
            <td align="center" class="ui-widget-content"><?php echo $myData['K_CONTROL_ROOMS']['estQuantity'];?>&nbsp;&nbsp;&nbsp;</td>
            <td align="center" class="ui-widget-content"><?php echo $myData['K_CONTROL_ROOMS']['progLastFY'];?>&nbsp;</td>
            <td align="center" class="ui-widget-content"><?php echo $myData['K_CONTROL_ROOMS']['overallTargetFY'];?>&nbsp;</td>
            <td align="center" class="ui-widget-content"><?php echo $myData['K_CONTROL_ROOMS']['achivEndMonthFY'];?>&nbsp;</td>
            <td align="center" class="ui-widget-content"><?php echo $myData['K_CONTROL_ROOMS']['overallAchivEndMonth'];?>&nbsp;</td>
            <td align="center" class="ui-widget-content"><?php echo $myData['K_CONTROL_ROOMS']['percentOverallAchivEndMonth'];?>&nbsp;</td>
        </tr>
		<?php } //foreach?>
<?php } //if?>
</tbody>
</table>
<?php echo $lockMessage;?>
</div>
</form>
<div class="mysavebar" align="right" style="float:right;width:100%" id="mySaveDiv">
<?php 
if(!$isAllValid){
	echo '<span class="ui-state-error" style="padding:10px">
	<span class="cus-lightbulb"></span> Not Ready to Lock Division...'.
	(($invalidMonthCount)? '<span class="cus-lightbulb"></span>'.$invalidMonthCount.' Projects\' Monthly record Not Locked...':'').
	(($progressCount)? '<span class="cus-lightbulb"></span>'.$progressCount.' Projects have Progress More than 110%...':'').
	(($noMonthlyEntryCount)? '<span class="cus-lightbulb"></span>'.$noMonthlyEntryCount.' Projects Does not have Monthly Data...':'').
	'</span> &nbsp; &nbsp; ';
}

if(!$reportOnlyPage){
	if($invalidMonthCount || $progressCount || $noMonthlyEntryCount){
	}else{
		if($canSELock){
			echo getButton('Lock Projects', 'lockProjects()', 4, 'cus-lock');
		}
	}
}?>
</div>
<script>
$().ready(function(){
	$("#select_all").click(function () {
		var mystatus = $("#select_all").prop('checked');
		//var ss = mystatus + ':';
		$('.chkSelect').each(function(){
		//	ss += $(this).attr('id') +  ' - ';
			$(this).prop('checked', mystatus);
		});
		//alert(ss);
	});
	var $demopp = $('#rptPP');
	$demopp.floatThead({
		scrollContainer: function($table){
			return $table.closest('.wrapper');
		}
	});
	<?php if(!$isAllValid){
		$str = (($invalidMonthCount)? $invalidMonthCount .
			" परियोजनाओं में गत माह की भौतिक प्रगति को संभाग द्वारा लॉक नहीं किया गया है अतः आप इस संभाग की प्रविष्टियों को लॉक नहीं कर सकते...":'');
		$str += (($noMonthlyEntryCount)? "\n".$noMonthlyEntryCount .
			" परियोजनाओं में भौतिक प्रगति प्रविष्ट नहीं किया गया है...":'');
		echo "alert('".$str."');";
		/*'Not Ready to Lock Division...'\n".
		(($invalidMonthCount)? $invalidMonthCount .' Projects\' Monthly record Not Locked...':'').
		(($progressCount)? $progressCount.' Projects have Progress More than 110%...':'').');';*/
	}?>
	
});
function lockProjects(){
	//var mCheckedLength = $('input[name="chkProject[]"]:checked').length;
	//var mProjectLength = $('.mhide').length;
	//alert('a:' + mCheckedLength + ' b:'+ mProjectLength);
	if($('input[name="chkProject[]"]:checked').length==$('.mhide').length){
		//save data
		var params = {
			'divid':'mySaveDiv', 
			'url':'lockProjects', 
			'data':$('#frmSELock').serialize(), 
			'donefname': 'doneLProject', 
			'failfname' :'failLProject', 
			'alwaysfname':''
		};
		callMyAjax(params);
	}else{
		alert('Unable to Lock Projects...');
	}
}
function doneLProject(response){
	var resp = parseMyResponse(response);
	if(resp.success==1){
		$('#message').html(resp.message);
		alert(resp.message);
		$('#tabs').html(resp.message);
	}else{
		$('#message').html(resp.message);
		alert(resp.message);
	}
}
function failLProject(){}
function doThisProject(){}
</script>
