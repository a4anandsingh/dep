<title>Lock Release Management System</title>
<?php echo $office_list;?>
<div id="content_wrapper">
    <div id="page_heading">
        <?php echo $page_heading;?>
    </div>
   <div style="width:100%;float:left">
        <div id="office_filter" class="messagebox"></div>
    </div>
    <div style="width:100%;float:left">
    	<?php echo getMessageBox('message', $message);?>
    </div>
    <div style="width:100%;float:left" align="center">
        <table id="lockListGrid"></table> 
        <div id="lockListGridPager"></div>
    </div>
</div>
<script type="text/javascript">
$().ready(function(){
	showOfficeFilterBox();
});
search_office = new clsOffice();
sdo_search_office = new clsOffice();
/** OK */
function showOfficeFilterBox(){
	$.ajax({
		type:"POST",
		url:'showOfficeFilterBox',
		data:{'prefix':'search_office'},
		success:function(msg){
			$('#office_filter').html(msg);
			search_office.init();
			getLockGrid();
		}
	});
}
/** OK */
function refreshSearch(){
	jQuery("#lockListGrid").setGridParam({
		postData :{
			'CE_ID':$('#search_officeCE_ID').val(), 
			'SE_ID':$('#search_officeSE_ID').val(), 
			'EE_ID':$('#search_officeEE_ID').val(),
			'SEARCH_PROJECT_NAME':$('#SEARCH_PROJECT_NAME').val()
		}
	}).trigger('reloadGrid');	
}
function unLockOperation(mode){
	s = jQuery("#lockListGrid").jqGrid('getGridParam','selarrrow');
	if(s==''){
		alert('Please Select Project...');
	}else{
		var mydata = { 'projectid':s, 'mode':mode};
		if(mode==0 || mode==99){
			var params = {'divid':'', 'url':'unlockData', 'data':mydata, 
				'donefname': 'getUnLockStatus', 'failfname' :'getUnLockStatus', 'alwaysfname':'none'};
			callMyAjax(params);
		}else{
			var showTitle = 'Project Unlock Management';
			showModalBox('modalBox', 'unlockData', mydata, showTitle, 'getLockWindow', true, false);
		}
	}
}
function getUnLockStatus(msg){
	$('#message').html(msg);
	refreshSearch();
}
function getLockWindow(msg){
	$('#modalBox').html(msg);
	centerDialog('modalBox');
	//$("#modalBox").dialog('close');
}
/**OK*/
function getLockGrid(){
	<?php echo $lock_grid;?>
	jQuery("#lockListGrid").jqGrid('setGroupHeaders', {
		useColSpanStyle:true, 
		groupHeaders:[
			{startColumnName:'MONTHLY_EXISTS', numberOfColumns: 2, titleText: 'Monthly'}
		]	
	});
}
/**OK*/
function saveData(){
	if( $('#REMARKS').val()==""){
		alert('Remark is must...');
		return false;
	}
	//alert($('#frmProjects').serialize());
	//return;
	myValidation = true;
	if(myValidation){
		var params = {
			'divid':'mySaveDiv', 
			'url':'saveData', 
			'data':$('#frmProjects').serialize(), 
			'donefname': 'doneProject', 
			'failfname' :'failProject', 
			'alwaysfname':''
		};
		callMyAjax(params);
	}else{
		showMyAlert('Error...', 'There is/are some Required Data... <br />Please Check & Complete it.', 'warn');
		//alert('There is/are some Required Data... ' + "\n Please Check & Complete it." );
	}
}
/* */
function doneProject(response){
	$("#lockListGrid").trigger('reloadGrid');
	$('#message').html(response);
	$("#modalBox").dialog('close');
}
/* */
function failProject(response){
	$('#message').html(parseAndShowMyResponse(response));
}
/* */
function showEntryBox(id){
	var showTitle = 'Project Monthly Unlock Management';
	var data = {'project_id':id};
	showModalBox('modalBox', 'showEntryBox', data, showTitle, 'showData', true, false);
}
/* */
function showData(msg){
	//alert(msg);
	$('#modalBox').html(msg);
	centerDialog('modalBox');
}
function unlock(mode, val){
	s = jQuery("#lockListGrid").jqGrid('getGridParam','selarrrow');
	if(s==''){
		alert('Please Select Project...');
	}else{
		var mydata = { 'projectid':s, 'mode':mode, 'myValue':val};
		var params = {
			'divid':'', 
			'url':'setLock', 
			'data':mydata, 
			'donefname': 'getUnLockStatus1', 
			'failfname' :'getUnLockStatus1', 
			'alwaysfname':'none'
		};
		callMyAjax(params);
	}
}
function getUnLockStatus1(msg){
	$('#message').html(msg);
	closeDialog('modalBox');
	refreshSearch();	//centerDialog('modalBox');
	//$("#modalBox").dialog('close');
}
function showOptions(choice){
	//alert(choice);
	choice = parseInt(choice);
	switch(choice){
		case 0:
			$('#divTarget').hide();
			$('#divMonthly').hide();
			break;
		case 1:
			$('#divTarget').show();
			$('#divMonthly').hide();
			break;
		case 2:
			$('#divTarget').hide();
			$('#divMonthly').show();
			break;
	}
}
</script>