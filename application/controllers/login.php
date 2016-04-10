<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if(empty($this->session->userdata("id"))){
			$data = array('header' => $this->lib->print_header());
			$this->load->view('login/vlogin', $data);
		}else{
			header("Location: ".base_url());
		}
	}

	public function control_login(){
		$this->load->model('login/mlogin');

		$user = $this->input->post('username');
		$pass = $this->input->post('password');

		$this->mlogin->action_longin($user, $pass);
	}

	public function control_logout(){
		$this->load->model('login/mlogin');
		$this->mlogin->action_longout();
	}

}