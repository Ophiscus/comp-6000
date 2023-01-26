<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Stats extends CI_Controller {

    public function __construct(){

        parent::__construct();

        //authorisation check
        $this->load->helper('url');
        $this->load->library('session');

        if (isset($_SESSION['role']) && $_SESSION['role'] === "Manager") {

        } else {
          redirect(base_url());
        }
    }
    
    public function index(){
       
        
    }

    public function show() {
            $this->load->model('Stats_model');

            $stock = $this->Stats_model->getStock();
            $income = $this->Stats_model->getIncome(date("Y"));
            $expense = $this->Stats_model->getExpenses(date("Y"));

            //$stockData = array("stockData" => $stock);
            //$profitData = array("profitData" => $profit);

            $data = array("stockData" => $stock, "incomeData" => $income, "expensesData" => $expense);

            $this->load->view('stats', $data);
    }

    function postStock() {
        //grab the data from the form on the view
        $name = $this->input->post("ItemName");
        $cost = $this->input->post("ItemCost");
        $quantity = $this->input->post("Quantity");
        $needed = $this->input->post("Needed");

        $this->load->model('Stats_model');
        $id = $this->Stats_model->postStock($name,$cost,$quantity,$needed);
        
        echo($id);
        //redirect to stats view page
        //redirect("stats/show");
    }

    function postIncome(){
        //input is sanitised from form through Codeigniter's input class (this input is gotten from stats view)
        $incomeName = $this->input->post('incomeSource',TRUE);
        $incomeAmount = $this->input->post('incomeAmount',TRUE);
        $incomeDate = $this->input->post('incomeDate',TRUE);
        
        //abort if somehow one of the inputs are empty
        if($incomeName === NULL || $incomeAmount === NULL || $incomeDate === NULL) {
            return;
        }

        $this->load->model('Stats_model');
        $this->Stats_model->postIncome($incomeName,$incomeAmount,$incomeDate);

        $this->show();
    }

    function postExpense(){
        //get input from form on stats view
        $expenseName = $this->input->post('expenseName',TRUE);
        $expenseAmount = $this->input->post('expenseAmount',TRUE);
        $expenseDate = $this->input->post('expenseDate',TRUE);
        if($expenseName === NULL || $expenseAmount === NULL || $expenseDate === NULL) {
            return;
        }

        $this->load->model('Stats_model');
        $this->Stats_model->postExpenses($expenseName,$expenseAmount,$expenseDate);

        $this->show();
    }

    function hideStockItem() {
        $itemID = $this->input->post('id',TRUE);
        $this->load->model('Stats_model');
        $this->Stats_model->hideStock($itemID);
    }

    function saveStock(){
        $id = $this->input->post('ItemID',TRUE);
        $name = $this->input->post('ItemName',TRUE);
        $needed = $this->input->post('Needed',TRUE);
        $cost = $this->input->post('ItemCost',TRUE);
        $quantity = $this->input->post('Quantity',TRUE);
        if($id === NULL || $name === NULL || $needed === NULL || $cost === NULL || $quantity === NULL) {
            return;
        }

        $this->load->model('Stats_model');
        $this->Stats_model->updateStock($id,$name,$needed,$cost,$quantity);
        

    }

    function getYearlyIncome()
    {
        $year = $this->input->get('year', TRUE);
        if($year === NULL) {
            return;
        }

        $this->load->model('Stats_model');
        $income = $this->Stats_model->getIncome($year);
        echo json_encode($income);
    }

    function getYearlyExpense()
    {
        $year = $this->input->get('year', TRUE);
        if($year === NULL) {
            return;
        }

        $this->load->model('Stats_model');
        $expense = $this->Stats_model->getExpenses($year);
        echo json_encode($expense);
    }

}

?>