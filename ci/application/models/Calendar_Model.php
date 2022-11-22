<?php
class Calendar_model extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function getEvents()
    {
        $Sql ='SELECT * FROM Rota WHERE StaffID = "TestUser"';
        $Query = $this->db->query($Sql);
        return $Query->result_array();
    }
}
?>