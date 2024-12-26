<?php date_default_timezone_set('Asia/Kolkata');
//error_reporting(E_ALL);
class Monthly_c extends MX_Controller{
    var $PROJECT_ID, $data, $message, $PROJECT_SETUP_ID;
	//ok
    function __construct(){
        parent::__construct();
        $this->RESULT = false;
        $this->message = array();
        $this->PROJECT_ID = 0;
        $this->PROJECT_SETUP_ID = 0;
        $this->data = array();    
        $this->load->model('dep/dep__t_monthly');
        date_default_timezone_set('Asia/Kolkata');
				if(getSessionDataByKey('CURRENT_OFFICE_ID')==0){
						echo '<h1 style="text-align:center;color:#f00">Please Contact SE MIS For Monthly Entry.</h1>';
					exit;
				}
    }
	//ok
    public function index(){
        $data = array();
        $data['message'] = '';
        $data['page_heading'] = pageHeading('Deposit Project - Monthly Data Entry');
        $this->load->library('office_filter');
        $data['office_list'] = $this->office_filter->office_list();
        $data['isValid'] = 0;
        if (getSessionDataByKey('HOLDING_PERSON') == 4) {
			$data['isValid'] = (IS_LOCAL_SERVER) ? 0: $this->dep__t_monthly->isSetupTargetNotLocked();
        }
        if (!$data['isValid']) {
            $data['project_monthly_grid'] = $this->createGrid();
        }
        $this->load->view('dep/monthly_index_view', $data);
    }
    public function showOfficeFilterBox(){
        $data = array();
        $data['prefix'] = 'search_office';
        $data['show_sdo'] = FALSE;
        $data['row'] = '<tr>
		<td class="ui-widget-content"><strong>Project Name</strong></td>
		<td class="ui-widget-content">
			<input type="text" value="" name="SEARCH_PROJECT_NAME" id="SEARCH_PROJECT_NAME">
		</td>
		</tr>
		<tr><td colspan="2" class="ui-widget-content">' . getButton('Search', 'refreshSearch()', 4, 'cus-zoom') . '</td></tr>';
        $this->load->view('setup/office_filter_view', $data);
    }
	//
    private function createGrid(){
        $permissions = $this->dep__t_monthly->getPermissions();
        $buttons = array();
        $mfunctions = array();
        array_push($mfunctions, "loadComplete: function(){afterReload();}");
        //array_push($mfunctions , "onSelectRow: function(ids){getProjectSubType(ids);}");
        $aData = array(
            'set_columns' => array(
                array(
                    'label' => 'Work Name',
                    'name' => 'WORK_NAME',
                    'width' => 80,
                    'align' => "left",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                ),
                array(
                    'label' => 'Parent Project',
                    'name' => 'PARENT_PROJECT',
                    'width' => 70,
                    'align' => "left",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                ),
                array(
                    'label' => 'Project Code',
                    'name' => 'PROJECT_CODE',
                    'width' => 40,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                ),
                array(
                    'label' => 'Exists',
                    'name' => 'MONTHLY_EXISTS',
                    'width' => 30,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => 'date',
                    'newformat' => 'M, Y',
                    'searchoptions' => ''
                ),
                array(
                    'label' => addslashes('<span class="cus-lock"></span>Month'),
                    'name' => 'MONTH_LOCK',
                    'width' => 30,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => 'date',
                    'newformat' => 'M, Y',
                    'searchoptions' => ''
                ),
                array(
                    'label' => 'Data Entry',
                    'name' => 'ADD',
                    'width' => 50,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => false,
                    'hidden' => false,
                    'view' => true,
                    'search' => false,
                    'formatter' => '',
                    'searchoptions' => ''
                ),
                array(
                    'label' => 'Action',
                    'name' => 'lock',
                    'width' => 40,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => false,
                    'hidden' => false,
                    'view' => true,
                    'search' => false,
                    'formatter' => '',
                    'searchoptions' => ''
                ),
                array(
                    'label' => 'Progress',
                    'name' => 'PROGRESS',
                    'width' => 25,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => false,
                    'hidden' => false,
                    'view' => true,
                    'search' => false,
                    'formatter' => '',
                    'searchoptions' => ''
                ),
				array(
                    'label' => 'Setup Id',
                    'name' => 'PROJECT_SETUP_ID',
                    'width' => 25,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => false,
                    'hidden' => false,
                    'view' => true,
                    'search' => false,
                    'formatter' => '',
                    'searchoptions' => ''
                )
            ),
            'custom' => array("button" => $buttons, "function" => $mfunctions),
            'div_name' => 'projectListGrid',
            'source' => 'loadProjectGrid',
            'postData' => '{}',
            'rowNum' => 10,
			'autowidth'=>true,
            'width' => DEFAULT_GRID_WIDTH,
            'height' => '',
            'altRows' => true,
            'rownumbers' => true,
            'sort_name' => 'PROJECT_SETUP_ID',
            'sort_order' => 'desc',
            'primary_key' => 'WORK_NAME',
            'add_url' => '',
            'edit_url' => '',
            'delete_url' => '',
            'caption' => addslashes('<span class="cus-date"></span>Projects for Monthly Data Entry'),
            'pager' => true,
            'showTotalRecords' => true,
            'toppager' => false,
            'bottompager' => true,
            'multiselect' => false,
            'toolbar' => true,
            'toolbarposition' => 'top',
            'hiddengrid' => false,
            'editable' => false,
            'forceFit' => true,
            'gridview' => true,
            'footerrow' => false,
            'userDataOnFooter' => true,
            'treeGrid' => false,
            'custom_button_position' => 'bottom'
        );
        return buildGrid($aData);
    }

