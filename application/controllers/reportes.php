<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function index(){
		$this->lib->required_session();
	}

}