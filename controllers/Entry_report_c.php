<?php
include_once("Project_library.php");

class Entry_report_c extends Project_library
{
    var $proID, $OFF_ARRAY, $RAA_ID, $PROJECT_SETUP_ID,
        $SAVE_MODE, $message, $MODULE_KEY, $IS_PROJECT_LOCKED,
        $block, $data;

    function __construct()
    {
        parent::__construct();
//  ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);
        $this->PROJECT_SETUP_ID = 0;
        $this->message = array();
        $this->IS_PROJECT_LOCKED = FALSE;
        $this->load->model('dep/dep__m_report');
    }

    public function index()
    {
        $data = array();
        $data['message'] = '';
        $data['page_heading'] = pageHeading('Deposit - Deposit Project Entry Reports');
        $this->load->library('office_filter');
        $data['office_list'] = $this->office_filter->office_list();
        $data['message'] = '';
        $data['project_list'] = $this->createGrid();
        $data['year_drop_down'] = $this->getYearDropDown();
        $data['month_drop_down'] = $this->getMonthDropDown();
        $this->load->view('dep/print/report_index_view', $data);
    }

    private function createGrid()
    {
        $buttons = array();
        $mfunctions = array();
        array_push($mfunctions, "onSelectRow: function(ids){fillProjectId();}");
        $aData = array(
            'set_columns' => array(
                array(
                    'label' => 'Project Name',
                    'name' => 'WORK_NAME',
                    'width' => 120,
                    'align' => "left",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                ),
                /*array(
                    'label' => 'परियोजना',
                    'name' => 'PROJECT_NAME_HINDI',
                    'width' => 120,
                    'align' => "left",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                ),*/
                array(
                    'label' => 'Project Code',
                    'name' => 'PROJECT_CODE',
                    'width' => 30,
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
                    'label' => 'Project Sub Type',
                    'name' => 'PROJECT_SUB_TYPE',
                    'width' => 25,
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
                    'label' => 'Head',
                    'name' => 'DEPOSIT_SCHEME_ID',
                    'width' => 75,
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
                    'label' => 'Status',
                    'name' => 'MY_PROJECT_STATUS',
                    'width' => 10,
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
                    'label' => 'Setup',
                    'name' => 'LOCKED',
                    'width' => 10,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true
                ),
                array(
                    'label' => 'Target',
                    'name' => 'TARGET_LOCK_SESSION',
                    'width' => 20,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true
                ),
                array(
                    'label' => 'Month',
                    'name' => 'MONTH_LOCK',
                    'width' => 20,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => 'date',
                    'newformat' => 'M, Y',
                    'srcformat' => 'Y-m-d',
                ),
                array(
                    'label' => 'Setup Id',
                    'name' => 'PROJECT_SETUP_ID',
                    'width' => 20,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => true,
                    /*'key'=>false,*/
                    'search' => true,
                    'view' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                ),
                array(
                    'label' => 'Project Id',
                    'name' => 'PROJECT_ID',
                    'width' => 30,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => true,
                    /*'key'=>false,*/
                    'search' => true,
                    'view' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                )
            ),
            'custom' => array("button" => $buttons, "function" => $mfunctions),
            'div_name' => 'projectList',
            'source' => 'getProjectListGrid',
            'postData' => '{}',
            'rowNum' => 10,
            'width' => DEFAULT_GRID_WIDTH,
            'autowidth' => true,
            'height' => '',
            'altRows' => true,
            'rownumbers' => true,
            'sort_name' => 'PROJECT_NAME',
            'sort_order' => 'asc',
            'primary_key' => 'PROJECT_SETUP_ID',
            'caption' => 'Projects परियोजनाएं',
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
            'custom_button_position' => 'bottom'
        );
        return buildGrid($aData);
    }

    public function getYearDropDown()
    {
        $opt = array();
        $curYear = (int)date("Y");
        for ($i = 2018; $i <= date('Y'); $i++) {
            array_push(
                $opt,
                '<option value="' . $i . '" ' .
                (($i == $curYear) ? 'selected="selected"' : '')
                . '>' . $i . '</option>');
        }
        return implode('', $opt);
    }

