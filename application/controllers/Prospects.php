<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Sistema administrativo de Prospects
 * <pre>14/04/2016</pre>
 * <b>Prospects que serao cadastrados no sistema</b>
 * 
 * @author Bruno Marques <bmarquesn@gmail.com>
 * @name Prospect
 * @license BrunoMarquesNogueira
 * @package Prospects
 * @subpackage Admin
 * @date 14/04/2016
 */
 
 /** biblioteca para ser usada pelo sistema administrativo */
require_once('admin/Admin.php');

class Prospects extends Admin {
	/** acoes default para os Prospects */
	protected $acao = array(
		1 => "1º Contato"
		,2 => "Marcar Reunião"
		,3 => "Reunião"
		,4 => "Aprovado"
		,5 => "Não Aprovado"
	);
	
	public function __construct(){
		parent::__construct();
		$this->checarSessao = 0;
		$this->checarSessao();
		$this->load->model('Prospects_model');
	}
	
	public function acao() {
		return $this->acao;
	}

	/** exibe a listagem de prospects e dá opções para inserir, excluir ou editar os Prospects */
	public function index($pagina = null, $msg = null) {
		$data['titulo_pagina'] = 'Prospects';
		$data['pagina'] = 'prospects';
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
		$total_registros = count($this->Prospects_model->get_all('prospects', 0));
		$itens_por_pagina = 10;
		$paginador = $this->paginator->createPaginate('prospects/index/', $pagina, $total_registros, $itens_por_pagina, $config);
		$prospects = $this->Prospects_model->get_all_prospects($filtros, $pagina, $itens_por_pagina);		
		if(!empty($filtros) && !empty($paginador)) {
			$paginador = $this->retorna_paginacao($filtros, $paginador);
		}
		
		$data['total_registros'] = $total_registros;
		$data['itens_por_pagina'] = $itens_por_pagina;
		$data['paginador'] = $paginador;
		$data['link_css'] = array('assets/css/tablesorter/style.css');
		$data['scripts_js'] = array('assets/js/tablesorter/jquery.tablesorter.js');
		$data['temTableSorter'] = 1;
		$data['acao'] = $this->acao;
		$data['prospects'] = $prospects;
		
		if(!empty($msg)) {
			$data['msg'] = ucfirst(str_replace('_', ' ', $msg));
		} elseif(isset($_GET['msg']) && !empty(isset($_GET['msg']))) {
			$data['msg'] = ucfirst(str_replace('_', ' ', $_GET['msg']));
		}
		
		$this->load->view('prospects/listar', $data);
	}

	/** Salva o Prospect no BD */
	public function cadastrar($id = null) {
		/** insercao/atualizacao */
		if(isset($_POST['nome']) && !empty($_POST['nome'])) {
			if($this->valida_email($_POST['email'])) {
				/** salvo os dados do prospect para pegar o ID */
				$data['id'] = $this->anti_sql_injection($_POST['id']);
				$data['nome'] = $this->anti_sql_injection($_POST['nome']);
				$data['setor_id'] = (int)$this->anti_sql_injection($_POST['setor']);
				$data['contatos'] = $this->anti_sql_injection($_POST['contatos']);
				$data['acao_id'] = (int)$this->anti_sql_injection($_POST['acao']);
				$data['data_proxima_acao'] = $this->formatar_data_banco_dados($this->anti_sql_injection($_POST['dataProximaAcao'])).' '.date('H:i:s');
				if(!empty($data['id'])) {
					$this->Prospects_model->upd_record($this->Prospects_model->tabela(), $data);
					$id_prospect = $data['id'];
				} else {
					$id_prospect = $this->Prospects_model->add_record($this->Prospects_model->tabela(), $data);
				}
				if(!empty($id_prospect)) {
					unset($_POST);
					if(!empty($data['id'])) {
						redirect(base_url().'prospects/index/0/prospect_atualizado_com_sucesso');
					} else {
						redirect(base_url().'prospects/index/0/prospect_cadastrado_com_sucesso');
					}
				} else {
					unset($_POST);
					redirect(base_url().'prospects/index/0/erro_ao_cadastrar_prospect');
				}
			} else {
				redirect(base_url().'prospects/index/0/erro_ao_cadastrar_prospect');
			}
		} else {
			$data['setores'] = $this->Prospects_model->get_all('setor', 'nome', null, 'ASC');
			if(empty($data['setores'])) {
				redirect(base_url().'prospects/index/0/nao_ha_setores_cadastrados_antes_cadastre_um');
			} else {
				if(!empty($id)) {
					$data['titulo_pagina'] = 'Editar';
				} else {
					$data['titulo_pagina'] = 'Cadastrar';
				}
				$data['pagina'] = 'prospects';
				if(!empty($id)) {
					/** dados edicao */
					$data['prospect'] = $this->Prospects_model->get_all_where($this->Prospects_model->tabela(), 'id', $this->anti_sql_injection($id));
				}
				$data['acao'] = $this->acao;
				//var_dump($data['setores']);die;
				$this->load->view('prospects/cadastrar', $data);
			}
		}
	}
	
	public function excluir($id = null) {
		if($this->Prospects_model->del_record($this->Prospects_model->tabela(), $id)) {
			redirect(base_url().'prospects/index/0/usuario_excluido_com_sucesso');
		} else {
			redirect(base_url().'prospects/index/0/erro_ao_excluir_usuario');
		}
	}
}