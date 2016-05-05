<?php
require_once('Comuns_model.php');

class Usuario_model extends Comuns_model {
	protected $tabela = 'usuario';
	
	public function listar($filtros, $pagina = '', $limit = '') {
		$select = 'Usuario.*';
		$this->db->select($select);
		
		if(!empty($filtros)) {
			if(isset($filtros['nome'])) {
				$this->db->where('Usuario.nome LIKE(\'%%'.$filtros['nome'].'%%\')');
			}
			if(isset($filtros['texto'])) {
				$this->db->where('Usuario.email LIKE(\'%%'.$filtros['email'].'%%\')');
			}
			if(isset($filtros['ativo'])) {
				$this->db->where('Usuario.ativo = '.$filtros['ativo']);
			}
		}
		
		$this->db->group_by('Usuario.id');
		$this->db->order_by('Usuario.nome ASC');
		
		if($pagina !== '' && $limit !== '') {
			$this->db->limit($limit, $pagina);
		}
		
		$data = $this->db->get($this->tabela.' AS Usuario');
		return $data->result();
	}
}