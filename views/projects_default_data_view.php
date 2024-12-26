<fieldset>
    <legend>
        <a id="btnfrm2" role="button" class="ui-button  ui-state-default ui-corner-all ui-button-text-only">
    <span class="ui-button-text"><i class="cus-table"></i>
        &nbsp; Estimation Form  &nbsp;
        <span id="sp_arrow_frm2_down" style=""><i class="cus-arrow-down"></i></span>
        <span id="sp_arrow_frm2_up" style="display:none;"><i class="cus-arrow-up"></i></span>
    </span>
        </a>
    </legend>
    <!--frm2-->
    <div id="frm2" style="display:none">

        <div class="wrdlinebreak"></div>
        <input type="hidden" name="SESSION_ID" id="SESSION_ID"
               value="<?php echo $projectSetupValues['SESSION_ID']; ?>"/>
        <input type="hidden" id="sessionRealMinDate" name="sessionRealMinDate" value=""/>
        <input type="hidden" id="sessionMinDate" name="sessionMinDate" value=""/>
        <input type="hidden" id="sessionMaxDate" name="sessionMaxDate" value=""/>
        <input type="hidden" id="startInSession" value="0"/>
        <input type="hidden" id="mytoday" value="<?php echo date("d-m-Y"); ?>"/>

        <?php
        /*'NEW_IRRIGATION_POTENTIAL_KHARIF','NEW_IRRIGATION_POTENTIAL_RABI',
        'NEW_IRRIGATION_POTENTIAL_TOTAL','IRRIGATION_POTENTIAL_RESTORED_KHARIF','IRRIGATION_POTENTIAL_RESTORED_RABI',
        'IRRIGATION_POTENTIAL_RESTORED_TOTAL' */
        $arrFields = array(
            'LA_NO', 'LA_HA', 'LA_COMPLETED_NO', 'LA_COMPLETED_HA',
            'FA_HA', 'FA_COMPLETED_HA', 'HW_EARTHWORK', 'HW_MASONRY', 'STEEL_WORK', 'CANAL_EARTHWORK',
            'CANAL_STRUCTURE', 'CANAL_STRUCTURE_MASONRY', 'CANAL_LINING'
        );
        $arrAchievementCompo = array();
        foreach ($arrFields as $f) {
            array_push($arrAchievementCompo, $f . '_ACHIEVE');
        }
        ?>
        <table width="100%" border="0" cellpadding="3" cellspacing="2" align="right" class="ui-widget-content">
            <tr>
                <td width="50%" class="ui-state-default">Financial Year in which this setup(data) is entered (in
                    Software):
                </td>
                <td class="ui-widget-content" align="center"><strong><?php
                        echo $SESSION_OPTIONS; ?></strong></td>
            </tr>
        </table>
        <div class="wrdlinebreak"></div>
        <table width="100%" border="0" cellpadding="3" cellspacing="2" class="ui-widget-content">
            <tbody>
            <tr>
                <th class="ui-widget-header">SNo</th>
                <th colspan="4" class="ui-widget-header">Contents</th>
                <th align="center" class="ui-widget-header">NA</th>
                <th width="130" align="center" class="ui-widget-header">Latest<br/>Estimated</th>
                <th align="center" class="ui-widget-header" colspan="2">Unit</th>
                <th width="130" align="center" class="ui-widget-header">Achievement <br/> upto last financial
                    year
                </th>
            </tr>
            <tr>
                <th class="ui-state-default" width="20">a</th>
                <th colspan="4" align="center" class="ui-state-default">b</th>
                <th align="center" class="ui-state-default">c</th>
                <th align="center" class="ui-state-default">d</th>
                <th align="center" class="ui-state-default" colspan="2">e</th>
                <th align="center" class="ui-state-default">f</th>
            </tr>
            <tr>
                <td rowspan="2" align="center" class="ui-widget-content"><strong>1</strong></td>
                <td colspan="4" rowspan="2" class="ui-widget-content"><strong>Land acquistion Submitted</strong>
                </td>
                <td rowspan="4" align="center" class="ui-widget-content">
                    <?php $disable = (($arrSetupStatus['LA_NA']) ? ' disabled="disabled" ' : '') ?>
                    <input type="checkbox" name="LA_NA" id="LA_NA"
                           class="css-checkbox"
                           onclick="setEstimationFields(this.name, this.checked)" value="1"
                        <?php if ($arrSetupStatus['LA_NA']) echo 'checked="checked"'; ?>
                    />
                    <label for="LA_NA" class="css-label lite-blue-check">NA</label>
                </td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('LA_NO', $arrSetupStatus['LA_NA']); ?>
                    <input type="text" name="LA_NO" id="LA_NO" size="10" maxlength="15" autocomplete="off"
                           class="centertext"
                           value="<?php echo ($arrSetupStatus['LA_NA']) ? '' : $arrEstimationData['LA_NO']; ?>"
                        <?php echo $disable; ?>
                    />
                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>Numbers</strong></td>
                <td align="center" class="ui-widget-content">
                    <?php echo getRequiredDiv('LA_NO_ACHIEVE', $arrSetupStatus['LA_NA'], $isCurrentSession); ?>
                    <input type="text" name="LA_NO_ACHIEVE" id="LA_NO_ACHIEVE" size="10" maxlength="15"
                           autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['LA_NO']; ?>"
                    />
                </td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('LA_HA', $arrSetupStatus['LA_NA']); ?>
                    <input type="text" name="LA_HA" id="LA_HA" size="10" maxlength="15" autocomplete="off"
                           class="centertext"
                           value="<?php echo ($arrSetupStatus['LA_NA']) ? '' : $arrEstimationData['LA_HA']; ?>"
                        <?php echo $disable; ?>
                    />
                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>Hectares</strong></td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('LA_HA_ACHIEVE', $arrSetupStatus['LA_NA'], $isCurrentSession); ?>
                    <input type="text" name="LA_HA_ACHIEVE" id="LA_HA_ACHIEVE" size="10" maxlength="15"
                           autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['LA_HA']; ?>"
                    />
                </td>
            </tr>
            <tr>
                <td rowspan="2" align="center" class="ui-widget-content"><strong>2</strong></td>
                <td colspan="4" rowspan="2" class="ui-widget-content"><strong>Land acquistion Completed</strong>
                </td>
                <td class="ui-widget-content" align="center" rowspan="2">
                    submitted
                    <!--  <?php echo getRequiredDiv('LA_COMPLETED_NO', $arrSetupStatus['LA_NA']); ?>
        <input type="text" name="LA_COMPLETED_NO" id="LA_COMPLETED_NO" size="10" maxlength="15" autocomplete="off"
            class="centertext" value="<?php echo ($arrSetupStatus['LA_NA']) ? '' : $arrEstimationData['LA_COMPLETED_NO']; ?>"
            <?php echo $disable; ?>
        /> -->
                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>Numbers</strong></td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('LA_COMPLETED_NO_ACHIEVE', $arrSetupStatus['LA_NA'], $isCurrentSession); ?>
                    <input type="text" name="LA_COMPLETED_NO_ACHIEVE" id="LA_COMPLETED_NO_ACHIEVE" size="10"
                           maxlength="15" autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['LA_COMPLETED_NO']; ?>"
                    />
                </td>
            </tr>
            <tr>
                <!--  <td class="ui-widget-content" align="center"> -->
                <!--  <?php echo getRequiredDiv('LA_COMPLETED_HA', $arrSetupStatus['LA_NA']); ?>
        <input type="text" name="LA_COMPLETED_HA" id="LA_COMPLETED_HA" size="10" maxlength="15" autocomplete="off"
            class="centertext" value="<?php echo ($arrSetupStatus['LA_NA']) ? '' : $arrEstimationData['LA_COMPLETED_HA']; ?>"
            <?php echo $disable; ?>
        /> -->
                <!--   </td> -->
                <td align="center" class="ui-widget-content" colspan="2"><strong>Hectares</strong></td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('LA_COMPLETED_HA_ACHIEVE', $arrSetupStatus['LA_NA'], $isCurrentSession); ?>
                    <input type="text" name="LA_COMPLETED_HA_ACHIEVE" id="LA_COMPLETED_HA_ACHIEVE" size="10"
                           maxlength="15" autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['LA_COMPLETED_HA']; ?>"
                    />
                </td>
            </tr>
            <tr>
                <td align="center" class="ui-widget-content"><strong>3</strong><strong></strong></td>
                <td colspan="4" rowspan="1" class="ui-widget-content"><strong>Forest Acquisition</strong></td>
                <td rowspan="2" align="center" class="ui-widget-content">
                    <?php $disable = (($arrSetupStatus['FA_NA']) ? ' disabled="disabled" ' : '') ?>
                    <input type="checkbox" name="FA_NA" id="FA_NA"
                           class="css-checkbox"
                           onclick="setEstimationFields(this.name, this.checked)" value="1"
                        <?php if ($arrSetupStatus['FA_NA']) echo 'checked="checked"'; ?>
                    />
                    <label for="FA_NA" class="css-label lite-blue-check">NA</label>
                </td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('FA_HA', $arrSetupStatus['FA_NA']); ?>
                    <input type="text" name="FA_HA" id="FA_HA" size="10" maxlength="15" autocomplete="off"
                           class="centertext"
                           value="<?php echo ($arrSetupStatus['FA_NA']) ? '' : $arrEstimationData['FA_HA']; ?>"
                        <?php echo $disable; ?>
                    />
                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>Hectares</strong></td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('FA_HA_ACHIEVE', $arrSetupStatus['FA_NA'], $isCurrentSession); ?>
                    <input type="text" name="FA_HA_ACHIEVE" id="FA_HA_ACHIEVE" size="10" maxlength="15"
                           autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['FA_HA']; ?>"
                    />
                </td>
            </tr>
            <tr>
                <td align="center" class="ui-widget-content"><strong>4</strong></td>
                <td colspan="4" rowspan="1" class="ui-widget-content"><strong>Forest Acquisition
                        Completed</strong></td>
                <td class="ui-widget-content" align="center">
                    <!--   <?php
                    echo getRequiredDiv('FA_COMPLETED_HA', $arrSetupStatus['FA_NA']); ?>
    <input type="text" name="FA_COMPLETED_HA" id="FA_COMPLETED_HA" size="10" maxlength="15" autocomplete="off"
            class="centertext" value="<?php echo ($arrSetupStatus['FA_NA']) ? '' : $arrEstimationData['FA_COMPLETED_HA']; ?>"
            <?php echo $disable; ?>
    /> -->
                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>Hectares</strong></td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('FA_COMPLETED_HA_ACHIEVE', $arrSetupStatus['FA_NA'], $isCurrentSession); ?>
                    <input type="text" name="FA_COMPLETED_HA_ACHIEVE" id="FA_COMPLETED_HA_ACHIEVE" size="10"
                           maxlength="15" autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['FA_COMPLETED_HA']; ?>"
                    />
                </td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center"><strong>5</strong></td>
                <td class="ui-widget-content" colspan="4"><strong>Headworks Earthwork</strong></td>
                <td class="ui-widget-content" align="center">
                    <?php

                    $disable = (($arrSetupStatus['HW_EARTHWORK_NA']) ? ' disabled="disabled" ' : '') ?>
                    <input type="checkbox" name="HW_EARTHWORK_NA" id="HW_EARTHWORK_NA"
                           class="css-checkbox"
                           onclick="setEstimationFields(this.name, this.checked)" value="1"
                        <?php if ($arrSetupStatus['HW_EARTHWORK_NA']) echo 'checked="checked"'; ?>
                    />
                    <label for="HW_EARTHWORK_NA" class="css-label lite-blue-check">NA</label>
                </td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('HW_EARTHWORK', $arrSetupStatus['HW_EARTHWORK_NA']); ?>
                    <input type="text" name="HW_EARTHWORK" id="HW_EARTHWORK" size="10" maxlength="15"
                           autocomplete="off"
                           class="centertext"
                           value="<?php echo ($arrSetupStatus['HW_EARTHWORK_NA']) ? '' : $arrEstimationData['HW_EARTHWORK']; ?>"
                        <?php echo $disable; ?>
                    />

                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>Th Cum</strong></td>
                <td align="center" class="ui-widget-content">
                    <?php echo getRequiredDiv('HW_EARTHWORK_ACHIEVE', $arrSetupStatus['HW_EARTHWORK_NA'], $isCurrentSession); ?>
                    <input type="text" name="HW_EARTHWORK_ACHIEVE" id="HW_EARTHWORK_ACHIEVE" size="10"
                           maxlength="15" autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['HW_EARTHWORK']; ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center"><strong>6</strong></td>
                <td class="ui-widget-content" colspan="4"><strong>Headworks Masonry / Concrete</strong></td>
                <td class="ui-widget-content" align="center">
                    <?php
                    $disable = (($arrSetupStatus['HW_MASONRY_NA']) ? ' disabled="disabled" ' : '') ?>
                    <input type="checkbox" name="HW_MASONRY_NA" id="HW_MASONRY_NA"
                           class="css-checkbox"
                           onclick="setEstimationFields(this.name, this.checked)" value="1"
                        <?php if ($arrSetupStatus['HW_MASONRY_NA']) echo 'checked="checked"'; ?>
                    />
                    <label for="HW_MASONRY_NA" class="css-label lite-blue-check">NA</label>
                </td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('HW_MASONRY', $arrSetupStatus['HW_MASONRY_NA']); ?>
                    <input type="text" name="HW_MASONRY" id="HW_MASONRY" size="10" maxlength="15"
                           autocomplete="off"
                           class="centertext"
                           value="<?php echo ($arrSetupStatus['HW_MASONRY_NA']) ? '' : $arrEstimationData['HW_MASONRY']; ?>"
                        <?php echo $disable; ?>
                    />
                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>Th Cum</strong></td>
                <td align="center" class="ui-widget-content">
                    <?php echo getRequiredDiv('HW_MASONRY_ACHIEVE', $arrSetupStatus['HW_MASONRY_NA'], $isCurrentSession); ?>
                    <input type="text" name="HW_MASONRY_ACHIEVE" id="HW_MASONRY_ACHIEVE" size="10"
                           maxlength="15" autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['HW_MASONRY']; ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center"><strong>7</strong></td>
                <td class="ui-widget-content" colspan="4"><strong>Steel Work</strong> (Reinforcement Steel
                    should not be included)
                </td>
                <td class="ui-widget-content" align="center">
                    <?php
                    $disable = (($arrSetupStatus['STEEL_WORK_NA']) ? ' disabled="disabled" ' : '') ?>
                    <input type="checkbox" name="STEEL_WORK_NA" id="STEEL_WORK_NA"
                           class="css-checkbox"
                           onclick="setEstimationFields(this.name, this.checked)" value="1"
                        <?php if ($arrSetupStatus['STEEL_WORK_NA']) echo 'checked="checked"'; ?>
                    />
                    <label for="STEEL_WORK_NA" class="css-label lite-blue-check">NA</label>
                </td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('STEEL_WORK', $arrSetupStatus['STEEL_WORK_NA']); ?>
                    <input type="text" name="STEEL_WORK" id="STEEL_WORK" size="10" maxlength="15"
                           autocomplete="off"
                           class="centertext"
                           value="<?php echo ($arrSetupStatus['STEEL_WORK_NA']) ? '' : $arrEstimationData['STEEL_WORK']; ?>"
                        <?php echo $disable; ?>
                    />
                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>MT</strong></td>
                <td align="center" class="ui-widget-content">
                    <?php echo getRequiredDiv('STEEL_WORK_ACHIEVE', $arrSetupStatus['STEEL_WORK_NA'], $isCurrentSession); ?>
                    <input type="text" name="STEEL_WORK_ACHIEVE" id="STEEL_WORK_ACHIEVE" size="10"
                           maxlength="15" autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['STEEL_WORK']; ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center"><strong>8</strong></td>
                <td class="ui-widget-content" colspan="4"><strong>Canal Earthwork</strong></td>
                <td class="ui-widget-content" align="center">
                    <?php
                    $disable = (($arrSetupStatus['CANAL_EARTHWORK_NA']) ? ' disabled="disabled" ' : '') ?>
                    <input type="checkbox" name="CANAL_EARTHWORK_NA" id="CANAL_EARTHWORK_NA"
                           class="css-checkbox"
                           onclick="setEstimationFields(this.name, this.checked)" value="1"
                        <?php if ($arrSetupStatus['CANAL_EARTHWORK_NA']) echo 'checked="checked"'; ?>
                    />
                    <label for="CANAL_EARTHWORK_NA" class="css-label lite-blue-check">NA</label>
                </td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('CANAL_EARTHWORK', $arrSetupStatus['CANAL_EARTHWORK_NA']); ?>
                    <input type="text" name="CANAL_EARTHWORK" id="CANAL_EARTHWORK" size="10" maxlength="15"
                           autocomplete="off"
                           class="centertext"
                           value="<?php echo ($arrSetupStatus['CANAL_EARTHWORK_NA']) ? '' : $arrEstimationData['CANAL_EARTHWORK']; ?>"
                        <?php echo $disable; ?>
                    />
                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>Th Cum</strong></td>
                <td align="center" class="ui-widget-content">
                    <?php
                    echo getRequiredDiv('CANAL_EARTHWORK_ACHIEVE', $arrSetupStatus['CANAL_EARTHWORK_NA'], $isCurrentSession); ?>
                    <input type="text" name="CANAL_EARTHWORK_ACHIEVE" id="CANAL_EARTHWORK_ACHIEVE" size="10"
                           maxlength="15" autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['CANAL_EARTHWORK']; ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center"><strong>9</strong></td>
                <td class="ui-widget-content" colspan="4"><strong>Canal Structures</strong></td>
                <td class="ui-widget-content" align="center">
                    <?php
                    $disable = (($arrSetupStatus['CANAL_STRUCTURE_NA']) ? ' disabled="disabled" ' : '') ?>
                    <input type="checkbox" name="CANAL_STRUCTURE_NA" id="CANAL_STRUCTURE_NA"
                           class="css-checkbox"
                           onclick="setEstimationFields(this.name, this.checked)" value="1"
                        <?php if ($arrSetupStatus['CANAL_STRUCTURE_NA']) echo 'checked="checked"'; ?>
                    />
                    <label for="CANAL_STRUCTURE_NA" class="css-label lite-blue-check">NA</label>
                </td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('CANAL_STRUCTURE', $arrSetupStatus['CANAL_STRUCTURE_NA']); ?>
                    <input type="text" name="CANAL_STRUCTURE" id="CANAL_STRUCTURE" size="10" maxlength="15"
                           autocomplete="off"
                           class="centertext"
                           value="<?php echo ($arrSetupStatus['CANAL_STRUCTURE_NA']) ? '' : $arrEstimationData['CANAL_STRUCTURE']; ?>"
                        <?php echo $disable; ?>
                    />
                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>No</strong></td>
                <td align="center" class="ui-widget-content">
                    <?php echo getRequiredDiv('CANAL_STRUCTURE_ACHIEVE', $arrSetupStatus['CANAL_STRUCTURE_NA'], $isCurrentSession); ?>
                    <input type="text" name="CANAL_STRUCTURE_ACHIEVE" id="CANAL_STRUCTURE_ACHIEVE" size="10"
                           maxlength="15" autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['CANAL_STRUCTURE']; ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center"><strong>10</strong></td>
                <td class="ui-widget-content" colspan="4"><strong>Canal Structure Masonry / Conc.</strong><span
                        style="color:#f00">(Applicable only if no. of stru. not mentioned above)</span></td>
                <td class="ui-widget-content" align="center">
                    <?php
                    $disable = (($arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA']) ? ' disabled="disabled" ' : '') ?>
                    <input type="checkbox" name="CANAL_STRUCTURE_MASONRY_NA" id="CANAL_STRUCTURE_MASONRY_NA"
                           class="css-checkbox"
                           onclick="setEstimationFields(this.name, this.checked)" value="1"
                        <?php if ($arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA']) echo 'checked="checked"'; ?>
                    />
                    <label for="CANAL_STRUCTURE_MASONRY_NA" class="css-label lite-blue-check">NA</label>
                </td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('CANAL_STRUCTURE_MASONRY', $arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA']); ?>
                    <input type="text" name="CANAL_STRUCTURE_MASONRY" id="CANAL_STRUCTURE_MASONRY" size="10"
                           maxlength="15" autocomplete="off"
                           class="centertext"
                           value="<?php echo ($arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA']) ? '' : $arrEstimationData['CANAL_STRUCTURE_MASONRY']; ?>"
                        <?php echo $disable; ?>
                    />
                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>Th Cum</strong></td>
                <td align="center" class="ui-widget-content">
                    <?php echo getRequiredDiv('CANAL_STRUCTURE_MASONRY_ACHIEVE', $arrSetupStatus['CANAL_STRUCTURE_MASONRY_NA'], $isCurrentSession); ?>
                    <input type="text" name="CANAL_STRUCTURE_MASONRY_ACHIEVE"
                           id="CANAL_STRUCTURE_MASONRY_ACHIEVE" size="10" maxlength="15" autocomplete="off"
                           class="centertext"
                           value="<?php echo $arrAchievementData['CANAL_STRUCTURE_MASONRY']; ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center"><strong>11</strong></td>
                <td class="ui-widget-content" colspan="4"><strong>Canal Lining</strong></td>
                <td class="ui-widget-content" align="center">
                    <?php
                    $disable = (($arrSetupStatus['CANAL_LINING_NA']) ? ' disabled="disabled" ' : '') ?>
                    <input type="checkbox" name="CANAL_LINING_NA" id="CANAL_LINING_NA"
                           class="css-checkbox"
                           onclick="setEstimationFields(this.name, this.checked)" value="1"
                        <?php if ($arrSetupStatus['CANAL_LINING_NA']) echo 'checked="checked"'; ?>
                    />
                    <label for="CANAL_LINING_NA" class="css-label lite-blue-check">NA</label>
                </td>
                <td class="ui-widget-content" align="center">
                    <?php echo getRequiredDiv('CANAL_LINING', $arrSetupStatus['CANAL_LINING_NA']); ?>
                    <input type="text" name="CANAL_LINING" id="CANAL_LINING" size="10" maxlength="15"
                           autocomplete="off"
                           class="centertext"
                           value="<?php echo ($arrSetupStatus['CANAL_LINING_NA']) ? '' : $arrEstimationData['CANAL_LINING']; ?>"
                        <?php echo $disable; ?>
                    />
                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>KM</strong></td>
                <td align="center" class="ui-widget-content">
                    <?php echo getRequiredDiv('CANAL_LINING_ACHIEVE', $arrSetupStatus['CANAL_LINING_NA'], $isCurrentSession); ?>
                    <input type="text" name="CANAL_LINING_ACHIEVE" id="CANAL_LINING_ACHIEVE" size="10"
                           maxlength="15" autocomplete="off"
                           class="centertext" value="<?php echo $arrAchievementData['CANAL_LINING']; ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center"><strong>12</strong></td>
                <td class="ui-widget-content" colspan="4"><strong>New Irrigation Potential</strong></td>
                <td class="ui-widget-content" align="center">
                    <?php
                    $disable = '';//(($arrSetupStatus['NEW_IRRIGATION_POTENTIAL_NA'])?' disabled="disabled" ' : '') ?>
                    <!--   <input type="checkbox" name="NEW_IRRIGATION_POTENTIAL_NA" id="NEW_IRRIGATION_POTENTIAL_NA"
            class="css-checkbox"
            onclick="setEstimationFields(this.name, this.checked)" value="1"
            <?php if ($arrSetupStatus['NEW_IRRIGATION_POTENTIAL_NA']) echo 'checked="checked"'; ?>
        />
        <label for="NEW_IRRIGATION_POTENTIAL_NA" class="css-label lite-blue-check">NA</label> -->
                </td>
                <td class="ui-widget-content" align="center">

                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>Hetares </strong></td>
                <td align="center" class="ui-widget-content">

                </td>
            </tr>

            <?php $i = 0;

            $arrBlocks = array();
            $arrTotals = array('KHARIF' => 0, 'RABI' => 0, 'TOTAL' => 0);
            $arrATotals = array('KHARIF' => 0, 'RABI' => 0, 'TOTAL' => 0);
            foreach ($arrBlockData as $k => $rec) {

                $blockId = $k;
                $arrTotals['KHARIF'] += $rec['ESTIMATION_IP']['KHARIF'];
                $arrTotals['RABI'] += $rec['ESTIMATION_IP']['RABI'];
                $arrTotals['TOTAL'] += ($rec['ESTIMATION_IP']['KHARIF'] + $rec['ESTIMATION_IP']['RABI']);
                $arrATotals['KHARIF'] += $rec['ACHIEVEMENT_IP']['KHARIF'];
                $arrATotals['RABI'] += $rec['ACHIEVEMENT_IP']['RABI'];
                $arrATotals['TOTAL'] += ($rec['ACHIEVEMENT_IP']['KHARIF'] + $rec['ACHIEVEMENT_IP']['RABI']);

                array_push($arrBlocks, $k);


                ?>
                <tr id="tr-bk-<?php echo $blockId; ?>" class="trb-<?php echo $blockId; ?> trbip">
                    <td rowspan="3" align="center" class="ui-widget-content">
                        <strong><?php echo chr($i + 97); ?></strong></td>
                    <td colspan="5" rowspan="3" class="ui-widget-content">
                        <strong><?php echo $rec['BLOCK_NAME']; ?></strong></td>
                    <td class="ui-widget-content" align="center">
                        <?php echo getRequiredDiv('BLOCK_EIP_K_' . $blockId, 0); ?>
                        <input type="text" name="BLOCK_EIP_K[<?php echo $blockId; ?>]"
                               id="BLOCK_EIP_K_<?php echo $blockId; ?>"
                               size="10" maxlength="15" autocomplete="off"
                               onkeyup="getIrriSubTotal(0, 0, <?php echo $blockId; ?>)"
                               class="centertext" value="<?php echo $rec['ESTIMATION_IP']['KHARIF']; ?>"
                            <?php echo $disable; ?> />
                    </td>

                    <td class="ui-state-default" colspan="2" align="center"><strong>Kharif</strong></td>
                    <td class="ui-widget-content" align="center">
                        <?php echo getRequiredDiv('BLOCK_AIP_K_' . $blockId, 0, $isCurrentSession); ?>
                        <input type="text" name="BLOCK_AIP_K[<?php echo $blockId; ?>]"
                               id="BLOCK_AIP_K_<?php echo $blockId; ?>"
                               size="10" maxlength="15" autocomplete="off"
                               onkeyup="getIrriSubTotal(0, 1, <?php echo $blockId; ?>)"
                               class="centertext" value="<?php echo $rec['ACHIEVEMENT_IP']['KHARIF']; ?>"
                            <?php echo $disable; ?>
                        />
                    </td>
                </tr>
                <tr id="tr-br-<?php echo $blockId; ?>" class="trb-<?php echo $blockId; ?>">
                    <td class="ui-widget-content" align="center">
                        <?php echo getRequiredDiv('BLOCK_EIP_R_' . $blockId, 0); ?>
                        <input type="text" name="BLOCK_EIP_R[<?php echo $blockId; ?>]"
                               id="BLOCK_EIP_R_<?php echo $blockId; ?>"
                               size="10" maxlength="15" autocomplete="off"
                               onkeyup="getIrriSubTotal(1, 0, <?php echo $blockId; ?>)"
                               class="centertext" value="<?php echo $rec['ESTIMATION_IP']['RABI']; ?>"
                            <?php echo $disable; ?>/>
                    </td>
                    <td class="ui-state-default" align="center" colspan="2"><strong>Rabi</strong></td>
                    <td class="ui-widget-content" align="center">
                        <?php echo getRequiredDiv('BLOCK_AIP_R_' . $blockId, 0, $isCurrentSession); ?>
                        <input type="text" name="BLOCK_AIP_R[<?php echo $blockId; ?>]"
                               id="BLOCK_AIP_R_<?php echo $blockId; ?>"
                               size="10" maxlength="15" autocomplete="off"
                               onkeyup="getIrriSubTotal(1, 1, <?php echo $blockId; ?>)"
                               class="centertext" value="<?php echo $rec['ACHIEVEMENT_IP']['RABI']; ?>"
                            <?php echo $disable; ?>
                        />
                    </td>
                </tr>
                <tr id="tr-bt-<?php echo $blockId; ?>" class="trb-<?php echo $blockId; ?>">
                    <td class="ui-state-default" align="center" id="BLOCK_EIP_T_<?php echo $blockId; ?>">
                        <?php echo $rec['ESTIMATION_IP']['KHARIF'] + $rec['ESTIMATION_IP']['RABI']; ?>
                    </td>
                    <td class="ui-state-default" align="center" colspan="2"><strong>Total</strong></td>
                    <td class="ui-state-default" align="center" id="BLOCK_AIP_T_<?php echo $blockId; ?>">
                        <?php echo $rec['ACHIEVEMENT_IP']['KHARIF'] + $rec['ACHIEVEMENT_IP']['RABI']; ?>
                    </td>
                </tr>

                <?php $i++;

            } ?>
            <tr id="tr-bk-total">
                <td rowspan="3" align="center" class="ui-state-default">
                    <strong></strong><strong></strong><strong></strong></td>
                <td colspan="5" rowspan="3" class="ui-state-default"><strong>Total Irrigation Potential To be
                        Created</strong></td>
                <td class="ui-widget-content" align="center"
                    id="IP_KHARIF_T"><?php echo $arrTotals['KHARIF']; ?></td>

                <td class="ui-state-default" align="center" colspan="2"><strong>Kharif</strong></td>
                <td class="ui-widget-content" align="center"
                    id="IP_KHARIF_T_ACHIEVE"><?php echo $arrATotals['KHARIF']; ?></td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center"
                    id="IP_RABI_T"><?php echo $arrTotals['RABI']; ?></td>
                <td class="ui-state-default" align="center" colspan="2"><strong>Rabi</strong></td>
                <td class="ui-widget-content" align="center"
                    id="IP_RABI_T_ACHIEVE"><?php echo $arrATotals['RABI']; ?></td>
            </tr>
            <tr>
                <td class="ui-state-default" align="center"
                    id="IP_TOTAL_T"><?php echo $arrTotals['TOTAL']; ?></td>
                <td class="ui-state-default" align="center" colspan="2"><strong>Total</strong></td>
                <td class="ui-state-default" align="center"
                    id="IP_TOTAL_T_ACHIEVE"><?php echo $arrATotals['TOTAL']; ?></td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center"><strong>13</strong></td>
                <td class="ui-widget-content" colspan="4"><strong>Irrigation Potential to be Restored</strong>
                </td>
                <td class="ui-widget-content" align="center">
                    <?php
                    $disable = (($arrSetupStatus['IRRIGATION_POTENTIAL_TO_BE_RESTORED_NA']) ? ' disabled="disabled" ' : '') ?>
                    <input type="checkbox" name="IRRIGATION_POTENTIAL_TO_BE_RESTORED_NA"
                           id="IRRIGATION_POTENTIAL_TO_BE_RESTORED_NA"
                           class="css-checkbox"
                           onclick="setEstimationFields(this.name, this.checked)" value="1"
                        <?php if ($arrSetupStatus['IRRIGATION_POTENTIAL_TO_BE_RESTORED_NA']) echo 'checked="checked"'; ?>
                    />
                    <label for="IRRIGATION_POTENTIAL_TO_BE_RESTORED_NA"
                           class="css-label lite-blue-check">NA</label>
                </td>
                <td class="ui-widget-content" align="center">

                </td>
                <td align="center" class="ui-widget-content" colspan="2"><strong>Hectares </strong></td>
                <td align="center" class="ui-widget-content">

                </td>
            </tr>

            <?php $i = 0;
            //showArrayValues($arrRestoredBlockData);
            $arrRestoredBlocks = array();
            $arrTotals = array('KHARIF' => 0, 'RABI' => 0, 'TOTAL' => 0);
            $arrATotals = array('KHARIF' => 0, 'RABI' => 0, 'TOTAL' => 0);
            foreach ($arrRestoredBlockData as $k => $rec) {
                $blockId = $k;
                $arrTotals['KHARIF'] += $rec['ESTIMATION_IP']['KHARIF'];
                $arrTotals['RABI'] += $rec['ESTIMATION_IP']['RABI'];
                $arrTotals['TOTAL'] += ($rec['ESTIMATION_IP']['KHARIF'] + $rec['ESTIMATION_IP']['RABI']);
                $arrATotals['KHARIF'] += $rec['ACHIEVEMENT_IP']['KHARIF'];
                $arrATotals['RABI'] += $rec['ACHIEVEMENT_IP']['RABI'];
                $arrATotals['TOTAL'] += ($rec['ACHIEVEMENT_IP']['KHARIF'] + $rec['ACHIEVEMENT_IP']['RABI']);
                array_push($arrRestoredBlocks, $k);

                ?>
                <tr id="tr-bk-r-<?php echo $blockId; ?>" class="trb-r-<?php echo $blockId; ?> trRestored">
                    <td rowspan="3" align="center" class="ui-widget-content"><strong><?php echo chr($i + 97); ?>
                            <input type="hidden" name="BLOCKS_BENEFITED_RESTORED[]"
                                   value="<?php echo $blockId; ?>"></strong></td>
                    <td colspan="5" rowspan="3" class="ui-widget-content">
                        <strong><?php echo $rec['BLOCK_NAME']; ?></strong></td>
                    <td class="ui-widget-content" align="center">
                        <?php echo getRequiredDiv('BLOCK_ERIP_K_' . $blockId, 0); ?>
                        <input type="text" name="BLOCK_REIP_K[<?php echo $blockId; ?>]"
                               id="BLOCK_ERIP_K_<?php echo $blockId; ?>"
                               size="10" maxlength="15" autocomplete="off"
                               onkeyup="getRestoredIrriSubTotal(0, 0, <?php echo $blockId; ?>)"
                               class="centertext required"
                               value="<?php echo $rec['ESTIMATION_IP']['KHARIF']; ?>" <?php echo $disable; ?>
                        />
                    </td>

                    <td class="ui-state-default" align="center" colspan="2"><strong>Kharif</strong></td>
                    <td class="ui-widget-content" align="center">
                        <?php echo getRequiredDiv('BLOCK_ARIP_K_' . $blockId, 0, $isCurrentSession); ?>
                        <input type="text" name="BLOCK_RAIP_K[<?php echo $blockId; ?>]"
                               id="BLOCK_ARIP_K_<?php echo $blockId; ?>"
                               size="10" maxlength="15" autocomplete="off"
                               onkeyup="getRestoredIrriSubTotal(0, 1, <?php echo $blockId; ?>)"
                               class="centertext required"
                               value="<?php echo $rec['ACHIEVEMENT_IP']['KHARIF']; ?>" <?php echo $disable; ?>/>
                    </td>
                </tr>
                <tr id="tr-br-r-<?php echo $blockId; ?>" class="trb-r-<?php echo $blockId; ?>">
                    <td class="ui-widget-content" align="center">
                        <?php echo getRequiredDiv('BLOCK_ERIP_R_' . $blockId, 0); ?>
                        <input type="text" name="BLOCK_REIP_R[<?php echo $blockId; ?>]"
                               id="BLOCK_ERIP_R_<?php echo $blockId; ?>"
                               size="10" maxlength="15" autocomplete="off"
                               onkeyup="getRestoredIrriSubTotal(1, 0, <?php echo $blockId; ?>)"
                               class="centertext required"
                               value="<?php echo $rec['ESTIMATION_IP']['RABI']; ?>" <?php echo $disable; ?>/>
                    </td>
                    <td class="ui-state-default" align="center" colspan="2"><strong>Rabi</strong></td>
                    <td class="ui-widget-content" align="center">
                        <?php echo getRequiredDiv('BLOCK_ARIP_R_' . $blockId, 0, $isCurrentSession); ?>
                        <input type="text" name="BLOCK_RAIP_R[<?php echo $blockId; ?>]"
                               id="BLOCK_ARIP_R_<?php echo $blockId; ?>"
                               size="10" maxlength="15" autocomplete="off"
                               onkeyup="getRestoredIrriSubTotal(1, 1, <?php echo $blockId; ?>)"
                               class="centertext required"
                               value="<?php echo $rec['ACHIEVEMENT_IP']['RABI']; ?>" <?php echo $disable; ?> />
                    </td>
                </tr>
                <tr id="tr-bt-r-<?php echo $blockId; ?>" class="trb-r-<?php echo $blockId; ?>">
                    <td class="ui-state-default" align="center" id="BLOCK_ERIP_T_<?php echo $blockId; ?>">
                        <?php echo $rec['ESTIMATION_IP']['KHARIF'] + $rec['ESTIMATION_IP']['RABI']; ?>
                    </td>
                    <td class="ui-state-default" align="center" colspan="2"><strong>Total</strong></td>
                    <td class="ui-state-default" align="center" id="BLOCK_ARIP_T_<?php echo $blockId; ?>">
                        <?php echo $rec['ACHIEVEMENT_IP']['KHARIF'] + $rec['ACHIEVEMENT_IP']['RABI']; ?>
                    </td>
                </tr>

                <?php $i++;
            } ?>
            <tr id="tr-bk-restored-total">
                <td rowspan="3" align="center" class="ui-state-default">
                    <strong></strong><strong></strong><strong></strong></td>
                <td colspan="5" rowspan="3" class="ui-state-default"><strong>Total Irrigation Potential to be
                        Restored</strong></td>
                <td class="ui-widget-content" align="center"
                    id="IP_KHARIF_R"><?php echo $arrTotals['KHARIF']; ?></td>

                <td class="ui-state-default" align="center" colspan="2"><strong>Kharif</strong></td>
                <td class="ui-widget-content" align="center"
                    id="IP_KHARIF_R_ACHIEVE"><?php echo $arrATotals['KHARIF']; ?></td>
            </tr>
            <tr>
                <td class="ui-widget-content" align="center"
                    id="IP_RABI_R"><?php echo $arrTotals['RABI']; ?></td>
                <td class="ui-state-default" align="center" colspan="2"><strong>Rabi</strong></td>
                <td class="ui-widget-content" align="center"
                    id="IP_RABI_R_ACHIEVE"><?php echo $arrATotals['RABI']; ?></td>
            </tr>
            <tr>
                <td class="ui-state-default" align="center"
                    id="IP_TOTAL_R"><?php echo $arrTotals['TOTAL']; ?></td>
                <td class="ui-state-default" align="center" colspan="2"><strong>Total</strong></td>
                <td class="ui-state-default" align="center"
                    id="IP_TOTAL_R_ACHIEVE"><?php echo $arrATotals['TOTAL']; ?></td>
            </tr>
        </table>

    </div>
    <!--//frm2-->
</fieldset>
<div class="wrdlinebreak"></div>
<!----------------------------[ Form - III ]------------------------------->
<?php //showArrayValues($arrSetupStatus);
$arrOptions = array(); ?>
<fieldset>
    <legend>
        <a role="button" class="ui-button  ui-state-default ui-corner-all ui-button-text-only"
           onclick="$('#frm4').slideToggle('slow');$('#sp_arrow_frm4_down').toggle();$('#sp_arrow_frm4_up').toggle(); ">
    <span class="ui-button-text"><i class="cus-table"></i>
        &nbsp; Milestone Form &nbsp;
        <span id="sp_arrow_frm4_down" style=""><i class="cus-arrow-down"></i></span>
        <span id="sp_arrow_frm4_up" style="display:none;"><i class="cus-arrow-up"></i></span>
    </span>
        </a>
    </legend>
    <div id="frm4" class="class2" style="display:none">
        <?php //showArrayValues($arrStatusOptions);?>
        <table width="100%" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1">
            <tr>
                <td class="ui-state-default" valign="middle" align="right" colspan="2">Completion Date of Scheme
                    :
                </td>
                <td class="ui-state-default" valign="middle" colspan="2">
                    <input name="PROJECT_COMPLETION_DATE" id="DATE_COMPLETION"
                           size="30" maxlength="50" type="text" class="centertext"
                           value="<?php echo myDateFormat($projectSetupValues['PROJECT_COMPLETION_DATE']); ?>"/>
                </td>
            </tr>
            <tr>
                <th class="ui-widget-header"></th>
                <th class="ui-widget-header">Contents</th>
                <th class="ui-widget-header">Status upto Last Financial Year</th>
                <th class="ui-widget-header">Target Dates of Completion</th>
            </tr>
            <tr>
                <td class="ui-state-default" align="center">a)</td>
                <td class="ui-state-default">Submission of LA Cases</td>
                <td class="ui-widget-content">
                    <?php echo getRequiredSign('left');
                    $arrHideCondition = array(0, 1, 5);
                    $displayCSS = 'block';
                    $isRequired = 'class=""';
                    if (in_array($arrStatusData['LA_CASES_STATUS'], $arrHideCondition) || $arrSetupStatus['LA_NA']) {
                        $displayCSS = 'none';
                        $isRequired = '';
                    } ?>
                    <select name="LA_CASES_STATUS" id="LA_CASES_STATUS" class="sel2" style="width:180px"
                        <?php echo(($arrSetupStatus['LA_NA']) ? 'disabled="disabled"' : ''); ?>
                            onchange="enableDisableDate(this.name, this.value)">
                        <?php echo $arrStatusOptions['LA_CASES_STATUS']; ?>
                    </select>
                    <?php $arrOptions['LA_CASES_STATUS'] = $arrStatusOptions['LA_CASES_STATUS']; ?>
                </td>
                <td class="ui-widget-content" align="center">
                    <div id="reqLA_CASES_STATUS"
                         style="float:left;display:<?php echo $displayCSS; ?>"><?php echo getRequiredSign('left'); ?></div>
                    <input name="LA_DATE" id="LA_DATE" readonly="readonly" type="text" size="48" maxlength="10"
                           style="width:50%;text-align:center;display:<?php echo $displayCSS; ?>"
                           value="<?php echo myDateFormat($arrTargetDates['LA_DATE']); ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default" align="center">b)</td>
                <td class="ui-state-default">Spillway / weir</td>
                <td class="ui-widget-content">
                    <?php
                    echo getRequiredSign('left');
                    $displayCSS = 'block';
                    $isRequired = 'class=""';
                    if (in_array($arrStatusData['SPILLWAY_WEIR_STATUS'], $arrHideCondition)) {
                        $displayCSS = 'none';
                        $isRequired = '';
                    } ?>
                    <select name="SPILLWAY_WEIR_STATUS" id="SPILLWAY_WEIR_STATUS" class="sel2"
                            style="width:180px"
                            onchange="enableDisableDate(this.name, this.value)">
                        <?php echo $arrStatusOptions['SPILLWAY_WEIR_STATUS']; ?>
                    </select>
                    <?php $arrOptions['SPILLWAY_WEIR_STATUS'] = $arrStatusOptions['SPILLWAY_WEIR_STATUS']; ?>
                </td>
                <td class="ui-widget-content" align="center">
                    <div id="reqSPILLWAY_WEIR_STATUS"
                         style="float:left;display:<?php echo $displayCSS; ?>"><?php echo getRequiredSign('left'); ?></div>
                    <input name="SPILLWAY_WEIR_DATE" id="SPILLWAY_WEIR_DATE" readonly="readonly" type="text"
                           size="48" maxlength="10"
                           style="width:50%;text-align:center;display:<?php echo $displayCSS; ?>"
                           value="<?php echo myDateFormat($arrTargetDates['SPILLWAY_WEIR_DATE']); ?>"/>
                </td>
            </tr>

            <tr>
                <td class="ui-state-default" align="center">c)</td>
                <td class="ui-state-default">Flanks /Af. bunds</td>
                <td class="ui-widget-content">
                    <?php echo getRequiredSign('left');
                    $displayCSS = 'block';
                    $isRequired = 'class=""';
                    if (in_array($arrStatusData['FLANKS_AF_BUNDS_STATUS'], $arrHideCondition)) {
                        $displayCSS = 'none';
                        $isRequired = '';//
                    } ?>
                    <select name="FLANKS_AF_BUNDS_STATUS" id="FLANKS_AF_BUNDS_STATUS" class="sel2"
                            style="width:180px"

                            onchange="enableDisableDate(this.name, this.value)">
                        <?php echo $arrStatusOptions['FLANKS_AF_BUNDS_STATUS']; ?>
                    </select>
                    <?php $arrOptions['FLANKS_AF_BUNDS_STATUS'] = $arrStatusOptions['FLANKS_AF_BUNDS_STATUS']; ?>
                </td>
                <td class="ui-widget-content" align="center">
                    <div id="reqFLANKS_AF_BUNDS_STATUS"
                         style="float:left;display:<?php echo $displayCSS; ?>"><?php echo getRequiredSign('left'); ?></div>
                    <input name="FLANKS_AF_BUNDS_DATE" id="FLANKS_AF_BUNDS_DATE" readonly="readonly" type="text"
                           size="48" maxlength="10"
                           style="width:50%;text-align:center;display:<?php echo $displayCSS; ?>"
                           value="<?php echo myDateFormat($arrTargetDates['FLANKS_AF_BUNDS_DATE']); ?>"/>
                </td>
            </tr>

            <tr>
                <td class="ui-state-default" align="center">d)</td>
                <td class="ui-state-default">Sluice/s</td>
                <td class="ui-widget-content">
                    <?php echo getRequiredSign('left');
                    $displayCSS = 'block';
                    $isRequired = 'class=""';
                    if (in_array($arrStatusData['SLUICE_STATUS'], $arrHideCondition)) {
                        $displayCSS = 'none';
                        $isRequired = '';
                    } ?>
                    <select name="SLUICE_STATUS" id="SLUICE_STATUS" class="sel2" style="width:180px"
                            onchange="enableDisableDate(this.name, this.value)">
                        <?php echo $arrStatusOptions['SLUICE_STATUS']; ?>
                    </select>
                    <?php $arrOptions['SLUICE_STATUS'] = $arrStatusOptions['SLUICE_STATUS']; ?>
                </td>
                <td class="ui-widget-content" align="center">
                    <div id="reqSLUICE_STATUS"
                         style="float:left;display:<?php echo $displayCSS; ?>"><?php echo getRequiredSign('left'); ?></div>
                    <input name="SLUICE_DATE" id="SLUICE_DATE" readonly="readonly" type="text" size="48"
                           maxlength="10"
                           style="width:50%;text-align:center;display:<?php echo $displayCSS; ?>"
                           value="<?php echo myDateFormat($arrTargetDates['SLUICE_DATE']); ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default" align="center">e)</td>
                <td class="ui-state-default">Nalla Closer</td>
                <td class="ui-widget-content">
                    <?php echo getRequiredSign('left');
                    $displayCSS = 'block';
                    $isRequired = 'class=""';
                    if (in_array($arrStatusData['NALLA_CLOSER_STATUS'], $arrHideCondition)) {
                        $displayCSS = 'none';
                        $isRequired = '';
                    } ?>
                    <select name="NALLA_CLOSER_STATUS" id="NALLA_CLOSER_STATUS" class="sel2" style="width:180px"

                            onchange="enableDisableDate(this.name, this.value)">
                        <?php echo $arrStatusOptions['NALLA_CLOSER_STATUS']; ?>
                    </select>
                    <?php $arrOptions['NALLA_CLOSER_STATUS'] = $arrStatusOptions['NALLA_CLOSER_STATUS']; ?>
                </td>
                <td class="ui-widget-content" align="center">
                    <div id="reqNALLA_CLOSER_STATUS"
                         style="float:left;display:<?php echo $displayCSS; ?>"><?php echo getRequiredSign('left'); ?></div>
                    <input name="NALLA_CLOSER_DATE" id="NALLA_CLOSER_DATE" readonly="readonly" type="text"
                           size="48" maxlength="10"
                           style="width:50%;text-align:center;display:<?php echo $displayCSS; ?>"
                           value="<?php echo myDateFormat($arrTargetDates['NALLA_CLOSER_DATE']); ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default" align="center">f)</td>
                <td class="ui-state-default">Canal E/W</td>
                <td class="ui-widget-content">
                    <?php echo getRequiredSign('left');
                    $displayCSS = 'block';
                    $isRequired = 'class=""';
                    if (in_array($arrStatusData['CANAL_EW_STATUS'], $arrHideCondition) || $arrSetupStatus['CANAL_EARTHWORK_NA']) {
                        $displayCSS = 'none';
                        $isRequired = '';
                    } ?>
                    <select name="CANAL_EW_STATUS" id="CANAL_EW_STATUS" class="sel2" style="width:180px"
                        <?php echo(($arrSetupStatus['CANAL_EARTHWORK_NA']) ? 'disabled="disabled"' : ''); ?>
                            onchange="enableDisableDate(this.name, this.value)">
                        <?php echo $arrStatusOptions['CANAL_EW_STATUS']; ?>
                    </select>
                    <?php
                    $arrOptions['CANAL_EW_STATUS'] = $arrStatusOptions['CANAL_EW_STATUS']; ?>
                </td>
                <td class="ui-widget-content" align="center">
                    <div id="reqCANAL_EW_STATUS"
                         style="float:left;display:<?php echo $displayCSS; ?>"><?php echo getRequiredSign('left'); ?></div>
                    <input name="CANAL_EW_DATE" id="CANAL_EW_DATE" readonly="readonly" type="text" size="48"
                           maxlength="10"
                           style="width:50%;text-align:center;display:<?php echo $displayCSS; ?>"
                           value="<?php echo myDateFormat($arrTargetDates['CANAL_EW_DATE']); ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default" align="center">g)</td>
                <td class="ui-state-default">Canal Structure</td>
                <td class="ui-widget-content">
                    <?php echo getRequiredSign('left');
                    $displayCSS = 'block';
                    $isRequired = 'class=""';
                    /*showArrayValues($arrStatusData['CANAL_STRUCTURE_STATUS']);
showArrayValues($arrStatusOptions);
showArrayValues($arrSetupStatus);*/
                    if (in_array($arrStatusData['CANAL_STRUCTURE_STATUS'], $arrHideCondition) || $arrSetupStatus['CANAL_STRUCTURE_NA']) {
                        $displayCSS = 'none';
                        $isRequired = '';
                    } ?>
                    <select name="CANAL_STRUCTURE_STATUS" id="CANAL_STRUCTURE_STATUS" class="sel2"
                            style="width:180px"
                        <?php echo(($arrSetupStatus['CANAL_STRUCTURE_NA']) ? 'disabled="disabled"' : ''); ?>
                            onchange="enableDisableDate(this.name, this.value)">
                        <?php echo $arrStatusOptions['CANAL_STRUCTURE_STATUS']; ?>
                    </select>
                    <?php $arrOptions['CANAL_STRUCTURE_STATUS'] = $arrStatusOptions['CANAL_STRUCTURE_STATUS']; ?>
                </td>
                <td class="ui-widget-content" align="center">
                    <div id="reqCANAL_STRUCTURE_STATUS"
                         style="float:left;display:<?php echo $displayCSS; ?>"><?php echo getRequiredSign('left'); ?></div>
                    <input name="CANAL_STRUCTURE_DATE" id="CANAL_STRUCTURE_DATE" readonly="readonly" type="text"
                           size="48" maxlength="10"
                           style="width:50%;text-align:center;display:<?php echo $displayCSS; ?>"
                           value="<?php echo myDateFormat($arrTargetDates['CANAL_STRUCTURE_DATE']); ?>"/>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default" align="center">h)</td>
                <td class="ui-state-default">Canal Lining</td>
                <td class="ui-widget-content">
                    <?php echo getRequiredSign('left');
                    $displayCSS = 'block';
                    $isRequired = 'class=""';
                    if (in_array($arrStatusData['CANAL_LINING_STATUS'], $arrHideCondition) || $arrSetupStatus['CANAL_LINING_NA']) {
                        $displayCSS = 'none';
                        $isRequired = '';
                    } ?>
                    <select name="CANAL_LINING_STATUS" id="CANAL_LINING_STATUS" class="sel2" style="width:180px"
                        <?php echo(($arrSetupStatus['CANAL_LINING_NA']) ? 'disabled="disabled"' : ''); ?>
                            onchange="enableDisableDate(this.name, this.value)">
                        <?php echo $arrStatusOptions['CANAL_LINING_STATUS']; ?>
                    </select>
                    <?php $arrOptions['CANAL_LINING_STATUS'] = $arrStatusOptions['CANAL_LINING_STATUS']; ?>
                </td>
                <td class="ui-widget-content" align="center">
                    <div id="reqCANAL_LINING_STATUS"
                         style="float:left;display:<?php echo $displayCSS; ?>"><?php echo getRequiredSign('left'); ?></div>
                    <input name="CANAL_LINING_DATE" id="CANAL_LINING_DATE" readonly="readonly" type="text"
                           size="48" maxlength="10"
                           style="width:50%;text-align:center;display:<?php echo $displayCSS; ?>"
                           value="<?php echo myDateFormat($arrTargetDates['CANAL_LINING_DATE']); ?>"/>
                </td>
            </tr>

        </table>
    </div>
</fieldset>