<title>PROMON - Division UnLock by SE - WRD MIS</title>
<?php  
date_default_timezone_set('Asia/Kolkata');
$message='';
echo $office_list;?>
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
	<div style="width:100%;float:left" id="divData">

	</div>
</div>
<!--End of Content -->
<script type="text/javascript">
var objOffice ;
var tmpData = '';
$().ready(function(){
	$('.select2').select2({placeholder: "Select",allowClear: true});
	showOfficeFilterBox();
});
//

function proceed() {
	var eeId = $("#SEARCH_EE_ID").select2('val');
	if(eeId==0){
		alert('Please Select Executive Engineer...');
		return;
	}
	/*var projectTypeId = $("#SEARCH_PROJECT_TYPE_ID").select2('val');
	if(projectTypeId==0){
		alert('Please Select Project Type...');
		return;
	}*/
	$("#divData").html(getLoadingDiv());
	var params = {
		'divid':'none', 
		'url':'showEntryBox', 
		'data':{'EE':eeId}, 
		'donefname': 'doneProject', 
		'failfname' :'failProject', 
		'alwaysfname':''
	};
	callMyAjax(params);
}
function doneProject(response){
	$('#divData').html(response);
}
function failProject(){}
function doThisProject(){}

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

</script>