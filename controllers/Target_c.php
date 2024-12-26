<?php
class Target_c extends MX_Controller{
    private $PROJECT_ID, $message, $PROJECT_SETUP_ID;
	function __construct(){
        parent::__construct();
             //  ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);
        $this->message = array();
        $this->PROJECT_ID = 0;
        $this->PROJECT_SETUP_ID = 0;
        $this->load->model('dep/dep__m_target');
    }

	public function index(){       
        $data = array();
        $data['message'] = '';
        $data['page_heading'] = pageHeading(
            'Deposit - Financial and Physical Target Setup'
        );
        /*$mm = (int) date("m");
		$dd = (int) date("d");
		if($mm==4 && $dd<=15){
			echo '<h1>Target Entry will be available After 15 April...</h1>';
			return;
		}*/
        $this->load->library('office_filter');
        $data['office_list'] = $this->office_filter->office_list();
        $data['project_target_grid'] = $this->createGrid();
        $this->load->view('dep/target_index_view', $data);
    }

	public function showOfficeFilterBox(){
        //$data['instance_name'] = 'search_office';
        $data = array();
        $data['prefix'] = 'search_office';
        $data['show_sdo'] = FALSE;
        $data['row'] = '<tr>
		<td class="ui-widget-content"><strong>Project Name</strong></td>
		<td class="ui-widget-content">
			<input type="text" value="" name="SEARCH_PROJECT_NAME" id="SEARCH_PROJECT_NAME">
		</td>
		</tr>
		<tr><td colspan="2" class="ui-widget-content">' . getButton(array('caption'=>'Search', 'event'=>'refreshSearch()', 'icon'=>'cus-zoom', 'title'=>'Search')) . '</td></tr>';
        $this->load->view('setup/office_filter_view', $data);
    }

