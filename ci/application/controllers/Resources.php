<?php

class Resources extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
                $this->load->library('session');
            
        }		
        

        public function show()
        {
	        
                        
                if (isset($_SESSION['role']) && $_SESSION['role'] === "Manager") {
                        $staff = $this->getStaff();
                        $videos = $this->getAllVideos();
                        $assignments = $this->getAssignments();
                        $this->load->view('resourceview', array('error' => ' ' , 'video' => $videos, 'team' =>$staff, 'assigned'=>$assignments ));
                } else {
                        $videos = $this->getVideos($_SESSION['staffid']);
                        $data = array('video' => $videos);
                        $this->load->view('videoview', $data);
                }
                
        }

        public function showVideos() {
                if (isset($_SESSION['role']) && $_SESSION['role'] === "Manager") {
                        $data['video'] = $this->getAllVideos();
                        $this->load->view('videoview', $data);
                } else {
                        $data['video'] = $this->getVideos($_SESSION['staffid']);
                        $this->load->view('videoview', $data);
                }
        }

        public function do_upload()
        {
                $this->load->model('Resources_Model');
                $config['upload_path']          = FCPATH . 'uploads/';
                $config['allowed_types']        = 'gif|webM|mp3|mp4|pdf|avi|mpeg|3gp';
                $config['max_size']             = 100000;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;
		
                

                $this->load->library('upload',$config);
		//$this->session->userdata('staffid')

                if (!$this->upload->do_upload('userfile')) {
                        $error = array('error' => $this->upload->display_errors());

                        $this->load->view('resourceview', $error);
                } else {
                        $data = array('upload_data' => $this->upload->data());
                        //$this->load->view('upload_success', $data);
		        $this->Resources_Model->index($data['upload_data']['raw_name'],$data['upload_data']['file_ext'],date('Y-m-d'));
                        $this->session->set_flashdata("success","File has been uploaded!");
                        $this->show();
                }
        }

        public function assignTraining() {
                $docs = $this->getDocuments();
                foreach ($docs as $doc) {
                        if(isset($_POST[$doc['Title']])) {
                                $trainingToAssign = $doc['TrainingID'];
                                $docName = $doc['Title'];
                                break;
                        }
                }


                $teamMember = $this->getStaff();
                $this->load->model('Resources_Model');
                foreach($teamMember as $staff) {
                   $isAssigned = $this->input->post($staff['StaffID']);
                   if(isset($isAssigned)) {
                        $this->Resources_Model->assignTraining($staff['StaffID'],$trainingToAssign);
                   }  else {
                        $this->Resources_Model->unassignTraining($staff['StaffID'],$trainingToAssign);
                   }
                }

                $this->show();
        }

        private function getAllVideos() {
                $this->load->model('Resources_Model');
                return $this->Resources_Model->getAllVideos();
        }

        private function getVideos($id) {
                $this->load->model('Resources_Model');
                return $this->Resources_Model->getVideosFor($id);
        }

        private function getStaff() {
                $this->load->model('Resources_Model');
                return $this->Resources_Model->getStaff();
        }

        private function getDocuments() {
                $this->load->model('Resources_Model');
                return $this->Resources_Model->getDocuments();
        }

        private function getAssignments() {
                $this->load->model('Resources_Model');
                return $this->Resources_Model->getAssignments();
        }
}
?>