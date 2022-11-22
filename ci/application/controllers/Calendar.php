<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Calendar extends CI_Controller {

    public function index(){
       
        
    }

    public function show() {
        $this->load->helper('url'); 
        $this->load->model('calendar_model');
        $data = $this->calendar_model->getEvents();
        $event = array("results"=> $data);
        $this->load->view('calendar', $event); 
    }
}

?>