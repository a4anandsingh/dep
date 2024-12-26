<title>PROMON (Micro Irrigation)- Division Lock by SE - WRD MIS</title>
<?php  
date_default_timezone_set('Asia/Kolkata');
$message='';
echo $office_list;?>
<!--Start of Content -->
<form name="all_reports" id="all_reports" onsubmit="return false">
<div id="content_wrapper">
	<div id="page_heading">
	    <strong><?php echo $page_heading;?></strong>
    </div>
    <div style="width:100%;float:left">
        <div id="office_filter" class="messagebox"></div>
    </div>
    <div style="width:100%;float:left">
    	<?php echo getMessageBox('message', $message);?>
    </div>
	<div style="width:100%;float:left" class="ui-widget-content">
  	    <div class="ui-widget-content" style="padding:5px;overflow:hidden">
            <table width="100%" border="0" cellpadding="5" cellspacing="2" class="ui-widget-content">
            <tr>
                <td colspan="3" class="ui-widget-header" align="center" valign="middle">
                 <div class="mysavebar" align="left" style="float:left;font-size:18px;padding-top:11px;padding-bottom:11px;text-align:center">
                	<?php //showArrayValues($monthList);?>
                	<select id="REPORT_SESSION_ID" name="REPORT_SESSION_ID"
                    	class="select2" onchange="changeMyMonthList(this.value)" style="width:300px">
                    	<?php echo $sessionOptionsReport;?>
                    </select> -
                    <?php $curMonth = date("n");
						//showArrayValues($monthList);?>
                    <select id="REPORT_MONTH_YEAR" name="REPORT_MONTH_YEAR" 
                    	class="select2"  style="width:300px" data-placeholder="Select Month">
                    	<?php 
							$curMonthYear = date("n-Y");
							//$curYear = date("Y");
							//$curMonth = date("n");
							$i = 1;
							foreach($monthList as $mlist){
								/*$arrD = explode('-', $mlist['OPTION_VALUE']);
								if($curYear==$arrD[1]){
									if($curMonth==
									if($arrD[0]==($curMonth-1)){
										
									}
								}*/
								if($mlist['SESSION_ID']==$lastSessionID){
									echo '<option value="'.$mlist['OPTION_VALUE'].'" '.
									((count($monthList)==$i)? 'selected="selected"':'').'>'.
									$mlist['OPTION_TEXT'].
									//((count($monthList)==$i)? 'sel':' '.$i).
									'</option>';
								}
								$i++;
							}
						?>
                    </select>
                    </div>
                    <div class="mysavebar" align="right" style="float:right">
                	<div id="LoadReportDiv">
                	<a class="fm-button ui-state-default ui-corner-all" onclick="generateReport() ">
	                   	<i class="cus-report-magnify"></i> Show Physical Progress
                    </a>
                	<a class="fm-button ui-state-default ui-corner-all" onclick="closeMe()">
                     <i class="cus-delete"></i> Close Tab
                    </a>
                    </div>
                    <div id="tmpLoadReportDiv" style="display:none">
	                    <div align="center" style="width:90%;color:#ffff00">
                            <span class="loadingnew"></span> 
                            Working...कृपया प्रतिक्षा करें...
                        </div>
                        <div id="progressbar"><div class="progress-label">Loading...</div></div>
                    </div>
                    </div>
                </td>
            </tr>
            </table>
		</div>
	</div>
</div>
</form>
<!--End of Content -->
<script type="text/javascript">
var objOffice ;
var tmpData = '';
$().ready(function(){
	$('#tabs').addClass('ui-widget-content').css('padding-top', '4px');
	$('.select2').select2({placeholder: "Select",allowClear: true});
	showOfficeFilterBox();
	$('#REPORT_SESSION_ID').on('change', function(){
		changeMyMonthList(this.value);
	});
});
//
function showReportLoad(status) {
	if(status){
		//window.tmpData = $('#LoadReportDiv').html();
		//$('#LoadReportDiv').html( $('#tmpLoadReportDiv').html() );
		$('#tabs').html( $('#tmpLoadReportDiv').html() )
			.addClass('mysavebar')
			.removeClass('ui-widget-content');
	}else{
		//alert(window.tmpData);
		//$('#LoadReportDiv').html(window.tmpData);
		$('#tabs').html( $('#tmpLoadReportDiv').html() )
			.removeClass('mysavebar')
			.addClass('ui-widget-content');

		$('#tabs').html('');
	}
}
function generateReport() {
	var mVal = $("#SEARCH_EE_ID").select2('val');
	if(mVal==0){
		//alert('Please Select Executive Engineer...');
        showAlert('Error','Please Select Executive Engineer.','cancel');
		return;
	}
	/*var mVal = $("#SEARCH_PROJECT_TYPE_ID").select2('val');
	if(mVal==0){
		alert('Please Select Project Type...');
		return;
	}*/
	showReportLoad(true);
	var params = {
		'divid':'mySaveDiv', 
		'url':'physical_progress', 
		'data':$('#all_reports').serialize(), 
		'donefname': 'doneProject', 
		'failfname' :'failProject', 
		'alwaysfname':''
	};
	callMyAjax(params);
}
function doneProject(response){
	showReportLoad(false);
	$('#tabs').html(response);
}
function failProject(){}
function doThisProject(){}
function closeMe(){
	$('#tabs').html('');
}
search_office = new clsOffice();
sdo_search_office = new clsOffice();
//
function showOfficeFilterBox(){
	$.ajax({
		type:"POST",
		url:'showOfficeFilterBox',
		data:{'prefix':'search_office'},
		success:function(msg){
			$('#office_filter').html(msg);
			search_office.init();
		}
	});
}
//
function getMonthYearList(){
	$.ajax({
		async: true,
		type:"POST",
		mtype:"POST",
		url:'show_month_year',
		success:function(data){
			$('#month_year').html(data);
		}
	});
}
//
function showProjectData(msg){
	$('#modalBox').html(parseAndShowMyResponse(msg));
	centerDialog('modalBox');
}
function printData(prjID){
	var data = {'PROJECT_ID':prjID};
	var title = 'Print Data';
	showModalBox('modalBox2', 'printData', data, title, 'showProjectDataPrint', true);
}
function showProjectDataPrint(msg){
	$('#modalBox2').html(parseAndShowMyResponse(msg));
	//$('#modalBox').html(parseMyResponse(msg));
	centerDialog('modalBox2');
}
function changeMyMonthList(sessionid){
	//alert(sessionid);
	var mmonth = Array();
	<?php $i=0;
	foreach($monthList as $mList){
		echo 'mmonth['.$i.'] = Array('.
			$mList['SESSION_ID'].', "'.
			$mList['OPTION_VALUE'].'", "'.
			$mList['OPTION_TEXT'].'");'.
			"\n";
		$i++;
	}?>
	var s = '';
	for(i=0; i<mmonth.length; i++){
		if(mmonth[i][0] == sessionid){
			s += '<option value="' + mmonth[i][1] + '" >' + mmonth[i][2] + '</option>';
		}
	}
	$('#REPORT_MONTH_YEAR').select2('data', null);
	$('#REPORT_MONTH_YEAR').html(s);
}
</script>