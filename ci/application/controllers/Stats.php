<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Stats extends CI_Controller {

    public function index(){
       
        
    }

    public function show() {
        //adding helper because the view calls base_url.
        $this->load->helper('url');
        $this->load->model('Stats_model');

        $stock = $this->Stats_model->getStock();
        $profit = $this->Stats_model->getProfit();
        $costs = $this->Stats_model->getCosts();

        //$stockData = array("stockData" => $stock);
        //$profitData = array("profitData" => $profit);

        $data = array("stockData" => $stock, "profitData" => $profit,"costsData" => $costs);

        $this->load->view('stats',$data);
    }
}

?>