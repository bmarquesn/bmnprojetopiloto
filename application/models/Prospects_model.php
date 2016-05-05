<?php
require_once('Comuns_model.php');

class Prospects_Model extends Comuns_Model {
	public $tabela = 'prospects';
	
	/** funcoes personalizadas */
	function get_all_prospects($pagina, $itens_por_pagina) {
		$this->db->select('Prospects.*, Setor.nome AS nomeSetor');
		$this->db->join('setor AS Setor','Setor.id = Prospects.setor_id','LEFT');
		$this->db->order_by('Prospects.data_insercao', 'DESC');
		$data = $this->db->get($this->tabela.' AS Prospects', $itens_por_pagina, $pagina);
		
		return $data->result();
	}

	function get_all_procedure() {
		$data = $this->db->query('CALL ListarCopiasProspectsInseridos()');

		return $data->result();
	}
}