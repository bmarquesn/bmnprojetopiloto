<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Usuarios
 * <pre>15/04/2016</pre>
 * <b>Login no sistema</b>
 * 
 * @author Bruno Marques <developer@crosshost.com.br>
 * @name Login
 * @license BrunoMarquesNogueira
 * @package Login
 * @subpackage Admin
 * @date 15/04/2016
 *
 * ---
 *
 * Login Atualização
 * <pre>15/02/2018</pre>
 * <b>Explicação do porque a Classe Comuns precisará sempre ser instanciada: Está dentro do PHP Query a integração com o Codeigniter</b>
 *
 * @author Bruno Marques <developer@crosshost.com.br>
 * @date 15/02/2018
 */
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
				/** Gravo log */
				$this->load->model('Logs_model');
				$dataLog['acao'] = 'O usuário '.$_SESSION['admin']['nome_usuario'].' - '.$_SESSION['admin']['email_usuario'].' logou no sistema';
				$dataLog['data_acao'] = date('Y-m-d H:i:s');
				$this->Logs_model->add_record($this->Logs_model->tabela(), $dataLog);
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
			/** Gravo log */
			$this->load->model('Logs_model');
			$dataLog['acao'] = 'O usuário '.$_SESSION['admin']['nome_usuario'].' - '.$_SESSION['admin']['email_usuario'].' saiu do sistema';
			$dataLog['data_acao'] = date('Y-m-d H:i:s');
			$this->Logs_model->add_record($this->Logs_model->tabela(), $dataLog);
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
				/** Gravo log */
				$this->load->model('Logs_model');
				$dataLog['acao'] = 'O usuário '.$dadosUsuario[0]->nome.' - '.$dadosUsuario[0]->email.' esqueceu/redefiniu sua senha do sistema';
				$dataLog['data_acao'] = date('Y-m-d H:i:s');
				$this->Logs_model->add_record($this->Logs_model->tabela(), $dataLog);
				if(!empty($dadosUsuario[0]->nome)) {
					$corpo = '<p>Olá '.$dadosUsuario[0]->nome.'</p>';
				} else {
					$corpo = '<p>Olá Nome Usuario</p>';
				}
				$corpo .= '<p>Envio / Reset de senha do sistema do Portfolio de Bruno Marques Nogueira - Desenvolvedor Web</p>';
				$corpo .= '<p><em>NÃO RESPONDA ESTE EMAIL !!! EMAIL AUTOMÁTICO !!!</em></p>';
				$corpo .= '<p>Foi feito um pedido de reenvio da sua senha para acessar o sistema do Portfolio de Bruno Marques Nogueira</p>';
				$corpo .= '<p>Sua nova senha é <strong>'.$novaSenha.'</strong></p>';
				
				if($this->envioMensagem('developer.bmn@gmail.com', 'Bruno Marques Nogueira - Gerente Web', $dadosUsuario[0]->nome, $dadosUsuario[0]->email, 'Recuperacao / Reset de Senha do painel do Portfolio de Bruno Marques Nogueira', $corpo)) {
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
