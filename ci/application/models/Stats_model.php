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
}

?>