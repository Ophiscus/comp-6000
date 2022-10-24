<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Stats extends CI_Controller {

    public function index(){
       
        
    }

    public function showData() {
        $this->load->helper('url');
        $this->load->model('Stats_model');

        $data = $this->Stats_model->getStock();

        $dataForView = array("stockData" => $data);
        
        $this->load->view('stats',$dataForView);
    }
}

?>