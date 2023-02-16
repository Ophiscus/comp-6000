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
        $this->load->view('calendar'); 
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

}

?>
