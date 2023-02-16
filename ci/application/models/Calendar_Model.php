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

    public function getAllEventsByMonth($Month) {
        $this->db->select("RotaID, StaffID, `ShiftStart`, `EndTime`, Description",FALSE);
        $this->db->where('MONTH(`ShiftStart`) =', $Month);
        $this->db->from('Rota');
        $this->db->order_by('ShiftStart', 'ASC');
        //$Sql = 'SELECT StaffID, `Shift Start`, `End Time`, `Description` FROM Rota WHERE MONTH(`Shift Start`) = ?';
        $query = $this->db->get();
        //$query = $this->db->query($Sql,[$month]);
        return $result = $query->result_array();
    }

    public function getAllEventsByMonthForStaff($Month,$StaffID) {
        $this->db->select("RotaID, StaffID, `ShiftStart`, `EndTime`, Description",FALSE);
        $this->db->where('MONTH(`ShiftStart`) =', $Month);
        $this->db->where('StaffID',$StaffID);
        $this->db->from('Rota');
        $this->db->order_by('ShiftStart', 'ASC');

        $query = $this->db->get();
        return $result = $query->result_array();
    }

	public function AddNewEvent($StaffID,$startShift,$EndShift,$description)
	{
		$data['StaffID'] = $StaffID;
		$data['ShiftStart'] = $startShift;
		$data['EndTime'] = $EndShift;
		$data['Description'] = $description;
		
		$this->db->insert('Rota', $data);
	}

    public function EditEvent($StaffID,$startShift,$EndShift,$description)
	{
		$data['StaffID'] = $StaffID;
		$data['ShiftStart'] = $startShift;
		$data['EndTime'] = $EndShift;
		$data['Description'] = $description;
		
		$this->db->update('Rota', $data);
	}

    public function DeleteEvent($EventID) 
    {
        $this->db->where('RotaID',$EventID);
        $this->db->delete('Rota');
    }
}
?>
