<?php
require_once('Comuns_model.php');

class Setor_model extends Comuns_model {
	protected $tabela = 'setor';
	
	public function listar($filtros, $pagina = '', $limit = '') {
		$select = 'Setor.*';
		$this->db->select($select);
		
		if(!empty($filtros)) {
			if(isset($filtros['nome'])) {
				$this->db->where('Setor.nome LIKE(\'%%'.$filtros['nome'].'%%\')');
			}
			if(isset($filtros['ativo'])) {
				$this->db->where('Setor.ativo = '.$filtros['ativo']);
			}
		}
		
		$this->db->group_by('Setor.id');
		$this->db->order_by('Setor.nome ASC');
		
		if($pagina !== '' && $limit !== '') {
			$this->db->limit($limit, $pagina);
		}
		
		$data = $this->db->get($this->tabela.' AS Setor');
		return $data->result();
	}
}