<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->model('home/mhome');

		$data = array(
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'LinkMenu' => $this->mhome->getLinks(),
			'ItemsMenu' => $this->mhome->getItems());
		$this->load->view('home/vhome', $data);
	}

}