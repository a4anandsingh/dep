<title>PROMON - Division UnLock by SE - WRD MIS</title>
<?php  
date_default_timezone_set('Asia/Kolkata');
$message='';?>
<!--Start of Content -->
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
    <form name="frmSELock" id="frmSELock" onsubmit="return false;" method="post" action="">
	<div style="width:100%;float:left">
        <?php $entryMonth = date("Y-m" , strtotime("-1 month")).'-01';?>
        <input type="hidden" id="MONTH_DATE" name="MONTH_DATE" value="<?php echo date("Y-m-d", strtotime($entryMonth));?>" />
        <table border="1" align="center" cellpadding="8" cellspacing="1" class="ui-widget-content">
          <tr>
            <td colspan="2" align="center" valign="middle" nowrap="nowrap" class="ui-state-default">
            	<big>For Month <?php echo date("F, Y" , strtotime($entryMonth) );?></big>
             </td>
          </tr>
          <tr>
            <td align="left" valign="middle" nowrap="nowrap" class="ui-state-default">SE </td>
            <td align="left" valign="top" class="ui-widget-content" >
            <select name="SE_ID" id="SE_ID" class="select2" style="width:700px" onchange="getEE(this.value)">
				<?php echo $selist;?>
            </select>
            </td>
          </tr>
          <tr>
            <td align="left" valign="middle" nowrap="nowrap" class="ui-state-default">EE </td>
            <td align="left" valign="top" class="ui-widget-content" >
            	<select name="EE_ID" id="EE_ID" class="select2" style="width:700px" onchange="getDetails(this.value)">
       			</select>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="ui-widget-content" id="divData">&nbsp;</td>
          </tr>
        </table>
	</div>
    </form>
	</div>
</div>
<!--End of Content -->
<script type="text/javascript">
$().ready(function(){
	$('.select2').select2({placeholder:"Select", allowClear:true});
});
//
function getEE(seid){
	var params = {
		'divid':'none', 
		'url':'getEEOfficeOptions', 
		'data':{'seid':seid}, 
		'donefname': 'doneEE', 
		'failfname' :'failEE', 
		'alwaysfname':''
	};
	callMyAjax(params);
}
function doneEE(response) {
	$('#EE_ID').html(response);
}
function failEE() {
}

function getDetails(){
	var eeId = $("#EE_ID").select2('val');
	var monthDate = $("#MONTH_DATE").val();
	if(eeId==0){
		alert('Please Select Executive Engineer...');
		return;
	}
	$("#divData").html(getLoadingDiv());
	var params = {
		'divid':'none', 
		'url':'showDetails', 
		'data':{'EE':eeId, 'monthDate':monthDate}, 
		'donefname': 'doneDetails', 
		'failfname' :'failDetails', 
		'alwaysfname':''
	};
	callMyAjax(params);
}
function doneDetails(response){
	$('#divData').html(response);
}
function failDetails(){}
function doThisProject(){}
</script>