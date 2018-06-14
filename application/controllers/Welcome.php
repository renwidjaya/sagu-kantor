<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct(){
        parent::__construct();

        if($this->session->userdata('status') != "login"){
            redirect(base_url("index.php/Login"));
        }
    }
    
    public function index(){
        $data['judul']  = "";
        $data['content']= "beranda";
        $this->load->view('layout', $data);
    }
}
