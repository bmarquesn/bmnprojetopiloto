<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Usuarios
 * <pre>15/04/2016</pre>
 * <b>Usuários do sistema</b>
 * 
 * @author Bruno Marques <developer@crosshost.com.br>
 * @name Usuarios
 * @license BrunoMarquesNogueira
 * @package Usuarios
 * @subpackage Admin
 * @date 15/04/2016
 */

/** biblioteca para ser usada pelo sistema administrativo */
require_once('Admin.php');

class Usuarios extends Admin {
	public function __construct(){
		parent::__construct();
		$this->checarSessao = 1;
		$this->checarSessao();
		$this->load->model('Usuario_model');
	}
	
	public function index($pagina = null, $msg = null) {
		$data['titulo_pagina'] = 'Usuários';
		$data['pagina'] = 'usuarios';
		$filtros = array();
		/** para paginacao estas variaveis são necessárias */
		$this->load->library('paginator');
		$config['page_query_string'] = TRUE;
		/** pega o numero das paginas */
		$pagina = $this->uri->segment_array();
		if(!empty($msg)) {
			/** retiro o elemento msg */
			$msg = array_pop($pagina);
			if(is_numeric(end($pagina))) {
				$pagina_sql = (int)end($pagina);
			}
		} else {
			if(is_numeric(end($pagina))) {
				$pagina_sql = (int)end($pagina);
			}
		}
		$pagina = !isset($pagina_sql)?0:$pagina_sql;
		$total_registros = count($this->Usuario_model->listar($filtros));
		$itens_por_pagina = 10;
		$paginador = $this->paginator->createPaginate('admin/usuarios/index/', $pagina, $total_registros, $itens_por_pagina, $config);
		$usuarios = $this->Usuario_model->listar($filtros, $pagina, $itens_por_pagina);
		if(!empty($usuarios)) {
			foreach($usuarios as $key => $value) {
				unset($usuarios[$key]->senha);
			}
		}
		if(!empty($filtros) && !empty($paginador)) {
			$paginador = $this->retorna_paginacao($filtros, $paginador);
		}
		
		$data['total_registros'] = $total_registros;
		$data['itens_por_pagina'] = $itens_por_pagina;
		$data['paginador'] = $paginador;
		$data['link_css'] = array('assets/css/tablesorter/style.css');
		$data['scripts_js'] = array('assets/js/tablesorter/jquery.tablesorter.js');
		$data['temTableSorter'] = 1;
		$data['usuarios'] = $usuarios;
		
		if(!empty($msg)) {
			$data['msg'] = ucfirst(str_replace('_', ' ', $msg));
		} elseif(isset($_GET['msg']) && !empty(isset($_GET['msg']))) {
			$data['msg'] = ucfirst(str_replace('_', ' ', $_GET['msg']));
		}
		
		$this->load->view('admin/usuarios/listar', $data);
	}
	
	public function cadastrar($id = null) {
		/** insercao/atualizacao */
		if(isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['email']) && !empty($_POST['email'])) {
			if($this->valida_email($_POST['email'])) {
				/** salvo os dados do usuario para pegar o ID */
				$data['id'] = $this->anti_sql_injection($_POST['id']);
				$data['nome'] = $this->anti_sql_injection($_POST['nome']);
				$data['email'] = $this->anti_sql_injection($_POST['email']);
				if(isset($_POST['senha']) && !empty($_POST['senha'])) {
					$data['senha'] = md5($this->anti_sql_injection($_POST['senha']).$this->hash_senha());
				}
				if(!empty($data['id'])) {
					$this->Usuario_model->upd_record($this->Usuario_model->tabela(), $data);
					$id_usuario = $data['id'];
				} else {
					$id_usuario = $this->Usuario_model->add_record($this->Usuario_model->tabela(), $data);
				}
				if(!empty($id_usuario)) {
					unset($_POST);
					if(!empty($data['id'])) {
						redirect(base_url().'admin/usuarios/index/0/usuario_atualizado_com_sucesso');
					} else {
						redirect(base_url().'admin/usuarios/index/0/usuario_cadastrado_com_sucesso');
					}
				} else {
					unset($_POST);
					redirect(base_url().'admin/usuarios/index/0/erro_ao_cadastrar_usuario');
				}
			} else {
				redirect(base_url().'admin/usuarios/index/0/erro_ao_cadastrar_usuario');
			}
		} else {
			if(!empty($id)) {
				$data['titulo_pagina'] = 'Editar';
			} else {
				$data['titulo_pagina'] = 'Cadastrar';
			}
			$data['pagina'] = 'usuarios';
			$data['colorpicker'] = 1;
			if(!empty($id)) {
				/** dados edicao */
				$data['usuario'] = $this->Usuario_model->get_all_where($this->Usuario_model->tabela(), 'id', $this->anti_sql_injection($id));
			}
			$this->load->view('admin/usuarios/cadastrar', $data);
		}
	}
	
	public function excluir($id = null) {
		if($this->Usuario_model->del_record($this->Usuario_model->tabela(), $id)) {
			redirect(base_url().'admin/usuarios/index/0/usuario_excluido_com_sucesso');
		} else {
			redirect(base_url().'admin/usuarios/index/0/erro_ao_excluir_usuario');
		}
	}
}