    public function loadProjectGrid(){
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
				$permissions = $this->dep__t_monthly->getPermissions();
        if ($this->input->post('SEARCH_PROJECT_NAME')) {
            array_push($objFilter->SQL_PARAMETERS, array('WORK_NAME', 'LIKE', $this->input->post('SEARCH_PROJECT_NAME')));
        }

        $EE_ID = $this->input->post('EE_ID');
        $CE_ID = $this->input->post('CE_ID');
        $SE_ID = $this->input->post('SE_ID');
        if ($EE_ID == false && $CE_ID == false && $SE_ID == false) {
            $EE_ID = getSessionDataByKey('EE_ID');
            $SE_ID = getSessionDataByKey('SE_ID');
            $CE_ID = getSessionDataByKey('CE_ID');
        }
        if ($EE_ID == 0 && $SE_ID == 0 && $CE_ID == 0) {// && $SDO_ID==0)
            //DO NOTHING .....
        } else {
           $arrOfficeWhere = array();
			if($EE_ID)									array_push($arrOfficeWhere,  ' EE_ID=' . $EE_ID);
			if($SE_ID && (!$EE_ID))						array_push($arrOfficeWhere,  ' SE_ID=' . $SE_ID);
			if($CE_ID && ( (!$SE_ID) && (!$EE_ID) ))	array_push($arrOfficeWhere,  ' CE_ID=' . $CE_ID);
			if($arrOfficeWhere)							array_push($objFilter->WHERE, implode(' AND ', $arrOfficeWhere));
        }
        $currentSessionId = getSessionDataByKey('CURRENT_SESSION_ID');
        $eeId = getSessionDataByKey('CURRENT_OFFICE_ID');
		
		$arrFields = array('PROJECT_SETUP_ID', 'PROJECT_CODE', 'AA_DATE', 
			'CONCAT(WORK_NAME,"<br />", WORK_NAME_HINDI)AS PROJECT_NAME',
			'CONCAT(PARENT_PROJECT_NAME,"<br />", PARENT_PROJECT_NAME_HINDI,"<br />", PARENT_PROJECT_ID)AS PARENT_PROJECT_NAME',
			'AA_DATE AS PROJECT_START_DATE','SETUP_LOCK',  'TARGET_LOCK_SESSION_ID', 'MONTH_LOCK', 'MONTHLY_EXISTS', 
			'SESSION_ID','SESSION_START_YEAR', 'SESSION_END_YEAR'
		);

        $strWhere = 'WHERE SETUP_LOCK=1 AND ((WORK_STATUS<5) OR ((WORK_STATUS>=5) AND ( IFNULL(IS_COMPLETED,0)=0) ))
				AND TARGET_LOCK_SESSION_ID>0 AND TARGET_LOCK_SESSION_ID<=' . $currentSessionId;
                
        //commented and new code on 06-01-2020
        /*$strWhere = 'WHERE SETUP_LOCK=1 AND ((WORK_STATUS<5) OR ((WORK_STATUS>=5) ) ) 
                AND TARGET_LOCK_SESSION_ID>0 AND TARGET_LOCK_SESSION_ID<=' . $currentSessionId;*/


		$this->load->library('DepositCommonSQLs');
		$strSQL = $this->depositcommonsqls->getProjectLockDataSQL($arrFields, $strWhere, 'english');

        $strSelect='';
        $strSelect.='SELECT PROJECT_SETUP_ID, PROJECT_CODE, AA_DATE, 
			PROJECT_NAME, PARENT_PROJECT_NAME, PROJECT_START_DATE, SETUP_LOCK, TARGET_LOCK_SESSION_ID, MONTH_LOCK, MONTHLY_EXISTS, 
			SESSION_ID,SESSION_START_YEAR,SESSION_END_YEAR, IS_COMPLETED
			from ( ';
        $strSelect.='SELECT 
                        distinct ps.PROJECT_SETUP_ID AS PROJECT_SETUP_ID, AA_DATE, 
                        CONCAT(WORK_NAME,"<br />", WORK_NAME_HINDI)AS PROJECT_NAME,                        
                        AA_DATE AS PROJECT_START_DATE,
                        office_ee.OFFICE_ID AS EE_ID,
                        office_se.OFFICE_ID AS SE_ID,
                        office_ce.OFFICE_ID AS CE_ID,
                        dep__t_locks.MONTH_LOCK AS MONTH_LOCK,
                        dep__t_locks.MONTHLY_EXISTS AS MONTHLY_EXISTS,
                        dep__t_locks.SE_LOCK_DATE_TIME AS SE_LOCK_DATE_TIME,
                        dep__t_locks.SE_LOCK_MONTH AS SE_LOCK_MONTH,
                        p.PROJECT_TYPE_ID AS PROJECT_TYPE_ID,
                        p.PROJECT_SUB_TYPE_ID AS PROJECT_SUB_TYPE_ID,
                        ps.PARENT_PROJECT_ID AS PARENT_PROJECT_ID,
                        ps.SESSION_ID AS SESSION_ID,
                        ps.PROJECT_COMPLETION_DATE AS PROJECT_COMPLETION_DATE,
                        ps.PROJECT_CODE AS PROJECT_CODE,
                        ps.AA_NO AS AA_NO,
                        
                        ps.AA_AUTHORITY_ID AS AA_AUTHORITY_ID,
                        ps.AA_AMOUNT AS AA_AMOUNT,
                        ps.AA_FILE_URL AS AA_FILE_URL,
                        ps.AA_USER_FILE_NAME AS AA_USER_FILE_NAME,
                        ps.LONGITUDE_D AS LONGITUDE_D,
                        ps.LONGITUDE_M AS LONGITUDE_M,
                        ps.LONGITUDE_S AS LONGITUDE_S,
                        ps.LATITUDE_D AS LATITUDE_D,
                        ps.LATITUDE_M AS LATITUDE_M,
                        ps.LATITUDE_S AS LATITUDE_S,
                        ps.DISTRICT_ID AS DISTRICT_ID,
                        ps.BLOCK_ID AS BLOCK_ID,
                        ps.TEHSIL_ID AS TEHSIL_ID,
                        ps.ASSEMBLY_ID AS ASSEMBLY_ID,
                        ps.NO_VILLAGES_BENEFITED AS NO_VILLAGES_BENEFITED,
                        ps.NALLA_RIVER AS NALLA_RIVER,
                        ps.WORK_STATUS AS WORK_STATUS,                        
                        ifnull(dep__t_locks.TARGET_LOCK_SESSION_ID,0) AS TARGET_LOCK_SESSION_ID,
                        ifnull(dep__t_locks.TARGET_EXISTS,0) AS TARGET_EXISTS,
                        ifnull(dep__t_locks.MONTH_LOCK,0) AS MONTHLY_LOCK,
                        ifnull(dep__t_locks.IS_COMPLETED,0) AS IS_COMPLETED,
                        ifnull(dep__t_locks.SE_COMPLETION,0) AS SE_COMPLETION,
                        ifnull(dep__t_locks.ID,0) AS LOCK_RECORD_ID,
                        ifnull(target_session.SESSION_START_YEAR,0) AS SESSION_START_YEAR,
                        ifnull(target_session.SESSION_END_YEAR,0) AS SESSION_END_YEAR,
                        setup_session.SESSION as SETUP_SESSION,
                        dep__t_locks.SETUP_LOCK AS SETUP_LOCK,
												p.PROJECT_NAME AS PARENT_PROJECT_NAME,
                        p.PROJECT_NAME_HINDI AS PARENT_PROJECT_NAME_HINDI,
                        ps.WORK_NAME AS WORK_NAME, ps.WORK_NAME_HINDI AS WORK_NAME_HINDI, office_ee.OFFICE_NAME AS EE_NAME,
                        office_se.OFFICE_NAME AS SE_NAME,
                        office_ce.OFFICE_NAME AS CE_NAME,
                        __project_types.PROJECT_TYPE AS PROJECT_TYPE,
                        __project_sub_types.PROJECT_SUB_TYPE AS PROJECT_SUB_TYPE,
                        pmon__m_authority.AUTHORITY_NAME AS AUTHORITY_NAME,
                        __districts.DISTRICT_NAME AS DISTRICT_NAME,
                        __blocks.BLOCK_NAME AS BLOCK_NAME,
                        __tehsils.TEHSIL_NAME AS TEHSIL_NAME,
                        __m_assembly_constituency.ASSEMBLY_NAME AS ASSEMBLY_NAME
		        FROM dep__m_project_setup as ps 
				inner join __projects as p on(ps.PARENT_PROJECT_ID = p.PROJECT_ID)
				inner join __projects_office as pro_office on(p.PROJECT_ID = pro_office.PROJECT_ID) 
				inner join __offices as office_ee on(pro_office.EE_ID = office_ee.OFFICE_ID) 
				inner join __offices as office_se on(office_ee.PARENT_OFFICE_ID = office_se.OFFICE_ID) 
				inner join __offices as  office_ce on(office_se.PARENT_OFFICE_ID = office_ce.OFFICE_ID) 
				left join dep__t_locks on(ps.PROJECT_SETUP_ID = dep__t_locks.PROJECT_SETUP_ID) 
				left join __sessions as target_session on(dep__t_locks.TARGET_LOCK_SESSION_ID = target_session.SESSION_ID) 
				left join __project_types on(p.PROJECT_TYPE_ID = __project_types.PROJECT_TYPE) 
				left join __project_sub_types on(p.PROJECT_SUB_TYPE_ID = __project_sub_types.PROJECT_SUB_TYPE_ID) 
				left join __sessions as setup_session on(ps.SESSION_ID = setup_session.SESSION_ID) 
				left join pmon__m_authority on(ps.AA_AUTHORITY_ID = pmon__m_authority.AUTHORITY_ID) 
				left join __districts on(ps.DISTRICT_ID = __districts.DISTRICT_ID) 
				left join __blocks on(ps.BLOCK_ID = __blocks.BLOCK_ID) 
				left join __tehsils on(ps.TEHSIL_ID = __tehsils.TEHSIL_ID) 
				left join __m_assembly_constituency on(ps.ASSEMBLY_ID = __m_assembly_constituency.ASSEMBLY_ID) '.$strWhere;
        $strSelect.= " UNION ";
        $strSelect.='SELECT 
                        distinct ps.PROJECT_SETUP_ID AS PROJECT_SETUP_ID, AA_DATE, 
                        CONCAT(WORK_NAME,"<br />", WORK_NAME_HINDI)AS PROJECT_NAME,                        
                        AA_DATE AS PROJECT_START_DATE,
                        office_ee.OFFICE_ID AS EE_ID,
                        office_se.OFFICE_ID AS SE_ID,
                        office_ce.OFFICE_ID AS CE_ID,
                        dep__t_locks.MONTH_LOCK AS MONTH_LOCK,
                        dep__t_locks.MONTHLY_EXISTS AS MONTHLY_EXISTS,
                        dep__t_locks.SE_LOCK_DATE_TIME AS SE_LOCK_DATE_TIME,
                        dep__t_locks.SE_LOCK_MONTH AS SE_LOCK_MONTH,
                        p.PROJECT_TYPE_ID AS PROJECT_TYPE_ID,
                        p.PROJECT_SUB_TYPE_ID AS PROJECT_SUB_TYPE_ID,
                        ps.PARENT_PROJECT_ID AS PARENT_PROJECT_ID,
                        ps.SESSION_ID AS SESSION_ID,
                        ps.PROJECT_COMPLETION_DATE AS PROJECT_COMPLETION_DATE,
                        ps.PROJECT_CODE AS PROJECT_CODE,
                        ps.AA_NO AS AA_NO,
                        
                        ps.AA_AUTHORITY_ID AS AA_AUTHORITY_ID,
                        ps.AA_AMOUNT AS AA_AMOUNT,
                        ps.AA_FILE_URL AS AA_FILE_URL,
                        ps.AA_USER_FILE_NAME AS AA_USER_FILE_NAME,
                        ps.LONGITUDE_D AS LONGITUDE_D,
                        ps.LONGITUDE_M AS LONGITUDE_M,
                        ps.LONGITUDE_S AS LONGITUDE_S,
                        ps.LATITUDE_D AS LATITUDE_D,
                        ps.LATITUDE_M AS LATITUDE_M,
                        ps.LATITUDE_S AS LATITUDE_S,
                        ps.DISTRICT_ID AS DISTRICT_ID,
                        ps.BLOCK_ID AS BLOCK_ID,
                        ps.TEHSIL_ID AS TEHSIL_ID,
                        ps.ASSEMBLY_ID AS ASSEMBLY_ID,
                        ps.NO_VILLAGES_BENEFITED AS NO_VILLAGES_BENEFITED,
                        ps.NALLA_RIVER AS NALLA_RIVER,
                        ps.WORK_STATUS AS WORK_STATUS,                        
                        ifnull(dep__t_locks.TARGET_LOCK_SESSION_ID,0) AS TARGET_LOCK_SESSION_ID,
                        ifnull(dep__t_locks.TARGET_EXISTS,0) AS TARGET_EXISTS,
                        ifnull(dep__t_locks.MONTH_LOCK,0) AS MONTHLY_LOCK,
                        ifnull(dep__t_locks.IS_COMPLETED,0) AS IS_COMPLETED,
                        ifnull(dep__t_locks.SE_COMPLETION,0) AS SE_COMPLETION,
                        ifnull(dep__t_locks.ID,0) AS LOCK_RECORD_ID,
                        ifnull(target_session.SESSION_START_YEAR,0) AS SESSION_START_YEAR,
                        ifnull(target_session.SESSION_END_YEAR,0) AS SESSION_END_YEAR,
                        setup_session.SESSION as SETUP_SESSION,
                        dep__t_locks.SETUP_LOCK AS SETUP_LOCK,
												p.PROJECT_NAME AS PARENT_PROJECT_NAME,
                        p.PROJECT_NAME_HINDI AS PARENT_PROJECT_NAME_HINDI,
                        ps.WORK_NAME AS WORK_NAME, ps.WORK_NAME_HINDI AS WORK_NAME_HINDI, office_ee.OFFICE_NAME AS EE_NAME,
                        office_se.OFFICE_NAME AS SE_NAME,
                        office_ce.OFFICE_NAME AS CE_NAME,
                        __project_types.PROJECT_TYPE AS PROJECT_TYPE,
                        __project_sub_types.PROJECT_SUB_TYPE AS PROJECT_SUB_TYPE,
                        pmon__m_authority.AUTHORITY_NAME AS AUTHORITY_NAME,
                        __districts.DISTRICT_NAME AS DISTRICT_NAME,
                        __blocks.BLOCK_NAME AS BLOCK_NAME,
                        __tehsils.TEHSIL_NAME AS TEHSIL_NAME,
                        __m_assembly_constituency.ASSEMBLY_NAME AS ASSEMBLY_NAME
		        FROM dep__m_project_setup as ps 
				inner join deposit__projects as p on(ps.PARENT_PROJECT_ID = p.PROJECT_ID)
				inner join deposit__projects_office as pro_office on(p.PROJECT_ID = pro_office.PROJECT_ID) 
				inner join __offices as office_ee on(pro_office.EE_ID = office_ee.OFFICE_ID) 
				inner join __offices as office_se on(office_ee.PARENT_OFFICE_ID = office_se.OFFICE_ID) 
				inner join __offices as  office_ce on(office_se.PARENT_OFFICE_ID = office_ce.OFFICE_ID) 
				left join dep__t_locks on(ps.PROJECT_SETUP_ID = dep__t_locks.PROJECT_SETUP_ID) 
				left join __sessions as target_session on(dep__t_locks.TARGET_LOCK_SESSION_ID = target_session.SESSION_ID) 
				left join __project_types on(p.PROJECT_TYPE_ID = __project_types.PROJECT_TYPE) 
				left join __project_sub_types on(p.PROJECT_SUB_TYPE_ID = __project_sub_types.PROJECT_SUB_TYPE_ID) 
				left join __sessions as setup_session on(ps.SESSION_ID = setup_session.SESSION_ID) 
				left join pmon__m_authority on(ps.AA_AUTHORITY_ID = pmon__m_authority.AUTHORITY_ID) 
				left join __districts on(ps.DISTRICT_ID = __districts.DISTRICT_ID) 
				left join __blocks on(ps.BLOCK_ID = __blocks.BLOCK_ID) 
				left join __tehsils on(ps.TEHSIL_ID = __tehsils.TEHSIL_ID) 
				left join __m_assembly_constituency on(ps.ASSEMBLY_ID = __m_assembly_constituency.ASSEMBLY_ID) '.$strWhere;
        $strSelect.=' ) AS a where 1 ';
        //$objFilter->SQL = $strSQL;
        $objFilter->SQL = $strSelect;
        $objFilter->executeMyQuery();
        //echo $objFilter->PREPARED_SQL;exit;
        if ($objFilter->TOTAL_RECORDS) {
            $rows = array();
            $isEE = ((getSessionDataByKey('HOLDING_PERSON') == 4) ? true : false);
            $seLockedMonth = '';
            $seLockedMonthValue = 0;
	      if($isEE){
	            $isOpt = isOperator();
                //$canEESave = TRUE;
                $canEELock = FALSE;
                $canEESave = FALSE;
				//$validEntryMonth = $this->dep__t_monthly->getValidEntryMonth();
				$validEntryMonth = date("Y-m-d", strtotime("first day of last month"));
           		$validEntrySessionId = getSessionIdByDate($validEntryMonth);
             	$validEntryMonthValue = strtotime($validEntryMonth);
	            $relaxRec = $this->dep__t_monthly->getEESELockRelaxation(getSessionDataByKey('CURRENT_OFFICE_ID'),  $validEntryMonth);
                $settingsRec = $this->dep__t_monthly->getEESELockSettings();
                $currentDay = date("j");
                $currentDateValue = strtotime("now");
                $saveStartDateValue = strtotime(date("Y-m-").str_pad($settingsRec->SAVE_START_DAY_EE, 2, '0', STR_PAD_LEFT));
                $saveEndDateValue = strtotime(date("Y-m-") . str_pad($settingsRec->SAVE_END_DAY_EE, 2, '0', STR_PAD_LEFT)." ".$settingsRec->LOCK_END_TIME_EE);
                $lockEndDateValue = strtotime(date("Y-m-") . str_pad($settingsRec->LOCK_END_DAY_EE, 2, '0', STR_PAD_LEFT)." ".$settingsRec->LOCK_END_TIME_EE);
                //SAVING
				//if current date is between EE date (start date and end date)
                if( ($currentDateValue >= $saveStartDateValue) && ($currentDateValue <= $saveEndDateValue) ) {
                     $canEESave = TRUE;
					
                }else{
										
									if ($relaxRec && ($relaxRec->IS_DEPOSIT_RM)) {
										$relaxFromDateValue = strtotime($relaxRec->RELAXATION_FROM);
										$relaxToDateValue = strtotime($relaxRec->RELAXATION_TO.' 23:59:00');
										if (($currentDateValue>= $relaxFromDateValue) && ($currentDateValue <= $relaxToDateValue)) {
											$canEESave = TRUE;
										}
									}
                }
 
								//LOCKING
                if(($currentDateValue >= $saveEndDateValue) && ($currentDateValue <= $lockEndDateValue)) {
										$canEELock = TRUE;
                }else{
										if ($relaxRec && ($relaxRec->IS_DEPOSIT_RM)) {
											$relaxFromDateValue = strtotime($relaxRec->RELAXATION_FROM);
											$relaxToDateValue = strtotime($relaxRec->RELAXATION_TO.' 23:59:00');
											if(($currentDateValue >= $relaxFromDateValue) && ($currentDateValue <= $relaxToDateValue)) {
												$canEELock = TRUE;
										}
								}
                }
                $arrEE = array();//36,38,84,52,77,72, 36,27,72, 27,51, 67, 53, 69
                if( in_array($this->session->userData('EE_ID'), $arrEE)){
                    $canEELock = TRUE;
                	$canEESave = TRUE;
                }
		 
                $isDebug = 0;
                if ($isDebug) {
                    //showArrayValues($settingsRec);
                    echo 'currentDateValue:' . date("d-m-Y", $currentDateValue) . "\n" .
                        'saveEndDateValue:' . date("d-m-Y H:i:s", $saveEndDateValue) . "\n" .
                        'lockEndDateValue:' . date("d-m-Y H:i:s", $lockEndDateValue) . "\n" .
                        'currentDay:' . $currentDay . "\n" .
                        'canEESave:' . $canEESave . ' canEELock:' . $canEELock . "\n";
                }
                //get last SE lock data
                $this->db->order_by('LOCKED_MONTH', 'DESC');
                $this->db->limit(1, 0);
                $recs = $this->db->get_where('dep__t_selocks', array('EE_ID'=>getSessionDataByKey('USER_ID')));
                if ($recs && $recs->num_rows()) {
                    $rec = $recs->row();
										$recs->free_result();
                   // $seLockedMonth = $rec->LOCKED_MONTH;
                   // $seLockedMonthValue = strtotime($seLockedMonth);
                }
            }
			$curDay = (int) date("d");
            $debug = FALSE;
            $oldCanEELock = $canEELock;
            $oldCanEESave = $canEESave;
			    foreach($objFilter->RESULT as $row) {
				//echo $row->SESSION_ID;
                $fieldValues = array();
                array_push($fieldValues, '"' . addslashes($row->PROJECT_NAME) . '"');
                array_push($fieldValues, '"' . addslashes($row->PARENT_PROJECT_NAME) . '"');
                array_push($fieldValues, '"' . addslashes($row->PROJECT_CODE) . '"');
                array_push($fieldValues, '"' . addslashes($row->MONTHLY_EXISTS) . '"');
                array_push($fieldValues, '"' . addslashes($row->MONTH_LOCK) . '"');
		        $lockMonth = '';
				$showEntryCaption = '';
				$showEntryButton = FALSE;
				$showLockCaption = '';
				$showLockButton = FALSE;
                $x = 'x';
	           if($isEE){
                    //last lock date by EE
                    $lockMonth = $row->MONTH_LOCK;
                    $lockMonthValue = strtotime($lockMonth);
                    $nextMonthValue = "";
                    $nextMonthValue = strtotime("+1 month", $lockMonthValue);

                    //no monthly records
                    if (($row->MONTHLY_EXISTS == NULL) || ($row->MONTH_LOCK == NULL)) {
                        $canEELock = TRUE;
                        $canEESave = TRUE;
                    }else{
                        $canEELock = $oldCanEELock;
                        $canEESave = $oldCanEESave;
                    }
               
               		if( (new DateTime(date('Y-m-d'))>= new DateTime('2024-06-07')) &&  (new DateTime(date('Y-m-d')) <= new DateTime('2024-06-08'))) {
						$canEELock = TRUE;
                    	$canEESave = TRUE;
					}
					if(($row->MONTHLY_EXISTS == NULL) || ($row->MONTH_LOCK == NULL)){
                        
						
						$startDateValue = strtotime(date("Y-m", strtotime($row->AA_DATE)) . "-01");
						$startSessionID = getSessionIdByDate($row->AA_DATE);
  						
                    	/*if($row->PROJECT_SETUP_ID ==226){
                        	echo $startDateValue. " -- ". $validEntryMonthValue;
                        }*/
                        
                		if($startDateValue <= $validEntryMonthValue) {
							if($validEntrySessionId < $row->SESSION_ID) {
								$showEntryCaption = '"<span class=\"cus-time\" title=\" \"></span> Not Ready"';
                        	}else{
                                //$validEntryMonthValue = strtotime(date("Y-m", strtotime("-1month")) . '-01');
                                $validEntryMonthValue = strtotime(date("Y-m-d", strtotime("first day of last month")));
                                
								$startDateValue = $nextMonthValue = $validEntryMonthValue;

								if($row->MONTHLY_EXISTS!=NULL){
									$monthlyExistsValue = strtotime($row->MONTHLY_EXISTS);

									if($monthlyExistsValue<$validEntryMonthValue){
										$nextMonthValue = $monthlyExistsValue;
                                         
									}
								}
								//show set button

								if($canEESave && $isOpt){
									$showEntryButton = TRUE;
									$x = '';
								}else{
									$showEntryCaption = '"<span class=\"cus-time\" title=\" Unavailable\"></span>"';
								}//else
                            }//else
						}else{

							$showEntryCaption = '"<span class=\"cus-time\" title=\" Wait for Next Month...\"></span>"';
						}
						 
                    }else{
                     
                        $lockShow = false;
                        //if lock month is same as se lock month
                      
                             if($lockMonthValue < $validEntryMonthValue){
                                //echo '99999999999999';
                                $nextMonthValue = strtotime("+1 month", $lockMonthValue);
                               
                            }
                            if($lockMonthValue == $validEntryMonthValue){
								$showEntryCaption = '"<span class=\"cus-lock\" title=\"Locked\"></span>"';
                                //array_push($fieldValues, '"<span class=\"cus-lock\" title=\"Locked\"></span>"');
                            }else{
                                if($canEESave){
                                    $curMonth = (int)date("m", $nextMonthValue);
                                    if($curMonth == 4) {
                                        $monthSessionId = getSessionIdByDate(date("Y-m-d", $nextMonthValue));
                                        //echo  '$monthSessionId:'.$monthSessionId.'=='.$row->TARGET_LOCK_SESSION_ID;
                                        if($monthSessionId == $row->TARGET_LOCK_SESSION_ID){
											$showEntryButton = TRUE;
                                        }else{
											$showEntryCaption = '"22-Waiting for Target..."';
                                        }
                                    }else{
										$showEntryButton = TRUE;
                                    }
                                }else{
									$showEntryCaption = '"<span class=\"cus-time\" title=\"Save Unavailable2\"></span>"';
                                }//else
                            }//else
                      //  }//if
                    }//else
					//lock ready
					////////////////////////////////////////////////////////////////////////////////////////
					//echo 'L:'.$lockMonthValue.' == '.$validEntryMonthValue.'<br />';
					if($debug) echo 'nextMonthValue:'.date("Y-m-d", $nextMonthValue)."\n";
					if($lockMonthValue == $validEntryMonthValue) {
						$showLockCaption = 'Locked';
						// array_push($fieldValues, '"<span class=\"cus-lock\" title=\"Locked\"></span>"');
					}else if($nextMonthValue <= $lockMonthValue) {
						$showLockCaption = 'Locked';
                        //array_push($fieldValues, '"' . addslashes('<span class="cus-lock" title="Monthly Locked"></span>') . '"');
                    }else{

                        if($row->MONTH_LOCK == NULL && $row->MONTHLY_EXISTS != NULL){
                            $showLockButton = TRUE;
                        }
						$monthSessionId = getSessionIdByDate(date("Y-m-d", $nextMonthValue));
                       // echo $monthSessionId;exit;
						//if($row->PROJECT_SETUP_ID==3) 
						if($debug) echo 'monthSessionId:'.$monthSessionId .'=='. $row->TARGET_LOCK_SESSION_ID.'::';
                        if($row->TARGET_LOCK_SESSION_ID==NULL)
                            $showLockCaption = '"' . addslashes('Target not locked...'). '"';
                        else if($monthSessionId == 0) {
                            $showLockCaption = '"' . addslashes('Wait for next Month..'). '"';
                        }
						else if($monthSessionId != $row->TARGET_LOCK_SESSION_ID) {
							$showLockCaption = '"' . addslashes('Waiting for Target...'). '"';
						}else if($nextMonthValue == strtotime(date("Y-m") . '-01')) {
							$showLockCaption = 'Locked';
							//array_push($fieldValues, '"<span class=\"cus-lock\" title=\"Locked\"></span>"');
						}
						// echo 'ee lock = '. $canEELock .'<<'.$permissions['SAVE_LOCK']; exit;
						if($canEELock && $permissions['SAVE_LOCK']){
							//check for ready to lock
							$isReady = $this->dep__t_monthly->readyToLock($row->PROJECT_SETUP_ID, $nextMonthValue);
                        	/*if( $row->PROJECT_SETUP_ID ==177){
                            	echo 'isReady ='.$isReady;
                            }*/
							//$isReady =true;
							if($isReady) {
								$showLockButton = TRUE;
							}
						}//if
                    }//else
					////////////////////////////////////////////////////////////////////////////////////////
				}//if($isEE)
				//
				if($showEntryButton){
					//$nextMonthValue = strtotime("2018-09-01");
					array_push($fieldValues, '"'.addslashes(getButton(date("M, Y", $nextMonthValue).$x.'', 'showMonthlyStatusForm('.$row->PROJECT_SETUP_ID.', '.$nextMonthValue . ')', 4, 'cus-calendar-view-day')).'"');
				}else{
					//array_push($fieldValues, '"'.addslashes($row->PROJECT_SETUP_ID).'"');
					if($showEntryCaption=='') $showEntryCaption = '"<span class=\"cus-time\" title=\"Unavailable.1\"></span>"';
					array_push($fieldValues, $showEntryCaption);
				}

				if($showLockButton){
					array_push($fieldValues, '"'.addslashes(
						getButton(date("M, Y", $nextMonthValue), 'lockMonthly('.$row->PROJECT_SETUP_ID.','.$nextMonthValue.')', 4, 'cus-lock')).'"'
					);
				}else{
					//array_push($fieldValues, '"'.addslashes($row->PROJECT_SETUP_ID).'"');
					if($showLockCaption=='') $showLockCaption = '"<span class=\"cus-time\" title=\"Lock Unavailable..\"></span>"';
					if($showLockCaption=='Locked') $showLockCaption =  '"'.addslashes('<span class="cus-lock" title="Month Locked"></span>').'"';
					array_push($fieldValues, $showLockCaption);
				}
				//Monthly progress
                array_push($fieldValues, '"'.addslashes($this->dep__t_monthly->getMonthlyProgress($row->PROJECT_SETUP_ID, $row->MONTHLY_EXISTS)).'"');
                array_push($fieldValues, '"'.addslashes($row->PROJECT_SETUP_ID).'"');
                array_push($objFilter->ROWS, '{"id":"' . $row->PROJECT_SETUP_ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
            }
        }
        echo $objFilter->getJSONCodeByRow();
        //echo $objFilter->getJSONCode('PROJECT_ID', $fields);
        //echo $objFilter->PREPARED_SQL;
    }
	//OK
    public function showMonthlyStatusForm(){
		$projectSetupId = $this->input->post('PROJECT_ID');
        $arrData = array('PROJECT_SETUP_ID'=>$projectSetupId, 'entryDate'=>$this->input->post('entryMonth'));
		$data = $this->dep__t_monthly->getData($arrData);
    	
    
    	$entryDate = $this->input->post('entryMonth');
        $prevMonthValue = strtotime("-1month", $entryDate);

        $arrWhich = array(  
                'PROJECT_SETUP_ID'=>$projectSetupId, 
                'MONTH_DATE' => date("Y-m-d", $prevMonthValue),
                'ENTRY_FROM' =>2
            );

        
        $this->db->select('PROJECT_SETUP_ID');
        $recs = $this->db->get_where('dep__t_monthly', $arrWhich);
        //echo $this->db->last_query(); //exit;
        $prevmonthExists = 0;
        if($recs && $recs->num_rows()) {
            $prevmonthExists = 1;            
        }else{
            $data['arrPreviousMonthData']['WORK_STATUS']='';
        }
        
        //code to get project status from epay servers //27-04-2020
        // [ CODE STARTS ]
        //if(!$bypassEworks){
          $this->load->library('mycurl');
          $serverStatus = $this->mycurl->getServerStatus();
          if($serverStatus==0){
              echo 'E-work Server Not responding. Try after sometime...';
              return;
          }
        //}     
        //$eworkData = array('PROJECT_CODE'=>$data['arrProjectData']['PROJECT_CODE']);
        $eworkData = $this->dep__t_monthly->getEWorksDetailsForMonthly($projectSetupId);
        //$result = 0;
        $result = $this->mycurl->getDepositProjectStatus($eworkData);
        //Get project status from epay
        //$result = $this->mycurl->getDepositProjectStatus($eworkData);
        //$data['EWORK_PROJECT_STATUS'] =$result;
        $jsonVal = json_decode($result , true);

        /**
		 * 8-7-2024, Check status of final Payment in eworks
		 */
		$curlParams = array("mode" => "PMON_AGR_FINAL_BILL_CHK",  "Ddocode" => $eworkData['ddocode'] , "PromonID"=> $eworkData['promon_id'] ,"projectCode" =>'');
		$paymentStatusJson = $this->mycurl->savePromonData($curlParams);
		$paymentStatusArr = json_decode($paymentStatusJson , true);
		$data['EWORK_PAYMENT_STATUS'] = $paymentStatusArr['success'];

        //showArrayValues($jsonVal); exit;
        $skipProjects= array(266); //167,169,160,162,163, 169,168,160
        //if($projectSetupId == 198){
        if (in_array( $projectSetupId , $skipProjects)){
            $data['EWORK_PROJECT_STATUS'] =0;
        }else{
            $data['EWORK_PROJECT_STATUS'] = $jsonVal['success'];
            if ($jsonVal['success'] ==2 ) {
                echo "<h2 style='color:#ff0000;'>चयनित परियोजना के मद में epay एवं MIS सर्वर में भिन्नता पाई गयी है , कृपया जांच कर डाटा सेन्टर को सूचित करें। </h2>"; 
                exit;
            }
        }
        // [ CODE END ] 

       // echo 'sadasd == '. $data['PROJECT_SUB_TYPE_ID'];    exit;
    
        if($data['PROJECT_SUB_TYPE_ID']==5){
            $this->load->view('dep/tubewell_monthly_data_view', $data);
        }else if($data['PROJECT_SUB_TYPE_ID']==25){
            $this->load->view('dep/mi_monthly_data_view', $data);
        }else{
            //$this->load->view('dep/target_data_default_view', $data);
            //$this->load->view('dep/tubewell_monthly_data_view', $data);
            $this->load->view('dep/default_monthly_data_view', $data);
        }
    }
	//
    public function saveMonthlyData(){
		date_default_timezone_set('Asia/Kolkata');
        //exit;
		$arrData = array();
		foreach($this->input->post() as $k=>$v)	$arrData[$k] = $v;
		$message = $this->dep__t_monthly->saveData($arrData);
		echo createJSONResponse($message);
    }
     
    //OK
    public function monthlyProgressCheck(){
        $projectId = (int)$this->input->post('project_id');
        $lockMonth = date("Y-m-d", $this->input->post('lock_month'));
        echo $this->dep__t_monthly->getMonthlyProgress($projectId, $lockMonth);
    }

	//ok
    public function lockMonthly(){
        date_default_timezone_set('Asia/Kolkata');   
        $projectSetupId = (int)$this->input->post('project_id');
        $lockMonth = (int)$this->input->post('lock_month');//AS value
		$arrParams = $this->dep__t_monthly->prepareDataForLock($projectSetupId, $lockMonth);
		//showArrayValues($arrParams); exit;
		if(!$arrParams){
			return ;
		}
		$lockResult = FALSE;
		 if(!IS_LOCAL_SERVER){
	 		$lockResult = TRUE;
				//echo "<br />Monthly Progress Sent to E-Works Server.<br />";
				$this->dep__t_monthly->updateLockedStatus($projectSetupId, $arrParams);
				//$this->mi__t_monthly->saveIrrigationPotential($lockMonth, $this->PROJECT_SETUP_ID);
				//clean monthly yearly
				if(in_array($arrParams['projectStatus'], array(5, 6))){
					//$arrParams = $this->dep__t_monthly->cleanupMonthlyData($projectSetupId, $lockMonth);
				}
		//	}
		} 
        $arrMonth = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        echo(($lockResult) ? '<span class="cus-lock"></span>"' .
            $arrMonth[date("n", $lockMonth)] . '" Month Data Locked' . (($arrParams['projectStatus']==5) ? '<br />Project Completed' : '') :
            '<span class="cus-bullet-error"></span> Unable to Lock  "'.$arrMonth[date("n", $lockMonth)].'" Month Data');
    }

    
    // not using this method
    private function getMonCorrect(){
        $PID = array(2733, 2845, 2971, 2986, 3005, 3044, 3046, 3119, 3148, 3149, 3189, 3211, 3252, 3253, 3254, 3255, 3266, 3283, 3285, 3287, 3289, 3290, 3293, 3294, 3349, 3359, 3360, 3361, 3363, 3373, 3374, 3375, 3376, 3406, 3411, 3421, 3426, 3526, 3566, 3666);
        $monthlyFields = $this->dep__t_monthly->getFields('dep__t_monthlydata');
        $this->db->where_in('PROJECT_ID', $PID);
        $this->db->order_by('PROJECT_ID ASC, MONTH_DATE ASC');
        $recs = $this->db->get('dep__t_monthlydata');
        if ($recs) {
            $prjid = 0;
            $i = 0;
            $prevmonth = 0;
            foreach ($recs->result() as $rec) {
                if ($prjid != $rec->PROJECT_ID) {
                    $prjid = $rec->PROJECT_ID;
                    $i = ($i == 0) ? 1 : 0;
                    echo '</p><p class="row' . $i . '">';
                    $prevmonth = (int)date("m", strtotime($rec->MONTH_DATE));
                    $y = 0;
                }
                $curmonth = (int)date("m", strtotime($rec->MONTH_DATE));
                if ($rec->MONTH_DATE == '0000-00-00' || $rec->MONTH_DATE == '2013-04-01') {
                    $prevRec = $rec;
                    continue;
                }
                $suspect = 0;
                if ($prevmonth == $curmonth) {

                } else if ($prevmonth == 12) {
                    if ($curmonth == 1) {
                        //ok
                    } else {
                        $suspect = 1;
                    }
                } else {
                    if (($prevmonth + 1) == $curmonth) {
                        //ok
                    } else {
                        $suspect = 1;
                    }
                }

                $missing_month = array();
                if ($suspect == 1) {
                    //get missing month
                    $monthDatas = array();
                    $xx = ($prevmonth == 12) ? 1 : ($prevmonth + 1);
                    $SESSION_ID = $prevRec->SESSION_ID;
                    $M_YEAR = $prevRec->ENTRY_YEAR + (($prevmonth == 12) ? 1 : 0);
                    $arrExclude = array('MONTHLY_DATA_ID', 'SESSION_ID',
                        'ENTRY_YEAR', 'MONTH_DATE',
                        'FINANCIAL_MONTH'
                    );
                    for (; $xx < $curmonth; $xx++) {
                        array_push($missing_month, $xx);
                        $monthData = array();
                        for ($imCount = 0; $imCount < count($monthlyFields); $imCount++) {
                            if (in_array($monthlyFields[$imCount], $arrExclude)) {
                                continue;
                            } else if ($monthlyFields[$imCount] == 'ENTRY_MONTH') {
                                $monthData['ENTRY_YEAR'] = '2014';
                                $monthData['ENTRY_MONTH'] = $xx;
                                $monthData['FINANCIAL_MONTH'] = getFinancialMonth($xx);
                                $monthData['MONTH_DATE'] = '2014-' . str_pad($xx, 2, "0", STR_PAD_LEFT) . '-01';
                                $monthData['SESSION_ID'] = (($xx >= 4) ? 9 : 8);

                                /*echo $monthData[ 'MONTH_DATE'] .'::fm : '.
								$monthData[ 'FINANCIAL_MONTH'].':: sid: '.
								$monthData[ 'SESSION_ID'].'<br />';*/
                            } else {
                                $monthData[$monthlyFields[$imCount]] = $prevRec->{$monthlyFields[$imCount]};
                            }
                        }

                        array_push($monthDatas, $monthData);

                    }
                    //showArrayValues($monthDatas);
                    $this->db->insert_batch('dep__t_monthlydata', $monthDatas);
                }
                $prevmonth = (int)date("m", strtotime($rec->MONTH_DATE));
                echo 'PR ID:' . $rec->PROJECT_ID . ' month dt:' .
                    (($suspect == 1) ? '<span style="color:#F00">Susp:' : '') . $rec->MONTH_DATE .
                    (($suspect == 1) ? '</span>' : '') .
                    (($suspect == 1) ? ' Missing : ' . implode(', ', $missing_month) : '') .
                    '<BR />';
                $prevRec = $rec;
                $y++;
            }
        }
    }

}
