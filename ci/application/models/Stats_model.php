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

    public function getProfit() {

        $profits = array();

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
                $profits[$i] = 0;
            } else { 
                //if query returned something, assign that to the array
                $profits[$i] = $query->row()->profit;
            }
        }

        $monthProfits = array("January" => $profits[1], "February" => $profits[2], "March" => $profits[3], "April" => $profits[4], "May" =>$profits[5], "June"=>$profits[6], "July"=>$profits[7], "August"=>$profits[8], "September"=>$profits[9], "October"=>$profits[10], "November"=>$profits[11], "December"=>$profits[12]);
        return $monthProfits;
    }

    public function getCosts() {
        $this->db->select('Name,Amount');
        $this->db->from('expenses');

        $query = $this->db->get();
        return $query->result_array();

    }

}

?>