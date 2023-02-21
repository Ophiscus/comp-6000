<?php 

defined('BASEPATH') OR exit('No direct script access allowed'); 
class Calendar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //authorisation check
        $this->load->helper('url');
        $this->load->library('session');
        if(!isset($_SESSION['role'])) {
            redirect(base_url());
        }
    }

    public function index(){
       
        
    }

    public function show() {
        $elevatedAccess = false;
        if($_SESSION['role'] == "Manager")  {
            $elevatedAccess = true;
        }
        $data = array("ManagerAccess" => $elevatedAccess);
        $this->load->view('calendar', $data); 
    }

    public function getEvents() {
        $this->load->model('Calendar_Model');
        $data = $this->Calendar_Model->getEvents();
        echo json_encode($data);
    }

    public function getEventByMonth() {
        $month = $this->input->get('month',TRUE);
        $this->load->model('Calendar_Model');
        $data = $this->Calendar_Model->getAllEventsByMonth($month);
        echo json_encode($data);
    }

    public function getStaffEvents() {
        
        $month = $this->input->get('month',TRUE);
        $id = $_SESSION['staffid'];
        $this->load->model('Calendar_Model');
        //$this->output->enable_profiler(TRUE);
        $data = $this->Calendar_Model->getAllEventsByMonthForStaff($month,$id);
        echo json_encode($data);
    }

	public function post()
	{
		$this->load->model('Calendar_Model');
	
		$StaffID = $this->input->post('StaffID');
		$StartShift = $this->input->post('StartDate');
		$EndShift = $this->input->post('endTime');
		$Description = $this->input->post('Description');

		$this->Calendar_Model->AddNewEvent($StaffID,$StartShift,$EndShift,$Description);
		
		//Reload the page
        $this->load->helper('url'); 
        
        $this->load->view('calendar');
	}

    public function deleteEvent()
    {
        $id = $this->input->post('id',TRUE);
        $this->load->model('Calendar_Model');
        $this->Calendar_Model->DeleteEvent($id);
    }
    public function edit()
	{
		$this->load->model('Calendar_Model');
        
        $RotaID = $this->input->post('RotaID');
		$StaffID = $this->input->post('StaffID');
		$StartShift = $this->input->post('ShiftStart');
		$EndShift = $this->input->post('EndTime');
		$Description = $this->input->post('Description');

		$this->Calendar_Model->EditEvent($RotaID,$StaffID,$StartShift,$EndShift,$Description);
		
		//Reload the page
        $this->load->helper('url'); 
        
        $this->load->view('calendar');
	}
}

?>
