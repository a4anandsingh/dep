<?php
echo getPrintButton("prjtarget_report", 'Print', 'xprjtarget_report');?>
<div id="prjtarget_report">
    <table width="100%" border="0" cellpadding="4" cellspacing="1" class="ui-widget-content">
    <tr>
        <td colspan="11" align="center" class="ui-widget-header"><big><strong>Financial and Physical Target Setup</strong></big></td>
    </tr>
    <tr>
        <td colspan="11" align="center" class="ui-state-default"><big><strong>For the Financial Year - <?php echo $session_year;?></strong></big></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="2" cellspacing="1" class="ui-widget-content">
            <tr>
                <td width="100" class="ui-state-default"><strong>Name of Project</strong></td>
                <td class="ui-widget-content"><big><strong><?php echo $PROJECT_NAME;?></strong></big></td>
                <td width="100" class="ui-state-default"><strong>Project Code</strong></td>
                <td width="150" class="ui-widget-content"><strong><?php echo $PROJECT_CODE;?></strong></td>
            </tr>
            <tr>
                <td class="ui-state-default"><strong>Budget Amount</strong></td>
                <td class="ui-widget-content"><?php echo $BUDGET_AMOUNT;?>(Rs. In Lakhs)</td>
                <td class="ui-state-default"><strong><?php echo $AA_RAA; ?> Amount (Rs.) </strong></td>
                <td class="ui-widget-content" align="right"><strong><?php echo $AA_AMOUNT; ?></strong> (in Lakh)</td>
            </tr>
            </table>
        </td>
    </tr>
    </table>
    <br />
    <table width="100%" border="1" cellpadding="4" cellspacing="1" class="ui-widget-content" id="xprjtarget_report">
    <thead>
   <tr>
                    <th rowspan="2" class="ui-state-default">Month</th>
                    <th  rowspan="2" class="ui-state-default">Financial</th>
                    <th rowspan="2" colspan="2"  class="ui-state-default">Land Acquisition <br/> (cases to be<br/> submitted)</th>                 
                    <th rowspan="2" class="ui-state-default">Forest<br/> Acquisition </th>                    
                         <th colspan="3" class="ui-state-default">Headworks</th>
                      <th colspan="4" class="ui-state-default">Canals</th>
                 
                    <th colspan="4"  class="ui-state-default">Irrigation Potential<br/> to be created</th>
                     <th colspan="3"  class="ui-state-default">Irrigation Potential<br/> to be Restored</th>
                </tr>
                <tr>
                    <th  class="ui-state-default">Earthwork </th>
                    <th  class="ui-state-default">Masonry/Concrete</th>
                    <th  class="ui-state-default">Steel Work </th>
                    <th  class="ui-state-default">Earth Work </th>
                    <th  class="ui-state-default">Structure </th>
                    <th  class="ui-state-default">Structure Masonry / Conc.     </th>
                    <th  class="ui-state-default">Lining </th>
                    <th class="ui-state-default">Block</th>
                    <th class="ui-state-default">Kharif</th>
                    <th class="ui-state-default">Rabi</th>
                    <th class="ui-state-default">Total</th>
                     
                    <th class="ui-state-default">Kharif</th>
                    <th class="ui-state-default">Rabi</th>
                    <th class="ui-state-default">Total</th>
                </tr>
                 
              
                <tr>
                    <th class="ui-state-default">&nbsp;</th>
                    <th class="ui-state-default">Rs. Lacs</th>
                   
                    <th class="ui-state-default">Number</th>
                    <th class="ui-state-default">Hectares</th>
                    <th class="ui-state-default">Hectares</th>
                 
                    <th class="ui-state-default">Th Cum</th>
                    <th class="ui-state-default">Th Cum</th>
                    <th class="ui-state-default">MT</th>
                    <th class="ui-state-default">Th Cum</th>
                    <th class="ui-state-default">No</th>
                    <th class="ui-state-default">Th Cum</th>
                    <th class="ui-state-default">KM</th>
                    <th class="ui-state-default">Name</th>
                    <th class="ui-state-default">Ha</th>
                    <th class="ui-state-default">Ha</th>
                    <th class="ui-state-default">Ha</th>
                      
                    <th class="ui-state-default">Ha</th>
                    <th class="ui-state-default">Ha</th>
                    <th class="ui-state-default">Ha</th>
                </tr>
    </thead>
    <tbody>
        <?php
        $monthsOfFinyear = array( 1=>'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $i=4;
        $arrRows = array();
        //'EXPENDITURE',
        $totalFields = array(
            'LA_NO', 'LA_HA', 'FA_HA', 'EXPENDITURE',
            'HW_EARTHWORK', 
            'HW_MASONRY', 'STEEL_WORK', 'CANAL_EARTHWORK',
            'CANAL_STRUCTURE', 'CANAL_STRUCTURE_MASONRY','CANAL_LINING'
        ); 
        //, 'KHARIF', 'RABI','IP_TOTAL',
        $arrTotal = array();
        foreach($totalFields as $f) $arrTotal[$f] = 0;
      //  showArrayValues($records);       // exit; CANAL_EARTHWORK
        //for($a=1 ; $a<=12;$a++){
        foreach($records as $key => $targetDatum) {
            $time = '';
            $time = strtotime($records[$key]->TARGET_DATE);
            $a = date("m", $time);

            foreach($totalFields as $f){
                //echo ':::'.$a->{$totalFields[$iC]}.':::';
                $arrTotal[$f] += (float) $records[$key]->{$f};
            }
            //echo '<br />';
            //print_r($records);
            $arrMonthTarget = array(
                array(
                    'NAME'=>'MON',
                    //'VALUE'=>$monthsOfFinyear[$i],
                    'VALUE' => date('M', strtotime($records[$key]->TARGET_DATE)),
                    'TYPE'=>'caption',
                    'MONTH' =>$i,
                    'COL_WIDTH' =>0,
                    'SHOW'=>1
                ),
                array(
                    'NAME'=>'EXPENDITURE',
                    'VALUE'=> $records[$key]->EXPENDITURE,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>3,
                    'SHOW'=>1
                ),
                array(
                    'NAME'=>'LA_NO',
                    'VALUE'=> $records[$key]->LA_NO,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>3,
                    'SHOW'=> ( ($setupData['LA_NA']==0)? 1:0)
                ),
                array(
                    'NAME'=>'LA_HA',
                    'VALUE'=> $records[$key]->LA_HA,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>3,
                    'SHOW'=> ( ($setupData['LA_NA']==0)? 1:0)
                ),
                array(
                    'NAME'=>'FA_HA',
                    'VALUE'=> $records[$key]->FA_HA,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>3,
                    'SHOW'=> ( ($setupData['FA_NA']==0)? 1:0)
                ),
                array(
                    'NAME'=>'HW_EARTHWORK',
                    'VALUE'=> $records[$key]->HW_EARTHWORK,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>3,
                    'SHOW'=> ( ($setupData['HW_EARTHWORK_NA']==0)? 1:0)
                ),
                
                array(
                    'NAME'=>'HW_MASONRY',
                    'VALUE'=> $records[$key]->HW_MASONRY,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>3,
                    'SHOW'=> ( ($setupData['HW_MASONRY_NA']==0)? 1:0)
                ),

                array(
                    'NAME'=>'STEEL_WORK',
                    'VALUE'=> $records[$key]->STEEL_WORK,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>3,
                    'SHOW'=> ( ($setupData['STEEL_WORK_NA']==0)? 1:0)
                ),
                array(
                    'NAME'=>'CANAL_EARTHWORK',
                    'VALUE'=> $records[$key]->CANAL_EARTHWORK,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>3,
                    'SHOW'=> ( ($setupData['CANAL_EARTHWORK_NA']==0)? 1:0)
                ),
                array(
                    'NAME'=>'CANAL_STRUCTURE',
                    'VALUE'=> $records[$key]->CANAL_STRUCTURE,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>3,
                    'SHOW'=> ( ($setupData['CANAL_STRUCTURE_NA']==0)? 1:0)
                ),
                array(
                    'NAME'=>'CANAL_STRUCTURE_MASONRY',
                    'VALUE'=> $records[$key]->CANAL_STRUCTURE_MASONRY,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>3,
                    'SHOW'=> ( ($setupData['CANAL_STRUCTURE_MASONRY_NA']==0)? 1:0)
                ),
                array(
                    'NAME'=>'CANAL_LINING',
                    'VALUE'=> $records[$key]->CANAL_LINING,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>3,
                    'SHOW'=> ( ($setupData['CANAL_LINING_NA']==0)? 1:0)
                ),
                /*array(
                    'NAME'=>'IP_TOTAL',
                    'VALUE'=> $records[$a]->IP_TOTAL,
                    'TYPE'=>'text',
                    'MONTH' =>$a,
                    'COL_WIDTH' =>6,
                    'SHOW'=> ( ($setupData['IP_TOTAL_NA']==0)? 1:0),
                    'KHARIF' =>$records[$a]->KHARIF,
                    'RABI' =>$records[$a]->RABI
                )*/
                array(
                    'NAME' => 'IP_TOTAL',
                    'VALUE' => '',
                    'TYPE' => 'text',
                    'MONTH' => $a,
                    'COL_WIDTH' => 3,
                    'SHOW' => (($setupData['IP_TOTAL_NA'] == 0) ? 1 : 0),
                    'KHARIF' => '',
                    'RABI' => '',
                    'TARGET_DATE'=>$records[$key]->TARGET_DATE
                )
            );
            array_push($arrRows, $arrMonthTarget);
            if ($i==12){$i=1;} else{$i++;}
        }//for
 
        $subTotalKharif=0;
        $subTotalRabi=0;
        $subTotalIp=0;

        $grandTotalKharif=0;
        $grandTotalRabi=0;
        $grandTotalIp=0;

        $grandTotalKharifRestored=0;
        $grandTotalRabiRestored=0;
        $grandTotalIpRestored=0;


        foreach($arrRows as $arrRow){
            echo '<tr>';
			$rowspan = '';
			if(count($arrBlockIps)>1){
				$rowspan =  'rowspan="'.(count($arrBlockIps) + 1).'"';
			}
			//$rowspan = (($arrColumn['NAME'] == 'IP_TOTAL') ? '' : (count($arrBlockIps) + 1))
            foreach($arrRow as $arrColumn){
                $subTotalKharif = $subTotalRabi = $subTotalIp = 0;
                $subTotalKharifRestored = $subTotalRabiRestored = $subTotalIpRestored = 0;
                $arrMonthB = array();
                echo '<td class="ui-widget-content" ' . (($arrColumn['NAME'] == 'IP_TOTAL') ? '' : $rowspan) . ' align="center">';
                if( $arrColumn['NAME']=='MON' ){
                    echo $arrColumn['VALUE'];
                }else{
                    if( $arrColumn['SHOW'] ){
                        if( $arrColumn['NAME']=='IP_TOTAL' ){
                            /*echo $arrColumn['KHARIF'].
                                '</td><td class="ui-widget-content" align="center">'.
                                $arrColumn['RABI'].
                                '</td><td class="ui-widget-content" align="center">'.
                                $arrColumn['VALUE'];*/
                            $cnt = 0;
                            foreach ($arrBlockIps as $k => $v) {
                                array_push($arrMonthB, $k);
                                $cnt++;
                                if ($cnt > 1) {
                                    echo '<tr><td align="center" class="ui-widget-content">' . $v['BLOCK_NAME'] . '</td>';
                                } else {
                                    echo $v['BLOCK_NAME'] . '</td>';
                                }
                                echo '<td class="ui-widget-content" align="center">';
                                echo $targetBlockData[$arrColumn['TARGET_DATE']][$k]->KHARIF . '</td>
                                    <td class="ui-widget-content" align="center">' . $targetBlockData[$arrColumn['TARGET_DATE']][$k]->RABI . '</td>                                    
                                    <td class="ui-widget-content" align="center">' . ($targetBlockData[$arrColumn['TARGET_DATE']][$k]->KHARIF+$targetBlockData[$arrColumn['TARGET_DATE']][$k]->RABI).'</td>';
                                echo '<td class="ui-widget-content" align="center">'.$targetBlockData[$arrColumn['TARGET_DATE']][$k]->KHARIF_RESTORED.'</td>';
                                echo '<td class="ui-widget-content" align="center">'.$targetBlockData[$arrColumn['TARGET_DATE']][$k]->RABI_RESTORED.'</td>';
                                echo '<td class="ui-widget-content" align="center">'.($targetBlockData[$arrColumn['TARGET_DATE']][$k]->RABI_RESTORED+$targetBlockData[$arrColumn['TARGET_DATE']][$k]->KHARIF_RESTORED).' ';

                                $subTotalKharif += $targetBlockData[$arrColumn['TARGET_DATE']][$k]->KHARIF;
                                $subTotalRabi += $targetBlockData[$arrColumn['TARGET_DATE']][$k]->RABI;
                                //$subTotalIp += $targetBlockData[$arrColumn['TARGET_DATE']][$k]->IP_TOTAL;
                                $subTotalIp += ($targetBlockData[$arrColumn['TARGET_DATE']][$k]->KHARIF+$targetBlockData[$arrColumn['TARGET_DATE']][$k]->RABI);

                                $subTotalKharifRestored += $targetBlockData[$arrColumn['TARGET_DATE']][$k]->KHARIF_RESTORED;
                                $subTotalRabiRestored += $targetBlockData[$arrColumn['TARGET_DATE']][$k]->RABI_RESTORED;
                                //$subTotalIp += $targetBlockData[$arrColumn['TARGET_DATE']][$k]->IP_TOTAL;
                                $subTotalIpRestored += ($targetBlockData[$arrColumn['TARGET_DATE']][$k]->KHARIF_RESTORED+$targetBlockData[$arrColumn['TARGET_DATE']][$k]->RABI_RESTORED);
                                if($cnt == 1) {
                                    echo '</td></tr>';
                                }
                            }
							if($blockCount>1){
								echo '<tr><td class="ui-widget-content" align="center">Total</td>';
								echo '<td class="ui-widget-content" align="center">'. $subTotalKharif . '</td>
									 <td class="ui-widget-content" align="center">' . $subTotalRabi . '</td>
									 <td class="ui-widget-content" align="center">' . $subTotalIp  . '</td>
                                     <td class="ui-widget-content" align="center">'.$subTotalKharifRestored.'</td>
                                     <td class="ui-widget-content" align="center">'.$subTotalRabiRestored.'</td>
                                     <td class="ui-widget-content" align="center">'.$subTotalIpRestored.'</td>
								   </tr>';
							}
                        }else{
							if($arrColumn['COL_WIDTH']==6)
	                            echo giveComma($arrColumn['VALUE'], 2);
							else
	                            echo giveComma($arrColumn['VALUE'], 3);
						}
                    }else{
                        echo 'NA';
                    }
                }
                echo '</td>';
            }
            echo '</tr>';

            $grandTotalKharif += $subTotalKharif;
            $grandTotalRabi += $subTotalRabi;
            $grandTotalIp += $subTotalIp;

              $grandTotalKharifRestored += $subTotalKharifRestored;
            $grandTotalRabiRestored += $subTotalRabiRestored;
            $grandTotalIpRestored += $subTotalIpRestored;
        }
        ?>
        </tr>
        <tr>
            <td class="ui-state-default" align="center"><strong>Total</strong></td>
            <td class="ui-state-default" align="center"><strong><?php echo giveComma($arrTotal['EXPENDITURE'], 2);?></strong></td>
            <td class="ui-state-default" align="center"><strong><?php echo ($setupData['LA_NA']==0) ? $arrTotal['LA_NO']:'NA';?></strong></td>
            <td class="ui-state-default" align="center"><strong><?php echo ($setupData['LA_NA']==0) ? giveComma($arrTotal['LA_HA'], 2):'NA';?></strong></td>
            <td class="ui-state-default" align="center"><strong><?php echo ($setupData['FA_NA']==0) ? giveComma($arrTotal['FA_HA'], 2):'NA';?></strong></td>
            <td class="ui-state-default" align="center"><strong><?php echo ($setupData['HW_EARTHWORK_NA']==0) ? giveComma($arrTotal['HW_EARTHWORK'], 2):'NA';?></strong></td>
            <td class="ui-state-default" align="center"><strong><?php echo ($setupData['HW_MASONRY_NA']==0) ? giveComma($arrTotal['HW_MASONRY'], 2):'NA';?></strong></td>
            <td class="ui-state-default" align="center"><strong><?php echo ($setupData['STEEL_WORK_NA']==0) ? $arrTotal['STEEL_WORK']:'NA';?></strong></td>
            <td class="ui-state-default" align="center"><strong><?php echo ($setupData['CANAL_EARTHWORK_NA']==0) ? $arrTotal['CANAL_EARTHWORK']:'NA';?></strong></td>
            <td class="ui-state-default" align="center"><strong><?php echo ($setupData['CANAL_STRUCTURE_NA']==0) ? $arrTotal['CANAL_STRUCTURE']:'NA';?></strong></td>
            <td class="ui-state-default" align="center"><strong><?php echo ($setupData['CANAL_STRUCTURE_MASONRY_NA']==0) ? $arrTotal['CANAL_STRUCTURE_MASONRY']:'NA';?></strong></td>
            <td class="ui-state-default" align="center"><strong><?php echo ($setupData['CANAL_LINING_NA']==0) ? $arrTotal['CANAL_LINING']:'NA';?></strong></td>
            <td class="ui-state-default" align="center"> </td>
            <td align="center" class="ui-state-default"><strong><?php echo $grandTotalKharif;?></strong></td>
            <td align="center" class="ui-state-default"><strong><?php echo $grandTotalRabi;?></strong></td>
            <td align="center" class="ui-state-default"><strong><?php echo $grandTotalIp;?></strong></td>
             <td align="center" class="ui-state-default"><strong><?php echo $grandTotalKharifRestored;?></strong></td>
            <td align="center" class="ui-state-default"><strong><?php echo $grandTotalRabiRestored;?></strong></td>
            <td align="center" class="ui-state-default"><strong><?php echo $grandTotalIpRestored;?></strong></td>
        </tr>
		</tbody>
    </table>
<p><small>Printed on <?php echo date("d-m-Y h:i:s a");?></small></p>
</div>
