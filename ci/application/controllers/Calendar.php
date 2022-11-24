<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Calendar extends CI_Controller {

    public function index(){
       
        
    }

    public function show() {
        $this->load->helper('url'); 
        $this->load->model('Calendar_Model');
        $data = $this->Calendar_Model->getEvents();
        $event = array("results"=> $data);
        $this->load->view('calendar', $event); 
    }
}

?>