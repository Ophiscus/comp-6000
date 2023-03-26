<?php
class Resources_model extends CI_Model{
    function __construct() {
        $this->load->database();
    }

    public function index($name,$type,$date) {
        $data = array('Title' => $name, 'Type' => $type, 'Date' => $date);
        $this->db->insert('TrainingDocument',$data);
    }

    public function getAllVideos() {
        $this->db->select('*');
        $this->db->from('TrainingDocument');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getVideosFor($id) {
        $this->db->select('*');
        $this->db->from('TrainingDocument');
        $this->db->join('AssignedTraining','TrainingDocument.TrainingID = AssignedTraining.TrainingID');
        $this->db->join('Staff','Staff.StaffID = AssignedTraining.StaffID');
        $this->db->where('AssignedTraining.StaffID',$id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getStaff() {
        $this->db->select('*');
        $this->db->from('Staff');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDocuments() {
        $this->db->select('*');
        $this->db->from('TrainingDocument');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function assignTraining($StaffID, $TrainingID) {
        if($this->isAssigned($StaffID,$TrainingID)) {

        } else {
            $this->db->set('StaffID',$StaffID);
            $this->db->set('TrainingID',$TrainingID);
            $this->db->insert('AssignedTraining');
        }
    }

    public function unassignTraining($StaffID,$TrainingID) {
        $this->db->where('StaffID',$StaffID);
        $this->db->where('TrainingID',$TrainingID);
        $this->db->delete('AssignedTraining');
    }

    public function getAssignments() {
        $this->db->select('*');
        $this->db->from('AssignedTraining');
        $this->db->order_by('TrainingID','ASC');
        $this->db->order_by('StaffID','ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    private function isAssigned($StaffID, $TrainingID) {
        $this->db->select('*');
        $this->db->from('AssignedTraining');
        $this->db->where('StaffID',$StaffID);
        $this->db->where('TrainingID',$TrainingID);

        $query = $this->db->get();
        return ($query->num_rows() > 0);
        
    }
}
?>