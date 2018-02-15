<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin
 * <pre>15/04/2016</pre>
 * <b>Admin do sistema</b>
 * 
 * @author Bruno Marques <developer@crosshost.com.br>
 * @name Admin
 * @license BrunoMarquesNogueira
 * @package Admin
 * @subpackage Comuns
 * @date 15/04/2016
 *
 * ---
 *
 * Admin Atualização
 * <pre>15/02/2018</pre>
 * <b>Explicação do porque a Classe Comuns precisará sempre ser instanciada: Está dentro do PHP Query a integração com o Codeigniter</b>
 *
 * @author Bruno Marques <developer@crosshost.com.br>
 * @date 15/02/2018
 */
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