	private function createGrid(){
		$permissions = $this->dep__m_target->getPermissions();
		$buttons = array();
		$mfunctions = array();
		array_push($mfunctions, "loadComplete: function(){afterReload();}");
		$aData = array(
			'set_columns' => array(
				array(
					'label' => 'Work',
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
					'label' => 'Project',
					'name' => 'PROJECT_NAME',
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
					'label' => addslashes('<span class="cus-lock"></span>Session'),
					'name' => 'TARGET_LOCK_SESSION_ID',
					'width' => 30,
					'align' => "center",
					'resizable' => false,
					'sortable' => true,
					'hidden' => false,
					'view' => true,
					'search' => true
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
					'label' => 'Action',
					'name' => 'ADD',
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
					'label' => '',
					'name' => 'lock',
					'width' => 35,
					'align' => "center",
					'resizable' => false,
					'sortable' => true,
					'hidden' => false,
					'view' => true,
					'search' => false,
					'formatter' => '',
					'searchoptions' => ''
				),
				array(
					'label' => 'id',
					'name' => 'PROJECT_ID',
					'width' => 20,
					'align' => "center",
					'resizable' => false,
					'sortable' => true,
					'hidden' => false,
					'view' => true,
					'search' => false,
					'formatter' => '',
					'searchoptions' => ''
				)
			),
			'custom' => array("button" => $buttons, "function" => $mfunctions),
			'div_name' => 'projectListGrid',
			'source' => 'getProjectGrid',
			'postData' => '{}',
			'rowNum' => 10,
			'width' => DEFAULT_GRID_WIDTH,
			'height' => '',
			'altRows' => true,
			'rownumbers' => true,
			'autowidth'=>true,
			'sort_name' => 'WORK_NAME',
			'sort_order' => 'asc',
			'primary_key' => 'WORK_NAME',
			'add_url' => '',
			'edit_url' => '',
			'delete_url' => '',
			'caption' => addslashes('<span class="cus-target"></span>Projects for Target Entry'),
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
	public function getProjectGrid(){
       echo  $this->dep__m_target->getProjectListGrid();
    }
	//ok
	public function showTargetForm(){
		$projectSetupId = $this->input->post('PROJECT_ID');
		$sessionId = $this->input->post('session_id');
		$data = $this->dep__m_target->getData($projectSetupId, $sessionId);
		//showArrayValues($data); exit;
        if($data['PROJECT_SUB_TYPE_ID']==5){
            $this->load->view('dep/tubewell_target_data_view', $data);
        }else if($data['PROJECT_SUB_TYPE_ID']==25){
            $this->load->view('dep/mi_target_data_view', $data);
        }else{
            $this->load->view('dep/target_data_default_view', $data);
        }
    }
    //not using so commenting it for MI
    /*private function isValidForLock($sessionId){

        //if record found for that session
        $this->db->select('YEARLY_TARGET_ID');
        $recs = $this->db->get_where(
            'mi__t_yearlytargets',
            array('PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID, 'SESSION_ID' => $sessionId)
        );
        return ($recs && $recs->num_rows());
    }*/
	//OK
	public function saveTarget(){
		// Data for dep__ip_target_block
	    // showArrayValues($this->input->post('CANAL_EARTHWORK'));exit;
		$arrTargetData = array(
			'PROJECT_SETUP_ID' => $this->input->post('PROJECT_SETUP_ID'),
			'arrKharif'=>$this->input->post('KHARIF'),
			'arrRabi' => $this->input->post('RABI'),
            'arrKharifRestored'=>$this->input->post('KHARIF_RESTORED'),
            'arrRabiRestored' => $this->input->post('RABI_RESTORED'),
			'arrTargetDates' => $this->input->post('TARGET_DATE'),
			'startMonth'=> $this->input->post('startMonth'), 
			'SESSION_ID' => $this->input->post('SESSION'),
			'startSession' => $this->input->post('startSession'),
			'endSession' => $this->input->post('endSession'),
			'endMonth' => $this->input->post('endMonth'),
			'arrLANo' => $this->input->post('LA_NO'),
			'arrLAHa' => $this->input->post('LA_HA'),
			'arrFAHa' => $this->input->post('FA_HA'),
			'arrHWEarthwork' => $this->input->post('HW_EARTHWORK'),
			'arrHWMasonry' => $this->input->post('HW_MASONRY'), 
			'arrSteelWork' => $this->input->post('STEEL_WORK'),
			'arrCanalEarthwork' => $this->input->post('CANAL_EARTHWORK'), 
			'arrCanalStructure' => $this->input->post('CANAL_STRUCTURE'),
			'arrCanalStructureMasonry' => $this->input->post('CANAL_STRUCTURE_MASONRY'),
			'arrCanalLining' => $this->input->post('CANAL_LINING'),
            'BUDGET_AMOUNT'=>$this->input->post('BUDGET_AMOUNT'),
            'arrExpenditure'=>$this->input->post('EXPENDITURE'),

            'arrLEarthwork' => $this->input->post('L_EARTHWORK'),
            /*'arrCEarthwork' => $this->input->post('C_EARTHWORK'),*/
            'arrCMasonry' => $this->input->post('C_MASONRY'),
            'arrCPipeWork' => $this->input->post('C_PIPEWORK'),
            'arrCDripPipe' => $this->input->post('C_DRIP_PIPE'),
            'arrCWaterPump' => $this->input->post('C_WATERPUMP'),

            'arrDrillingWork' => $this->input->post('DRILLINGWORK'),
            'arrHousingPipe' => $this->input->post('HOUSING_PIPE'),
            'arrBlingPipe' => $this->input->post('BLIND_PIPE'),
            'arrSlottedPipe' => $this->input->post('SLOTTED_PIPE'),
            'arrSubmersible' => $this->input->post('SUBMERSIBLE'),
            'arrControlRooms' => $this->input->post('K_CONTROL_ROOMS')
		);
		//showArrayValues($arrTargetData); exit;
		$result = $this->dep__m_target->saveTargetData($arrTargetData);
		echo $result ;
	}
	public function lockProject(){
      /*  if (!IS_LOCAL_SERVER) {
            $this->load->library('mycurl');
            $serverStatus = $this->mycurl->getServerStatus();
            if ($serverStatus == 0) {
                echo 'Unable to lock. E-work Server Not responding. Try after sometime...';
                return;
            }
        }*/
        $projectSetupId = (int)$this->input->post('project_id');
        $sessionId = (int)$this->input->post('session_id');
		$arrParams = $this->dep__m_target->prepareDataToSend($projectSetupId, $sessionId);
	//	showArrayValues($arrParams);
		//$goAhead = FALSE;
		if($arrParams){
          /*  if (!IS_LOCAL_SERVER) {
                $result = $this->mycurl->savePromonData($params);
                //echo $result;
                $obj = json_decode($result);
                if ($obj->{'success'}) {
					$goAhead = TRUE;
                }
            }else*/
			 	$goAhead = TRUE;
		//	if($goAhead){
				//echo "<br />Target Status Sent to E-Works Server.<br />";	
				$this->dep__m_target->afterLockStatus($projectSetupId, $arrParams);			
		//	}
		}
        //if in 2013-14
        //if ($sessionId == PMON_MI_START_SESSION_ID)
          //  $this->populateMonthlyData($projectId, $sessionId);
        echo(($goAhead) ? '<span class="cus-lock"></span> Target Locked':'<span class="cus-lock"></span> Unable to Lock');
    }
}
