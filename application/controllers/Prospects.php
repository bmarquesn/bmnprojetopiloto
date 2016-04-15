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

	/** exibe a listagem de prospects e dá opções para inserir, excluir ou editar os Prospects */
	public function index($pagina = null, $msg = null) {
		$this->load->model('prospects_model');
		/** para paginacao estas variaveis são necessárias */
		$this->load->library('paginator');
		$pagina = (!$this->uri->segment("3"))?0:(int)$this->uri->segment("3");
		$total_registros = count($this->prospects_model->get_all('prospects', 0));
		$itens_por_pagina = 10;
		$paginador = $this->paginator->createPaginate('prospect/index/', $pagina, $total_registros, $itens_por_pagina);
		
		$data['prospects'] = $this->prospects_model->get_all_prospects($pagina, $itens_por_pagina);
		$data['paginador'] = $paginador;
		$data['acao'] = $this->acao;

		$this->load->view('prospects/listar', $data);
	}

	/** Salva o Prospect no BD */
	public function inserir() {
		if(isset($_POST) && !empty($_POST['nome'])) {
			$admin = new Admin();

			$data['nome'] = $_POST['nome'];
			$data['setor_id'] = (int)$_POST['setor'];
			$data['contatos'] = $_POST['contatos'];
			$data['acao_id'] = (int)$_POST['acao'];
			$data['data_proxima_acao'] = $admin->formatar_data_banco_dados($_POST['dataProximaAcao']).' '.date('H:i:s');

			if(isset($_POST['id']) && !empty($_POST['id'])) {
				$data['id'] = (int)$_POST['id'];

				if($this->prospects_model->upd_record('prospects', $data)){
					$resposta = "atualizado com";
				}else{
					$resposta = "atualizado sem";
				}
			} else {
				$data['data_insercao'] = date('Y-m-d H:i:s');

				if($this->prospects_model->add_record('prospects', $data)){
					$resposta = "inserido com";
				}else{
					$resposta = "inserido sem";
				}
			}

			$msg = "Prospect ".$resposta." sucesso com a ação ".$this->acao[$data['acao_id']];

			/** gravo o historico */
			$dataHistorico['acao'] = $msg;
			$dataHistorico['data_acao'] = date('Y-m-d H:i:s');
			$this->prospects_model->add_record('historico_acoes', $dataHistorico);

			redirect(base_url().'prospect/?msg='.$msg);
		} else {
			$data['acao'] = $this->acao;
			$data['setores'] = $this->prospects_model->get_all('setor',0);
			$data['msg'] = "";

			$this->load->view('inserir_prospect',$data);
		}
	}

	/** exlcuir o prospect e mostra a mensagem de sucesso ou erro */
	public function excluir($id) {
		if(!empty($id)) {
			if($this->prospects_model->del_record('prospects',$id)) {
				$resposta = "excluido com";
			} else {
				$resposta = "excluido sem";
			}
		} else {
			$resposta = "excluido sem";
		}

		$msg = "Prospect ".$resposta." sucesso";

		/** gravo o historico */
		$dataHistorico['acao'] = $msg;
		$dataHistorico['data_acao'] = date('Y-m-d H:i:s');
		$this->prospects_model->add_record('historico_acoes', $dataHistorico);

		redirect(base_url().'prospect/?msg='.$msg);
	}

	/** traz os dados do Prospect para edita-lo */
	public function editar($id) {
		$data['setores'] = $this->prospects_model->get_all('setor',0);
		$data['acao'] = $this->acao;

		if(!empty($id)) {
			$data['dados'] = $this->prospects_model->searchField('prospects', 'id', $id);
		}

		$this->load->view('inserir_prospect', $data);
	}

	/** todo o Prospect quando criado sera criada ma copia deste Prospect via Procedure. Esta é a listagem destas copias  */
	public function listar_copias_procedure() {
		$data['prospects'] = $this->prospects_model->get_all_procedure();
		$data['acao'] = $this->acao;

		$this->load->view('listar_copias_procedure',$data);
	}

	/** Atualizar Status Prospect via AJAX */
	public function atualizar_status_prospect($idProspect) {
		$admin = new Admin();

		$data['id'] = (int)$idProspect;
		$data['acao_id'] = (int)$_POST['acao'];

		if($this->prospects_model->upd_record('prospects', $data)) {
			/** gravo o historico */
			$dataHistorico['acao'] = 'Atualizacao de Status do Prospect ID '.$idProspect;
			$dataHistorico['data_acao'] = date('Y-m-d H:i:s');
			$this->prospects_model->add_record('historico_acoes', $dataHistorico);
			echo "1";
		} else {
			echo "0";
		}

		die;
	}
	
	/** criar e exibir documentacao PHPDoc do Projeto */
	public function documentacao_phpdoc() {
		$this->load->view('documentacao_phpdoc');
	}
}