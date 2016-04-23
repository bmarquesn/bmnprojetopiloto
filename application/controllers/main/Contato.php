<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Contato via Email
 * <pre>23/04/2016</pre>
 * <b>Enviar email</b>
 * 
 * @author Bruno Marques <developer@crosshost.com.br>
 * @name Contato
 * @license BrunoMarquesNogueira
 * @package Contato
 * @subpackage Admin
 * @date 23/04/2016
 */

/** biblioteca para ser usada pelo sistema administrativo */
require_once(APPPATH.'controllers'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'Admin.php');

class Contato extends Admin {
	public function __construct(){
		parent::__construct();
		$this->checarSessao = 1;
		$this->checarSessao();
	}
	/** enviar email de contato */
	public function index() {
		if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['mensagem']) && !empty($_POST['mensagem'])) {
			$nome = isset($_POST['nome'])&&!empty($_POST['nome'])?$_POST['nome']:'Nome';
			$email = $_POST['email'];
			$mensagem = $_POST['mensagem'];
			$corpo = '<p>Contato via Portfólio Bruno Marques Nogueira</p>';
			$corpo .= '<p>Mensagem enviada em: '.date('d/m/Y H:i:s').'</p>';
			$corpo .= '<p>Remetente: '.$nome.' - '.$email.'</p>';
			$corpo .= '<p>Mensagem:<br />'.$mensagem.'</p><br /><br />';
			$corpo .= '<p><em>Mensaagem enviada via portfólio Bruno Marques Nogueira</em></p>';
			if($this->envioMensagem('bmarquesn@gmail.com', 'Bruno Marques Gerente de Projetos', $nome, $email, 'Contato via Portfolio Bruno Marques Nogueira', $corpo)) {
				$data['mensagem_enviada'] = 'Mensagem enviada com sucesso!!!';
			} else {
				$data['mensagem_enviada'] = 'Erro ao enviar a mensagem... tente novamente...';
			}
		}
		$data['titulo_pagina'] = 'Contato';
		$data['pagina'] = 'contato';
		$this->load->view('contato', $data);
	}
}