    public function getMonthDropDown()
    {
        $opt = array();
        $month = array(
            'Select month', 'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        );
        $curMonth = ((int)date("m")) - 1;
        foreach ($month as $key => $val) {
            array_push($opt, '<option value="' . $key . '" ' .
                (($key == $curMonth) ? 'selected="selected"' : '')
                . '>' . $val . '</option>');
        }
        return implode('', $opt);
    }

    /**-------- Report ----------*/
    public function showOfficeFilterBox()
    {
        //$data['instance_name'] = 'search_office';
        $data = array();
        $data['prefix'] = 'search_office';
        $data['show_sdo'] = FALSE;
        $data['row'] = '<tr><td class="ui-widget-content"><strong>Project Status </strong></td>' .
            '<td class="ui-widget-content">
				<select name="SEARCH_PROJECT_STATUS" style="width:400px" class="office-select" id="SEARCH_PROJECT_STATUS">
			<option value="0">All Projects (सभी परियोजनाएं)</option>
			<option value="1">Ongoing Projects (निर्माणाधीन परियोजनाएं)</option>
			<option value="2">Completed Projects (पूर्ण परियोजनाएं)</option>
			<!--<option value="6">Dropped Projects</option>-->
			</select></td>
		</tr>
		<tr>
		<td class="ui-widget-content"><strong>Project Name</strong></td>
		<td class="ui-widget-content">
			<input type="text" value="" name="SEARCH_PROJECT_NAME" id="SEARCH_PROJECT_NAME">
		</td>
		</tr>
		<tr><td colspan="2" class="ui-widget-content">' . getButton(array('caption' => 'Search', 'event' => 'refreshSearch()', 'icon' => 'cus-zoom', 'title' => 'Search')) . '</td></tr>';
        $this->load->view('setup/office_filter_view', $data);
    }

    public function getProjectListGrid_OLD()
    {
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        /* =============== */
        if ($this->input->post('project_id')) {
            array_push($objFilter->SQL_PARAMETERS, array("PROJECT_SETUP_ID" => $this->input->post('project_id')));
        }
        if ($this->input->post('SEARCH_PROJECT_NAME')) {
            array_push($objFilter->SQL_PARAMETERS, array("WORK_NAME", 'LIKE', $this->input->post('SEARCH_PROJECT_NAME')));
        }
        $searchProjectStatus = $this->input->post('SEARCH_PROJECT_STATUS');
        $w = '';

        if ($searchProjectStatus == 1) {
            $w = ' AND WORK_STATUS <5';
        } elseif ($searchProjectStatus == 2) {
            $w = ' AND WORK_STATUS =5';
        }
        $EE_ID = $this->input->post('EE_ID');
        $CE_ID = $this->input->post('CE_ID');
        $SE_ID = $this->input->post('SE_ID');
        if ($EE_ID == false && $CE_ID == false && $SE_ID == false) {
            $EE_ID = $this->session->userData('EE_ID');
            $SE_ID = $this->session->userData('SE_ID');
            $CE_ID = $this->session->userData('CE_ID');
        }
        if ($EE_ID == 0 && $SE_ID == 0 && $CE_ID == 0) {
            //NO OPTION SELECTED BY E-IN-C
            array_push($objFilter->WHERE, ' 1 GROUP BY ps.PROJECT_SETUP_ID');

            $strSelect = ' ps.PROJECT_SETUP_ID, p.PROJECT_ID,  ps.AA_DATE AS PROJECT_START_DATE,
					ps.WORK_NAME, ps.WORK_NAME_HINDI, ps.PROJECT_CODE, locks.MONTH_LOCK, 
					CONCAT(target_session.SESSION_START_YEAR, "-",target_session.SESSION_END_YEAR)AS TARGET_LOCK_SESSION,
					IF(locks.SETUP_LOCK=1, "<span class=\'cus-lock\'></span>",
					 "<span class=\'cus-bullet-green\'></span>") as LOCKED,
					 IF(ps.WORK_STATUS<5, "<span class=\'cus-eye\'></span>",
					 IF(ps.WORK_STATUS=5, "<span class=\'cus-thumb-up\'></span>",
					 "<span class=\'cus-cancel\'></span>")) as MY_PROJECT_STATUS, psubtype.PROJECT_SUB_TYPE';
            $objFilter->SQL = $this->dep__m_report->getDEPProjectListSQL($strSelect, $w);

        } else {
            $EEE = '';//($SDO_ID==0)? '' : ' OFFICE_SDO_ID='.$SDO_ID;
            $EEE .= ($EE_ID == 0) ? '' : (($EEE == '') ? '' : ' AND ') . ' office_ee.OFFICE_ID=' . $EE_ID;
            $EEE .= ($SE_ID == 0) ? '' : (($EEE == '') ? '' : ' AND ') . ' office_se.OFFICE_ID=' . $SE_ID;
            $EEE .= ($CE_ID == 0) ? '' : (($EEE == '') ? '' : ' AND ') . ' office_ce.OFFICE_ID=' . $CE_ID;

            if ($this->session->userData('HOLDING_PERSON') != 4) {
                $EEE .= ' GROUP BY ps.PROJECT_SETUP_ID';
            }

            array_push($objFilter->WHERE, $EEE);
            $strSelect = 'DISTINCT ps.PROJECT_SETUP_ID, p.PROJECT_ID, ps.AA_DATE AS PROJECT_START_DATE,
					ps.WORK_NAME, ps.WORK_NAME_HINDI, ps.PROJECT_CODE,  locks.MONTH_LOCK, 
					CONCAT(target_session.SESSION_START_YEAR, "-",target_session.SESSION_END_YEAR)AS TARGET_LOCK_SESSION,
					IF(locks.SETUP_LOCK=1, "<span class=\'cus-lock\'></span>",
					 "<span class=\'cus-bullet-green\'></span>") as LOCKED,
					 IF(ps.WORK_STATUS<5, "<span class=\'cus-eye\'></span>",
					 IF(ps.WORK_STATUS=5, "<span class=\'cus-thumb-up\'></span>",
					 "<span class=\'cus-cancel\'></span>")) as MY_PROJECT_STATUS, psubtype.PROJECT_SUB_TYPE';

            $objFilter->SQL = $this->dep__m_report->getDEPProjectListSQL($strSelect, $w);
        }
        /* =============== */
        $fields = array(
            array('WORK_NAME', FALSE),
            array('WORK_NAME_HINDI', FALSE),
            array('PROJECT_CODE', FALSE),
            array('PROJECT_SUB_TYPE', FALSE),
            array('MY_PROJECT_STATUS', FALSE),
            array('LOCKED', FALSE),
            array('TARGET_LOCK_SESSION', FALSE),
            array('MONTH_LOCK', FALSE),
            array('PROJECT_SETUP_ID', FALSE),
            array('PROJECT_ID', FALSE)
        );
        echo $objFilter->getJSONCode('PROJECT_SETUP_ID', $fields);
        //echo $objFilter->PREPARED_SQL;
    }

    public function getProjectListGrid()
    {
        //echo $this->dep__m_project_setup->getDEPProjectListGrid($mode);
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        //$holdingPerson = getSessionDataByKey('HOLDING_PERSON');
        $w = '';
        $searchProjectStatus = $this->input->post('SEARCH_PROJECT_STATUS');
        $w = '';

        if ($searchProjectStatus == 1) {
            $w = ' AND WORK_STATUS <5';
        } elseif ($searchProjectStatus == 2) {
            $w = ' AND WORK_STATUS =5';
        }
        /* =============== */
        if ($this->input->post('SEARCH_PROJECT_NAME')) {
            //$w.= 'AND ps.WORK_NAME like "%'.$this->input->post('SEARCH_PROJECT_NAME').'%"';
            $w .= 'AND a.PROJECT_NAME like "%' . $this->input->post('SEARCH_PROJECT_NAME') . '%"';
        }
        if ($this->input->post('SEARCH_PROJECT_TYPE')) {
            //$w.= 'AND p.PROJECT_TYPE_ID='.$this->input->post('SEARCH_PROJECT_TYPE');
            $w .= 'AND a.PROJECT_TYPE_ID=' . $this->input->post('SEARCH_PROJECT_TYPE');
        }
        //$w.= ' AND ps.WORK_STATUS' . (($mode == 0) ? '<5 ' : '=5 ');
        //$w.= ' AND WORK_STATUS' . (($mode == 0) ? '<5 ' : '=5 ');

        $EE_ID = $this->input->post('EE_ID');
        $CE_ID = $this->input->post('CE_ID');
        $SE_ID = $this->input->post('SE_ID');
        $officeSelected = $EE_ID + $CE_ID + $SE_ID;
        if (!$officeSelected) {
            $EE_ID = getSessionDataByKey('EE_ID');
            $SE_ID = getSessionDataByKey('SE_ID');
            $CE_ID = getSessionDataByKey('CE_ID');
        }
        $arrOfficeWhere = array();
        /*if($EE_ID)									array_push($arrOfficeWhere,  ' office_ee.OFFICE_ID=' . $EE_ID);
        if($SE_ID && (!$EE_ID))						array_push($arrOfficeWhere,  ' office_se.OFFICE_ID=' . $SE_ID);
        if($CE_ID && ( (!$SE_ID) && (!$EE_ID) ))	array_push($arrOfficeWhere,  ' office_ce.OFFICE_ID=' . $CE_ID);*/

        if ($EE_ID) array_push($arrOfficeWhere, ' OFFICE_EE_ID=' . $EE_ID);
        if ($SE_ID && (!$EE_ID)) array_push($arrOfficeWhere, ' OFFICE_SE_ID=' . $SE_ID);
        if ($CE_ID && ((!$SE_ID) && (!$EE_ID))) array_push($arrOfficeWhere, ' OFFICE_CE_ID=' . $CE_ID);

        if ($arrOfficeWhere) array_push($objFilter->WHERE, implode(' AND ', $arrOfficeWhere));

        $strSelect = 'DISTINCT ps.PROJECT_SETUP_ID, ps.AA_DATE as  PROJECT_START_DATE, ps.PROJECT_CODE, ps.PARENT_PROJECT_ID, 
				CONCAT(ps.WORK_NAME,"<br />", ps.WORK_NAME_HINDI)as PROJECT_NAME,
				CONCAT(p.PROJECT_NAME,"<br />", p.PROJECT_NAME_HINDI)as PARENT_PROJECT_NAME,
				IF(locks.SETUP_LOCK=1, "<span class=\'cus-lock\'></span>", "<span class=\'cus-bullet-green\'></span>") as LOCKED';
        $strSelect = '';

        $strSelect .= 'select 
			a.PROJECT_SETUP_ID, a.PROJECT_START_DATE, a.PROJECT_CODE, a.PARENT_PROJECT_ID, 
            a.PROJECT_NAME,
            a.PARENT_PROJECT_NAME,
            a.LOCKED, 
			a.OFFICE_EE_ID,
			a.OFFICE_SE_ID,
			a.OFFICE_CE_ID, PROJECT_TYPE_ID, WORK_STATUS, HEAD, PROJECT_TYPE, PROJECT_SUB_TYPE,
			IF(a.WORK_STATUS<5, "<span class=\'cus-eye\'></span>",
					 IF(a.WORK_STATUS=5, "<span class=\'cus-thumb-up\'></span>",
					 "<span class=\'cus-cancel\'></span>")) as MY_PROJECT_STATUS,
			CONCAT(a.SESSION_START_YEAR, "-",a.SESSION_END_YEAR)AS TARGET_LOCK_SESSION, MONTHLY_LOCK
            from( ';
        $strSelect .= 'SELECT DISTINCT ps.PROJECT_SETUP_ID, ps.AA_DATE as  PROJECT_START_DATE, ps.PROJECT_CODE, ps.PARENT_PROJECT_ID, 
				CONCAT(ps.WORK_NAME,"<br />", ps.WORK_NAME_HINDI)as PROJECT_NAME,
				CONCAT(p.PROJECT_NAME,"<br />", p.PROJECT_NAME_HINDI)as PARENT_PROJECT_NAME,
				IF(locks.SETUP_LOCK=1, "<span class=\'cus-lock\'></span>", "<span class=\'cus-bullet-green\'></span>") as LOCKED, p.PROJECT_TYPE_ID, 
				CONCAT(HEAD," ",SCHEME_NAME_HINDI) AS HEAD,ptype.PROJECT_TYPE, psubtype.PROJECT_SUB_TYPE ';
        $strSelect .= ", p.PROJECT_NAME_HINDI AS PARENT_PROJECT_NAME_HINDI,
                    ifnull(locks.TARGET_LOCK_SESSION_ID, 0) AS TARGET_LOCK_SESSION_ID,
                   ifnull(locks.TARGET_EXISTS, 0) AS TARGET_EXISTS,
                   ifnull(locks.MONTH_LOCK, 0) AS MONTHLY_LOCK,
                   ifnull(locks.IS_COMPLETED, 0) AS IS_COMPLETED,
                   ifnull(locks.ID, 0) AS LOCK_RECORD_ID,
                   ifnull(target_session.SESSION_START_YEAR, 0) AS SESSION_START_YEAR,
                   ifnull(target_session.SESSION_END_YEAR, 0) AS SESSION_END_YEAR,
                   concat_ws(_utf8'-', setup_session.SESSION_START_YEAR, setup_session.SESSION_END_YEAR) AS SETUP_SESSION,
                   office_ee.OFFICE_NAME AS OFFICE_EE_NAME,
                   office_ee.OFFICE_ID AS OFFICE_EE_ID,
                   office_ee.OFFICE_NAME_HINDI AS OFFICE_EE_NAME_HINDI,
                   office_se.OFFICE_ID AS OFFICE_SE_ID,
                   office_se.OFFICE_NAME AS OFFICE_SE_NAME,
                   office_se.OFFICE_NAME_HINDI AS OFFICE_SE_NAME_HINDI,
                   office_ce.OFFICE_ID AS OFFICE_CE_ID,
                   office_ce.OFFICE_NAME AS OFFICE_CE_NAME,
                   office_ce.OFFICE_NAME_HINDI AS OFFICE_CE_NAME_HINDI, ps.WORK_STATUS
                FROM dep__m_project_setup as ps
                    JOIN __projects as p on ps.PARENT_PROJECT_ID = p.PROJECT_ID
                    LEFT JOIN __project_types AS ptype on ptype.PROJECT_TYPE_ID = p.PROJECT_TYPE_ID
                    LEFT JOIN __project_sub_types  AS psubtype on p.PROJECT_SUB_TYPE_ID = psubtype.PROJECT_SUB_TYPE_ID 
                    JOIN __projects_office pro_office on p.PROJECT_ID = pro_office.PROJECT_ID 
                    JOIN __offices office_ee on pro_office.EE_ID = office_ee.OFFICE_ID 
                    JOIN __offices office_se on office_ee.PARENT_OFFICE_ID = office_se.OFFICE_ID 
                    JOIN __offices office_ce on office_se.PARENT_OFFICE_ID = office_ce.OFFICE_ID 
                    LEFT JOIN dep__t_locks as locks on ps.PROJECT_SETUP_ID = locks.PROJECT_SETUP_ID 
                    LEFT JOIN __sessions as target_session on locks.TARGET_LOCK_SESSION_ID = target_session.SESSION_ID 
                    LEFT JOIN __project_types on p.PROJECT_TYPE_ID = __project_types.PROJECT_TYPE 
                    LEFT JOIN __project_sub_types on p.PROJECT_SUB_TYPE_ID = __project_sub_types.PROJECT_SUB_TYPE_ID 
                    LEFT JOIN __sessions as setup_session on ps.SESSION_ID = setup_session.SESSION_ID 
                    LEFT JOIN pmon__m_authority on ps.AA_AUTHORITY_ID = pmon__m_authority.AUTHORITY_ID 
                    LEFT JOIN __districts on ps.DISTRICT_ID = __districts.DISTRICT_ID 
                    LEFT JOIN __blocks on ps.BLOCK_ID = __blocks.BLOCK_ID 
                    LEFT JOIN __tehsils on ps.TEHSIL_ID = __tehsils.TEHSIL_ID 
                    LEFT JOIN __m_assembly_constituency as assembly_const on ps.ASSEMBLY_ID = assembly_const.ASSEMBLY_ID
                    LEFT JOIN " . AGREEMENT_DB . ".dep__m_scheme AS tblscheme on tblscheme.ID = ps.DEPOSIT_SCHEME_ID
                    WHERE 1 ";//.$w;
        $strSelect .= " UNION ";
        $strSelect .= 'Select DISTINCT ps.PROJECT_SETUP_ID, ps.AA_DATE as  PROJECT_START_DATE, ps.PROJECT_CODE, ps.PARENT_PROJECT_ID, 
				CONCAT(ps.WORK_NAME,"<br />", ps.WORK_NAME_HINDI)as PROJECT_NAME,
				CONCAT(p.PROJECT_NAME,"<br />", p.PROJECT_NAME_HINDI)as PARENT_PROJECT_NAME,
				IF(locks.SETUP_LOCK=1, "<span class=\'cus-lock\'></span>", "<span class=\'cus-bullet-green\'></span>") as LOCKED, p.PROJECT_TYPE_ID,
				CONCAT(HEAD," ",SCHEME_NAME_HINDI) AS HEAD, ptype.PROJECT_TYPE, psubtype.PROJECT_SUB_TYPE';
        $strSelect .= ", p.PROJECT_NAME_HINDI AS PARENT_PROJECT_NAME_HINDI,
                    ifnull(locks.TARGET_LOCK_SESSION_ID, 0) AS TARGET_LOCK_SESSION_ID,
                   ifnull(locks.TARGET_EXISTS, 0) AS TARGET_EXISTS,
                   ifnull(locks.MONTH_LOCK, 0) AS MONTHLY_LOCK,
                   ifnull(locks.IS_COMPLETED, 0) AS IS_COMPLETED,
                   ifnull(locks.ID, 0) AS LOCK_RECORD_ID,
                   ifnull(target_session.SESSION_START_YEAR, 0) AS SESSION_START_YEAR,
                   ifnull(target_session.SESSION_END_YEAR, 0) AS SESSION_END_YEAR,
                   concat_ws(_utf8'-', setup_session.SESSION_START_YEAR, setup_session.SESSION_END_YEAR) AS SETUP_SESSION,
                   office_ee.OFFICE_NAME AS OFFICE_EE_NAME,
                   office_ee.OFFICE_ID AS OFFICE_EE_ID,
                   office_ee.OFFICE_NAME_HINDI AS OFFICE_EE_NAME_HINDI,
                   office_se.OFFICE_ID AS OFFICE_SE_ID,
                   office_se.OFFICE_NAME AS OFFICE_SE_NAME,
                   office_se.OFFICE_NAME_HINDI AS OFFICE_SE_NAME_HINDI,
                   office_ce.OFFICE_ID AS OFFICE_CE_ID,
                   office_ce.OFFICE_NAME AS OFFICE_CE_NAME,
                   office_ce.OFFICE_NAME_HINDI AS OFFICE_CE_NAME_HINDI, ps.WORK_STATUS
                FROM dep__m_project_setup as ps
                JOIN deposit__projects as p on ps.PARENT_PROJECT_ID = p.PROJECT_ID 
                LEFT JOIN __project_types AS ptype on ptype.PROJECT_TYPE_ID = p.PROJECT_TYPE_ID
                LEFT JOIN __project_sub_types  AS psubtype on p.PROJECT_SUB_TYPE_ID = psubtype.PROJECT_SUB_TYPE_ID                    
                JOIN deposit__projects_office pro_office on p.PROJECT_ID = pro_office.PROJECT_ID 
                JOIN __offices office_ee on pro_office.EE_ID = office_ee.OFFICE_ID 
                JOIN __offices office_se on office_ee.PARENT_OFFICE_ID = office_se.OFFICE_ID 
                JOIN __offices office_ce on office_se.PARENT_OFFICE_ID = office_ce.OFFICE_ID 
                LEFT JOIN dep__t_locks as locks on ps.PROJECT_SETUP_ID = locks.PROJECT_SETUP_ID 
                LEFT JOIN __sessions as target_session on locks.TARGET_LOCK_SESSION_ID = target_session.SESSION_ID 
                LEFT JOIN __project_types on p.PROJECT_TYPE_ID = __project_types.PROJECT_TYPE 
                LEFT JOIN __project_sub_types on p.PROJECT_SUB_TYPE_ID = __project_sub_types.PROJECT_SUB_TYPE_ID 
                LEFT JOIN __sessions as setup_session on ps.SESSION_ID = setup_session.SESSION_ID 
                LEFT JOIN pmon__m_authority on ps.AA_AUTHORITY_ID = pmon__m_authority.AUTHORITY_ID 
                LEFT JOIN __districts on ps.DISTRICT_ID = __districts.DISTRICT_ID 
                LEFT JOIN __blocks on ps.BLOCK_ID = __blocks.BLOCK_ID 
                LEFT JOIN __tehsils on ps.TEHSIL_ID = __tehsils.TEHSIL_ID 
                LEFT JOIN __m_assembly_constituency as assembly_const on ps.ASSEMBLY_ID = assembly_const.ASSEMBLY_ID 
                LEFT JOIN " . AGREEMENT_DB . ".dep__m_scheme AS tblscheme on tblscheme.ID = ps.DEPOSIT_SCHEME_ID
                WHERE 1 ";//.$w;
        $strSelect .= ' ) as a where 1 ' . $w;
        //echo $strSelect; exit;
        $objFilter->SQL = $strSelect;
        //$objFilter->SQL = $this->dep__m_project_setup->getDEPProjectListSQL($strSelect, $w);
        $fields = array(
            array('PROJECT_NAME', FALSE),
            array('PROJECT_CODE', FALSE),
            array('PROJECT_SUB_TYPE', FALSE),
            array('HEAD', FALSE),
            array('MY_PROJECT_STATUS', FALSE),
            array('LOCKED', FALSE),
            array('TARGET_LOCK_SESSION', FALSE),
            array('MONTHLY_LOCK', FALSE),
            array('PROJECT_SETUP_ID', FALSE),
            array('PARENT_PROJECT_ID', FALSE)
        );
        echo $objFilter->getJSONCode('PROJECT_SETUP_ID', $fields);
        //echo '<br />'. $objFilter->PREPARED_SQL;
    }

    /**-------- Setup Report ----------*/
    public function getTargetSessionOptions()
    {
        $PROJECT_SETUP_ID = (int)$this->input->post('PROJECT_SETUP_ID');
        $recs = $this->db->distinct()
            ->select('target.SESSION_ID, concat(__sessions.SESSION_START_YEAR,"-",__sessions.SESSION_END_YEAR) as SESSION_YEAR')
            ->from('dep__t_yearlytargets as target')
            ->join('__sessions', '__sessions.SESSION_ID=target.SESSION_ID')
            ->order_by('SESSION_ID')
            ->where(array('PROJECT_SETUP_ID' => $PROJECT_SETUP_ID))
            ->get();
        $vOpt = '<option value="">Select Session</option>';
        if ($recs && $recs->num_rows()) {

            $totalCount = $recs->num_rows();
            $iCount = 1;
            foreach ($recs->result() as $rec) {
                $vOpt .= '<option value="' . $rec->SESSION_ID . '" ' . (($iCount == $totalCount) ? 'selected="selected"' : '') . '>' .
                    $rec->SESSION_YEAR .
                    '</option>';
                $iCount++;
            }
        }
        echo $vOpt;
    }

    public function getMonthlyOptions()
    {
        $PROJECT_SETUP_ID = (int)$this->input->post('PROJECT_SETUP_ID');
        $monthlyRecs = $this->dep__m_report->getMonthlyOptions($PROJECT_SETUP_ID);
        $vOpt = '';
        $vdate = '';
        $vOpt = '<option value="">Select Month</option>';
        $completed = FALSE;
        $lastMonth = '';
        $curMonthValue = strtotime(date("Y-m") . '-01');
        $prjNxtMonthValue = strtotime("+1months", $curMonthValue);
        if ($monthlyRecs && $monthlyRecs->num_rows()) {
            $totalCount = $monthlyRecs->num_rows();
            $iCount = 1;
            foreach ($monthlyRecs->result() as $rec) {
                $vOpt .= '<option label="0"  ' . (($iCount == $totalCount) ? 'selected="selected"' : '') . ' value="' . $rec->MONTHLY_DATA_ID . '">' .
                    date("M, Y", strtotime($rec->MONTH_DATE)) .
                    '</option>';
                if ($rec->WORK_STATUS == 5) $completed = TRUE;
                $lastMonth = $rec->MONTH_DATE;
                $iCount++;
            }
        } else {
            $dd = date("Y-m", strtotime("-1months")) . '-01';
        }
        $v1 = '';
        $curDay = (int)date("d");
        if (!$completed) {

            if (($lastMonth == date("Y-m") . '-01') && ($curDay < 20)) {
                //
            } else {
                $nextMonthValue = strtotime($lastMonth);
                $curMonthValue = strtotime(date("Y-m") . '-01');
                if ($nextMonthValue != '') {
                    $count = 0;
                    while (1) {
                        $count++;
                        $nextMonthValue = strtotime("+1months", $nextMonthValue);
                        $v1 .= '<option label="1" ' . (($nextMonthValue == $prjNxtMonthValue) ? " selected='selected'" : "") . ' value="-1">' . date("M, Y", $nextMonthValue) . '</option>';
                        $vdate = $nextMonthValue;
                        if ($nextMonthValue == $curMonthValue) break;
                        if ($count >= 21) break;
                    }
                }
            }
        }
        echo $vOpt . '##' . $v1 . '##' . $vdate;
    }

    public function printSetup()
    {
        $this->load->model('dep/dep__m_project_setup');
        $this->PROJECT_SETUP_ID = (int)$this->input->post('PROJECT_SETUP_ID');
        $arrSetupStatus = $this->dep__m_project_setup->getEstimationStatus($this->PROJECT_SETUP_ID);
        $projectSetupFields = $this->dep__m_report->getProjectSetupFields();
        //showArrayValues($projectSetupFields );exit;
        $projectSetupValues = array();
        foreach ($projectSetupFields as $f) $projectSetupValues[$f] = '';
        $arrWhere = array('PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID);
        $recs = $this->dep__m_project_setup->getDEPProjectDataAll($this->PROJECT_SETUP_ID);
        if ($recs && $recs->num_rows()) {
            if ($recs->num_rows() == 1) {
                $rec = $recs->row();
                foreach ($projectSetupFields as $f) {
                    $projectSetupValues[$f] = $rec->{$f};
                }
                $recs->free_result();
            }
        }
        //get sdo list BLOCK_IP_DATA
        $sdo = array();
        $recs = $this->db->select('m_p.OFFICE_ID,off.OFFICE_NAME')->from('dep__m_projects_office as m_p')->join('__offices as off', 'm_p.OFFICE_ID=off.OFFICE_ID')->where($arrWhere)->get();
        //$recs = $this->db->get_where('dep__m_projects_office', $arrWhere);
        if ($recs && $recs->num_rows()) {
            $xi = 1;
            foreach ($recs->result() as $recSDO) {
                array_push($sdo, $xi . '.' . $recSDO->OFFICE_NAME);
                $xi++;
            }
        }
        $projectSetupValues['SDO_OFFICE_NAME'] = implode(', ', $sdo);
        $data['projectSetupValues'] = $projectSetupValues;
        $data['arrSetupStatus'] = $arrSetupStatus;

        $recRAA = $this->dep__m_project_setup->getRAAData(1, $this->PROJECT_SETUP_ID);
        $data['RAA_AUTHORITY_ID'] = $this->dep__m_project_setup->getAuthorityName($recRAA['RAA_AUTHORITY_ID']);
        $data['RAA_VALUES'] = $recRAA;

        /************ check point */
        $SESSION_ID = 0;
        if ($projectSetupValues['SESSION_ID'])
            $SESSION_ID = $projectSetupValues['SESSION_ID'];
        if ($this->PROJECT_SETUP_ID) {

            $recAchieve = $this->dep__m_project_setup->getAchievement($SESSION_ID - 1, $this->PROJECT_SETUP_ID);
            $recEstimation = $this->dep__m_project_setup->getEstimation($this->PROJECT_SETUP_ID);
            $arrSetupStatusData = $this->dep__m_project_setup->getSetupStatus($this->PROJECT_SETUP_ID);
            $arrTargetDates = $this->dep__m_project_setup->getTargetDates($this->PROJECT_SETUP_ID);

            $data['arrEstimationData'] = $recEstimation;
            $data['arrAchievementData'] = $recAchieve;
            $data['arrSetupStatus'] = $arrSetupStatus;
            $data['arrSetupStatusData'] = $arrSetupStatusData;
            $data['arrTargetDates'] = $arrTargetDates;
        }
        $EE_ID = 0;
        $SDO_DD = '';
        $HOLDING_PERSON = $this->session->userData('HOLDING_PERSON');
        if ($HOLDING_PERSON == 4) {//ee
            $EE_ID = $this->session->userData('CURRENT_OFFICE_ID');
            $SDO_DD = '';
        }
        $data['EE_ID'] = $EE_ID;
        $SDO_IDs = array();
        if ($this->PROJECT_SETUP_ID > 0) {
            $recs = $this->db->get_where('dep__m_projects_office', $arrWhere);
            if ($recs && $recs->num_rows()) {
                foreach ($recs->result() as $rec) {
                    $EE_ID = $rec->EE_ID;
                    array_push($SDO_IDs, $rec->OFFICE_ID);
                }
            }
        }
        $data['sdo_options'] = $this->dep__m_report->SDOofficeOptions($EE_ID, $SDO_IDs);
        $data['EE_NAME'] = $this->dep__m_report->getOfficeEEname($EE_ID);
        if ($this->PROJECT_SETUP_ID) {
            $sessionId = $projectSetupValues['SESSION_ID'];
            // Restored IP start from here 27 Mar 2019
            $arrRestoredBlockIds = $this->dep__m_report->getRestoredBlockIds1($projectSetupValues['PROJECT_SETUP_ID']);
            //showArrayValues($arrRestoredBlockIds);exit;
            $arrRestoredBlockIps = $this->dep__m_report->getEstimationRestoredBlockIPReport($this->PROJECT_SETUP_ID);
            $arrBlockAIps = $this->dep__m_report->getRestoredAchievementBlockIP($this->PROJECT_SETUP_ID, $sessionId - 1);

            if ($arrRestoredBlockIds) {
                foreach ($arrRestoredBlockIds as $arrBlockId) {
                    if (array_key_exists($arrBlockId, $arrBlockAIps))
                        $arrRestoredBlockIps[$arrBlockId]['ACHIEVEMENT_IP'] = $arrBlockAIps[$arrBlockId]['ACHIEVEMENT_IP'];
                    else
                        $arrRestoredBlockIps[$arrBlockId]['ACHIEVEMENT_IP'] = 0;
                }
            }
            $data['BLOCK_IP_RESTORED_DATA'] = $arrRestoredBlockIps;
            //showArrayValues($data['BLOCK_IP_RESTORED_DATA']);
            // Restored IP end Here 27 Mar 2019
            $data['DISTRICT_BENEFITED'] = $this->getDistricts($this->dep__m_report->getDistrictBenefitedIDs($this->PROJECT_SETUP_ID));
            $arrBlockIds = $this->dep__m_report->getBlockIds($this->PROJECT_SETUP_ID);
            $data['BLOCKS_BENEFITED'] = $this->dep__m_project_setup->getBlockString($arrBlockIds);
            $data['ASSEMBLY_BENEFITED'] = $this->dep__m_report->getAssemblys($this->getBenefitedAssemblyIDs($this->PROJECT_SETUP_ID));
            $data['VILLAGES_BENEFITED'] = $this->dep__m_report->getVillages($this->PROJECT_SETUP_ID);
            //blockwise iP BLOCK_IP_RESTORED_DATA
            $arrBlockIds = $this->dep__m_report->getBlockIds($this->PROJECT_SETUP_ID);
            $arrBlockIps = $this->dep__m_report->getEstimationBlockIP($this->PROJECT_SETUP_ID, $recEstimation['ESTIMATED_QTY_ID']);
            $arrBlockAIps = $this->dep__m_report->getAchievementBlockIP($this->PROJECT_SETUP_ID, $sessionId - 1);
            foreach ($arrBlockIds as $arrBlockId) {
                if ($arrBlockId != null) {
                    if (array_key_exists($arrBlockId, $arrBlockAIps)) {
                        $arrBlockIps[$arrBlockId]['ACHIEVEMENT_IP'] = $arrBlockAIps[$arrBlockId]['ACHIEVEMENT_IP'];
                    } else {
                        $arrBlockIps[$arrBlockId]['ACHIEVEMENT_IP'] = 0;
                    }
                }
            }
            $data['BLOCK_IP_DATA'] = $arrBlockIps;
        }

        $arrProjectTypes = $this->dep__m_project_setup->getProjectSubTypeId($this->PROJECT_SETUP_ID);
        if ($arrProjectTypes['PROJECT_SUB_TYPE_ID'] == 5) { //tubewell
            $myview = $this->load->view('dep/print/project_setup_data_tubewell_print_view_table', $data, true);
        } elseif ($arrProjectTypes['PROJECT_SUB_TYPE_ID'] == 25) { //microirrigation
            $myview = $this->load->view('dep/print/project_setup_data_mi_print_view_table', $data, true);
        } else {
            $myview = $this->load->view('dep/print/project_setup_data_print_view_table', $data, true);
        }
        array_push($this->message, getMyArray(null, $myview));
        echo createJSONResponse($this->message);
    }

    //NOT using this function
    protected function getBenefitedAssemblyIDs($projectId)
    {
        $ids = array();
        if ($projectId) {
            $recs = $this->db->get_where('dep__m_assembly_const_served', array('PROJECT_SETUP_ID' => $projectId));
            //array_push($vlist, '<option value="0">Select District</option>');
            if ($recs && $recs->num_rows()) {
                foreach ($recs->result() as $rec) {
                    array_push($ids, $rec->ASSEMBLY_ID);
                }
                $recs->free_result();
            }
        }
        return $ids;
    }

    /**-------- Target Report ---------*/
    public function printTarget()
    {
        $data = array();
        $this->PROJECT_SETUP_ID = $this->input->post('PROJECT_SETUP_ID');
        $sessionId = $this->input->post('session');
        $rec_prj = null;
        $arrWhere = array('PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID);
        // Get AA AMOUNT to Compare with Target should no excessed
        $DepProjectData = $this->dep__m_report->getDepProjectData(array('WORK_NAME', 'PROJECT_CODE', 'AA_AMOUNT', 'AA_DATE', 'PROJECT_COMPLETION_DATE'), $arrWhere);

        $data['AA_AMOUNT'] = $DepProjectData['AA_AMOUNT'];
        $data['AA_RAA'] = 'AA';
        $extCompletionDate = $this->dep__m_report->getExtensionDate($this->PROJECT_SETUP_ID);
        $projectCompletionDate = ($extCompletionDate == '') ? $DepProjectData['PROJECT_COMPLETION_DATE'] : $extCompletionDate;

        $data['PROJECT_NAME'] = $DepProjectData['WORK_NAME'];
        $data['PROJECT_CODE'] = $DepProjectData['PROJECT_CODE'];

        $data['setupData'] = $this->dep__m_report->getSetupData($this->PROJECT_SETUP_ID);
        $data['BUDGET_AMOUNT'] = '';
        $data['SUBMISSION_DATE'] = '';
        //session
        if ($sessionId == 0) {
            $MONTH = date('m');
            $YEAR = date('Y');
            $sessionId = getSessionIdByDate();
        }
        $data['session_year'] = $this->dep__m_report->getSessionYearByID($sessionId);
        $data['sessionId'] = $sessionId;
        $SessionProjComp = getSessionIdByDate($projectCompletionDate);
        $data['SESSION_LIST'] = $this->dep__m_report->getMySessionOptions($SessionProjComp, $sessionId);
        $records = array();
        $targetFields = $this->dep__m_report->getYearlyTargetFields();

        //get RAA data
        $ress = $this->db->select('RAA_AMOUNT')
            ->from('dep__t_raa_project')
            ->order_by('RAA_PROJECT_ID', 'DESC')
            ->where(array('PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID))
            ->limit(1, 0)
            ->get();
        if ($ress && $ress->num_rows()) {
            $rrec = $ress->row();
            $ress->free_result();
            $data['AA_AMOUNT'] = $rrec->RAA_AMOUNT;
            $data['AA_RAA'] = 'RAA';
        }

        $arrBlockIps = $this->dep__m_report->getEstimationBlockIP1($this->PROJECT_SETUP_ID);
        $data['arrBlockIps'] = $arrBlockIps;

        for ($i = 1; $i <= 12; $i++) {
            $tMonth = (($i >= 10) ? ($i - 9) : ($i + 3));
            $mYears = $this->dep__m_report->getYearBySessionMonth($sessionId, $i);
            $tYears = (($i >= 10) ? $mYears[1] : $mYears[0]);
            $rec['TARGET_DATE'] = $tYears . '-' . str_pad($tMonth, 2, '0', STR_PAD_LEFT) . '-01';
            foreach ($targetFields as $key => $value) {
                if ($value == 'TARGET_DATE') {

                } else {
                    $rec[$value] = '';
                }
            }
            $records[$tYears . '-' . str_pad($tMonth, 2, '0', STR_PAD_LEFT) . '-01'] = (object)$rec;
        }
        $recs = $this->db->get_where(
            'dep__t_yearlytargets',
            array('PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID, 'SESSION_ID' => $sessionId)
        );
        if ($recs && $recs->num_rows()) {
            $i = 0;
            foreach ($recs->result() as $rec) {
                if ($i == 0) {
                    $data['SUBMISSION_DATE'] = $rec->SUBMISSION_DATE;
                    $i++;
                }
                $records[$rec->TARGET_DATE] = $rec;
            }
        }

        $targetBlockFields = $this->dep__m_report->getBlockWiseYearlyTargetFields();
        $rec = array();
        foreach ($targetBlockFields as $f) $rec[$f] = '';
        $targetBlockData = array();
        for ($i = 1; $i <= 12; $i++) {
            $tMonth = (($i >= 10) ? ($i - 9) : ($i + 3));
            $mYears = $this->dep__m_report->getYearBySessionMonth($sessionId, $i);
            $tYears = (($i >= 10) ? $mYears[1] : $mYears[0]);
            $rec['TARGET_DATE'] = $tYears . '-' . str_pad($tMonth, 2, '0', STR_PAD_LEFT) . '-01';

            foreach ($arrBlockIps as $k => $v) {
                $targetBlockData[$tYears . '-' . str_pad($tMonth, 2, '0', STR_PAD_LEFT) . '-01'][$k] = (object)$rec;
            }
        }
        $targetBlockRecs = $this->dep__m_report->getBlockWiseYearlyTarget($sessionId, $this->PROJECT_SETUP_ID);
        if ($targetBlockRecs) {
            foreach ($targetBlockRecs as $rec) {
                $targetBlockData[$rec->TARGET_DATE][$rec->BLOCK_ID] = $rec;
            }
        }
        $data['blockCount'] = count($arrBlockIps);
        $data['targetBlockData'] = $targetBlockData;

        $data['records'] = $records;
        //$myview = $this->load->view('dep/print/target_data_print_view', $data, true);
        $this->load->model('dep/dep__m_project_setup');
        $arrProjectTypes = $this->dep__m_project_setup->getProjectSubTypeId($this->PROJECT_SETUP_ID);
        if ($arrProjectTypes['PROJECT_SUB_TYPE_ID'] == 5) { //tubewell
            $myview = $this->load->view('dep/print/target_data_tubewell_print_view', $data, true);
        } elseif ($arrProjectTypes['PROJECT_SUB_TYPE_ID'] == 25) { //microirrigation
            $myview = $this->load->view('dep/print/target_data_mi_print_view', $data, true);
        } else {
            $myview = $this->load->view('dep/print/target_data_default_print_view', $data, true);
        }

        array_push($this->message, getMyArray(null, $myview));
        echo createJSONResponse($this->message);
    }

    /**-------- Monthly Report --------*/
    public function printMonthly()
    {
        $this->load->model('dep/dep__m_project_setup');
        $this->PROJECT_SETUP_ID = $this->input->post('PROJECT_SETUP_ID');
        $isBlank = $this->input->post('blank_monthly');
        $monthlyDataId = 0;
        $data['isBlank'] = $isBlank;

        $monthlyDataId = (int)$this->input->post('monthId');

        $arrSetupStatus = $this->dep__m_project_setup->getEstimationStatus($this->PROJECT_SETUP_ID);
        $data['arrSetupStatus'] = $arrSetupStatus;
        if ($isBlank && ($monthlyDataId == -1)) {
            $currentMonth = $this->input->post('dt');
            if ($currentMonth > 0)
                $currentMonth = date("Y-m-d", $currentMonth);
        }
        $monthlyTable = 'dep__t_monthly';
        $mMonthlyFields = $this->dep__m_report->getMonthlyFields();
        $currentMonthValues = array();
        if ($monthlyDataId == -1) {
            foreach ($mMonthlyFields as $f) {
                $currentMonthValues[$f] = '';
            }
        } else {
            $recs = $this->db->get_where($monthlyTable, array('MONTHLY_DATA_ID' => $monthlyDataId));
            if ($recs && $recs->num_rows()) {
                $rec = $recs->row();
                foreach ($mMonthlyFields as $f) {
                    $currentMonthValues[$f] = $rec->{$f};
                }
                $currentMonth = $currentMonthValues['MONTH_DATE'];
            }
        }
        $entryDate = strtotime($currentMonth);
        $data['MONTH_DATE'] = $entryDate;
        $MONTH = date("n", $entryDate);
        $YEAR = date("Y", $entryDate);
        $sessionId = $this->dep__m_report->getSessionID($MONTH, $YEAR);
        //monthly remarks
        $mMonthlyRemarkFields = $this->dep__m_report->getMonthlyRemarkFields();
        $CURRENT_MONTH_REMARK_VALUES = array();
        for ($i = 0; $i < count($mMonthlyRemarkFields); $i++) {
            $currentMonthRemarkData[$mMonthlyRemarkFields[$i]] = '';
        }
        $arrWhich = array(
            'PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID,
            'MONTH_DATE' => $currentMonth
        );
        $recs = $this->db->get_where('dep__t_monthlydata_remarks', $arrWhich);
        $currentMonthRemarkValues = array();

        foreach ($mMonthlyRemarkFields as $f)
            $currentMonthRemarkValues[$f] = '';

        if ($recs && $recs->num_rows()) {
            $rec = $recs->row();
            $recs->free_result();
            foreach ($mMonthlyRemarkFields as $f)
                $currentMonthRemarkValues[$f] = $rec->{$f};
        }
        $data['monthly_remarks'] = $currentMonthRemarkValues;
        //PROGRESS
        $this->db->select('PROGRESS');
        $recs = $this->db->get_where('dep__t_progress', array(
            'PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID,
            'PROGRESS_DATE' => $currentMonth
        ));
        //arrBlockData
        $data['PROGRESS'] = 0;
        if ($recs && $recs->num_rows()) {
            $prec = $recs->row();
            $recs->free_result();
            $data['PROGRESS'] = $prec->PROGRESS;
        }
        $mMonthlyStatusFields = $this->dep__m_report->getMonthlyStatusFields();
        $currentMonthStatusValues = array();
        foreach ($mMonthlyStatusFields as $f)
            $currentMonthStatusValues[$f] = '';
        $recs = $this->db->get_where('dep__t_status_date', $arrWhich);
        if ($recs && $recs->num_rows()) {
            $rec = $recs->row();
            $recs->free_result();
            foreach ($mMonthlyStatusFields as $f)
                $currentMonthStatusValues[$f] = $rec->{$f};
        }
        $data['monthlyStatusData'] = $currentMonthStatusValues;
        //get previous month
        $prevMonthValue = strtotime("-1month", $entryDate);
        $mAFStatus = array(
            'LA_CASES_STATUS', 'SPILLWAY_WEIR_STATUS', 'FLANKS_AF_BUNDS_STATUS', 'SLUICE_STATUS', 'NALLA_CLOSER_STATUS',
            'CANAL_EW_STATUS', 'CANAL_STRUCTURE_STATUS',
            'CANAL_LINING_STATUS', 'DRILLINGWORK_STATUS',
            'HOUSING_PIPE_STATUS',
            'BLIND_PIPE_STATUS',
            'SLOTTED_PIPE_STATUS',
            'SUBMERSIBLE_STATUS', 'FA_CASES_STATUS', 'CONTROL_ROOMS_STATUS');
        $previousMonthValues = $prevMonthStatus = array();
        $prevMonthExists = $currentMonthRecordExists = false;
        $recs_p = $this->db->get_where($monthlyTable, array(
            'PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID,
            'MONTH_DATE' => date("Y-m-d", $prevMonthValue)
        ));
        if ($recs_p && $recs_p->num_rows()) {
            $recp = $recs_p->row();
            $recs->free_result();
            foreach ($mMonthlyFields as $f)
                $previousMonthValues[$f] = $recp->{$f};

            foreach ($mAFStatus as $f)
                $prevMonthStatus[$f] = $recp->{$f};
            $prevMonthExists = true;
        }
        $arrWhere = array('PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID);
        $arrComponentStatus = array();
        $recs = $this->db->get_where('dep__m_setup_status', $arrWhere);
        if ($recs && $recs->num_rows()) {
            $rec = $recs->row();
            $recs->free_result();
            foreach ($mAFStatus as $f) {
                $arrComponentStatus[$f] = $rec->{$f};
            }
        }
        if (!$prevMonthExists) {
            foreach ($mMonthlyFields as $f)
                $previousMonthValues[$f] = '';
            $previousMonthValues['IP_TOTAL'] = '';
            //get status from project setup
            foreach ($mAFStatus as $f)
                $prevMonthStatus[$f] = $arrComponentStatus[$f];
        }
        $data['arrComponentStatus'] = $arrComponentStatus;
        $data['currentMonthRecordExists'] = $currentMonthRecordExists;
        $data['arrCurrentMonthData'] = $currentMonthValues;
        $data['arrPreviousMonthData'] = $previousMonthValues;
        $data['prevMonthStatus'] = $prevMonthStatus;
        $arrSTData = array();
        //if ($currentMonthRecordExists && ($currentMonthValues['WORK_STATUS'] == 5)) {
        if ($currentMonthValues['WORK_STATUS'] == 5) {
            $arrStFields = $this->getFields('dep__t_status_date');

            $recs = $this->db->select('*')
                ->from('dep__t_status_date')
                ->where('PROJECT_SETUP_ID', $this->PROJECT_SETUP_ID)
                ->get();
            if ($recs && $recs->num_rows()) {
                $rec = $recs->row();
                $recs->free_result();
                foreach ($arrStFields as $f)
                    $arrSTData[$f] = $rec->{$f};
            }
        }
        $data['completionStatusData'] = $arrSTData;
        $arrFields = array(
            'SESSION_ID',
            'LA_NO', 'LA_HA', 'LA_COMPLETED_NO', 'LA_COMPLETED_HA',
            'FA_HA', 'FA_COMPLETED_HA',
            'HW_EARTHWORK', 'HW_MASONRY',
            'STEEL_WORK', 'CANAL_EARTHWORK', 'CANAL_STRUCTURE', 'CANAL_STRUCTURE_MASONRY',
            'CANAL_LINING', 'L_EARTHWORK', 'C_MASONRY',
            'C_PIPEWORK', 'C_DRIP_PIPE', 'C_WATERPUMP', 'K_CONTROL_ROOMS',
            'KHARIF', 'RABI', 'DRILLINGWORK',
            'HOUSING_PIPE',
            'BLIND_PIPE',
            'SLOTTED_PIPE',
            'SUBMERSIBLE',
        );//'EXPENDITURE_TOTAL', 'EXPENDITURE_WORKS',
        $currentFinancialMonth = $this->dep__m_report->getFinancialMonthByMonth($MONTH);
        $totalInCurrentFY = $achievementTillLastFY = array();
        //init
        foreach ($arrFields as $f)
            $totalInCurrentFY[$f] = $achievementTillLastFY[$f] = 0;

        $totalInCurrentFY['SESSION_ID'] = $sessionId;
        $totalInCurrentFY['PROJECT_SETUP_ID'] = $this->PROJECT_SETUP_ID;
        $achievementTillLastFY['SESSION_ID'] = $sessionId;
        $achievementTillLastFY['PROJECT_SETUP_ID'] = $this->PROJECT_SETUP_ID;

        $arrSumFields = array(
            'LA_NA' => 'LA_NO', 'FA_NA' => 'FA_HA', 'HW_EARTHWORK_NA' => 'HW_EARTHWORK', 'HW_MASONRY_NA' => 'HW_MASONRY',
            'STEEL_WORK_NA' => 'STEEL_WORK', 'CANAL_EARTHWORK_NA' => 'CANAL_EARTHWORK',
            'CANAL_STRUCTURE_NA' => 'CANAL_STRUCTURE', 'CANAL_STRUCTURE_MASONRY_NA' => 'CANAL_STRUCTURE_MASONRY',
            'CANAL_LINING_NA' => 'CANAL_LINING', 'L_EARTHWORK_NA' => 'L_EARTHWORK', 'C_MASONRY_NA' => 'C_MASONRY',
            'C_PIPEWORK_NA' => 'C_PIPEWORK', 'C_DRIP_PIPE_NA' => 'C_DRIP_PIPE',
            'C_WATERPUMP_NA' => 'C_WATERPUMP', 'K_CONTROL_ROOMS_NA' => 'K_CONTROL_ROOMS'
        );

        $arrSF = $arrValidFields = array();
        foreach ($arrSumFields as $k => $v) {

            array_push($arrValidFields, $v);
            array_push($arrSF, ' IFNULL(SUM(' . $v . '), 0) AS ' . $v . ' ');

            if ($k == 'LA_NA') {
                array_push($arrValidFields, 'LA_HA');
                array_push($arrSF, ' IFNULL(SUM(LA_HA), 0) AS LA_HA ');
                array_push($arrValidFields, 'LA_COMPLETED_NO');
                array_push($arrSF, ' IFNULL(SUM(LA_COMPLETED_NO), 0) AS LA_COMPLETED_NO ');
                array_push($arrValidFields, 'LA_COMPLETED_HA');
                array_push($arrSF, ' IFNULL(SUM(LA_COMPLETED_HA), 0) AS LA_COMPLETED_HA ');
            }
            if ($k == 'FA_NA') {
                array_push($arrValidFields, 'FA_COMPLETED_HA');
                array_push($arrSF, ' IFNULL(SUM(FA_COMPLETED_HA), 0) AS FA_COMPLETED_HA ');
            }


        }
        $sumField = implode(',', $arrSF);
        if ($currentFinancialMonth != 0) {
            //get total in this financial year
            $strSQL = 'SELECT ' . $sumField . ' FROM dep__t_monthly WHERE PROJECT_SETUP_ID=' . $this->PROJECT_SETUP_ID .
                ' AND SESSION_ID=' . $sessionId .
                ' AND MONTH_DATE <="' . date("Y-m-d", $entryDate) . '"';
            $recs = $this->db->query($strSQL);
            if ($recs && $recs->num_rows()) {
                $rec = $recs->row();
                $recs->free_result();
                foreach ($arrValidFields as $f) {
                    if (!($f == 'SESSION_ID')) $totalInCurrentFY[$f] = $rec->{$f};
                }
                $totalInCurrentFY['SESSION_ID'] = $sessionId;
                $totalInCurrentFY['PROJECT_SETUP_ID'] = $this->PROJECT_SETUP_ID;
            }
        }
        $data['arrCFY'] = $totalInCurrentFY;

        //GET DATA TILL LAST FINANCIAL YEAR
        $strSQL = 'SELECT  ' . $sumField . ' FROM dep__t_monthly WHERE PROJECT_SETUP_ID=' . $this->PROJECT_SETUP_ID .
            ' AND SESSION_ID<' . $sessionId . ' GROUP BY PROJECT_SETUP_ID';
        $recs = $this->db->query($strSQL);
        if ($recs && $recs->num_rows()) {
            $rec = $recs->row();
            $recs->free_result();
            foreach ($arrValidFields as $f) {
                if ($f == 'PROJECT_SETUP_ID') continue;
                if ($f != 'SESSION_ID')
                    $achievementTillLastFY[$f] = $rec->{$f};
            }
        }
        $data['arrTLY'] = $achievementTillLastFY;

        $arrFieldsForProgress = array(
            'HW_EARTHWORK', 'HW_MASONRY', "CANAL_STRUCTURE_MASONRY", "CANAL_LINING",
            'HW_EARTHWORK', 'HW_MASONRY', 'STEEL_WORK', 'CANAL_EARTHWORK',
            'LA_NO', 'LA_HA', 'FA_HA', "CANAL_STRUCTURE",
            'LA_COMPLETED_NO', 'LA_COMPLETED_HA', 'FA_COMPLETED_HA', 'L_EARTHWORK', 'C_MASONRY',
            'C_PIPEWORK', 'C_DRIP_PIPE', 'C_WATERPUMP', 'K_CONTROL_ROOMS',
            'LA_NO', 'LA_HA', 'FA_HA',
            'LA_COMPLETED_NO', 'LA_COMPLETED_HA', 'FA_COMPLETED_HA', 'DRILLINGWORK',
            'HOUSING_PIPE',
            'BLIND_PIPE',
            'SLOTTED_PIPE',
            'SUBMERSIBLE'

        );
        $arrEstimation = array();
        //init
        for ($iCount = 0; $iCount < count($arrFieldsForProgress); $iCount++)
            $arrEstimation[$arrFieldsForProgress[$iCount]] = 0;

        $strSQL = 'SELECT e.*, p.RAA_DATE FROM dep__t_estimated_qty as e 
				LEFT JOIN dep__t_raa_project as p on(p.RAA_PROJECT_ID=e.RAA_ID)
					WHERE e.PROJECT_SETUP_ID in (' . $this->PROJECT_SETUP_ID . ') and p.RAA_DATE<="' . $currentMonth . '"
				ORDER BY p.RAA_DATE desc 
				LIMIT 0, 1';
        $recs = $this->db->query($strSQL);

        if ($recs && $recs->num_rows()) {
            $rec = $recs->row();
        } else {
            $this->db->select(implode(',', $arrFieldsForProgress) . ',KHARIF,RABI, SUM(KHARIF+RABI) as IP_TOTAL,KHARIF_RESTORED,RABI_RESTORED, sum(KHARIF_RESTORED+RABI_RESTORED) as IP_TOTAL_RESTORED')
                ->from('dep__t_estimated_qty')
                ->join('dep__ip_design', 'dep__ip_design.PROJECT_SETUP_ID=dep__t_estimated_qty.PROJECT_SETUP_ID', 'left')
                ->where_in('dep__t_estimated_qty.PROJECT_SETUP_ID', $this->PROJECT_SETUP_ID)
                ->where('ADDED_BY', 0);
            $recs = $this->db->get();
            if ($recs && $recs->num_rows())
                $rec = $recs->row();
        }

        array_push($arrFieldsForProgress, 'KHARIF', 'RABI', 'IP_TOTAL');
        for ($iCount = 0; $iCount < count($arrFieldsForProgress); $iCount++) {
            $arrEstimation[$arrFieldsForProgress[$iCount]] = $rec->{$arrFieldsForProgress[$iCount]};
        }

        //echo $this->db->last_query();
        $data['arrEstimationData'] = $arrEstimation;
        $arrWhich = array(
            'PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID,
            'TARGET_DATE' => $currentMonth
        );
        $data['TARGET_FLAG'] = 0;
        $data['BUDGET_AMOUNT'] = 0;
        $data['SUBMISSION_DATE'] = '';
        $recs = $this->db->get_where('dep__t_yearlytargets', $arrWhich);
        if ($recs && $recs->num_rows()) {
            $rec = $recs->row();
            $data['TARGET_FLAG'] = 1;
        }
        //get actual completion date
        $data['ACTUAL_COMPLETION_DATE'] = '0000-00-00';
        $arrWhere = array('PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID);
        $this->db->select('PROJECT_COMPLETION_DATE, AA_DATE AS PROJECT_START_DATE,WORK_NAME,WORK_NAME_HINDI,PROJECT_CODE');
        $recs = $this->db->get_where('dep__m_project_setup', $arrWhere);
        if ($recs && $recs->num_rows()) {
            $rec = $recs->row();
            $data['ACTUAL_COMPLETION_DATE'] = $rec->PROJECT_COMPLETION_DATE;
            $data['PROJECT_START_DATE'] = $rec->PROJECT_START_DATE;
            $data['PROJECT_NAME'] = $rec->WORK_NAME . ' - ' . $rec->WORK_NAME_HINDI;
            $data['PROJECT_CODE'] = $rec->PROJECT_CODE;
        }
        $data['setupData'] = $this->dep__m_report->getSetupData($this->PROJECT_SETUP_ID);
        $data['statusData'] = $this->dep__m_report->getStatusData($this->PROJECT_SETUP_ID);

        $YEAR = date("Y", $entryDate);
        $MONTH = date("n", $entryDate);
        $sessionId = $this->dep__m_report->getSessionID($MONTH, $YEAR);

        $data['arrBlockData'] = $this->dep__m_report->getBlockwiseIP($currentMonth, $sessionId, $this->PROJECT_SETUP_ID);
        $data['arrRestoredBlockData'] = $this->dep__m_report->getRestoredBlockwiseIP($currentMonth, $sessionId, $this->PROJECT_SETUP_ID);

        //$myview = $this->load->view('dep/print/monthly_data_print_view_table', $data, true);
        $this->load->model('dep/dep__m_project_setup');
        $arrProjectTypes = $this->dep__m_project_setup->getProjectSubTypeId($this->PROJECT_SETUP_ID);
        if ($arrProjectTypes['PROJECT_SUB_TYPE_ID'] == 5) { //tubewell
            $myview = $this->load->view('dep/print/tubewell_monthly_data_print_view_table', $data, true);
        } elseif ($arrProjectTypes['PROJECT_SUB_TYPE_ID'] == 25) { //microirrigation
            $myview = $this->load->view('dep/print/mi_monthly_data_print_view_table.php', $data, true);
        } else {
            $myview = $this->load->view('dep/print/monthly_data_default_print_view_table', $data, true);
        }

        array_push($this->message, getMyArray(null, $myview));
        echo createJSONResponse($this->message);//PROGRESS
    }

    public function printMP()
    {
        $projectId = (int)$this->input->post('PROJECT_SETUP_ID');
        $this->db->select('PROGRESS_DATE, PROGRESS');
        $this->db->order_by('PROGRESS_DATE', 'ASC');
        $recs = $this->db->get_where('dep__t_progress', array('PROJECT_SETUP_ID' => $projectId));
        // echo $this->db->last_query();exit;
        $content = '<table border="0" cellpadding="8" cellspacing="2" class="ui-widget-content" id="rptMP">
		<thead>
		<tr><th class="ui-state-default" valign="middle">Month</th>
					<th class="ui-state-default" valign="middle">Progress</th></tr>
					</thead><tbody>';
        if ($recs && $recs->num_rows()) {
            foreach ($recs->result() as $rec) {
                $content .= '<tr><td class="ui-widget-content" valign="middle">' . date("M, Y", strtotime($rec->PROGRESS_DATE)) . '</td>
					<td class="ui-widget-content" valign="middle" align="center">' . $rec->PROGRESS . '</td></tr>';
            }
        }
        $content .= '</tbody></table>
		<script type="text/javascript">
			$().ready(function(){
				var $demopp = $("#rptMP");
				$demopp.floatThead({
					scrollContainer: function($table){
						return $table.closest(".wrapper");
					}
				});
			});
		</script>';
        array_push($this->message, getMyArray(null, $content));
        echo createJSONResponse($this->message);
    }
}
