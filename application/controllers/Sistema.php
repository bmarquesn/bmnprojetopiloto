<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Sistema
 * <pre>14/04/2016</pre>
 * <b>Sistema administrativo do projeto</b>
 * 
 * @author Bruno Marques Nogueira <bmarquesn@gmail.com>
 * @name Sistema
 * @license BrunoMarquesNogueira
 * @package Sistema
 * @subpackage Admin
 * @date 14/04/2015
 */

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
