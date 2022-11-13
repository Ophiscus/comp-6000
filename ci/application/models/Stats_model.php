<?php

class Stats_model extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    public function getStock() {
        $this->db->select('*');
        $this->db->from('items');

        $query=$this->db->get();

        return $query->result_array();
    }

    public function getIncome() {

        $income = array();

        for($i=1;$i<=12;$i++) {
            $this->db->select_sum('Amount','profit');
            $this->db->from('income');
            $this->db->where('MONTH(Date)',$i);
            $this->db->where('YEAR(Date)',date("Y"));

            $query = $this->db->get();
            $result = $query->result_array();
            $count = count($result);
            //otherwise assign 0
            if($query->row()->profit === NULL) {
                $income[$i] = 0;
            } else { 
                //if query returned something, assign that to the array
                $income[$i] = $query->row()->profit;
            }
        }

        $monthIncome = array("January" => $income[1], "February" => $income[2], "March" => $income[3], "April" => $income[4], "May" =>$income[5], "June"=>$income[6], "July"=>$income[7], "August"=>$income[8], "September"=>$income[9], "October"=>$income[10], "November"=>$income[11], "December"=>$income[12]);
        return $monthIncome;
    }

    public function getExpenses() {
        $this->db->select('Name,Amount');
        $this->db->from('expenses');

        $query = $this->db->get();
        return $query->result_array();

    }

    public function postCost($name,$amount,$date) {
        //consider getting current date as an alternative
        $data = array('Name' =>$name,'Amount'=>$amount,'Date'=>$date);
        $this->db->insert('expenses',$data);
    }

    public function postIncome($name,$amount,$date) {
        //consider getting current date as an alternative (or maybe as an optional parameter?)
        $data = array('incomeSource' =>$name,'Amount'=>$amount,'Date'=>$date);
        $this->db->insert('income',$data);
    }

    public function postStock($name,$cost,$owned,$needed) {
        //consider getting current date as an alternative
        $data = array('Name' =>$name,'ItemCost'=>$cost,'Quantity'=>$owned,'Needed'=>$needed);
        $this->db->insert('items',$data);
    }

}

?>