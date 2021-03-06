<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Setores
 * <pre>15/04/2016</pre>
 * <b>Setores do sistema</b>
 * 
 * @author Bruno Marques Nogueira <bmarquesn@gmail.com>
 * @name Setores
 * @license BrunoMarquesNogueira
 * @package Setores
 * @subpackage Admin
 * @date 15/04/2016
 *
 * ---
 *
 * Setores Atualização
 * <pre>15/02/2018</pre>
 * <b>Explicação do porque a Classe Comuns precisará sempre ser instanciada: Está dentro do PHP Query a integração com o Codeigniter</b>
 *
 * @author Bruno Marques Nogueira <bmarquesn@gmail.com>
 * @date 15/02/2018
 * 
 * ---
 * 
 * Inserido template nas views para as páginas internas
 * <pre>26/05/2020</pre>
 * <b>Template padrão para as páginas internas</b>
 * 
 * @author Bruno Marques Nogueira <bmarquesn@gmail.com>
 * @date 25/05/2020
 */
require_once('Admin.php');

class Setores extends Admin {
	public function __construct(){
		parent::__construct();
		$this->checarSessao = 1;
		$this->checarSessao();
		$this->load->model('Setor_model');
	}
	
	public function index($pagina = null, $msg = null) {
		$data['titulo_pagina'] = 'Setores';
		$data['pagina'] = 'setores';
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
		$total_registros = count($this->Setor_model->listar($filtros));
		$itens_por_pagina = $this->itensPorPagina;
		$paginador = $this->paginator->createPaginate('admin/setores/index/', $pagina, $total_registros, $itens_por_pagina, $config);
		$setores = $this->Setor_model->listar($filtros, $pagina, $itens_por_pagina);
		
		if(!empty($filtros) && !empty($paginador)) {
			$paginador = $this->retorna_paginacao($filtros, $paginador);
		}
		
		$data['total_registros'] = $total_registros;
		$data['itens_por_pagina'] = $itens_por_pagina;
		$data['paginador'] = $paginador;
		$data['link_css'] = array('assets/css/tablesorter/style.css');
		$data['scripts_js'] = array('assets/js/tablesorter/jquery.tablesorter.js');
		$data['temTableSorter'] = 1;
		$data['setores'] = $setores;
		
		if(!empty($msg)) {
			$data['msg'] = ucfirst(str_replace('_', ' ', $msg));
		} elseif(isset($_GET['msg']) && !empty(isset($_GET['msg']))) {
			$data['msg'] = ucfirst(str_replace('_', ' ', $_GET['msg']));
		}

		$data['pagina_atual'] = 'admin/setores/listar';
		
		$this->load->view('template_paginas_internas', $data);
	}
	
	public function cadastrar($id = null) {
		/** insercao/atualizacao */
		if(isset($_POST['nome']) && !empty($_POST['nome'])) {
			/** salvo os dados do setor para pegar o ID */
			$data['id'] = $this->anti_sql_injection($_POST['id']);
			$data['nome'] = $this->anti_sql_injection($_POST['nome']);
			if(!empty($data['id'])) {
				$this->Setor_model->upd_record($this->Setor_model->tabela(), $data);
				$id_setor = $data['id'];
			} else {
				$id_setor = $this->Setor_model->add_record($this->Setor_model->tabela(), $data);
			}
			if(!empty($id_setor)) {
				unset($_POST);
				/** Gravo log */
				$this->load->model('Logs_model');
				$dataLog['acao'] = (!empty($data['id'])?'Atualizacao':'Cadastro').' de setor';
				$dataLog['data_acao'] = date('Y-m-d H:i:s');
				$this->Logs_model->add_record($this->Logs_model->tabela(), $dataLog);
				if(!empty($data['id'])) {
					redirect(base_url().'admin/setores/index/0/setor_atualizado_com_sucesso');
				} else {
					redirect(base_url().'admin/setores/index/0/setor_cadastrado_com_sucesso');
				}
			} else {
				unset($_POST);
				redirect(base_url().'admin/setores/index/0/erro_ao_cadastrar_setor');
			}
		} else {
			if(!empty($id)) {
				$data['titulo_pagina'] = 'Editar';
			} else {
				$data['titulo_pagina'] = 'Cadastrar';
			}
			$data['pagina'] = 'setores';
			$data['colorpicker'] = 1;
			if(!empty($id)) {
				/** dados edicao */
				$data['setor'] = $this->Setor_model->get_all_where($this->Setor_model->tabela(), 'id', $this->anti_sql_injection($id));
				if(empty($data['setor'])) {
					redirect(base_url().'admin/setores/index/0/nao_foi_possivel_selecionar_setor');
				}
			}

			$data['scripts_js'] = array('assets/js/setores.js');
			$data['pagina_atual'] = 'admin/setores/cadastrar';
		
			$this->load->view('template_paginas_internas', $data);
		}
	}
	
	public function excluir($id = null) {
		if(!empty($id)) {
			if($this->Setor_model->del_record($this->Setor_model->tabela(), $id)) {
				/** Gravo log */
				$this->load->model('Logs_model');
				$dataLog['acao'] = 'Exclusao de setor';
				$dataLog['data_acao'] = date('Y-m-d H:i:s');
				$this->Logs_model->add_record($this->Logs_model->tabela(), $dataLog);
				redirect(base_url().'admin/setores/index/0/setor_excluido_com_sucesso');
			} else {
				redirect(base_url().'admin/setores/index/0/erro_ao_excluir_setor');
			}
		} else {
			redirect(base_url().'admin/setores/index/0/nao_foi_possivel_selecionar_setor');
		}
	}
}
