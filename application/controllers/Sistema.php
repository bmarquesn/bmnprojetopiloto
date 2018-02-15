<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Sistema
 * <pre>15/04/2016</pre>
 * <b>Sistema principal</b>
 * 
 * @author Bruno Marques <bmarquesn@gmail.com>
 * @name Sistema
 * @license BrunoMarquesNogueira
 * @package Sistema
 * @subpackage Admin
 * @date 15/04/2016
 *
 * ---
 *
 * Sistema Atualização
 * <pre>15/02/2018</pre>
 * <b>Explicação do porque a Classe Comuns precisará sempre ser instanciada: Está dentro do PHP Query a integração com o Codeigniter</b>
 *
 * @author Bruno Marques <bmarquesn@gmail.com>
 * @date 15/02/2018
 */
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
