<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** biblioteca para ser usada pelo sistema administrativo */
require_once('admin/Admin.php');

class Sistema extends Admin {
	public function __construct(){
		parent::__construct();
		$this->checarSessao = 1;
		$this->checarSessao();
	}

	public function index()	{
		$this->load->view('sistema');
	}
	
	public function sair() {
		unset($_SESSION['admin']);
		redirect(base_url().'login');
	}
}
