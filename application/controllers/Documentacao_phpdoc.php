<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Documentacao_phpdoc
 * <pre>23/04/2016</pre>
 * <b>Usuários do sistema</b>
 * 
 * @author Bruno Marques <bmarquesn@gmail.com>
 * @name Documentacao_phpdoc
 * @license BrunoMarquesNogueira
 * @package Documentacao_phpdoc
 * @subpackage Admin
 * @date 23/04/2016
 */

/** biblioteca para ser usada pelo sistema administrativo */
require_once('admin/Admin.php');

class Documentacao_phpdoc extends Admin {
	public $endereco_pasta = BASEPATH;
	
	public function __construct(){
		parent::__construct();
		$this->checarSessao = 1;
		$this->checarSessao();
	}
	/** criar e exibir documentacao PHPDoc do Projeto */
	public function index() {
		$data['titulo_pagina'] = 'Documentação PHPDoc';
		$data['pagina'] = 'documentacao_phpdoc';
		$_SESSION['endereco_pasta'] = explode('system', $this->endereco_pasta)[0];
		$this->load->view('documentacao_phpdoc', $data);
	}
}
