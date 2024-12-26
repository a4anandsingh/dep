<?php
//error_reporting(E_ALL);
include_once("Project_library.php");
//all variable name should be in camelcase
Class Project_c extends Project_library{
    protected $PARENT_PROJECT_ID, $PROJECT_SETUP_FLAG;
    private $arrSetupData;
    function __construct(){
        
        parent::__construct();
        $this->message = array();
        $this->arrSetupData = array();
        $this->load->model('dep/dep__m_project_setup');
        date_default_timezone_set('Asia/Kolkata');
    	$id = getSessionDataByKey('USER_ID');
    	$isOffline = false;
    	if($isOffline){
    		if(in_array($id, array(23, 86, 84))){

        	}else{
        		echo '<h1 style="color:#f00;margin-top:50px">Deposit Modulees Currentely Not Available</h1>';
        		exit;
        	}
        }        
    }
	function index(){
		$data['page_heading'] = pageHeading('Deposit Project Setup Master');
		$this->load->library('office_filter');
		$data['office_list'] = $this->office_filter->office_list();
		$data['message'] = '';
		$data['project_grid'] = $this->createGrid().$this->createWrDepGrid(). $this->createDEPGrid(0) . $this->createDEPGrid(1);
		$arrValidMsg = array('0'=>'','1'=>"Monthly data not exists/locked", '2'=> "Target not exists/locked");
		$isValidForNewProject =$this->dep__m_project_setup->getProjectStatus();
		$data['validMsg'] = '';$arrValidMsg[$isValidForNewProject];
		$this->load->view('dep/project_index_view', $data);
	}
 	//
    public function showOfficeFilterBox(){
        $data = array();
        $data['prefix'] = 'search_office';
        $data['show_sdo'] = FALSE;
        $data['row'] = '<tr><td class="ui-widget-content"><strong>Project Type</strong></td>' .
            '<td class="ui-widget-content">
				<select id="SEARCH_PROJECT_TYPE" name="SEARCH_PROJECT_TYPE" style="width:350px" class="office-select">
                   <option value="0">Select Project Type</option>
                   <option value="1">Minor(लघु परियोजनाएं)</option>
                   <option value="2">Medium(मध्यम परियोजनाएं)</option>
                   <option value="3">Major(वृहद् परियोजनाएं)</option>
				</select>
            </td>
		</tr>		
		<tr>
		<td class="ui-widget-content"><strong>Project Name</strong></td>
		<td class="ui-widget-content">
			<input type="text" value="" name="SEARCH_PROJECT_NAME" id="SEARCH_PROJECT_NAME">
		</td>
		</tr>
		<tr><td colspan="2" class="ui-widget-content">' . getButton(array('caption'=>'Search', 'event'=>'refreshSearch()', 'icon'=>'cus-zoom', 'title'=>'Search')). '</td></tr>';
        $this->load->view('setup/office_filter_view', $data);
    }
	//
    private function createGrid(){
        $buttons = array();
        $mfunctions = array();
        $aData = array(
            'set_columns' => array(
                array(
                    'label' => 'Project Name',
                    'name' => 'PROJECT_NAME',
                    'width' => 90,
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
                    'label' => 'परियोजना',
                    'name' => 'PROJECT_NAME_HINDI',
                    'width' => 90,
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
                    'width' => 50,
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
                    'width' => 50,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                ),

                /*array(
                    'label' => 'Status',
                    'name' => 'PSTATUS',
                    'width' => 20,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                ),*/
                array(
                    'label' => 'Deposit Promon',
                    'name' => 'ENTRY_MI_FORM',
                    'width' => 70,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => false,
                    'hidden' => false,
                    'view' => true,
                    'formatter' => '',
                    'search' => true,
                    'searchoptions' => ''
                ),
                /*array(
                    'label' => 'Entry From',
                    'name' => 'ENTRY_FROM',
                    'width' => 30,
                    'align' => "center", 
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'formatter' => '',
                    'search' => true,
                    'searchoptions' => ''
                ),*/
                array(
                    'label' => 'id',
                    'name' => 'PROJECT_ID',
                    'width' => 20,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => true,
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
            'width' => DEFAULT_GRID_WIDTH/2,
            'height' => '',
            'altRows' => true,
			'autowidth'=>true,
            'rownumbers' => true,
            'sort_name' => 'PROJECT_NAME',
            'sort_order' => 'asc',
            'primary_key' => 'PROJECT_ID',
            'caption' => '<span class="cus-dam-1"></span> Projects - परियोजनाएं',
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

    private function createWrDepGrid(){
        $buttons = array();
        $mfunctions = array();
        $aData = array(
            'set_columns' => array(
                array(
                    'label' => 'Project Name',
                    'name' => 'PROJECT_NAME',
                    'width' => 90,
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
                    'label' => 'परियोजना',
                    'name' => 'PROJECT_NAME_HINDI',
                    'width' => 90,
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
                    'width' => 50,
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
                    'width' => 50,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                ),

                /*array(
                    'label' => 'Status',
                    'name' => 'PSTATUS',
                    'width' => 20,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'search' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                ),*/

                array(
                    'label' => 'Deposit Promon',
                    'name' => 'ENTRY_MI_FORM',
                    'width' => 70,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => false,
                    'hidden' => false,
                    'view' => true,
                    'formatter' => '',
                    'search' => true,
                    'searchoptions' => ''
                ),
                /*array(
                    'label' => 'Entry From',
                    'name' => 'ENTRY_FROM',
                    'width' => 30,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => false,
                    'view' => true,
                    'formatter' => '',
                    'search' => true,
                    'searchoptions' => ''
                ),*/
                array(
                    'label' => 'id',
                    'name' => 'PROJECT_ID',
                    'width' => 20,
                    'align' => "center",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => true,
                    'search' => true,
                    'view' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                )
            ),
            'custom' => array("button" => $buttons, "function" => $mfunctions),
            'div_name' => 'projectDepList',
            'source' => 'getProjectWrDepositListGrid',
            'postData' => '{}',
            'rowNum' => 10,
            'width' => DEFAULT_GRID_WIDTH/2,
            'height' => '',
            'altRows' => true,
			'autowidth'=>true,
            'rownumbers' => true,
            'sort_name' => 'PROJECT_NAME',
            'sort_order' => 'asc',
            'primary_key' => 'PROJECT_ID',
            'caption' => '<span class="cus-drop"></span> Deposit Projects - परियोजनाएं',
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

    private function createDEPGrid($mode){
		$permissions = $this->dep__m_project_setup->getPermissions();		
		$buttons = array();
	
	     $mfunctions = array();
		if($mode == 0) {
			if($permissions['MODIFY']) {
				array_push(
					$buttons,
					"{ caption:'', title:'Edit Record',position :'first',
					buttonicon : 'ui-icon-pencil',
					onClickButton:function(){projectOperation(BUTTON_MODIFY, 0);}, cursor: 'pointer'}"
				);
				array_push(
					$mfunctions ,
					"ondblClickRow: function(ids){projectOperation(BUTTON_MODIFY, 0);}"
				);
			}
		}
		$aData = array(
			'set_columns' => array(
				array(
					'label' => 'Work Name',
					'name' => 'WORK_NAME',
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
					'label' => 'Code',
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
					'label' => 'Project Sub Type',
					'name' => 'PROJECT_SUB_TYPE',
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
                    'label' => 'Head',
                    'name' => 'DEPOSIT_SCHEME_ID',
                    'width' => 50,
                    'align' => "center",
                    'resizable'=>false,
                    'sortable'=>true,
                    'hidden'=>false,
                    'view'=>true,
                    'search'=>true,
                    'formatter'=> '',
                    'searchoptions'=>''
                ),
				array(
					'label' => 'Locked',
					'name' => 'LOCKED',
					'width' => 15,
					'align' => "center",
					'resizable' => false,
					'sortable' => true,
					'hidden' => false,
					'view' => true,
					'search' => true
				),
				array(
					'label' => 'id',
					'name' => 'PROJECT_SETUP_ID',
					'width' => 20,
					'align' => "center",
					'resizable' => false,
					'sortable' => true,
					'hidden' => true,
					'search' => true,
					'view' => true,
					'formatter' => '',
					'searchoptions' => ''
				)
			,
				array(
					'label' => 'parent_id',
					'name' => 'PARENT_PROJECT_ID',
					'width' => 70,
					'align' => "center",
					'resizable' => false,
					'sortable' => true,
					'hidden' => true,
					'search' => true,
					'view' => true,
					'formatter' => '',
					'searchoptions' => ''
				)
			),
			'custom' => array("button" => $buttons, "function" => $mfunctions),
			'div_name' => 'depProjectList',
			'div_name' => (($mode == 0) ? 'depProjectList' : 'depProjectCList'),
			'source' => 'getDEPProjectListGrid/' . $mode,
			'postData' => '{}',
			'rowNum' => 10,
			'autowidth'=>true,
			'width' => DEFAULT_GRID_WIDTH,
			'height' => '',
			'altRows' => true,
			'rownumbers' => true,
			'sort_name' => 'PROJECT_NAME',
			'sort_order' => 'asc',
			'caption' => (($mode == 0) ? 'On going ' : 'Completed ') . ' Deposit Project',
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
	
	//Grids
	public function getProjectListGrid(){
		echo $this->dep__m_project_setup->getProjectListGrid();
	}

	public function getProjectWrDepositListGrid(){
		echo $this->dep__m_project_setup->getProjectWrDepositListGrid();
	}

	public function getDEPProjectListGrid($mode){
		echo $this->dep__m_project_setup->getDEPProjectListGrid($mode);
	}

	public function showProjectSetupEntryBox(){
		$permissions = $this->dep__m_project_setup->getPermissions();
		$this->PARENT_PROJECT_ID = (int)trim($this->input->post('PARENT_PROJECT_ID'));
		$this->PROJECT_SETUP_ID = (int)trim($this->input->post('PROJECT_SETUP_ID'));
		$this->PROJECT_ID = (int)trim($this->input->post('PROJECT_ID'));

		$holdingPerson = getSessionDataByKey('HOLDING_PERSON');

		//Check if any Deposit project setup is there and it is not locked, of this project(parent project)
		$editMode = (($this->PROJECT_SETUP_ID) ? true : false);

		if($editMode){
            $recs = $this->db->select('PROJECT_SETUP_MODE')
                ->from('dep__m_project_setup')
                ->where(array('PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID))
                ->get();
            if ($recs && $recs->num_rows()) {
                $rec = $recs->row();
                $recs->free_result();
                $this->PROJECT_SETUP_FLAG = $rec->PROJECT_SETUP_MODE;
            }
        }else{
            $this->PROJECT_SETUP_FLAG = (int)trim($this->input->post('PROJECT_SETUP_FLAG'));
        }

		//Commenting below if,, on 16-05-2019
		if(!$editMode ){
            if($this->PROJECT_SETUP_FLAG ==2){
                $numProjects = $this->dep__m_project_setup->getTotalDepositProjectsDeposit($this->PARENT_PROJECT_ID);
            }else{
                $numProjects = $this->dep__m_project_setup->getTotalDepositProjects($this->PARENT_PROJECT_ID);
            }


			if($numProjects>0){
			$data['report'] = array('mode'=>'custom', 'message'=>'Uncompleted or Unlocked Project already exists of this project.<br />Please lock it to proceed further.', 'icon'=>'cus-error', 'report'=>false);
				$mView= $this->load->view('utility/lock_view', $data, TRUE);
				array_push($this->message, getMyArray(null, $mView));
				echo createJSONResponse($this->message);
				return;
			}
		}

		$data['LockStatus'] = (($this->PROJECT_SETUP_ID) ? $this->getLockStatus(1) : 0);	 
		if($data['LockStatus'] == 1) {
			$data['report'] = array('mode' => 'lock', 'report' => true);
			$mView = $this->load->view('utility/lock_view', $data, TRUE);
			array_push($this->message, getMyArray(null, $mView));
			echo createJSONResponse($this->message);
		}else {
			$this->showProjectSetupData();
		}
	}

	private function showProjectSetupData(){
		$arrWhere = array('PROJECT_ID' => $this->PARENT_PROJECT_ID);
		$holdingPerson = getSessionDataByKey('HOLDING_PERSON');
		$arrProjectData = array();
		$param = array('parentProjectId'=> $this->PARENT_PROJECT_ID, 'projectSetupId'=> $this->PROJECT_SETUP_ID, 'holdingPerson'=>$holdingPerson,'projectSetupFlag'=>$this->PROJECT_SETUP_FLAG);
		$data = $this->dep__m_project_setup->getData($param);
		//showArrayValues($data); exit;
		$myview = $this->load->view('dep/project_data_view', $data, true);
		array_push($this->message, getMyArray(null, $myview));
		echo createJSONResponse($this->message);
		return;
	}
	 
	public function checkProjectCode_old(){
		$projectSetupId = $this->input->post('PROJECT_SETUP_ID');
		$parentProjectId = $this->input->post('PARENT_PROJECT_ID');
		$arrFields = array('LATITUDE_D', 'LATITUDE_M', 'LATITUDE_S', 'LONGITUDE_D', 'LONGITUDE_M', 'LONGITUDE_S');
		$tables=array(
					array('table'=>$this->dep__m_project_setup->tblProjects,'col'=>'PROJECT_ID'),
					array('table'=>$this->dep__m_project_setup->tblRRRProjectSetup,'col'=>'PROJECT_SETUP_ID'),
					array('table'=>$this->dep__m_project_setup->tblMiProjectSetup,'col'=>'PROJECT_SETUP_ID'),
					array('table'=>$this->dep__m_project_setup->tblSetup,'col'=>'PROJECT_SETUP_ID'),
                    array('table'=>'dep_mi__m_project_setup' ,'col'=>'PROJECT_SETUP_ID'),
					);
		$searchData = array();
		foreach ($arrFields as $field) {
			$searchData[$field] = $this->input->post($field);
		}
		//search lat & long in projects & micro irrigation
		$arrResponse = array("success" => 0, "message" => "");
		$projectData = 0;

		foreach ($tables as $key) {
			$recs = $this->db->select('*')
				->where($key['col'].' !=', $projectSetupId)
				->where($searchData)
				->get($key['table']);			
			if($recs && $recs->num_rows()) {
				$projectData++;
			}
		}

		if($projectData>0)
		{
			$arrResponse["message"] = 'Longitude / Latitude already exists';			
		}
		else
		{
			$arrResponse["success"] = 1;
		}		 
		echo json_encode($arrResponse);
	}
	

    public function checkProjectCode(){
        $this->load->library('Check_latlong');
        $myDataForCode = array();
        //$projCode = array('', 'MI', 'ME', 'MJ');
        // $myDataForCode['PROJECT_TYPE'] = $projCode[ $this->session->userData('SETUP_PROJECT_TYPE_ID')];
        $myDataForCode['DISTRICT_ID'] = $this->input->post('DISTRICT_ID');
        $myDataForCode['LATITUDE_D'] = $this->input->post('LATITUDE_D');
        $myDataForCode['LATITUDE_M'] = $this->input->post('LATITUDE_M');
        $myDataForCode['LATITUDE_S'] = $this->input->post('LATITUDE_S');
        $myDataForCode['LONGITUDE_D'] = $this->input->post('LONGITUDE_D');
        $myDataForCode['LONGITUDE_M'] = $this->input->post('LONGITUDE_M');
        $myDataForCode['LONGITUDE_S'] = $this->input->post('LONGITUDE_S');
        $PROJECT_SETUP_ID = $this->input->post('PROJECT_SETUP_ID');//PROJECT_ID
        //$PROJECT_ID=$this->input->post('PROJECT_ID');//PROJECT_ID
        $arrResponse = array("success"=>1, "message"=>"");
        if($PROJECT_SETUP_ID==null || $PROJECT_SETUP_ID==0)
        {
            $iCount=$this->check_latlong->check($myDataForCode);
            if( ($iCount==1)){
                $arrResponse["message"] =  'LATITUDE/LONGITUDE already in use ';
                $arrResponse["success"]=0;
            }
        }
        echo json_encode($arrResponse);
    }

    //OK
	public function saveProjectSetup(){	
		$this->PROJECT_SETUP_ID = (int) trim($this->input->post('PROJECT_SETUP_ID'));
		$this->PROJECT_ID = (int) trim($this->input->post('PARENT_PROJECT_ID'));
		$editMode = (($this->PROJECT_SETUP_ID) ? TRUE : FALSE);
		$this->load->model('dep/dep__t_locks');
		if($editMode) {
			//0-setup lock
			$lockStatus = $this->dep__t_locks->getLockStatus(0, $this->PROJECT_SETUP_ID);
			if($lockStatus) {
				array_push(
					$this->message,
					getMyArray(
						false,
						'<button class="btn-large btn-danger" onclick="closeDialog();">
						Project Locked...</button>'
					)
				);
				echo createJSONResponse($this->message);
				return;
			}			 
		}
		 
		//saveMode	0-save & edit	1-save & close	2-modify(save)
		$saveMode = $this->input->post('saveMode');
		/**Transaction starts here*/
		$this->db->trans_begin(); // stopped fortesting
		/** __projects */
		$arrData = array();
		$arrProjectSetup = array();
		$arrProjectSetup['PROJECT_SETUP_ID'] = $this->PROJECT_SETUP_ID;
		$arrFields = $this->getFields($this->tblSetup);
		$oneTimeFields = array(
			'CE_ID', 'WORK_STATUS', 'DISTRICT_ID', 'PROJECT_SAVE_DATE', 'PROJECT_CODE', 'AA_FILE_URL', 'AA_USER_FILE_NAME','LONGITUDE_D', 'LONGITUDE_M', 'LONGITUDE_S', 'LATITUDE_D', 'LATITUDE_M', 'LATITUDE_S'
		);
		foreach($arrFields as $field){
			if($editMode && in_array($field, $oneTimeFields)){
				continue;//skip fields
			}else if($field == 'AA_DATE' || $field == 'PROJECT_COMPLETION_DATE'){
				$arrProjectSetup[$field] = myDateFormat($this->input->post($field));
			}elseif($field == 'PROJECT_SAVE_DATE'){
				$arrProjectSetup[$field] = date("Y-m-d");
			}else{
				if($this->input->post($field)){
					$arrProjectSetup[$field] = trim($this->input->post($field));
				}else{
					$arrProjectSetup[$field] = '';
				}
			}
		}

		$arrData['PROJECT_SETUP_DATA'] = $arrProjectSetup;
		$processArrData = array();
		$processArrData['OFFICE_SDO_ID'] = $this->input->post('OFFICE_SDO_ID');
		$processArrData['DISTRICT_BENEFITED'] = $this->input->post('DISTRICT_BENEFITED');
		$processArrData['BLOCKS_BENEFITED'] = $this->input->post('BLOCKS_BENEFITED');
		$processArrData['ASSEMBLY_BENEFITED'] = $this->input->post('ASSEMBLY_BENEFITED');
		$processArrData['VILLAGES_BENEFITED'] = $this->input->post('VILLAGES_BENEFITED');
		$arrData['PROCESS_DATA'] = $processArrData;

		$arrRAA = array();

		if(($this->input->post('isRAA') == 1) && ($this->input->post('RAA_NO') != '')) {
			$this->RAA_ID = $this->input->post('RAA_PROJECT_ID');
			$arrData['RAA_ID'] = $this->RAA_ID;
			$raaDate = myDateFormat($this->input->post('RAA_DATE'));
			$raaFieldNames = $this->dep__m_project_setup->getRAAFields();
			for($i = 0; $i < count($raaFieldNames); $i++) {
				if($raaFieldNames[$i] == 'RAA_PROJECT_ID') {
					continue;
				}else if($raaFieldNames[$i] == 'PROJECT_SETUP_ID') {
					$arrRAA[$raaFieldNames[$i]] = $this->PROJECT_SETUP_ID;
				}else if($raaFieldNames[$i] == 'RAA_DATE')
					$arrRAA['RAA_DATE'] = $raaDate;
				else {
					// RAA Save status will be change according to Save and Lock status 0 forSave 1 forLock
					if($raaFieldNames[$i] == 'RAA_SAVE_STATUS')
						$arrRAA['RAA_SAVE_STATUS'] = 0;
					else if($raaFieldNames[$i] == 'RAA_SAVE_DATE')
						$arrRAA['RAA_SAVE_DATE'] = date('Y-m-d');
					else if($raaFieldNames[$i] == 'ADDED_BY')
						$arrRAA['ADDED_BY'] = 0;//Added through project setup module
					else {
						$arrRAA[$raaFieldNames[$i]] = $this->input->post($raaFieldNames[$i]);
					}
				}
			}
		}

		$arrData['RAA_DATA'] = $arrRAA;
		$estimationFieldNames = $this->getEstimationStatusFields();
		$arrEstimationData = array();
		/* `ADDED_BY 0-through setup, 1-RAA setup */
		foreach($estimationFieldNames as $f){
			if($f == 'PROJECT_SETUP_ID') {
				$arrEstimationData[$f] = $this->PROJECT_SETUP_ID;
			}else if($f == 'LA_NA')
				$arrEstimationData[$f] = trim($this->input->post('LA_NA'));
			else if($f == 'FA_NA')
				$arrEstimationData[$f] = trim($this->input->post('FA_NA'));
			else
				$arrEstimationData[$f] = trim($this->input->post($f));
		}//for
        $arrEstimationData['DRINKING_PURPOSE'] = $this->input->post('DRINKING_PURPOSE');
		$arrData['ESTIMATION_DATA'] = $arrEstimationData;

		/***
		*************** New Irrigation Potential Data start **************** 
		***/
		$arrEstiBlockData = array();
		$arrEstiBlockData['IP_NA'] = $this->input->post('IP_TOTAL_NA');
		$arrEstiBlockData['BLOCKS_BENEFITED'] = $this->input->post('BLOCKS_BENEFITED');	
		$arrEstiBlockData['BLOCK_EIP_K'] = $this->input->post('BLOCK_EIP_K');
		$arrEstiBlockData['BLOCK_EIP_R'] = $this->input->post('BLOCK_EIP_R');
		$arrEstiBlockData['BLOCK_AIP_K'] = $this->input->post('BLOCK_AIP_K');
		$arrEstiBlockData['BLOCK_AIP_R'] = $this->input->post('BLOCK_AIP_R');

		$arrData['arrEstiBlockData'] = $arrEstiBlockData;
		/***
		*************** New Irrigation Potential Data end **************** 
		***/

		/***RESTORED_BLOCKS_BENEFITED BLOCKS_BENEFITED_RESTORED
		*************** Irrigation Potential to be Restoed Data start **************** 
		***/
		$arrEstiRestoredBlockData = array();
		 
		$arrEstiRestoredBlockData['RESTORED_BLOCKS_BENEFITED'] = $this->input->post('BLOCKS_BENEFITED_RESTORED');
	
		$arrEstiRestoredBlockData['RESTORED_BLOCK_EIP_K'] = $this->input->post('BLOCK_REIP_K');
		$arrEstiRestoredBlockData['RESTORED_BLOCK_EIP_R'] = $this->input->post('BLOCK_REIP_R');
		$arrEstiRestoredBlockData['RESTORED_BLOCK_AIP_K'] = $this->input->post('BLOCK_RAIP_K');
		$arrEstiRestoredBlockData['RESTORED_BLOCK_AIP_R'] = $this->input->post('BLOCK_RAIP_R');
		$arrData['arrEstiRestoredBlockData'] = $arrEstiRestoredBlockData;
		/***
		*************** Irrigation Potential to be Restoed Data end **************** 
		***/
		$eFieldNames = $this->getEstimationFields();

		$arrEstimatedQtyData = array();
		foreach($eFieldNames as $f){
			if($f == 'PROJECT_SETUP_ID') {			
				$arrEstimatedQtyData[$f] = $this->PROJECT_SETUP_ID;
			}else if($f == 'RAA_ID') {			
				$arrEstimatedQtyData[$f] = '';
			}else
				$arrEstimatedQtyData[$f] = trim($this->input->post($f));
		}//for
		$arrData['arrEstimatedQtyData'] = $arrEstimatedQtyData;
		$sessionId = (((int) $this->input->post('SESSION_ID')) - 1);
		$achievementFieldNames = $this->getAchivementFields();
		$mStatusFields = $this->getFields('dep__m_setup_status');
		$arrAchievementData = array();
		foreach($achievementFieldNames as $f){
			if(!in_array($f, $mStatusFields)){
				if($this->input->post($f . '_ACHIEVE')){
					$arrAchievementData[$f] = $this->input->post($f.'_ACHIEVE');
				}else{
					$arrAchievementData[$f] = 0;//set status to NA
				}
			}
			if($f == 'SESSION_ID')
				$arrAchievementData[$f] = $sessionId;
			else if($f == 'PROJECT_SETUP_ID') {
				//
			}else if($f== 'SUBMISSION_DATE') {
				//skip
			}
		}
 
		$arrData['arrAchievementData'] = $arrAchievementData;  
		$arrLastStatusData = $arrTargetDates = array();
		$arrStatusFields = array(
			'LA_CASES_STATUS', 'SPILLWAY_WEIR_STATUS', 'FLANKS_AF_BUNDS_STATUS', 'SLUICE_STATUS',
			'NALLA_CLOSER_STATUS', 'CANAL_EW_STATUS', 'CANAL_STRUCTURE_STATUS',
			'CANAL_LINING_STATUS',
            'DRILLINGWORK_STATUS',
            'HOUSING_PIPE_STATUS',
            'BLIND_PIPE_STATUS',
            'SLOTTED_PIPE_STATUS',
            'SUBMERSIBLE_STATUS',
            'FA_CASES_STATUS',
            'INTAKE_WELL_STATUS',
            'PUMPING_UNIT_STATUS',
            'PVC_LIFT_SYSTEM_STATUS',
            'PIPE_DISTRI_STATUS',
            'DRIP_SYSTEM_STATUS',
            'WATER_STORAGE_TANK_STATUS',
            'FERTI_PESTI_CARRIER_SYSTEM_STATUS',
            'CONTROL_ROOMS_STATUS',
            'DRILLINGWORK_STATUS',
            'HOUSING_PIPE_STATUS',
            'BLIND_PIPE_STATUS',
            'SLOTTED_PIPE_STATUS',
            'SUBMERSIBLE_STATUS'
		);
		
		foreach($arrStatusFields as $f)
			$arrLastStatusData[$f] = $this->input->post($f);

		$arrTargetDatesFields = array(
			'LA_DATE','FA_DATE', 'SPILLWAY_WEIR_DATE', 'FLANKS_AF_BUNDS_DATE', 'SLUICE_DATE',
			'NALLA_CLOSER_DATE', 'CANAL_EW_DATE',	'CANAL_STRUCTURE_DATE', 
			'CANAL_LINING_DATE',
            'PUMPING_UNIT_DATE',
            'INTAKE_WELL_DATE',
            'PVC_LIFT_SYSTEM_DATE',
            'PIPE_DISTRI_DATE',
            'DRIP_SYSTEM_DATE',
            'WATER_STORAGE_TANK_DATE',
            'FERTI_PESTI_CARRIER_SYSTEM_DATE',
            'CONTROL_ROOMS_DATE',
            'TARGET_SUBMISSION_DATE',
            'DRILLINGWORK_DATE',
            'HOUSING_PIPE_DATE',
            'BLIND_PIPE_DATE',
            'SLOTTED_PIPE_DATE',
            'SUBMERSIBLE_DATE'
		);
		
		foreach($arrTargetDatesFields as $f)
			$arrTargetDates[$f] = myDateFormat($this->input->post($f));

		//arrEstiBlockData
		$arrData['arrTargetDatesFields'] = $arrTargetDatesFields;
		$arrData['arrTargetDates'] = $arrTargetDates;
		$arrData['arrLastStatusData'] = $arrLastStatusData;
 
		$this->dep__m_project_setup->saveProjectData($arrData);
	
		if($this->db->trans_status()===FALSE){
			// generate an error... or use the log_message() function to log your error
			array_push($this->message, getMyArray(false, $this->db->log_message()));
			$this->db->trans_rollback();
		}else{
			$this->db->trans_complete();
		} // stopped fortesting
	
		//save & show edit mode data
		if($saveMode == 0) {
			//$this->PROJECT_SETUP_ID = (int) trim($this->input->post('PROJECT_SETUP_ID'));
			$this->PROJECT_SETUP_ID = $this->dep__m_project_setup->getProjectSetupId();
			$this->PARENT_PROJECT_ID = $this->PROJECT_ID;

			//get project setup mode
            $recs = $this->db->select('PROJECT_SETUP_MODE')
                ->from('dep__m_project_setup')
                ->where(array('PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID))
                ->get();
            if ($recs && $recs->num_rows()) {
                $rec = $recs->row();
                $recs->free_result();
                $this->PROJECT_SETUP_FLAG = $rec->PROJECT_SETUP_MODE;
            }
			$this->showProjectSetupData();
		}else {
			echo createJSONResponse($this->message);
		}
	}
 
/*
DELETE FROM dep__ip_design where PROJECT_SETUP_ID in(23);
DELETE FROM dep__ip_design_block where PROJECT_SETUP_ID in(23);
DELETE FROM dep__ip_exists where PROJECT_SETUP_ID in(23);
DELETE FROM `dep__m_assembly_const_served` where PROJECT_SETUP_ID in (23);
DELETE FROM `dep__m_block_served` WHERE PROJECT_SETUP_ID in (23);
DELETE FROM `dep__m_district_served` WHERE PROJECT_SETUP_ID in (23);
DELETE FROM dep__m_office WHERE PROJECT_SETUP_ID in(23);
DELETE FROM `dep__m_projects_office` where PROJECT_SETUP_ID in (23);
DELETE FROM `dep__m_project_setup` where PROJECT_SETUP_ID in (23);
DELETE FROM `dep__m_setup_status` where PROJECT_SETUP_ID in (23);
DELETE FROM `dep__m_villages_served` where PROJECT_SETUP_ID in (23);
DELETE FROM `dep__t_estimated_qty` where PROJECT_SETUP_ID in (23);
DELETE FROM `dep__t_estimated_status` where PROJECT_SETUP_ID in (23);
DELETE FROM `dep__t_locks` where PROJECT_SETUP_ID in (23);
DELETE FROM dep__t_lock_logs WHERE PROJECT_SETUP_ID in(23);
*/
    /**-----------------------------------------------*/
    public function getSDOOffices(){
        $eeid = $this->input->post('eeid');
        echo $this->dep__m_project_setup->SDOofficeOptions($eeid);
    }
	//OK
    public function getBlockBenefitedList(){
        $dist_id = $this->input->post('dist_id');
        $block_id = $this->input->post('block_id');
        $projectId = $this->input->post('project_id');
        if(!is_array($dist_id))
            $dist_id = array($dist_id);

         $recs = $this->db->select('PARENT_PROJECT_ID')
                ->from('dep__m_project_setup')
                ->where('PROJECT_SETUP_ID', $projectId)
                ->get();
        $superProjectId = '';
        if($recs && $recs->num_rows()){
            $rec = $recs->row();
			$superProjectId = $rec->PARENT_PROJECT_ID;
			$recs->free_result();
        }
        $parentBlocks = $this->getBlockIdsBenefited($superProjectId);
        //showArrayValues($parentBlocks ); exit;
        //list with select existing block otherwise only new selection will be saved
         $bid = array();     
        echo $this->dep__m_project_setup->getBlockOptions($dist_id, $block_id, $parentBlocks);
    }

    public function getAssemblyBenefitedList(){
        $assemblyId = $this->input->post('assembly_id');
        $projectId = $this->input->post('project_id');
        echo $this->dep__m_project_setup->getAssemblyBenefitedList($assemblyId,$projectId);
    }

	//OK
    public function getVillagesByDistrict(){
        $DISTRICT_ID = $this->input->post('DISTRICT_ID');
		  $PARENT_PROJECT_ID=htmlspecialchars($this->input->post('PARENT_PROJECT_ID'));
        if(!is_array($DISTRICT_ID)) $DISTRICT_ID = array($DISTRICT_ID);
        $v_ids=array();
          if($PARENT_PROJECT_ID)
        {
            $p_id=$this->db->select('VILLAGE_ID')->where('PROJECT_ID',$PARENT_PROJECT_ID)->from($this->dep__m_project_setup->tblParentVillage)->get();
         //   echo $this->db->last_query();
            if($p_id && $p_id->num_rows()>0)
            {
                foreach($p_id->result() as $rec){
                	if($rec->VILLAGE_ID!=0 && $rec->VILLAGE_ID!=null)
                    array_push($v_ids, $rec->VILLAGE_ID);                    
                }
            }
        }
        echo $this->dep__m_project_setup->getVillagesByDistrictList($DISTRICT_ID,$v_ids);
    }

    //Locks
    public function deleteProject(){
        $this->PROJECT_SETUP_ID = (int)$this->input->post('PROJECT_SETUP_ID');
        $arrWhich = array('PROJECT_SETUP_ID' => $this->PROJECT_SETUP_ID);
        $recs = $this->db->get_where('dep__t_locks', $arrWhich);
        $goAhead = false;
        if($recs && $recs->num_rows()) {
            $rec = $recs->row();
            if($rec->SETUP_LOCK == 0)
                $goAhead = true;
        }
        if(!$goAhead) {
            echo 'Project Can Not Be Deleted, Project Is Locked';
            return true;
        }
        //if goahead
        $this->db->trans_begin();
        $countDeleted1 = 0;
        $countDeleted2 = 0;
        $countDeleted3 = 0;
        //1. delete from promon
        $projectTables = array(
            'dep__t_estimated_status',
            'dep__t_monthlydata_remarks',
            'dep__t_extensions',
            'dep__t_monthlydata',
            'dep__t_progress',
            'dep__t_yearlytargets',
            'dep__t_achievements',
            'dep__t_estimated_qty',
            'dep__t_target_date_completion',
            'dep__t_raa_project',
            'dep__m_status_date',
            'dep__m_setup_status',
            'dep__m_project_setup',
            'dep__t_locks',
            'dep__t_lock_logs'
        );
        $this->db->where('PROJECT_SETUP_ID', $this->PROJECT_SETUP_ID);
        $this->db->delete($projectTables);
        $countDeleted1 = $this->db->affected_rows();
 
        if($this->db->trans_status() === FALSE) {
            echo 'Unable to Delete Project Data...Roll Back';
            $this->db->trans_rollback();
        }else {
            $this->db->trans_commit();
            echo 'Project Record Deleted...';
        }
    }

    public function lockProject(){ 
		 
        $this->PROJECT_SETUP_ID = $this->input->post('project_setup_id');
		$this->PARENT_PROJECT_ID=htmlspecialchars($this->input->post('PARENT_PROJECT_ID'));		        
        $status = $this->setLock();  		 
        echo $status;
    }
	
    public function getValidationForLock(){
		$this->PROJECT_ID = $this->input->post('project_id');
		echo $this->createButtonSet();
    }

     public function checkAaRaafileExists(){
        $PROJECT_SETUP_ID = $this->input->post('PROJECT_SETUP_ID');
        $mode = $this->input->post('mode');
        $userFileName = $this->input->post('filename');
        //1-delete file from directory
        //2-update table
        if($mode == 1) {
            $recs = $this->db->select('PROJECT_SETUP_ID, AA_USER_FILE_NAME, AA_FILE_URL')
            		 ->from('dep__m_project_setup')
            		 ->where('AA_USER_FILE_NAME',$userFileName)
            		 ->get();
            if($recs && $recs->num_rows()) {
                $rec = $recs->row();
                $aaFileName = $rec->AA_FILE_URL;
                $filePath = FCPATH . 'dep_uploads' . DIRECTORY_SEPARATOR . $aaFileName;
                if(file_exists($filePath)) {
            		array_push($this->message, getMyArray(false, '<span style="color:#ff0000;">Sorry, you can not upload the file. File with same name is alreay uploaded on server.</span>'));
                    echo createJSONResponse($this->message);
                    return;                    
                }
            }else{
            	echo "";
            }
        }elseif($mode == 2) {
        	$aaFiles=0;
        	$raaFiles=0;
        	$recs = $this->db->select('PROJECT_SETUP_ID, AA_USER_FILE_NAME, AA_FILE_URL')
            		 ->from('dep__m_project_setup')
            		 ->where('AA_USER_FILE_NAME',$userFileName)
            		 ->get();
			$aaFiles= $recs->num_rows();
            $recsRaa =$this->db->select('RAA_USER_FILE_NAME, RAA_FILE_URL')
        			->from('dep__t_raa_project')
        			->where('RAA_USER_FILE_NAME', $userFileName)
        			->get();
        	$raaFiles= $recsRaa->num_rows(); 	
           if($aaFiles>0 || $raaFiles>0){
                		array_push($this->message, getMyArray(false, '<span style="color:#ff0000;">Sorry, you can not upload the file. File with same name is alreay uploaded on server.</span>'));
                    echo createJSONResponse($this->message);
                    return;                    
            }else{
            	echo "";
            }
        }
    }

    public function removeAARAAFile(){
        $PROJECT_SETUP_ID = $this->input->post('PROJECT_SETUP_ID');
        $mode = $this->input->post('mode');
        //1-delete file from directory
        //2-update table
        if($mode == 1) {
            $this->db->select('AA_FILE_URL');
            $this->db->from('dep__m_project_setup');
            $this->db->where('PROJECT_SETUP_ID', $PROJECT_SETUP_ID);
            $recs = $this->db->get();
            if($recs && $recs->num_rows()) {
                $rec = $recs->row();
                $aaFileName = $rec->AA_FILE_URL;
                $filePath = FCPATH . 'dep_uploads' . DIRECTORY_SEPARATOR . $aaFileName;
                if(file_exists($filePath)) {
                    if(@unlink($filePath)) {
                        $data = array('AA_FILE_URL' => '', 'AA_USER_FILE_NAME' => '');
                        $arrWhere = array('PROJECT_SETUP_ID' => $PROJECT_SETUP_ID);
                        @$this->db->update('dep__m_project_setup', $data, $arrWhere);

                        array_push($this->message, getMyArray(true, 'File Deleted'));
                        echo createJSONResponse($this->message);
                        return;
                    }
                }
            }
        }elseif($mode == 2) {
            $this->db->select('RAA_FILE_URL');
            $this->db->from('dep__t_raa_project');
            $this->db->where(array('PROJECT_SETUP_ID' => $PROJECT_SETUP_ID, 'ADDED_BY' => '0'));
            $recs = $this->db->get();
            if($recs && $recs->num_rows()) {
                $rec = $recs->row();
				$recs->free_result();
                $raaFileName = $rec->RAA_FILE_URL;
                $filePath = FCPATH . 'dep_uploads' . DIRECTORY_SEPARATOR . $raaFileName;
                if(file_exists($filePath)) {
                    if(@unlink($filePath)) {
                        $data = array('RAA_FILE_URL' => '', 'RAA_USER_FILE_NAME' => '');
                        $arrWhere = array('PROJECT_SETUP_ID'=>$PROJECT_SETUP_ID, 'ADDED_BY'=>'0');
                        @$this->db->update('dep__t_raa_project', $data, $arrWhere);
                        array_push($this->message, getMyArray(true, 'File Deleted'));
                        echo createJSONResponse($this->message);
                        return;
                    }
                }
            }
        }
    }
    public function getAASessionId(){
        $date = myDateFormat($this->input->post('date'));
        $sessionId = getSessionIdByDate($date);
        echo $sessionId;
    }
    /**
     * @todo: update logic/code of this function saveIrrigationPotential()
     */
   
}
