<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Utilizar, importar ou criar funcoes, bibliotecas default para o Sistema
 * <pre>14/04/2016</pre>
 * 
 * @author Bruno Marques <developer@crosshost.com>
 * @name Admin
 * @license BrunoMarquesNogueira
 * @package Admin
 * @subpackage Comuns
 * @date 14/04/2016
 */
 
/** biblioteca padrão para todo o sistema */
require_once('Comuns.php');

class Admin extends Comuns {
	public $checarSessao = 0;
	public $itensPorPagina = 10;
	
	public function __construct(){
		parent::__construct();
	}
	
	public function checarSessao() {
		if($this->checarSessao === 1) {
			if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
				session_destroy();
				redirect(base_url().'login/index/preciso_estar_logado');
			}
		}
	}
}