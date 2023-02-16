<?php

class Video extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
				$this->load->database();
                if(!isset($_SESSION['role'])) {
                    redirect(base_url());
                }
        
				
        }
		
		public function get_video() {
          $query = $this->db->get('videos');
          return $query->result();
        }
		
		public function show(){
		$data['video'] = $this->get_video();
        $this->load->view('videoview', $data);
		}
}		
?>