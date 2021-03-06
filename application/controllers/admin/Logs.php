<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Logs
 * <pre>15/04/2016</pre>
 * <b>Logs do sistema</b>
 * 
 * @author Bruno Marques Nogueira <bmarquesn@gmail.com>
 * @name Logs
 * @license BrunoMarquesNogueira
 * @package Logs
 * @subpackage Admin
 * @date 15/04/2016
 *
 * ---
 *
 * Logs Atualização
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

class Logs extends Admin {
	public function __construct(){
		parent::__construct();
		$this->checarSessao = 1;
		$this->checarSessao();
		$this->load->model('Logs_model');
	}
	
	public function index($pagina = null, $msg = null) {
		$data['titulo_pagina'] = 'Histórico de Açoes - Logs';
		$data['pagina'] = 'logs';
		$filtros = array();
		if(isset($_GET['acao']) && !empty($_GET['acao'])) {
			$filtros['acao'] = $this->anti_sql_injection($_GET['acao']);
		}
		if(isset($_GET['data_acao']) && !empty($_GET['data_acao'])) {
			$filtros['data_acao'] = $this->formatar_data_banco_dados($this->anti_sql_injection($_GET['data_acao']));
		}
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
		$total_registros = count($this->Logs_model->listar($filtros));
		$itens_por_pagina = $this->itensPorPagina;
		$paginador = $this->paginator->createPaginate('admin/logs/index/', $pagina, $total_registros, $itens_por_pagina, $config);
		$historico_acoes = $this->Logs_model->listar($filtros, $pagina, $itens_por_pagina);
		
		if(!empty($filtros) && !empty($paginador)) {
			$paginador = $this->retorna_paginacao($filtros, $paginador);
		}
		
		$data['total_registros'] = $total_registros;
		$data['itens_por_pagina'] = $itens_por_pagina;
		$data['paginador'] = $paginador;
		$data['link_css'] = array('assets/css/tablesorter/style.css');
		$data['scripts_js'] = array('assets/js/tablesorter/jquery.tablesorter.js');
		$data['temTableSorter'] = 1;
		if(!empty($historico_acoes)) {
			foreach($historico_acoes as $key => $value) {
				$historico_acoes[$key]->data_acao = date('d/m/Y H:i:s', strtotime($value->data_acao));
			}
		}
		$data['historico_acoes'] = $historico_acoes;

		$data['pagina_atual'] = 'admin/logs/listar';
		
		$this->load->view('template_paginas_internas', $data);
	}
}
