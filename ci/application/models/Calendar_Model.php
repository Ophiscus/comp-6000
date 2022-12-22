<?php
class Calendar_model extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function getEvents()
    {
        $Sql ='SELECT * FROM Rota WHERE StaffID = "1"';
        $Query = $this->db->query($Sql);
        return $Query->result_array();
    }

    public function getAllEventsByMonth($month) {
        $this->db->select("StaffID, `Shift Start`, `End Time`, Description",FALSE);
        $this->db->where('MONTH(`Shift Start`) =', $month);
        $this->db->from('Rota');
        //$Sql = 'SELECT StaffID, `Shift Start`, `End Time`, `Description` FROM Rota WHERE MONTH(`Shift Start`) = ?';
        $query = $this->db->get();
        //$query = $this->db->query($Sql,[$month]);
        return $result = $query->result_array();
    }
}
?>