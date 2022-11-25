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
        $event = array("results"=> $data);
        $bla = $data[0];
        echo($bla['Shift Start']."divider".$bla['End Time']."divider".$bla['Description']);
    }
}

?>