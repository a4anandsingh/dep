<input type="hidden" id="ID" name="ID" value="<?php echo $arrData['ID'];?>" />
<table width="100%" border="1" align="center" cellpadding="8" cellspacing="1" class="ui-widget-content">
<tr>
  <td align="left" valign="middle" class="ui-state-default"><strong>Relaxation For :</strong></td>
  <td align="left" valign="top" class="ui-widget-content" >
    <input type="checkbox" id="IS_PROMON" name="IS_PROMON" class="css-checkbox " value="1"
       	<?php echo ($arrData['IS_PROMON']==1)? 'checked="checked"':'';?>  />
    <label for="IS_PROMON" class="css-label lite-red-check">Promon</label>
    <input type="checkbox" id="IS_RRR" name="IS_RRR" class="css-checkbox " value="1"
       		<?php echo ($arrData['IS_RRR']==1)? 'checked="checked"':'';?>  >
    <label for="IS_RRR" class="css-label lite-green-check">RRR/Remodelling</label>
    </td>
  <td align="left" valign="middle" class="ui-state-default"><strong>Relaxation Date :</strong></td>
  <td align="left" valign="top" class="ui-widget-content" ><input type="text" id="RELAXATION_FROM" name="RELAXATION_FROM" 
        	size="14" class="centertext"
        	value="<?php echo myDateFormat($arrData['RELAXATION_FROM']);?>" />
    -
    <input type="text" id="RELAXATION_TO" name="RELAXATION_TO" 
        	size="14" class="centertext"
        	value="<?php echo myDateFormat($arrData['RELAXATION_TO']);?>" /></td>
</tr>
<tr>
  <td align="left" class="ui-state-default"><strong>Remarks</strong></td>
  <td colspan="3" align="left" valign="top" class="ui-widget-content" >
    <textarea name="REMARKS" cols="70" rows="2" id="REMARKS"><?php echo $arrData['REMARKS'];?></textarea></td>
  </tr>
<tr>
  <td colspan="4" align="left" class=" mysavebar">
  <?php echo getButton('Save Relaxation', 'saveDataThis()',4, 'cus-disk');?>
  </td>
  </tr>
</table>
<?php 
$minDate = date("Y-m-d");
if($arrData['ID']){
	$minDate = $arrData['RELAXATION_FROM'];
}
$maxDate = strtotime("+7days", strtotime($minDate));

?>
<input type="hidden" id="maxdate" value="<?php echo myDateFormat($maxDate);?>" />
<input type="hidden" id="mindate" value="<?php echo myDateFormat($minDate);?>" />
</form>
</div>
<script>
$().ready(function(){
	$('#RELAXATION_FROM').attr("placeholder", "dd-mm-yyyy").datepicker({ 
		dateFormat:'dd-mm-yy', changeMonth:true, changeYear:true, showOtherMonths: true, maxDate:new Date 
	});
	$('#RELAXATION_TO').attr("placeholder", "dd-mm-yyyy").datepicker({
		dateFormat:'dd-mm-yy', changeMonth:true, changeYear:true, showOtherMonths: true,
		beforeShow: function(input, inst) {	return setMinMaxDate('#RELAXATION_FROM', '#maxdate'); }
	});
});
function saveDataThis(){
	var params = {
		'divid':'mySaveDiv', 
		'url':'saveRelaxationData', 
		'data':$('#frmSELock').serialize(), 
		'donefname': 'doneLProject', 
		'failfname' :'failLProject', 
		'alwaysfname':''
	};
	callMyAjax(params);
}
function doneLProject(response){
	$('#message').html(response);
	$('#divData').html('');
	
}
function failLProject(){}
function doThisProject(){}
</script>