<?php 

defined('BASEPATH') OR exit('No direct script access allowed'); 
class Calendar extends CI_Controller {

    public function index(){
       
        
    }

    public function show() {
        $this->load->helper('url'); 
        
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

}

?>