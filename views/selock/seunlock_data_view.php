<form name="frmProjects" id="frmProjects" onsubmit="return false;">
<input type="hidden" id="PROJECT_ID" name="PROJECT_ID" value="<?php echo $projectID;?>" />
<table width="100%" border="0" cellpadding="3" class="ui-widget-content">
<tr>
    <td class="ui-state-default">Remarks</td>
    <td class="ui-widget-content">
	    <textarea name="REMARKS" id="REMARKS" cols="45" rows="3"></textarea>
    </td>
</tr>
</table>
	<div id="mySaveDiv" align="right" class="mysavebar">
    <?php echo getButton('Unlock Last Month', 'saveData()', 4, 'cus-lock-open').' &nbsp; '.
		 getButton('Close', 'closeDialog()', 4, 'icon-remove-sign');
	?>
    </div>
</form>
<script type="text/javascript" language="javascript">
$().ready(function(){
	//
});
</script>