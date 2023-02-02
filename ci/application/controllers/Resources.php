<?php

class Resources extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
				
        }

        public function show()
        {
			    $this->load->library('session');
                $this->load->view('resourceview', array('error' => ' ' ));
        }

        public function do_upload()
        {
                $config['upload_path']          = FCPATH."application/uploads/";
                $config['allowed_types']        = 'gif|webM|mp3|mp4|pdf';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload');
				$this->upload->initialize($config);
				//$this->session->userdata('staffid')

                if ( !$this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        $this->load->view('resourceview', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                        $this->load->view('upload_success', $data);
                }
        }
}
?>