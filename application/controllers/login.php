<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		$this->load->model('lib');
		$data = array('header' => $this->lib->print_header());
		$this->load->view('login', $data);
	}
}