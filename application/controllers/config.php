<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller {

	public function index()
	{

		$this->lib->required_session();
		
		$this->load->model('home/mhome');

		$data = array(
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'LinkMenu' => $this->mhome->getLinks(),
			'ItemsMenu' => $this->mhome->getItems());
		$this->load->view('config/config', $data);
	}

}