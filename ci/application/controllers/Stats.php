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
        $income = $this->Stats_model->getIncome();
        $expense = $this->Stats_model->getExpenses();

        //$stockData = array("stockData" => $stock);
        //$profitData = array("profitData" => $profit);

        $data = array("stockData" => $stock, "incomeData" => $income, "expensesData" => $expense);

        $this->load->view('stats',$data);
    }

    function postStock() {
        //once sessions are working, check that the user is logged in and a manager
        if(true) {
        //grab the data from the form on the view
        $name = $this->input->post("ItemName");
        $cost = $this->input->post("ItemCost");
        $quantity = $this->input->post("Quantity");
        $needed = $this->input->post("Needed");

        $this->load->model('Stats_model');
        $this->Stats_model->postStock($name,$cost,$quantity,$needed);
        
        //redirect to stats view page
        redirect("stats/show");
        } else {
            //handling for non-logged in users.
            $this->load->view('login');
        }
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
}

?>