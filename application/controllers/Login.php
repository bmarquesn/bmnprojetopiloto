<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Login
 * <pre>14/04/2016</pre>
 * <b>Login no sistema administrativo</b>
 * 
 * @author Bruno Marques Nogueira <bmarquesn@gmail.com>
 * @name Login
 * @license BrunoMarquesNogueira
 * @package CI_Controller
 * @subpackage Login
 * @date 14/04/2016
 */

/** biblioteca para ser usada pelo sistema administrativo */
require_once('admin/Admin.php');

class Login extends Admin {
	
	public function index($retorno = null) {
		if(!empty($retorno)) {
			$data['retorno'] = ucfirst(str_replace('_', ' ', $retorno));
			$this->load->view('login', $data);
		} else {
			$this->load->view('login');
		}
	}
	
	public function entrar() {
		if((isset($_POST['emailLogin']) && !empty($_POST['emailLogin'])) && (isset($_POST['senha']) && !empty($_POST['senha']))) {
			$this->load->model('Usuario_model');
			$email = $this->anti_sql_injection($_POST['emailLogin']);
			$senha = md5($this->anti_sql_injection($_POST['senha']).$this->hash_senha());
			
			$dadosUsuario = $this->Usuario_model->get_all_where('usuario',array('email','senha'),array($email,$senha));

			if(!empty($dadosUsuario)) {
				$_SESSION['admin']['id_usuario'] = $dadosUsuario[0]->id;
				$_SESSION['admin']['nome_usuario'] = $dadosUsuario[0]->nome;
				$_SESSION['admin']['email_usuario'] = $dadosUsuario[0]->email;
				redirect(base_url().'sistema/');
			} else {
				redirect(base_url().'login/index?msg=dadosInvalidos');
			}
		} else {
			redirect(base_url().'login/index?msg=dadosNaoPreenchidos');
		}
	}
	
	public function sair() {
		if(isset($_SESSION) && !empty($_SESSION)) {
			session_destroy();
		}
		redirect(base_url().'login/');
	}
	
	public function esqueci_minha_senha() {
		$this->load->model('Usuario_model');
		$email = $this->anti_sql_injection($_POST['email']);
		
		$dadosUsuario = $this->Usuario_model->get_all_where('usuario','email',$email);
		
		if(!empty($dadosUsuario)) {
			$novaSenha = $this->geradorSenha();
			
			$data['senha'] = md5($this->anti_sql_injection($novaSenha).$this->hash_senha());
			$data['id'] = $dadosUsuario[0]->id;
			
			if($this->Usuario_model->upd_record('usuario', $data)) {
				if(!empty($dadosUsuario[0]->nome)) {
					$corpo = '<p>Olá '.$dadosUsuario[0]->nome.'</p>';
				} else {
					$corpo = '<p>Olá Nome Usuario</p>';
				}
				$corpo .= '<p>Envio / Reset de senha do sistema de Controle de Jobs Crosshost</p>';
				$corpo .= '<p><em>NÃO RESPONDA ESTE EMAIL !!! EMAIL AUTOMÁTICO !!!</em></p>';
				$corpo .= '<p>Foi feito um pedido de reenvio da sua senha para acessar o painel de Jobs Crosshost</p>';
				$corpo .= '<p>Sua nova senha é <strong>'.$novaSenha.'</strong></p>';
				
				if($this->envioMensagem('developer.bmn@gmail.com', 'Bruno Marques Nogueira - Gerente Web', $dadosUsuario[0]->nome, $dadosUsuario[0]->email, 'Recuperacao / Reset de Senha do painel de Prospects', $corpo)) {
					$resposta = 'senha_enviada_com_sucesso';
				} else {
					$resposta = 'erro_ao_enviar_a_senha';
				}
				
				redirect(base_url().'login/index/'.$resposta);
			} else {
				redirect(base_url().'login/index/erro_ao_atualizar_a_senha');
			}
		} else {
			redirect(base_url().'login/index/email_nao_encontrado');
		}
	}
}
