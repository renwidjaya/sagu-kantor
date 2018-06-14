<?php  
class Login extends CI_Controller{ 
    function __construct(){
        parent::__construct();		
        $this->load->model('Model_users');
    }

    function index(){
        $this->load->view('users/login');
    }

    function aksi_login(){
        $post_data= $this->input->post('data');
        $isi_data = explode("^", $post_data);
        
        $username = $isi_data[0];
        $password = base64_encode($isi_data[1]);

        $cek = $this->Model_users->cek_login($username, $password)->row_array();
        if($cek){
            $data_session = array(
                    'user_id'=>$cek['id'],
                    'username' =>$username,
                    'realname'=>$cek['realname'],
                    'group'=>$cek['group_name'],
                    'group_id'=>$cek['group_id'],
                    'status' => "login",
                    'photo_profile_url'=>$cek['photo_profile_url']
                    );

            $this->session->set_userdata($data_session);
            $url = "BENAR";
        }else{
            $url = "SALAH";
        }
        header('Content-Type: application/json');
        echo json_encode($url); 
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url('index.php/Login'));
    }
}